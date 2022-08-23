<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Config;
use think\facade\Db;
use think\facade\Cache;
use think\facade\Session;
use think\facade\Request;
use app\model\Users;
use app\model\Player;
use app\model\Song;
use app\model\SongSheet;
use app\model\Plays;
use app\model\PlayerAuth;
use app\model\PlayerSongSheet;

class Api extends Common
{
	public function playerinfo()
    {
		$act=input('get.');
		$id=$act['id'];
		if(!$id){
			$result['code'] = -1;
			return json($result);
		}elseif(Player::checkPlayerKey($id)== true){
			$result['code'] = -1;
			return json($result);
		}
        $player = Player::where("id",$id)->find();
		$data=[
			'plays'	=>	$player['plays']+1,
			'endtime'	=>	date('Y-m-d H:i:s')
		];
		Player::where('id','=',$id)->data($data)->update();
		$data2=[
			'player_id'	=>	$id,
			'user_id'	=>	$player['user_id'],
			'side'	=>	'ios',
			'create_time'	=>	date('Y-m-d H:i:s')
		];
		Plays::add($data2);
        $cache = Cache::get('info'.$id);
        if($cache){
			return response($act['jsoncallback']."(".$cache.")");
        }
        
        // 获取播放器歌单
		$result =[];
        // 获取歌单歌曲
        $songSheetList = [];
		$songSheets = PlayerSongSheet::alias('pss')
            ->join('song_sheet ss', 'ss.id=pss.song_sheet_id')
            ->field('ss.*')->where('pss.player_id', $id)
            ->order('pss.taxis asc')
            ->select();
        foreach ($songSheets as $key => $item){
            $songs = Song::where('song_sheet_id', $item['id'])->order('taxis asc')->select();
            //print_r($songs);exit;
            $songlists = [];
            foreach ($songs as $key2 => $item2){
                $songlists[$key2] = [
                'type' => $item2['type'],
                'id' => $item2['song_id'],
                'name' => $item2['name'],
                'cover' => $item2['album_cover'],
                'artist' => $item2['artist_name'],
                'album' => $item2['album_name'],
				'url' => $item2['location'],
				'lyric' => $item2['lyric'],
            ];
            }
            $songSheetList[$key] = [
                'SheetName' => $item['name'],
                'author' => $item['author'],
                'songs' => $songlists,
            ];
        }
		$result = [
			'playerName' => $player['name'],
			'showGreeting' => $player['show_greeting'],
			'switchopen' => $player['switchopen'],
			'time' => $player['time'],
			'showLrc' => $player['show_lrc'],
			'showMsg' => $player['showmsg'],
			'defaultAlbum' => $player['default_album'],
			'randomPlayer' => $player['random_player'],
			'defaultVolume' => $player['default_volume'],
			'greeting' => $player['greeting'],
			'autoPlayer' => $player['auto_player'],
			'Sheetlist' => $songSheetList,
			'showNotes' => $player['show_notes'],
		];
		$result = json_encode($result);

        Cache::set('info'.$id,$result);
		return response($act['jsoncallback']."(".$result.")");
    }
	
	public function musicUrl()
    {
		$data=input('get.');
		if(!array_key_exists("HTTP_REFERER",$_SERVER)){
			$url='http://tts.baidu.com/text2audio?cuid=baiduid&lan=zh&ctp=1&pdt=311&tex=本接口用于本站播放器音乐播放调用,禁止私自盗用。';
		}else{
			$url = $_SERVER["HTTP_REFERER"]; //获取完整的来路URL
			if(strpos($url,'http://') !== false){
			    $str = str_replace('http://',"",$url); //去掉http://
			}else{
			    $str = str_replace('https://',"",$url); //去掉https://
			}
			$strdomain = explode("/",$str);  // 以“/”分开成数组
			$domain = $strdomain[0];//取第一个“/”以前的字符
			$auth=PlayerAuth::where('domain','=',$domain)->where('player_id','=',$data['id'])->find();
			if($_SERVER['HTTP_HOST']==$domain){
				$type=$data['type'];
				$id=$data['songId'];
				$json = send_get(Config::get('api.music').'?input='.$id.'&filter=id&type='.$type.'&page=1&url='. $_SERVER['SERVER_NAME']);
				$data=json_decode($json,true);
				$url=$data['url'];
			}elseif(!$auth){
				$player=Player::where('id','=',$data['id'])->find();
				$url='http://tts.baidu.com/text2audio?cuid=baiduid&lan=zh&ctp=1&pdt=311&tex='.$player['voice_msg'];
			}else{
				$type=$data['type'];
				$id=$data['songId'];
				$json = send_get(Config::get('api.music').'?input='.$id.'&filter=id&type='.$type.'&page=1&url='. $_SERVER['SERVER_NAME']);
				$data=json_decode($json,true);
				$url=$data['url'];
			}
		}
		return redirect($url);
    }
	
