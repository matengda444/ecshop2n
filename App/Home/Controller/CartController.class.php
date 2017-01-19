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
//        p($cartdata);
//        exit;
        $this->assign('cartdata', $cartdata);
        //取出购物车里面的商品,和总的价格
        $total = $cartmodel->getTotal();
//        p($cartList);
//        exit;
        $this->assign('total', $total);
        $this->display();
    }
    public function cartDel()
    {
        $goods_id = $_GET['goods_id'];
        $goods_attr_id = $_GET['goods_attr_id'];
        $cartmodel = D('Cart');
        $cartdata = $cartmodel->cartDel($goods_id, $goods_attr_id);
        $this->redirect('Cart/cartList');
    }
    //cookie数据移动到数据库里
    public function cookie2db()
    {
        //取出cookie数据
        $cart = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();//一维数组
        $user_id = $_SESSION['user_id'];
        if ($cart) {
            //cookie里有数据
            //判断数据库里面,是否有该商品
            foreach ($cart as $k => $v) {
                $a = explode('-', $k);
                $goods_id = $a[0];
                $goods_attr_id = $a[1];
                $goods_count = $v;
                $info = $this->where("user_id=$user_id and goods_id=$goods_id and goods_attr_id='$goods_attr_id''")->find();
                if ($info) {
                    //说明该商品已经存在,则直接修改购买数量
                    $this->where("user_id=$user_id and goods_id=$goods_id and goods_attr_id='$goods_attr_id''")->setInc('goods_count', $goods_count);
                } else {
                    //说明该商品不存在,则直接添加数据库
                    $this->add(array(
                        'goods_id' => $goods_id,
                        'goods_attr_id' => $goods_attr_id,
                        'goods_count' => $goods_count,
                        'user_id' => $user_id
                    ));
                }
            }
            //把cookie数据清空
            setcookie('cart', '', time()-1, '/');
        }
    }
}
