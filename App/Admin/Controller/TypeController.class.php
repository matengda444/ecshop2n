<?php
namespace Admin\Controller;

use Think\Controller;

class TypeController extends Controller //添加商品类型
{
    public function add() 
    {
        if (IS_POST) {
            $typemodel = D('Type');
            if ($typemodel->create(I('post'), 1)) { //在创建数据验证，在创建数据验证时，完成自动验证功能。
            //create($data = '', $type = '')$type=1是执行插入操作,$type=2是执行更新操作,如果不传值,则是自己分析是插入还是更新
                if ($typemodel->add()) {
                    $this->success('添加成功', U('lst'));
                    exit;
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($typemodel->getError());
            }
        }
    $this->display(); //输出验证失败后的错误提示信息。
    }
    public function lst() //list是关键字
    {
        $typemodel = D('Type');
        $typedata = $typemodel->select();
        $this->assign('typedata', $typedata);
        $this->display();
    }
}
