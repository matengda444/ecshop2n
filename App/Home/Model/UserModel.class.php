<?php
namespace Home\Model;

use Think\Model;

class UserModel extends Model
{
    //添加数据验证
    protected $_validate = array(
        array('username', 'require', '用户名不能为空'),
        array('username', '', '用户名已经存在', 1, 'unique'),
        array('username', '/^[\w]{3,20}$/', '用户名不合法', 1, 'regex'),
        array('password', 'require', '密码不能为空'),
        array('password', '6,12', '密码长度不合法', 1, 'length'),
        array('rpassword', 'password', '两次密码不一致', 1, 'confirm'),
        array('email', 'require', '邮箱不能为空'),
        array('email', 'email', '邮箱格式不合法'),
        array('email', '', '邮箱已经存在', 1, 'unique'),
        array('question', 'require', '要选择问题'),
        array('answer', 'require', '要回答问题')
    );
}
