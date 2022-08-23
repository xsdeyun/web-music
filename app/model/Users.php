<?php
namespace app\model;

use think\facade\Cookie;
use think\facade\Config;

class Users extends Base
{
    public static function search()
    {
        $page = input('page/d');
        $pageSize = input('limit/d');
        $page = ($page < 1) ? 1 : $page;
        $pageSize = ($pageSize < 1 || $pageSize > 50) ? 10 : $pageSize;
        $self = new static();
        $query = $self->alias('a');
        $username = input('username');
        !empty($username) && $query->where('a.username', '=', $username);
        $query2 = clone $query;
        return [
            'total' => $query2->count('a.uid'),
            'list' => $query->page($page, $pageSize)->order('a.regtime desc')->select()
        ];
    }

    public static function qqlogin($data)
    {
        $self = new static();
		$token=$data['openid'];
		$userInfo = $self->where('token', '=' ,$token)->find();
		$str = $userInfo['username'] . $userInfo['password'] . time() . real_ip();
		$sign = md5($str . md5('11144452888'));
		setcookie("pskey",authcode($userInfo['uid'], 'ENCODE', md5($str)),time()+3600*24,'/');
        setcookie("skey",md5($str),time()+3600*24,'/');
		setcookie("sid",$sign,time()+3600*24,'/');
        $update = $self->where('uid', '=', $userInfo['uid'])
		->update([
			'skey' => md5($str),
			'sid' => $sign,
			'dlip' => real_ip(),
			'city' => get_ip_city(real_ip()),
			'time' => time()
		]);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }
	
	public static function reg($data)
    {
        $self = new static();
        $insert['username'] = $data['username'];
		$insert['password'] = md5($data['password']);
        $insert['qq'] = $data['qq'];
		$insert['mail'] = $data['mail'];
		$insert['skey'] = '0';
        $insert['regtime'] = date("Y-m-d H:i:s");
        $insert['regip'] = real_ip();
        $insert['time'] = time();
		$insert['power'] = 2;
		$insert['pie'] = Config::get('web.regpie');
        $check = $self->insert($insert);
        if ($check) {
            return true;
        } else {
            return false;
        }
    }
	
	public static function login($userInfo)
    {
        $self = new static();
		$str = $userInfo['username'] . $userInfo['password'] . time() . real_ip();
		$sign = md5($str . md5('11144452888'));
		$userInfo = $self->where('username', '=' ,$userInfo['username'])->find();
		cookie("pskey",authcode($userInfo['uid'], 'ENCODE', md5($str)));
        cookie("skey",md5($str));
		cookie("sid",$sign);
        $update = $self->where('uid', '=', $userInfo['uid'])
            ->update([
				'skey' => md5($str),
                'sid' => $sign,
                'dlip' => real_ip(),
                'city' => get_ip_city(real_ip()),
                'time' => time()
            ]);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }
	
	public
    static function checkUsername($username)
    {
		$self = new static();
		if(!$row=$self->where("username",$username)->find()){
			return true;
		}else{
			return false;
		}
    }
	
	public
    static function checkQqToken($token)
    {
		$self = new static();
		if(!$row=$self->where("token",$token)->find()){
			return false;
		}else{
			return true;
		}
    }
	
	public
    static function checkQq($qq)
    {
		$self = new static();
		if(!$row=$self->where("qq",$qq)->find()){
			return true;
		}else{
			return false;
		}
    }
	
	public
    static function checkPass($userInfo)
    {
        $self = new static();
		if(!$row=$self->where("username=:username and password=:password")->bind(['username'=>$userInfo['username'],"password"=>md5($userInfo['password'])])->find()){
			return false;
		}else{
			return true;
        }
    }

    public
    static function change_Password($uid, $data)
    {
        $self = new static();
		$user_row = $self->where('uid', '=', $uid)->field('password')->find();
		$rule=[
			'password'  => 'require|alphaNum|length:5,20',
		];
		$message=[
			'password.require'=>'密码不能为空',
			'password.alphaNum'=>'密码只能字母和数字',
			'password.length'=>'密码长度必须在5到20之间',
		];
		
		$validate=new \think\Validate($rule,$message);
		if(!$validate->check($data)){
			$result = [
				'code' => -1,
				'msg' => $validate->getError()
			];
		}elseif (md5($data['outpass'])== $user_row['password']) {
			$new_pass = md5($data['password']);
			if ($self->where('uid', '=', $uid)->update(['password' => $new_pass])) {
				Cookie::delete('skey');
				Cookie::delete('sid');
				Cookie::delete('pskey');
				Cookie::delete('user_token');
				$result = [
					'code' => 0,
					'message' => '修改密码成功，请重新登录',
				];
			}
		} else {
			$result = [
				'code' => 1,
				'message' => '原密码不正确！'
			];
		}
        return $result;
    }
	
	public
    static function findpassword($data)
    {
        $self = new static();
		$user_row = $self->where('mail', '=', $data['mail'])->field('password')->find();
		$new_pass = md5($data['password']);
		$rule=[
			'password'  => 'require|alphaNum|length:5,20',
		];
		$message=[
			'password.require'=>'密码不能为空',
			'password.alphaNum'=>'密码只能字母和数字',
			'password.length'=>'密码长度必须在5到20之间',
		];
		
		$validate=new \think\Validate($rule,$message);
		if(!$validate->check($data)){
			$result = [
				'code' => -1,
				'msg' => $validate->getError()
			];
		}elseif ($self->where('mail', '=', $data['mail'])->update(['password' => $new_pass])) {
			$result = [
				'code' => 0,
				'msg' => '重置密码成功'
			];
		}
        return $result;
    }
	
    public
    static function updateByUid($uid, $data)
    {
        $self = new static();
        if ($result = $self->where('uid', '=', $uid)->update($data)) {
            return $result;
        } else {
            return false;
        }
    }
	
	public
    static function updateByUsername($username, $data)
    {
        $self = new static();
        if ($result = $self->where('username', '=', $username)->update($data)) {
            return $result;
        } else {
            return false;
        }
    }

    public
    static function delByUid($uid)
    {
        $self = new static();
        if ($result = $self->where('uid', '=', $uid)->delete()) {
            return $result;
        } else {
            return false;
        }
    }

    public
    static function getLoginUser()
    {
        $self = new static();
		$skey = cookie("skey");
        $pskey = authcode(cookie('pskey'), 'DECODE', $skey);
        //获取登录Cookie
        $uid = $pskey;
        //组成查询条件
        $where['uid'] = $uid;
        //通过Cookie存储的数据查询数据库记录
        if (!$uid || !$userInfo = $self->where($where)->find()) {
            //不存在
            return false;
        } else {
            //存在则返回该用户的这条记录内容
            return $userInfo;
        }
    }

    public
    static function checkLogin()
    {
		$skey = cookie("skey");
		if(!$skey){
			$result = [
				'url' => '/console#/user/login',
				'msg' => '请登录后再进行操作！'
			];
		}else{
			$self = new static();
			$sid = cookie("sid");
			$pskey = authcode(cookie('pskey'), 'DECODE', $skey);
			$user = $self
					->where('uid', '=',$pskey )
					->find();
			if ($sid == $user['sid']) {
				if ($user['skey'] === $skey) {
					$result = null;
				} else {
					$result = [
						'url' => '/console#/user/login',
						'msg' => '请登录后再进行操作！'
					];
				}
			} else {
				cookie('skey', null);
				cookie('sid', null);
				cookie('pskey', null);
				$result = [
					'url' => '/console#/user/login',
					'msg' => '您的账号在别处登录，请重新登录！'
				];
			}
		}
        return $result;
    }
}