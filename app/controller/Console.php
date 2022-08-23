<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;

class Console extends Common
{
    public function index()
    {
		return View::fetch();
    }
}
