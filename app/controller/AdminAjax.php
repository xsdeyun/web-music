<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Config;
use think\facade\Db;
use think\facade\Cache;
use think\facade\Request;
use think\facade\Session;
use app\model\Users;
use app\model\Player;
use app\model\SongSheet;
use app\model\Song;
use app\model\Plays;
use app\model\PlayerAuth;
use app\model\PlayerSongSheet;
use app\model\Links;

class AdminAjax extends Common
{
	public function encode_netease_data($data)
    {
        $_key = '7246674226682325323F5E6544673A51';
        $data = json_encode($data);
        if (function_exists('openssl_encrypt')) {
            $data = openssl_encrypt($data, 'aes-128-ecb', pack('H*', $_key));
        } else {
            $_pad = 16 - (strlen($data) % 16);
            $data = base64_encode(mcrypt_encrypt(
                MCRYPT_RIJNDAEL_128,
                hex2bin($_key),
                $data . str_repeat(chr($_pad), $_pad),
                MCRYPT_MODE_ECB
            ));
        }
        $data = strtoupper(bin2hex(base64_decode($data)));
        return ['eparams' => $data];
    }
	
	private function getFilePath($fileName, $content)
	{
		$path = dirname(__FILE__) . "\\$fileName";
		if (!file_exists($path)) {
			file_put_contents($path, $content);
		}
		return $path;
	}

