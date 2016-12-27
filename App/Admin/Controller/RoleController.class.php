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
    //角色列表
    public function lst()
    {
        // 取出角色数据并且取出角色对应的权限
        $rolemodel = D('Role');
        $roledata = $rolemodel->field("a.*,group_concat(c.priv_name) as privnames")->join("a left join
       e2_role_privilege b on a.id=b.role_id left join e2_privilege c on b.priv_id=c.id")->group("a.id
       ")->select();
        //p($roledata);
        $this->assign('roledata', $roledata);
        $this->display();
    }
}
