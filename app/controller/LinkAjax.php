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

class LinkAjax extends Common
{
	public function lists()
    {
		$this->checkLogin();
		$select = Links::search();
		if (false === $select) {
			$result['msg'] = '获取列表失败，请稍后再试';
		} elseif (is_string($select)) {
			$result['msg'] = $select;
		} else {
			$result = [
				'code' => 0,
				'msg' => 'success',
				'count' => $select['total'],
				'data' => $select['list']
			];
		}
        return json($result);
	}
	
	public function del()
    {
		$this->checkLogin();
		$data = input('post.');
		if (Links::delByid($data['id'])) {
			$result = [
				'code' => 0,
				'message' => '删除广告成功',
			];
		} else {
			$result = [
				'code' => 1,
				'message' => '删除失败',
			];
		}
        return json($result);
    }
	
	public function add()
    {
		$this->checkLogin();
		$data = input('post.');
		if (Links::add($data)) {
			$result = [
				'code' => 0,
				'message' => '添加广告成功',
			];
		} else {
			$result = [
				'code' => 1,
				'message' => '添加失败',
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
			if($userInfo['power']!==0){
				View::assign('alert', '你没有权限进入这个页面');
				View::assign('url', '#/');
				exit(View::fetch('common/error'));
			}
        }
    }
}
