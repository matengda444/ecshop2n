<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    //显示登陆页面
    public function login()
    {
        $this->display();
    }
    public function authcode()
    {
        //生成验证码的方法
        $config = array(
            'fontSize' => 20, //验证码字体大小
            'length' => 4, //验证码位数
            'useNoise' => false, //关闭验证码杂点
            'imageW' => 140, //验证码宽度
            'imageH' => 40 //验证码高度
        );
        $Verify = new\Think\Verify($config);
        $Verify->entry();
    }
}
