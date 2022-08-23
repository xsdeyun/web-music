<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\model\Users;
use think\facade\Session;
use think\facade\Cookie;
use think\middleware\SessionInit;
use PHPMailer\SendEmail;
use app\util\geetest\GeetestLib;

class LoginAjax extends Common
{
    public function login()
    {
		$data = input('post.');	
		switch (true) {
            case (!$this->geetest_check($data['geetest_challenge'], $data['geetest_validate'], $data['geetest_seccode'])):
                $result['msg'] = '验证码效验失败，请重试';
            break;
			default;
			$rule=[
				'username'  => 'require|alphaDash|length:5,20',
				'password'  => 'require|alphaNum|length:5,20',
			];
			$message=[
				'username.require'=>'用户名不能为空',
				'username.length'=>'用户名长度必须在5到20之间',
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
			}elseif(Users::checkUsername($data['username']) == true){
			$result = [
						'code' => -1,
						'msg' => '用户名不存在'
					];
			}elseif(Users::checkPass($data) == false){
				$result = [
						'code' => -1,
						'msg' => '账号或密码错误'
					];
			}elseif(Users::login($data)){
					$result = [
						'code' => 0,
						'msg' => '登录成功'
					];
			}
			break;
		}
        return json($result);
    }
	
	public function reg()
	{
		$data = input('');
		$rule=[
			'username'  => 'require|alphaDash|length:5,20',
			'password'  => 'require|alphaNum|length:5,20',
			'qq'    => 'require|number|length:4,13',
			'mail'    => 'require',
			'code'    => 'require',
		];
		$message=[
			'username.require'=>'用户名不能为空',
			'username.length'=>'用户名长度必须在5到20之间',
			'username.alphaDash'=>'用户名只能是字母、数字和下划线_及破折号-',
			'password.require'=>'密码不能为空',
			'password.alphaNum'=>'密码只能字母和数字',
			'password.length'=>'密码长度必须在5到20之间',
			'qq.require'=>"QQ不能为空",
			'qq.number'=>"QQ只能数字",
			'qq.length'=>"QQ长度必须在4到13之间",
			'mail.require'=>"邮箱账号不能为空",
			'mail.require'=>"邮箱验证码不能为空",
		];
		
		$validate=new \think\Validate($rule,$message);
		if(!$validate->check($data)){
			$result = [
				'code' => -1,
				'msg' => $validate->getError()
			];
		}elseif($this->checkcode($data['code']) != true){
			$result = [
				'code' => -1,
				'msg' => '邮箱验证码错误'
			];
		}elseif(Users::checkUsername($data['username']) != true){
			$result = [
				'code' => -1,
				'msg' => '用户名已被注册'
			];
		}elseif(Users::checkQq($data['qq']) != true){
			$result = [
				'code' => -1,
				'msg' => 'QQ已被其他用户绑定'
			];
		}elseif(Users::where('mail', '=', $data['mail'])->find()){
			$result = [
				'code' => -1,
				'msg' => '此邮箱已被其他用户绑定'
			];
		}elseif(Users::reg($data)){
			$result = [
				'code' => 0,
				'msg' => '注册成功'
			];
		}
        return $result;
    }
	
	public function find()
	{
		$data = input('');
		$rule=[
			'password'  => 'require|alphaNum|length:5,20',
			'mail'    => 'require',
			'code'    => 'require',
		];
		$message=[
			'password.require'=>'密码不能为空',
			'password.alphaNum'=>'密码只能字母和数字',
			'password.length'=>'密码长度必须在5到20之间',
			'mail.require'=>"邮箱账号不能为空",
			'mail.require'=>"邮箱验证码不能为空",
		];
		
		$validate=new \think\Validate($rule,$message);
		if(!$validate->check($data)){
			$result = [
				'code' => -1,
				'msg' => $validate->getError()
			];
		}elseif($this->checkcode($data['code']) != true){
			$result = [
				'code' => -1,
				'msg' => '邮箱验证码错误'
			];
		}elseif(!Users::where('mail', '=', $data['mail'])->find()){
			$result = [
				'code' => -1,
				'msg' => '此邮箱未被任何用户绑定'
			];
		}elseif(Users::findpassword($data)){
			$result = [
				'code' => 0,
				'msg' => '重置密码成功'
			];
		}
        return $result;
    }
	
	public function sendcode()
    {
		if( \think\facade\Request::instance()->isAjax()){
			$email=input('get.email');
			$code=rand(1000,9999);
			$msg='尊敬的用户，您正在进行邮箱验证，本次请求的验证码为：'.$code;
			$result = SendEmail::SendEmail('邮箱验证码',$msg,$email);
			cookie('regcode',md5($code));
			if($result){
				$result = [
					'code' => 0,
					'msg' => '已发送验证码到邮箱'.$email
				];
			}else{
				$result = [
					'code' => 0,
					'msg' => '发送验证码失败'
				];
			}
		}else{
			$result = [
				'code' => 0,
				'msg' => '非法请求'
			];
		}
        return json($result);
    }
	
	public function checkcode($code)
    {
		if(md5($code)==Cookie::get('regcode')){
			Cookie::delete('regcode');
			return true;
		}else{
			return false;
		}
    }
}
