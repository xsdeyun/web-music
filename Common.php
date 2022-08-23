<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Config;
use think\facade\View;
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
}