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
        //添加角色
        if (IS_POST) {
            $rolemodel = D('Role');
            if ($rolemodel->create()) {
                if ($rolemodel->add()) {
                    $this->success('添加成功', U('lst'));
                    exit;
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($rolemodel->getError());
            }
        }
        //取出权限数据,便于给角色分配权限
        $privmodel = D('Privilege');
        $privdata = $privmodel->getTree();
        $this->assign('privdata', $privdata);
        $this->display();
    }
}
