<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Config;
use app\model\Users;
use app\model\Player;
use app\model\SongSheet;
use app\model\Song;

class Index extends Common
{
    public function index()
    {
        $data = [
            'users' =>  Users::where(1)->count(),
            'players'    =>  Player::where(1)->count(),
            'sheets'    =>  SongSheet::where(1)->count(),
            'songs'  =>  Song::where(1)->count(),
        ];
        $users = Users::orderRand()->limit(12)->select();
        View::assign('data', $data);
        View::assign('users', $users);
        return View::fetch();
    }
}
