<?php
namespace app\model;

class PlayerAuth extends Base
{
	public static function add($data)
    {
        $self = new static();
        $check = $self->insert([
			'player_id'=> $data['id'],
			'domain'=> $data['domain'],
			'remark'=> $data['remark']
		]);
        if ($check) {
            return true;
        } else {
            return false;
        }
    }
}