	private function getCupUsageVbsPath()
	{
		return $this->getFilePath(
			'cpu_usage.vbs',
			"On Error Resume Next
			Set objProc = GetObject(\"winmgmts:\\\\.\\root\cimv2:win32_processor='cpu0'\")
			WScript.Echo(objProc.LoadPercentage)"
		);
	}

	private function getMemoryUsageVbsPath()
	{
		return $this->getFilePath(
			'memory_usage.vbs',
			"On Error Resume Next
			Set objWMI = GetObject(\"winmgmts:\\\\.\\root\cimv2\")
			Set colOS = objWMI.InstancesOf(\"Win32_OperatingSystem\")
			For Each objOS in colOS
			Wscript.Echo(\"{\"\"TotalVisibleMemorySize\"\":\" & objOS.TotalVisibleMemorySize & \",\"\"FreePhysicalMemory\"\":\" & objOS.FreePhysicalMemory & \"}\")
			Next"
		);
	}

	public function getCpuUsage()
	{
		$path = $this->getCupUsageVbsPath();
		exec("cscript -nologo $path", $usage);
		return $usage[0];
	}

	public function getMemoryUsage()
	{
		$path = $this->getMemoryUsageVbsPath();
		exec("cscript -nologo $path", $usage);
		$memory = json_decode($usage[0], true);
		$memory['usage'] = Round((($memory['TotalVisibleMemorySize'] - $memory['FreePhysicalMemory']) / $memory['TotalVisibleMemorySize']) * 100);
		return $memory;
	}

	public function getLinuxCount()
    {
		$fp = popen('top -b -n 2 | grep -E "(Cpu|Mem|Tasks)"',"r"); //????????????????????????cpu?????????????????????
		$rs = "";
		while(!feof($fp)){
			$rs .= fread($fp,1024);
		}
		pclose($fp);
		$sys_info = explode("\n",$rs);

		$cpu_info = explode(",",$sys_info[1]); //CPU????????? ??????
		$mem_info = explode(",",$sys_info[2]); //??????????????? ??????
		//????????????????????????
		//CPU?????????
		$cpu_usage = trim(trim($cpu_info[0],'%Cpu(s):  '),'%us'); //?????????
		//???????????????
		$mem_total = trim(trim($mem_info[0],'KiB Mem : '),'total');
		$mem_used = trim($mem_info[2],'used');
		$mem_usage = round(100*intval($mem_used)/intval($mem_total),2); //?????????
		$result = [
			'mem'	=>	$mem_usage.'%',
			'memRealUsed'	=>	getFilesize(intval($mem_used)),
			'memTotal'	=>	getFilesize(intval($mem_total)),
			'cpu'	=>	$cpu_usage.'%',
		];
        return $result;
	}
  
    public function menu()
    {
		$this->checkLogin();
		$userInfo = Users::getLoginUser();
		if($userInfo['power']==0){
			$userInfo['lv']='?????????';
			$home_head=[
				[
					'jump'	=>	'/',
					'title'	=>	'<i class=\"layui-icon layui-icon-console\"></i> ????????????'
				],[
					'jump'	=>	'/help',
					'title'	=>	'????????????'
				],[
					'jump'	=>	'/webset',
					'title'	=>	'????????????'
				],[
					'jump'	=>	'/users/act/list',
					'title'	=>	'????????????'
				],[
					'jump'	=>	'/links/act/list',
					'title'	=>	'????????????'
				],[
					'jump'	=>	'/orders/act/list',
					'title'	=>	'????????????'
				]
			];
		}elseif($userInfo['power']==1){
			$userInfo['lv']='?????????';
			$home_head=[
				[
					'jump'	=>	'/',
					'title'	=>	'<i class=\"layui-icon layui-icon-console\"></i> ????????????'
				],
				[
					'jump'	=>	'/help',
					'title'	=>	'????????????'
				]
			];
		}elseif($userInfo['power']==2){
			$userInfo['lv']='?????????';
			$home_head=[
				[
					'jump'	=>	'/',
					'title'	=>	'<i class=\"layui-icon layui-icon-console\"></i> ????????????'
				],
				[
					'jump'	=>	'/help',
					'title'	=>	'????????????'
				]
			];
		}
		$players = Player::where('user_id', '=', $userInfo['uid'])->order('create_time desc')->select();
		$player_head=[];
		foreach($players as $k=>$v){
			$player_head[$k]=[
				'jump'	=>	'/Player/id/'.$players[$k]['id'],
				'title'	=>	'<i class="layui-icon layui-icon-play"></i>'.$players[$k]['name']
			];
		}
		if(!$player_head){
			$player_head=[[
				'jump'	=>	'/#',
				'title'	=>	'??????????????????'
			]];
		}
		
		$sheets = SongSheet::where('user_id', '=', $userInfo['uid'])->order('create_time desc')->select();
		$sheet_head=[];
		foreach($sheets as $k=>$v){
			$sheet_head[$k]=[
				'jump'	=>	'/songSheet/id/'.$sheets[$k]['id'],
				'title'	=>	'<img src="/static/images/type/sdtj.png" class="typeico">'.$sheets[$k]['name']
			];
		}
		if(!$sheet_head){
			$sheet_head=[[
				'jump'	=>	'/#',
				'title'	=>	'???????????????'
			]];
		}
		$result = [
			'code' => 0,
			'data' => [
				[
					'title'	=>	$userInfo['lv'].'??????',
					'icon'	=>	'layui-icon-home',
					'list'	=>	$home_head,
				],[
					'title'	=>	'????????????',
					'icon'	=>	'layui-icon-cart-simple',
					'jump'	=>	'/shop',
				],[
					'title'	=>	'?????????['.Player::where('user_id',$userInfo['uid'])->count().']',
					'icon'	=>	'layui-icon-set',
					'list'	=>	$player_head,
				],[
					'title'	=>	'??????['.SongSheet::where('user_id',$userInfo['uid'])->count().']',
					'icon'	=>	'layui-icon-user',
					'list'	=>	$sheet_head,
				]
			],
			'config' =>	[
				'logo'	=>	'<i class="layui-icon layui-icon layui-icon-headset" style="font-weight:bold;font-size:20px;"></i><span style="font-weight: bold;font-size: 20px"> '.Config::get('web.webname').'</span>',
			],
			'msg'	=>	''
		];
        return json($result);
	}
	
	public function MycountList()
    {
		$this->checkLogin();
		$userInfo = Users::getLoginUser();
		$players=Player::where('user_id',$userInfo['uid'])->count();
		$plays = Player::where('user_id', '=', $userInfo['uid'])->order('endtime desc')->select();
		if($players==0){
			$plays='??????????????????';
		}else{
			$plays=$plays[0]['name'];
		}
		$pies = $userInfo['pie'];
		$result = [
			'code' => 0,
			'data' => [
				'players'	=>	Player::where('user_id',$userInfo['uid'])->count(),
				'sheets'	=>	SongSheet::where('user_id',$userInfo['uid'])->count(),
				'pies'	=>	$userInfo['pie'],
				'plays'	=>	$plays
			],
			'msg'	=>	''
		];
        return json($result);
	}
	
	public function editPlayerSongSheet()
	{
		$data = input('post.');
		$userInfo = Users::getLoginUser();
		if(Player::checkPlayerUid($data['playerId'],$userInfo['uid'])== true){
			$result = [
				'code' => -1,
				'msg' => '????????????'
			];
		}else{
			Cache::delete('info'.$data['playerId']);
			
			$ids = request()->param('ids/a');
			
			// ?????????????????????
			Db::name('player_song_sheet')->where('player_id',$data['playerId'])->delete();

			if($ids != null){
				$joins = [];
				for($i = 0;$i < count($ids);$i++){
					$joins[$i] = ['player_id' => $data['playerId'],'song_sheet_id' => $ids[$i],'taxis'=>$i];
				}

				//???????????????????????????
				Db::name('player_song_sheet')->insertAll($joins);
			}
			$result = [
				'code' => 0,
				'msg' => '????????????[???????????????]'
			];
		}
        return json($result);
    }
	
	public function Player($act)
    {
		$this->checkLogin();
		$userInfo = Users::getLoginUser();
		switch ($act) {
            case 'add':
				$data = input('post.');
				$data['uid'] = $userInfo['uid'];
				$data['id']	= uniqid();
				$rule=[
					'name'  => 'require',
				];
				$message=[
					'name.require'=>'???????????????????????????',
				];
				$validate=new \think\Validate($rule,$message);
				if(!$validate->check($data)){
					$result = [
						'code' => -1,
						'msg' => $validate->getError()
					];
				}elseif($userInfo['pie'] < 1){
					$result = [
						'code' => -1,
						'msg' => '?????????????????????',
					];
				}elseif(Player::add($data)){
					$pie['pie'] = $userInfo['pie'] - 1;
					Users::updateByUid($userInfo['uid'],$pie);
					$result = [
						'code' => 0,
						'id'	=>	$data['id'],
						'msg' => '?????????????????????,??????????????????'
					];
				}
			break;
			case 'auth':
				$data = input('post.');
				if($data['remark']==''){
					$data['remark']='?????????';
				}
				$check=PlayerAuth::where('player_id','=',$data['id'])
					->where('domain','=',$data['domain'])
					->find(); 
				$number=PlayerAuth::where('player_id','=',$data['id'])->count(); 
				if($userInfo['power']==2){
					if($number>=1){
						$result = [
							'code' => -1,
							'msg' => '?????????????????????????????????',
						];
					}else{
						if(!$check){
							PlayerAuth::add($data);
							$result = [
								'code' => 0,
								'msg' => '??????????????????',
							];
						}else{
							$result = [
								'code' => -1,
								'msg' => '???????????????',
							];
						}
					}
				}else{
					if(!$check){
						PlayerAuth::add($data);
						$result = [
							'code' => 0,
							'msg' => '??????????????????',
						];
					}else{
						$result = [
							'code' => -1,
							'msg' => '???????????????',
						];
					}
				}
			break;
			case 'delauth':
				$data = input('post.');
				$del=PlayerAuth::where('player_id','=',$data['id'])->where('domain','=',$data['domain'])->delete();
				if($del){
					$result = [
						'code' => 0,
						'msg' => '??????????????????',
					];
				}else{
					$result = [
						'code' => -1,
						'msg' => '??????????????????',
					];
				}
			break;
			case 'edit':
				$data = input('post.');
				Cache::delete('info'.$data['id']);
				if(!array_key_exists('phone_load',$data)){
					$data['phone_load']='0';
				}
				if(!array_key_exists('show_lrc',$data)){
					$data['show_lrc']='0';
				}
				if(!array_key_exists('random_player',$data)){
					$data['random_player']='0';
				}
				if(!array_key_exists('auto_player',$data)){
					$data['auto_player']='0';
				}
				if(!array_key_exists('show_notes',$data)){
					$data['show_notes']='0';
				}
				if(!array_key_exists('showmsg',$data)){
					$data['showmsg']='0';
				}
				if(!array_key_exists('switchopen',$data)){
					$data['switchopen']='0';
				}
				if(!array_key_exists('show_greeting',$data)){
					$data['show_greeting']='0';
				}
				Player::where('id','=',$data['id'])->data($data)->update();
				$result = [
					'code' => 0,
					'msg' => '????????????[???????????????]'
				];
			break;
			case 'del':
				$data = input('post.');
				Cache::delete('info'.$data['id']);
				$userInfo = Users::getLoginUser();
				// ?????????????????????
				PlayerSongSheet::where('player_id',$data['id'])->delete();
				// ???????????????
				Player::where('id',$data['id'])->delete();
				$pie['pie'] =$userInfo['pie'] + 1;
				Users::updateByUid($userInfo['uid'],$pie);
				$result = [
					'code' => 0,
					'msg' => '????????????'
				];
			break;
		}
        return json($result);
	}
	
	public function songSheet($act)
    {
		$this->checkLogin();
		$userInfo = Users::getLoginUser();
		switch ($act) {
            case 'add':
				$data = input('post.');
				$data['id']	= uniqid();
				$data['uid'] = $userInfo['uid'];
				$data['author'] = $userInfo['username'];
				$rule=[
					'name'  => 'require',
				];
				$message=[
					'name.require'=>'????????????????????????',
				];
				$validate=new \think\Validate($rule,$message);
				if(!$validate->check($data)){
					$result = [
						'code' => -1,
						'msg' => $validate->getError()
					];
				}elseif(SongSheet::add($data)){
					$result = [
						'code' => 0,
						'id'	=>	$data['id'],
						'msg' => '????????????',
					];
				}
			break;
			case 'edit':
				$data = input('post.');
				$rule=[
					'name'  => 'require',
				];
				$message=[
					'name.require'=>'????????????????????????',
				];
				$validate=new \think\Validate($rule,$message);
				if(!$validate->check($data)){
					$result = [
						'code' => -1,
						'msg' => $validate->getError()
					];
				}elseif(SongSheet::checkSheetUid($data['id'],$userInfo['uid'])== true){
					$result = [
						'code' => -1,
						'msg' => '????????????',
					];
				}else{
					$players = SongSheet::songSheetPlayers($data['id']);
					if(count($players) > 0){
						foreach ($players as $value){
							// ??????api??????
							Cache::delete('info'.$value->player_id);
						}
					}
					SongSheet::sets($data);
					$result = [
						'code' => 0,
						'msg' => '????????????[???????????????]',
					];
				}
			break;
			case 'del':
				$data = input('post.');
				$players = SongSheet::songSheetPlayers($data['id']);
						if(count($players) > 0){
							foreach ($players as $value){
								// ??????api??????
								Cache::delete('info'.$value->player_id);
							}
						}
				// ??????????????????
				Song::where('song_sheet_id', $data['id'])->delete();
				// ?????????????????????
				PlayerSongSheet::where('song_sheet_id',$data['id'])->delete();
				// ????????????
				SongSheet::where('id',$data['id'])->delete();
				$result = [
					'code' => 0,
					'msg' => '????????????'
				];
			break;
		}
        return json($result);
	}
	
	public function Song($act)
    {
		$this->checkLogin();
		$userInfo = Users::getLoginUser();
		switch ($act) {
            case 'info':
				$data = input('post.');
				$rule=[
					'songid'  => 'require',
				];
				$message=[
					'songid.require'=>'??????ID????????????',
				];
				$validate=new \think\Validate($rule,$message);
				if(!$validate->check($data)){
					$result = [
						'code' => -1,
						'msg' => $validate->getError()
					];
				}else{
					$data2 = Song::findMusicInfo($data);
					if($data2==false){
						$result = [
							'code' => -1,
							'msg' => '?????????????????????'
						];
					}else{
						$result = $data2;
					}	
				}
			break;
			case 'check':
				$data = input('post.');
				$rule=[
					'name'  => 'require',
					'album_name'  => 'require',
					'artist_name'  => 'require',
					'album_cover'  => 'require',
					'location'  => 'require',
				];
				$message=[
					'name.require'=>'????????????????????????',
					'album_name.require'=>'????????????????????????',
					'artist_name.require'=>'????????????????????????',
					'album_cover.require'=>'??????????????????????????????',
					'location.require'=>'??????????????????????????????',
				];
				$validate=new \think\Validate($rule,$message);
				if(!$validate->check($data)){
					$result = [
								'code' => -1,
								'msg' => $validate->getError()
							];
				}else{
					$result = [
						'code' => 0,
						'name'  => $data['name'],
						'album_name'  => $data['album_name'],
						'artist_name'  => $data['artist_name'],
						'album_cover'  => $data['album_cover'],
						'location'  => $data['location'],
						'lyric'  => $data['lyric'],
					];
				}
			break;
			case 'save':
				$jsonData = $_POST['jsonData'];
				$songSheetId = $_POST['songSheetId'];
				// ????????????
				$players = SongSheet::songSheetPlayers($songSheetId);
				if(count($players) > 0){
					foreach ($players as $value){
						// ??????api??????
						Cache::delete('info'.$value->player_id);
					}
				}

				// ??????????????????????????????
				Song::where('song_sheet_id', $songSheetId)->delete();

				// ????????????????????????
				$array = json_decode($jsonData, true);
				foreach ($array as $key => $value) {
					$value['song_sheet_id'] = $songSheetId;
					$value['id'] = uniqid();
					$array[$key] = $value;
				}
				if(Db::name('song')->replace()->insertAll($array)){
					$result = [
						'code' => 0,
						'msg' => '????????????[???????????????]',
					];
				}else{
					$result = [
						'code' => -1,
						'msg' => '????????????',
					];
				}
			break;
			case 'search':
				$data=input('get.');
				$s=$data['song_name'];
				switch ($data['type']) {
					case 'netease':
						$body = $this->encode_netease_data([
							'method' => 'POST',
							'url' => 'http://music.163.com/api/cloudsearch/pc',
							'params' => [
								's' => $s,
								'type' => 1,
								'offset' => 1 * 10 - 10,
								'limit' => 50
							]
						]);
						$data=send_get('http://music.163.com/api/linux/forward?eparams='.$body['eparams'],1,'http://music.163.com/');
						$arr=json_decode($data, true);
						$songs = [];
						foreach($arr['result']['songs'] as $value){
							$songs[] = array(
							'song_name' => $value['name'],
							'type' => 'netease',
							'id' => $value['id'],
							'artist_name' => $value['ar'][0]['name']
							);
						}
						break;
					case  'kugou':
						$data=send_get('http://mobilecdn.kugou.com/api/v3/search/song?keyword='.$s.'&format=json&page=1&pagesize=50',0,'http://m.kugou.com/v2/static/html/search.html');
						$arr=json_decode($data, true);
						$songs = [];
						foreach($arr['data']['info'] as $value){
							$songs[] = array(
							'song_name' => $value['songname'],
							'type' => 'kugou',
							'id' => $value['hash'],
							'artist_name' => $value['singername']
							);
						}
						break;
				}
			$result['songs'] = $songs;
			break;
			case 'sheet':
				$data = input('post.');
				$rule=[
					'sheetid'  => 'require',
				];
				$message=[
					'sheetid.require'=>'??????ID????????????',
				];
				$validate=new \think\Validate($rule,$message);
				if(!$validate->check($data)){
					$result = [
						'code' => -1,
						'msg' => $validate->getError()
					];
				}else{
					$songs = Song::findSheetInfo($data['type'],$data['sheetid']);
					if($songs==''){
						$result = [
							'code' => -1,
							'msg' => '?????????????????????'
						];
					}else{
						$result = [
						'code' => 0,
						'msg' => '????????????',
						'songs' => $songs
						];
					}	
				}
			break;
		}
        return json($result);
	}
	
	public function play($id)
    {
		$this->checkLogin();
		$player=Player::where('id',$id)->find();
		$data=[
			'plays'	=>	$player['plays']+1,
			'endtime'	=>	date('Y-m-d H:i:s')
		];
		Player::where('id','=',$id)->data($data)->update();
		$data2=[
			'player_id'	=>	$id,
			'user_id'	=>	'1',
			'side'	=>	'ios',
			'create_time'	=>	date('Y-m-d H:i:s')
		];
		Plays::add($data2);
		$result = [
			'code' => 0,
			'msg'	=>	'??????????????????['.$player['name'].']'
		];
        return json($result);
	}
	
	public function clearCache()
    {
		$this->checkLogin();
		if(cache(NUll)){
			$result = [
				'code' => 0,
				'msg'	=>	'?????????????????????????????????'
			];
		}else{
			$result = [
				'code' => -1,
				'msg'	=>	'??????????????????'
			];
		}
        return json($result);
	}

	public function load()
    {
		$this->checkLogin();
		$userInfo = Users::getLoginUser();
		$plays = Plays::where(1)->order('create_time desc')->select();
		$play = 0;
		$Todayplay = 0;
		foreach($plays as $k=>$v){
			$b = substr($plays[$k]['create_time'],0,10);
			$c = date('Y-m-d');
			if($b==$c){
				$Todayplay = $Todayplay+1;
			}else{
				$Todayplay = $Todayplay;
			}
			$play=$play+1;
		}
		
		$meplays = Plays::where('user_id','=',$userInfo['uid'])->order('create_time desc')->select();
		$meplay = 0;
		$meTodayplay = 0;
		foreach($meplays as $k=>$v){
			$b = substr($meplays[$k]['create_time'],0,10);
			$c = date('Y-m-d');
			if($b==$c){
				$meTodayplay = $meTodayplay+1;
			}else{
				$meTodayplay = $meTodayplay;
			}
			$meplay=$meplay+1;
		}
		$players = Player::where(1)->count();
		if($players==0){
			$newplay='?????????';
			$newplaytime=date('Y-m-d H:i:s');
		}else{
			$newplay = Player::where(1)->order('endtime desc')->select();
			$newplay=$newplay[0]['name'];
			$newplaytime=isset($newplay[0]['endtime']) ?$newplay[0]['endtime'] : date('Y-m-d H:i:s');
		}
		$newplays = Player::order('endtime desc')->limit(6)->select();
		$newplaylist='';
		foreach($newplays as $k=>$v){
			$user=Users::where('uid','=',$v['user_id'])->find();
			if($user['power']==0){
				$lv='?????????';
			}elseif($user['power']==1){
				$lv='?????????';
			}else{
				$lv='?????????';
			}
			if($k==0){
				$color='first';
			}elseif($k==1){
				$color='second';
			}elseif($k==2){
				$color='third';
			}else{
				$color='';
			}
			$newplaylist .='<tr><td><span class="'.$color.'"><img src="https://q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$user['qq'].'&spec=100" width="20px" style="border-radius: 5px;"> '.$v['name'].'</span></td><td><span class="'.$color.'">'.date( 'H:i:s',strtotime($v['endtime'])).'</span></td><td><span class="'.$color.'">'.$lv.'</span></td></tr>';
		}
		
		$newlogin = Users::order('time desc')->limit(6)->select();
		$newloginlist='';
		foreach($newlogin as $k=>$v){
			if($v['power']==0){
				$lv='?????????';
			}elseif($v['power']==1){
				$lv='?????????';
			}else{
				$lv='?????????';
			}
			if($v['time']==null){
				$time=='1599123926';
			}else{
				$time=$v['time'];
			}
			if($k==0){
				$color='first';
			}elseif($k==1){
				$color='second';
			}elseif($k==2){
				$color='third';
			}else{
				$color='';
			}
			
			$newloginlist .='<tr><td><span class="'.$color.'"><img src="https://q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$v['qq'].'&spec=100" width="20px" style="border-radius: 5px;"> '.hideStr($v['username'],2,2).'</span></td><td><span class="'.$color.'">'.date('h:i:s',$time).'</span></td><td><span class="'.$color.'">'.$lv.'</span></td></tr>';
		}
		$os_name=PHP_OS;
		if(strpos($os_name,"Linux")!==false){
			$count=$this->getLinuxCount();
			$result = [
				'code' => 0,
				'data' => [
					'mem'	=>	$count['mem'],
					'memRealUsed'	=>	$count['memRealUsed'],
					'memTotal'	=>	$count['memTotal'],
					'mems'		=>	'layui-progress-bar layui-bg-red',
					'cpu'	=>	$count['cpu'],
					'cpus'		=>	'layui-progress-bar',
					'play'	=>	whits($play),
					'todayplay'	=>	whits($Todayplay),
					'meplay'	=>	whits($meplay),
					'metodayplay'	=>	whits($meTodayplay),
					'newplay'	=>	$newplay,
					'newplaytime'	=>	$newplaytime,
					'newplaylist'	=>	$newplaylist,
					'newloginlist'	=>	$newloginlist
				],
				'msg'	=>	''
			];
		}else if(strpos($os_name,"WIN")!==false){
			$mem=$this->getMemoryUsage();
			$result = [
				'code' => 0,
				'data' => [
					'mem'	=>	$mem['usage'].'%',
					'memRealUsed'	=>	getFilesize($mem['TotalVisibleMemorySize']-$mem['FreePhysicalMemory']),
					'memTotal'	=>	getFilesize($mem['TotalVisibleMemorySize']),
					'mems'		=>	'layui-progress-bar layui-bg-red',
					'cpu'	=>	$this->getCpuUsage().'%',
					'cpus'		=>	'layui-progress-bar',
					'play'	=>	whits($play),
					'todayplay'	=>	$Todayplay,
					'meplay'	=>	whits($meplay),
					'metodayplay'	=>	$meTodayplay,
					'newplay'	=>	$newplay,
					'newplaytime'	=>	$newplaytime,
					'newplaylist'	=>	$newplaylist,
					'newloginlist'	=>	$newloginlist
				],
				'msg'	=>	''
			];
		}
        return json($result);
	}
	
	public function config()
    {
		$this->checkLogin();
		foreach (input('post.') as $k => $value) {
			Db::execute("INSERT INTO ocink_configs SET k='" . $k . "',v='" . $value . "' ON DUPLICATE KEY UPDATE v='" . $value . "'");
		}
		$result = [
			'code' => 0,
			'message' => '????????????'
		];
        return json($result);
    }
	
	public function userInfo()
    {
		$this->checkLogin();
		$userInfo = Users::getLoginUser();
		if($userInfo['power']==0){
			$userInfo['lv']='???????????????';
		}elseif($userInfo['power']==1){
			$userInfo['lv']='???????????????';
		}elseif($userInfo['power']==2){
			$userInfo['lv']='???????????????';
		}
		$result = [
			'code' => 0,
			'data' => $userInfo,
			'msg'	=>	''
		];
		
        return json($result);
	}
	
	public function password()
	{
		$userInfo = Users::getLoginUser();
		$data = input('post.');
		$result = Users::change_Password($userInfo['uid'],$data);
        return json($result);
    }
	
	private
    function checkLogin()
    {
        $check_Login = Users::checkLogin();
        if ($check_Login != null) {
            View::assign('alert', $check_Login['msg']);
            View::assign('url', $check_Login['url']);
            exit(View::fetch('common/error'));
        } else {
            $this->userInfo = Users::getLoginUser();
            View::assign('userInfo', $this->userInfo);
        }
    }
}
