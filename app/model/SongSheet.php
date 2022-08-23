<?php
namespace app\model;

use app\model\PlayerSongSheet;

class SongSheet extends Base
{
    public static function add($data)
    {
        $self = new static();
        $check = $self->insert([
        			'id'=> $data['id'],
					'user_id'=> $data['uid'],
					'status' => '0',
					'type' => 'sdtj',
                    'author' => $data['author'],
                    'name'=> $data['name'],
                    'create_time' => date("Y-m-d H:i:s")]);
        if ($check) {
            return true;
        } else {
            return false;
        }
    }
	
	public static function sets($data)
    {
        $self = new static();
        $check = $self->where('id', $data['id'])->update([
					'status' => $data['status'],
                    'name'=> $data['name'],
                    'author' => $data['author']]);
        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    // 一对多关联
    public
	static function songs(){
        return $this->hasMany('Song','song_sheet_id');
    }

    // 查询歌单关联的播放器
    public
	static function songSheetPlayers($songSheetId){
        return PlayerSongSheet::where('song_sheet_id',$songSheetId)->select();
    }
	
	public
    static function checkSheetKey($key)
    {
		$self = new static();
		if(!$row=$self->where("id",$key)->find()){
			return true;
		}else{
			return false;
		}
    }
	
	public
    static function checkSheetUid($id,$uid)
    {
		$self = new static();
		if(!$row=$self->where("id=:id and user_id=:user_id")->bind(['id'=>$id,"user_id"=>$uid])->find()){
			return true;
		}else{
			return false;
		}
    }
	
	
}