<?php
namespace Admin\Controller;

use Think\Controller;

class GoodsController extends Controller
{
    public function add()
    {
        if (IS_POST) {
            $goodsmodel = D('Goods');
            if ($goodsmodel->create()) {
                if ($goodsmodel->add()) {
                    $this->success('添加成功', U('lst'));
                    exit;
                }
            }
            $error = $goodsmodel->getError();
            if (empty($error)) {
                $error = '添加失败';
            }
            $this->error($error);
        }
        $catemodel = D('Category');
        $catedata = $catemodel->getTree();
        $this->assign('catedata', $catedata);
        $this->display();
    }
    public function lst()
    {
        echo 'ok';
    }
}

