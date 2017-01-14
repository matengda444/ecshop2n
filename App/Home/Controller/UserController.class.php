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
                $key = substr(uniqid(), -6);
                $usermodel->validate = $key;
                $usermodel->password = md5(I('post.password'));
                $usermodel->reg_time=time();
                if ($usermodel->add()) {
                    // 注册完成
                    $title = '注册完成激活用户';
                    $fromuser = '京西商城';
                    $address = I('post.email');
                    $username = I('post.username');
                    $url = "http://a.b" . U('User/active', array('email' => $address, 'key' => $key));
                    $content = "尊敬的用户,我是你爹:<br/>话费充值请按1,流量购买请按2,否则,请挂机<br/>爱用就用不用就滚<br/><a href='$url'>单击激活<a/>";
                    if (sendEmail($title, $content, $fromuser, $address)) {
                        $this->success('注册成功,请点击邮箱激活链接');
                    } else {
                        $this->error('注册失败');
                    }
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
    public function active()
    {
        //接受传递的内容
        $email = $_GET['email'];
        $key = $_GET['key'];
        //根据email查找出用户,如果用户不存在,则提示链接有误
        $usermodel = D('User');
        $info = $usermodel->where("email = '$email'")->find();
        if (!$info) {
            $this->error('链接有误');
        }
        //验证链接的有效性,从表里的取出的validate和传递的key进行比较
        if ($info['validate'] != $key) {
            $this->error('链接有误');
        }
        //验证链接的有效期,取出注册时的时间戳,和当前的时间戳进行比较
        if (time() - $info['reg_time'] > 3600*24) {
            $this->error('链接失效');
        }
        //查看用户的active字段,如果已经激活,则无需激活
        if ($info['active'] == 1) {
            $this->error('已经激活,无需重复激活');
        }
        //用户激活,则修改active字段为1
        $usermodel->where("email='$email'")->setField("active", 1);
        $this->success('激活成功', U('User/login'));
    }
    public function login()
    {
        //登录页面
        $this->display();
    }
    public function demo()
    {
        for ($i = 0; $i < 10; $i++) {
            p(sendEmail('title', $i . 'content', 'n1113d', 'n1113d@163.com'));
            //sleep(3);
        }
    }

}
