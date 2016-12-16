<?php
namespace Admin\Controller;

use Think\Controller;

class CategoryController extends Controller
{
    public function add()
    {
        $catemodel = D('Category');
        if (IS_POST) {
            if ($catemodel->create()) {
                if ($catemodel->add()) {
                    $this->success('添加成功', U('lst'));
                    exit;
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($catemodel->getError());
            }
        }
        $catedata = $catemodel->getTree();
        $this->assign('catedata', $catedata);
        $this->display();
    }
    public function lst() {
        $catemodel = D('Category');
        $catedata = $catemodel->getTree();
        $this->assign('catedata', $catedata);
        $this->display();
    }
}
