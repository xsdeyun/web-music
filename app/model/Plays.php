<?php
namespace app\model;

class Plays extends Base
{
    public static function add($data)
    {
        $self = new static();
        $check = $self->insert($data);
        if ($check) {
            return true;
        } else {
            return false;
        }
    }
}