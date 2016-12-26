<?php
/**
 * Created by PhpStorm.
 * User: MY
 * Date: 2016/12/26
 * Time: 22:52
 */
namespace Admin\Controller;

use Think\Controller;

class RoleController extends AuthController
{
    public function add()
    {
        $privmodel = D('Privilege');
        $privdata = $privmodel->getTree();
        $this->assign('privdata', $privdata);
        $this->display();
    }
}