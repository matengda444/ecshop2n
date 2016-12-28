<?php
/**
 * Created by PhpStorm.
 * User: MY
 * Date: 2016/12/28
 * Time: 17:59
 */
namespace Admin\Controller;

use Think\Controller;

class AdminController extends AuthController
{
    //添加管理员
    public function add ()
    {
        //取出角色数据
        $rolemodel = D('Role');
        $roledata = $rolemodel->select();
        $this->assign('roledata', $roledata);
        $this->display();
    }
}
