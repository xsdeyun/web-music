<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Config;
use think\facade\Db;
use think\facade\Cache;
use think\facade\Request;
use think\facade\Session;
use app\model\Users;
use app\model\Player;
use app\model\SongSheet;
use app\model\Song;
use app\model\Plays;
use app\model\PlayerAuth;
use app\model\PlayerSongSheet;
use app\model\Links;
use app\model\Pays;

class PayAjax extends Common
{
	public function shop()
    {
		$this->checkLogin();
		$userInfo = Users::getLoginUser();
		$data = input('post.');
		if($data['shop']=='vip'){
			if($userInfo['power']!==2){
				$result=[
					'code'	=>	-1,
					'msg'	=>	'您已经是付费版用户,无需再次升级'
				];
			}else{
				$result=[
					'code'	=>	0,
					'url'	=>	Pays::Submit_Pay($userInfo, $data)
				];
			}
		}else{
			$result=[
				'code'	=>	0,
				'url'	=>	Pays::Submit_Pay($userInfo, $data)
			];
		}
        return json($result);
	}
	
	private
    function checkLogin()
    {
        $check_Login = Users::checkLogin();
        if ($check_Login != null) {
            View::assign('alert', $check_Login['msg']);
            View::assign('url', $check_Login['url']);
            exit(View::fetch('common/error'));
        } else {
            $userInfo = Users::getLoginUser();
        }
    }
}
