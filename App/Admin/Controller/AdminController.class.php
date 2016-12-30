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
        if (IS_POST) {
            $adminmodel = D('Admin');
            if ($adminmodel->create()) {
                //定义一个盐,该盐是随机生成的
                $salt = substr(uniqid(), -6);
                $pwd = I('post.password'); // 接受明文密码
                $adminmodel->password = md5(md5($pwd).$salt);
                $adminmodel->salt = $salt;
                if ($adminmodel->add()) {
                    $this->success('添加成功', U('lst'));
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($adminmodel->getError());
            }
        }
        //取出角色数据
        $rolemodel = D('Role');
        $roledata = $rolemodel->select();
        $this->assign('roledata', $roledata);
        $this->display();
    }
    public function lst()
    {
        $adminmodel = D('Admin');
        //取出普通管理員
        $admindata = $adminmodel->field("a.*,c.role_name")->join("a left join e2_admin_role b 
        on a.id=b.admin_id left join e2_role c on b.role_id=c.id")->where("a.id!=1")->select();
        $this->assign('admindata', $admindata);
        $this->display();
    }
}
