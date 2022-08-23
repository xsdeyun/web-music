<?php
namespace app\model;

class Links extends Base
{
	public static function search()
    {
        $page = input('page/d');
        $pageSize = input('limit/d');
        $page = ($page < 1) ? 1 : $page;
        $pageSize = ($pageSize < 1 || $pageSize > 50) ? 10 : $pageSize;
        $self = new static();
        $query = $self->alias('a');
        $query2 = clone $query;
        return [
            'total' => $query2->count('a.id'),
            'list' => $query->page($page, $pageSize)->order('a.id desc')->select()
        ];
    }
	
    public static function add($data)
    {
        $self = new static();
        if ($result = $self->insert($data)) {
            return $result;
        } else {
            return false;
        }
    }
	
	public
    static function delByid($id)
    {
        $self = new static();
        if ($result = $self->where('id', '=', $id)->delete()) {
            return $result;
        } else {
            return false;
        }
    }
}