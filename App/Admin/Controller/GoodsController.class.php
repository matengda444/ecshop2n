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
        $typemodel = D('Type');
        $typedata = $typemodel->select();
        $this->assign('typedata',$typedata);
        $this->display();
    }
    public function showattr()
    {
        $type_id = $_GET['type_id'];
        $attrmodel = D('Attribute');
        $attrdata = $attrmodel->where("type_id=$type_id")->select();
        $this->assign('attrdata', $attrdata);
        $this->display();
    }
    public function lst()
    {
        echo 'ok';
    }
}

