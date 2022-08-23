<?php
namespace app\model;

use think\facade\Config;
use think\facade\Db;

class Pays extends Base
{

    public static function Submit_Pay($userInfo, $data)
    {
        $self = new static();
        switch ($data['shop']) {
            case 'vip':
			    $name='永久付费版';
                $money=Config::get('web.vipmoney');
                break;
            case 'pie':
				$name='1个播放器额度';
                $money=Config::get('web.piemoney');
                break;
        }
		$insert = [
            'uid' => $userInfo['uid'],
            'qq' => $userInfo['qq'],
            'orderid' => date("YmdHis") . rand(111, 999),
            'addtime' => date('Y-m-d H:i:s'),
            'name' => $name,
            'money' => $money,
            'type' => $data['paytype'],
            'shop' => $data['shop'],
            'shopid' => 1,
        ];
		if ($self->insert($insert)) {
            $row = $self->where('uid', '=', $userInfo['uid'])->order('addtime desc')->find();
			$pay_url = '/Epay/submit?orderid=' . $row['orderid'] . '&type=' . $data['paytype'] . '';
            $result = $pay_url;
        }
        return $result;
    }
	
    public
    static function findByOrderId($orderid)
    {
        $self = new static();
        if ($result = $self->where('orderid', '=', $orderid)->find()) {
            return $result;
        } else {
            return false;
        }
    }

    public
    static function updateByOrderId($orderid, $data)
    {
        $self = new static();
        if ($result = $self->where('orderid', '=', $orderid)->update($data)) {
            return $result;
        } else {
            return false;
        }
    }
}