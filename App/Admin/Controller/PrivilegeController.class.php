<?php
/**
 * Created by PhpStorm.
 * User: MY
 * Date: 2016/12/26
 * Time: 17:58
 */
namespace Admin\Controller;

use Think\Controller;

class PrivilegeController extends AuthController
{
    public function add()
    {
        if (IS_POST) {
            $privmodel = D('Privilege');
            if ($privmodel->create()) {
                if ($privmodel->add()) {
                    $this->success('添加成功', U('lst'));
                    exit;
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($privmodel->getError());
            }
        }
        $this->display();
    }
    public function lst()
    {
        echo 'ok';
    }
}
