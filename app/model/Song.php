<?php
namespace app\model;

use think\facade\Config;

class Song extends Base
{
	
    public static function findMusicInfo($data){
		$json = send_get(Config::get('api.music').'?input='.$data['songid'].'&filter=id&type='.$data['type'].'&page=1&url='. $_SERVER['SERVER_NAME']);
		$data=json_decode($json,true);
        if($data==''){
			return '';
		}else{
			$arr = [
				"code" => 0,
				"song_name" => $data['title'],
				"artist_name" => $data['author'],
				"album_name" => $data['title'],
				"album_cover" => $data['pic'],
				"location" => '',
				"lyric" => '',
			];
			return $arr;
		}
		
    }
	
	
	public static function findSheetInfo($type,$songsheetid) {
		if($type=='wy'){
    		$data = send_get('http://music.163.com/api/playlist/detail?id='.$songsheetid,'http://music.163.com/');
    		$arr = json_decode($data, true);
			$songs = $arr;
			$songs = $songs["result"]["tracks"];
			$song_list=[];
    		foreach ($songs as $value) {
			    $radio_song_id = $value['id'];
				$radio_authors = [];
				foreach ($value['artists'] as $key => $val) {
                $radio_authors[] = $val['name'];
				}
				$radio_author = implode(',', $radio_authors);
			    $song_list[]= Array(
				'type' => 'netease',
				'song_id' => $radio_song_id,
				'name' => $value['name'],
				'artist_name' => $radio_author,
				'album_cover' => $value['album']['picUrl'].'?param=300x300',
				'album_name' => $value['album']['name'],
				);
    		}
		}elseif($type=='kg'){
			$data = send_get('http://www.kugou.com/yy/special/song/sid='.$songsheetid);
    		$arr = json_decode($data, true);
			$songs = $arr;
			$songs = $songs["data"];
			$song_list=[];
    		foreach ($songs as $value) {
				$data = array(
				'songid' => $value['HASH'],
				'type' => 'kugou'
				);
				$info = Song::findMusicInfo($data);
			    $song_list[]= Array(
				'type' => 'kugou',
				'song_id' => $value['HASH'],
				'name' => $value['songname'],
				'artist_name' => $value['singername'],
				'album_cover' => str_replace('{size}', '150', $value['authors'][0]['sizable_avatar']),
				'album_name' => $value['album_name'],
				);
			}
		
		}
		if($songs==''){
			return '';
		}else{
			return $song_list;
		}
	}
}