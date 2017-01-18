<?php
namespace Home\Controller;

use Think\Controller;

class CartController extends Controller
{
    //添加一个方法用于添加商品到购物车
    public function addCart()
    {
        //接受提交的数据
        $goods_id = I('post.id');
        $attr = I('post.attr');//数组
        $goods_attr_id = '';
        //判断当前商品是否有属性
        if (!empty($attr)) {
            $goods_attr_id = implode(',', $attr);
        }
        $goods_count = I('post.goods_count');
        $cartmodel = D('Cart');
        //调用模型中添加商品到购物车的方法
        $cartmodel->addCart($goods_id, $goods_attr_id, $goods_count);
        //添加数据到购物车后,要跳转到购物车列表页面
        $this->success('添加购物车成功', U('Cart/cartList'));
    }
    public function cartList()
    {
        $cartmodel = D('Cart');
        $cartdata = $cartmodel->cartList();//返回购物车里的数据
        $this->assign('cartdata', $cartdata);
        $this->display();
    }
}