	public function musicLyric()
    {
		$data=input('get.');
		$cache = Cache::get('musicLyric'.$data['type'].$data['id']);
		if($data['type']=='local'){
			$id=$data['id'];
			$url=$data['url'];
			$result=send_get($url);
			$result = [
				'file' => 'null',
				'time' => date('Y-m-d h:i:s', time()),
				'type' => 'lrc',
				'txt' => $result
			];
		}else{
			$player=Player::where('id','=',$data['id'])->find();
			$userInfo=Users::where('uid','=',$player['user_id'])->find();
			if($userInfo['power']==2){
				$json = send_get(Config::get('api.music').'?input='.$data['songId'].'&filter=id&type='.$data['type'].'&page=1&url='. $_SERVER['SERVER_NAME']);
				$result=json_decode($json,true);
				$result = [
					'file' => 'null',
					'time' => date('Y-m-d h:i:s', time()),
					'type' => 'lrc',
					'txt' => $result['lrc']
				];
			}else{
				if($data['type']=='kugou'){
					$ksctext = send_get(Config::get('api.getksc').'?s='.$data['songId']);
					if($ksctext==''){
						$json = send_get(Config::get('api.music').'?input='.$data['songId'].'&filter=id&type='.$data['type'].'&page=1&url='. $_SERVER['SERVER_NAME']);
						$result=json_decode($json,true);
						$result = [
							'file' => 'null',
							'time' => date('Y-m-d h:i:s', time()),
							'type' => 'lrc',
							'txt' => $result['lrc']
						];
					}else{
						$result = [
							'file' => Config::get('api.getksc').'?s='.$data['songId'],
							'time' => date('Y-m-d h:i:s', time()),
							'type' => 'ksc',
							'txt' => $ksctext
						];
					}
					
				}else{
					$ksc=isset($data['ksc'])?$data['ksc']:null;
					preg_replace('# #','',$ksc);
					$res = @file_get_contents($ksc,null,null,0,10);
					if ($res) {
						$ksctext = send_get($ksc);
						$result = [
							'file' => $ksc,
							'time' => date('Y-m-d h:i:s', time()),
							'type' => 'ksc',
							'txt' => $ksctext
						];
					}else{
						$json = send_get(Config::get('api.music').'?input='.$data['songId'].'&filter=id&type='.$data['type'].'&page=1&url='. $_SERVER['SERVER_NAME']);
						$result=json_decode($json,true);
						$result = [
							'file' => 'null',
							'time' => date('Y-m-d h:i:s', time()),
							'type' => 'lrc',
							'txt' => $result['lrc']
						];
					}
				}
			}
			Cache::set('musicLyric'.$data['type'].$data['id'],json_encode($result));
		}
		
		$result = json_encode($result);
		return response($data['jsoncallback']."(".$result.")");
    }
	
	public function mainColor(){
		$url = input('get.url');
        $cache = Cache::get('mainColor'.$url);
        if($cache){
            return response($cache);
        }
        $result = "var cont =";
        if($url != null && $url != ''){
            list($r,$g,$b) = mainColor($url);
            $result .= "'".$r.",".$g.",".$b."'";
            $grayLevel = $r * 0.299 + $g * 0.587 + $b * 0.114;
            if ($grayLevel >= 150) {
                $result .= ";font_color='0,0,0';";
            }else{
                $result .= ";font_color='255,255,255';";
            }
        }else{
            $result .= "'0,0,0';font_color='255,255,255';";
        }

        // 设置缓存
        Cache::set('mainColor'.$url,$result);
        return $result;
    }
	
	public function PlayerJs($id){
        $player=Player::where('id','=',$id)->find();
		$user=Users::where('uid','=',$player['user_id'])->find();
		if($user['power']==2){
			$theme=1;
		}else{
			$theme=$player['theme'];
		}
		$url = get_domain().'static/theme/'.$theme.'/player/js/player.js';
        return redirect($url);
    }
	
	public function PlayerCss($id){
        $player=Player::where('id','=',$id)->find();
		$user=Users::where('uid','=',$player['user_id'])->find();
		if($user['power']==2){
			$theme=1;
		}else{
			$theme=$player['theme'];
		}
		$url = get_domain().'static/theme/'.$theme.'/player/css/player.css';
		return redirect($url);
    }
}
