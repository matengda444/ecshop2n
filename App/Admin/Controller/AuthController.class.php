<?php
/**
 * Created by PhpStorm.
 * User: MY
 * Date: 2016/12/25
 * Time: 19:46
 */
namespace Admin\Controller;

use Think\Controller;

class AuthController extends Controller
{
    public function _initialize()
    {
        $admin_id = $_SESSION['admin_id'];
        if ($admin_id > 0) {
            return true;
        } else {
            //没有登陆
            $this->success('必须登陆', U('Login/login'));
        }
    }
}