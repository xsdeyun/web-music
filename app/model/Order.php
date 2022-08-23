<?php
namespace app\model;

class Order extends Base
{

    public static function search()
    {
        $page = input('page/d');
        $pageSize = input('limit/d');
        $page = ($page < 1) ? 1 : $page;
        $pageSize = ($pageSize < 1 || $pageSize > 50) ? 10 : $pageSize;
        $self = new static();
        $query = $self->alias('a');
        $orderid = input('orderid');
        !empty($orderid) && $query->where('a.orderid', '=', $orderid);
        $type = input('type');
        !empty($type) && $query->where('a.type', '=', $type);
        $trade_no = input('trade_no');
        !empty($trade_no) && $query->where('a.trade_no', '=', $trade_no);
        $query2 = clone $query;
        return [
            'total' => $query2->count('a.trade_no'),
            'list' => $query->page($page, $pageSize)->order('a.time desc')->select()
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
}