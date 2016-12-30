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
    public function update()
    {
        //取出管理员的基本信息
        $adminmodel = D('Admin');
        if (IS_POST) {
            if ($adminmodel->create()) {
                //判断是否修改密码
                $pwd = I('post.password');
                if (!empty($pwd)) {
                    //重设密码
                    $salt = substr(uniqid(), -6);
                    $pwd = I('post.password');
                    $adminmodel->password = md5(md5($pawd) . $salt);
                    $adminmodel->salt = $salt;
                } else {
                    //使用原来的密码,把数据对象里的password去掉,表示不修改密码值
                    unset($adminmodel->password);
                }
                if ($adminmodel->save() !== falese) {
                    $this->success('修改成功', U('lst'));
                    exit;
                } else {
                    $this->error('修改失败');
                }
            } else {
                $this->error($adminmodel->getError());
            }
        }
        $id = $_GET['id']+0;
        //判断提交的id合法性
        if ($id == 1) {
            $this->error('参数错误');
        }
        $info = $adminmodel->find($id);
        //查找不到管理员
        if (!$info) {
            $this->error('参数错误');
        }
        $this->assign('info',$info);
        //取出角色数据
        $rolemodel = D('Role');
        $roledata = $rolemodel->select();
        $this->assign('roledata', $roledata);
        $this->display();
    }
}
