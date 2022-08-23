<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;
use think\facade\Config;
use think\facade\Cookie;
use think\facade\Session;
use app\model\Users;
use app\model\Player;
use app\model\SongSheet;
use app\model\Song;
use app\model\PlayerAuth;
use app\model\Links;
use app\model\Pays;

class Admin extends Common
{
    public function index()
    {
		$this->checkLogin();
        return View::fetch();
    }

    public function help()
    {
		$this->checkLogin();
        return View::fetch();
    }
	
	public function shop()
    {
		$this->checkLogin();
		$userInfo = Users::getLoginUser();
		$pays=Pays::where('uid','=',$userInfo['uid'])->order('addtime', 'desc')->limit(5)->select();
		View::assign('pays', $pays);
        return View::fetch();
    }
	
    public function webset()
    {
        $this->checkLogin();
		$this->checkPower();
        return View::fetch();
    }

    public function userinfo()
    {
		$this->checkLogin();
		$userInfo = Users::getLoginUser();
		$sheets=SongSheet::where('user_id',$userInfo['uid'])->count();
		View::assign('sheets', $sheets);
        return View::fetch();
    }
	
	public function QqLoginSet()
	{
		$userInfo = Users::getLoginUser();
		header("Location: https://music.xingyaox.com/qqlogin/api.php?callback=".get_domain()."/Admin/set_callback/uid/".$userInfo['uid']);
		exit();
	}
	
	public function set_callback($uid)
	{
		$data = input();
		$update['token']=$data['openid'];
		if(!$data['openid'] || !$data['callback']){
			View::assign('alert', '参数不完整');
			View::assign('url', '/console#/userinfo');
			exit(View::fetch('common/error_no_console'));
		}elseif(Users::checkQqToken($data['openid'])){
			View::assign('alert', '此QQ已被其他用户绑定');
			View::assign('url', '/console#/userinfo');
			exit(View::fetch('common/error_no_console'));
		}elseif(Users::updateByUid($uid, $update)){
			View::assign('alert', '绑定QQ成功');
			View::assign('url', '/console#/userinfo');
			exit(View::fetch('common/error_no_console'));
		}
        return $result;
	}
	
	public function QqLogin()
	{
		header("Location: https://music.xingyaox.com/qqlogin/api.php?callback=".get_domain()."/Admin/login_callback");
		exit();
	}
	
	public function login_callback()
	{
		$data = input();
		if(!$data['openid'] || !$data['callback']){
			View::assign('alert', '参数不完整');
			View::assign('url', '/console#/user/login');
			exit(View::fetch('common/error_no_console'));
		}elseif(!Users::checkQqToken($data['openid'])){
			View::assign('alert', '此QQ未被任何用户绑定');
			View::assign('url', '/console#/user/login');
			exit(View::fetch('common/error_no_console'));
		}elseif(Users::qqlogin($data)){
			View::assign('alert', 'QQ登录成功');
			View::assign('url', '/console#/');
			exit(View::fetch('common/error_no_console'));
		}
        return $result;
	}
	
	public function Player($id)
    {
		$this->checkLogin();
		$key = $id;
		$userInfo = Users::getLoginUser();
		if(!$key){
			View::assign('alert', '页面不存在');
            View::assign('url', '#/');
            exit(View::fetch('common/error'));
		}elseif(Player::checkPlayerKey($key)== true){
			View::assign('alert', '播放器不存在');
            View::assign('url', '#/');
            exit(View::fetch('common/error'));
		}elseif(Player::checkPlayerUid($key,$userInfo['uid'])== true && $userInfo['power']!==0){
			View::assign('alert', '你没有权限管理这个播放器');
            View::assign('url', '#/');
            exit(View::fetch('common/error'));
		}else{
			$data = Player::where("id",$key)->find();
			$this->getSide();
			View::assign('entity', $data);

			// 获取播放器歌单
			$list = Player::songSheets($key);
			View::assign('selectedSongSheetList', $list);
			$auths = PlayerAuth::where('player_id','=',$key)->select();
			View::assign('auths', $auths);
			// 获取用户的所有歌单
			$userSongSheet = SongSheet::where('user_id', $userInfo['uid'])
				->select();
			$webSongSheet = SongSheet::where(1)
				->select();
			$gy = SongSheet::where('status','=','1')->orderRand()->limit(10)->select();
			View::assign('gy', $gy);
			View::assign('userSongSheet', $userSongSheet);
			View::assign('webSongSheet', $webSongSheet);
			return View::fetch();
		}
    }
	
