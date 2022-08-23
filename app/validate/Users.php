<?php
namespace app\validate;

use think\Validate;

class Users extends Validate
{
    protected $rule = [
        'nickname' => 'require',
        'username' => 'require|min:5|max:25',
        'outpass' => 'require|min:6|alphaNum|max:18',
        'password' => 'require|min:6|alphaNum|max:18',
        'code' => 'require|min:6|max:6',
        'mail' => 'require',
        'qq' => 'require',
        'phone' => 'require|max:11|min:11',
        'repass' => 'require|confirm:password',
    ];

    protected $message = [
        'nickname.require' => '昵称不能为空',
        'username.require' => '用户名不能为空',
        'username.min' => '请输入不低于5位的用户名',
        'username.max' => '请输入5-25位的用户名',
        'outpass.require' => '原密码不能为空',
        'outpass.min' => '请输入不低于6位的用户密码',
        'outpass.max' => '请输入6-18位的用户密码',
        'outpass.alphaNum' => '密码只能是字母和数字！',
        'password.require' => '密码不能为空',
        'password.min' => '请输入不低于6位的用户密码',
        'password.max' => '请输入6-16位的用户密码',
        'password.alphaNum' => '登录密码只能是字母和数字！',
        'mail.require' => '邮箱不能为空',
        'qq.require' => 'QQ号码不能为空',
        'code.require' => '请输入6位数字验证码',
        'code.min' => '验证码不正确',
        'code.max' => '验证码不正确',
        'phone.require' => '手机号码不能为空',
        'phone.max' => '手机号码不正确',
        'phone.min' => '手机号码不正确',
        'repass' => '两次输入的密码不一致',
        'repass.require' => '二次密码确认不能为空',
    ];

    protected $scene = [
        'login' => ['username', 'password'],
        'reg' => ['nickname','username', 'password', 'qq', 'mail', 'code'],
        'find'=> ['mail'],
        'reset' => ['password','repass'],
        'changePass'=>['outpass','password','repass'],
        'edit' => ['password'],
    ];

}