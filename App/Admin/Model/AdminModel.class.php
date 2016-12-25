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
}
