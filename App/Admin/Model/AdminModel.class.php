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
        array('checkcode', 'require', '验证码不能为空')
    );
}
