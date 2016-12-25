<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    //显示登陆页面
    public function login()
    {
        if (IS_POST) {
            $adminmodel = D('Admin');
            if ($adminmodel->validate($adminmodel->_login_validate)->create()) {
                if ($adminmodel->login()) {
                    //登陆成功
                    $this->success('登陆成功', U('Index/index'));
                    exit;
                }
            }
                $this->error($adminmodel->getError());
            }
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
