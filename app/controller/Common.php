<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Config;
use think\facade\View;
use think\facade\Session;
use app\util\geetest\GeetestLib;
use app\model\Users;
use app\model\Player;
use app\model\SongSheet;
use app\model\Plays;
use app\model\PlayerAuth;

class Common extends BaseController
{
    function __construct()
    {
        $config = Db::name('configs')->column('v', 'k');
		$config['version']='3.9';
		Config::set($config, 'web');
		$data=[
			'music'	=>	'https://yun.xingyaox.com/music.php',
			'getksc'	=>	'https://yun.xingyaox.com/getksc.php'
		];
		Config::set($data, 'api');
    }
	
	protected function getSide(){
		$userInfo = Users::getLoginUser();
        // 获取用户拥有的播放器
        $userPlayers = Player::where('user_id',$userInfo['uid'])->select();

        // 获取用户所拥有的歌单
        $userSongSheets = SongSheet::where('user_id',$userInfo['uid'])->select();

        // 设置到session域中
        View::assign('userPlayers',$userPlayers);
        View::assign('userSongSheets',$userSongSheets);
    }
	
	protected function geetest_check($geetest_challenge, $geetest_validate, $geetest_seccode)
    {
        $GtSdk = new GeetestLib('fd772a9a5dbd10d2b164870729abbd2d','f4c61df26a8552cc51697bd53d352b4b');
        $data = [
            "user_id" => time(), # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => real_ip() # 请在此处传输用户请求验证时所携带的IP
        ];
        if (session('gtserver') == 1) {   //服务器正常
            if ($GtSdk->success_validate($geetest_challenge, $geetest_validate, $geetest_seccode, $data)) {
                return true;
            } else {
                return false;
            }
        } else {  //服务器宕机,走failback模式
            if ($GtSdk->fail_validate($geetest_challenge, $geetest_validate, $geetest_seccode)) {
                return true;
            } else {
                return false;
            }
        }
    }
	
    public function geetest_captcha()
    {
        $GtSdk = new GeetestLib('fd772a9a5dbd10d2b164870729abbd2d','f4c61df26a8552cc51697bd53d352b4b');
        $data = [
            "user_id" => time(),
            "client_type" => "web",
            "ip_address" => real_ip()
        ];
        $status = $GtSdk->pre_process($data, 1);
        session('gtserver', $status);
        session('user_id', $data['user_id']);
        echo $GtSdk->get_response_str();
    }
}