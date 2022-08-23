<?php
namespace app\model;

class Chat extends Base
{
    public static function loadNewList($id)
    {
        $self = new static();
        $load_id = $id-20;
        $data = $self->where('id','>',$load_id)->order('time asc')->limit(20)->select();
        return $data;
    }
}