	public function songSheet($id)
    {
		$this->checkLogin();
		$key = $id;
		$userInfo = Users::getLoginUser();
		if(!$key){
			View::assign('alert', '页面不存在');
            View::assign('url', '#/');
            exit(View::fetch('common/error'));
		}elseif(SongSheet::checkSheetKey($key)== true){
			View::assign('alert', '歌单不存在');
            View::assign('url', '#/');
            exit(View::fetch('common/error'));
		}elseif(SongSheet::checkSheetUid($key,$userInfo['uid'])== true && $userInfo['power']!==0){
			View::assign('alert', '你没有权限管理这个歌单');
            View::assign('url', '#/');
            exit(View::fetch('common/error'));
		}else{
			
		$entity = SongSheet::where("id",$key)->find();
		
        View::assign('entity', $entity);

        // 获取歌单关联歌曲
        $songs = Song::where('song_sheet_id', $key)->order('taxis asc')->select();
		$suiji = Song::orderRand()->limit(10)->select();
        View::assign('songs', $songs);
		View::assign('suiji', $suiji);
		View::assign('webTitle', '歌单配置');
        return View::fetch();
		}
    }

    public function logout()
    {
        $this->checkLogin();
        Cookie::delete('skey');
		Cookie::delete('sid');
		Cookie::delete('pskey');
        Cookie::delete('user_token');
        View::assign('alert', '成功注销登陆状态');
        View::assign('url', '/console#/user/login');
        return View::fetch('common/error');
    }
	
	public function layout()
    {
		$this->checkLogin();
		$links = Links::where(1)->order('id desc')->select();
		$linkcount = Links::where(1)->count();
		View::assign('links', $links);
		View::assign('linkcount', $linkcount);
        return View::fetch();
    }
	
	public function users($act)
    {
		$this->checkLogin();
		$this->checkPower();
		switch ($act) {
			case 'list':
				return View::fetch('admin/users/list');
			break;
			case 'edit':
				$data=input();
				$user=Users::where('uid','=',$data['uid'])->find();
				$player=Player::where('user_id','=',$data['uid'])->select();
				$sheet=SongSheet::where('user_id','=',$data['uid'])->select();
				View::assign('user', $user);
				View::assign('player', $player);
				View::assign('sheet', $sheet);
				return View::fetch('admin/users/edit');
			break;
		}
    }
	
	public function links($act)
    {
		$this->checkLogin();
		$this->checkPower();
		switch ($act) {
			case 'list':
				return View::fetch('admin/links/list');
			break;
			case 'del':
				$data=input();
			break;
		}
    }
	
	public function orders($act)
    {
		$this->checkLogin();
		$this->checkPower();
		switch ($act) {
			case 'list':
				return View::fetch('admin/orders/list');
			break;
		}
    }
	
	public function user($act='login')
    {
		switch ($act) {
			case 'login':
				$check_Login = Users::checkLogin();
				if ($check_Login != null) {
					return View::fetch('user/login');
				} else {
					$this->userInfo = Users::getLoginUser();
					View::assign('userInfo', $this->userInfo);
					return View::fetch('user/lock');
				}
			break;
			case 'reg':
				$check_Login = Users::checkLogin();
				if ($check_Login != null) {
					return View::fetch('user/reg');
				} else {
					$this->userInfo = Users::getLoginUser();
					View::assign('userInfo', $this->userInfo);
					return View::fetch('user/lock');
				}
			break;
			case 'find':
				return View::fetch('user/find');
			break;
		}
    }
	
	public function system()
    {
		$this->checkLogin();
		return View::fetch('theme');
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
            $this->userInfo = Users::getLoginUser();
            View::assign('userInfo', $this->userInfo);
        }
    }
	
	private
    function checkPower()
    {
        $userInfo = Users::getLoginUser();
		if($userInfo['power']!==0){
			View::assign('alert', '你没有权限进入这个页面');
            View::assign('url', '#/');
            exit(View::fetch('common/error'));
		}
    }
}
