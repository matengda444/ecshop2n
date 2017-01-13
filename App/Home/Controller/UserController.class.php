<?php
/**
 * Created by PhpStorm.
 * User: MY
 * Date: 2017/1/9
 * Time: 21:33
 */
namespace Home\Controller;

use Think\Controller;

class UserController extends Controller
{
    public function register()
    {
        //注册页面
        if (IS_POST) {
            $usermodel = D('User');
            if ($usermodel->create()) {
                $usermodel->validate = substr(uniqid(), -6);
                $usermodel->password = md5(I('post.password'));
                $usermodel->reg_time=time();
                if ($usermodel->add()) {
                    // 注册完成
                    $this->success('注册完成', U('Index/index'));
                    exit;
                } else {
                    //注册失败
                    $this->error('注册失败');
                }
            } else {
                $this->error($usermodel->getError());
            }
        }
        $this->display();
    }
    public function login()
    {
        $this->display();
    }
}
