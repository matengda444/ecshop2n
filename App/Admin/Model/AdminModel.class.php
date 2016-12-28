<?php
/**
 * Created by PhpStorm.
 * User: MY
 * Date: 2016/12/25
 * Time: 17:02
 */
namespace Admin\Model;

use Think\Model;

class AdminModel extends Model
{
    //使用动态的方式,自定义规则
    public $_login_validate = array(
        array('admin_name', 'require', '管理员名称不能为空'), //$_login_validate 该名称任意
        array('password', 'require', '密码不能为空'),
        array('checkcode', 'require', '验证码不能为空'),
        array('checkcode', 'check_verify', '验证码不能为空', 1, 'callback') //check_verify和下方的check_verify对应,
        //callback表示该条规则要使用当前类的一个方法来完成验证
    );
    protected function check_verify($code, $id = '')
    {
        //验证,验证码
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
    //使用静态方式来完成验证
    protected $_validate = array(
        array('admin_name', 'require', '管理员名称不为空'),
        array('admin_name', '', '管理员已经存在', 1, 'unique'),
        array('password', '6,12', '密码长度要在6到12位之间', 1, 'length'),
        array('rpassword', 'password', '两次密码不一致', 1, 'confirm'),
        array('role_id', 'number', '要选择角色')
    );
    public function login() //管理员登陆密码
    {
        // 接收传递的用户名和密码
        $admin_name = I('post.admin_name');
        $password = I('post.password');
        // 根据用户名找出密码,和输入的密码进行匹配
        $info = $this->where("admin_name = '$admin_name'")->find();
        if (!empty($info)) { //有该用户
            //密码判断
            if ($info['password'] == md5(md5($password).$info['salt'])) {
                //正确
                $_SESSION['admin_name'] = $admin_name;
                $_SESSION['admin_id'] = $info['id'];
                return true;
            }
        }
        $this->error = '用户名或密码错误';
        return false;
    }
}
