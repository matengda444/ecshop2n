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
    //货品管理
    public function product()
    {
        //接受传递的商品id
        $goods_id = $_GET['id']+0;
        if (IS_POST) {
            //接受goods_id
            $goods_id = I('post.goods_id');
            //接受属性
            $attr = I('post.attr');
            //接受库存
            $goods_number = I('post.goods_number');
            //循环完成入库
            $kc = 0;
            foreach ($goods_number as $k => $v) {
                $a = array();
                foreach ($attr as $k1=>$v1) {
                    $a[] = $v1[$k];
                }
                M("Product")->add(array(
                    'goods_id' => $goods_id,
                    'goods_attr_id' => implode(',', $a),
                    'goods_number' => $v
                ));
                $kc += $v;
            }
            //设置e2_goods表里面的总的库存,
            M('Goods')->where('id = $goods_id')->setField('goods_number', $kc);
        }
        $goodsmodel = D('Goods');
        $sql = "select a.*,b.attr_name from e2_goods_attr  a left join e2_attribute  b on a.goods_attr_id = b.id where  
        a.goods_id=$goods_id and a.goods_attr_id in (select  goods_attr_id  from e2_goods_attr  where goods_id=
        $goods_id group by goods_attr_id  having count(*)>1)";
        $data = $goodsmodel->query($sql);
        $list = array();
        foreach ($data as $v) {
            $list[$v['goods_attr_id']][] = $v;
        }
        $this->assign('list', $list);
        $this->display();
    }
}

