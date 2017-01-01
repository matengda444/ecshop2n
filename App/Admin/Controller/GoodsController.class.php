<?php
namespace Admin\Controller;

use Think\Controller;

class GoodsController extends AuthController
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
        $goodsmodel = D('Goods');
        $goodsdata =
        $goodsdata =  $goodsmodel->field("id, goods_name, goods_sn, shop_price, is_best, is_sale, is_new, is_hot")->select();
        $this->assign('goodsdata', $goodsdata);
        $this->display();
    }
    //完成jajx切换的要给方法
    public function ajaxToggle()
    {
        //接受传递的参数
        $id = $_GET['id'];
        $value = $_GET['value'];
        $field = $_GET['field'];
        $goodsmodel = D('Goods');
        //返回受影响的行数
        echo $goodsmodel->where("id = $id")->setField('is_' . $field,$value);
    }
}

