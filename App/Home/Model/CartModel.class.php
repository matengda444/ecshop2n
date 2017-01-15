<?php
namespace Home\Model;

use Think\Model;

class CartModel extends Model
{
    //添加商品到购物车的方法
    //参数1:购物车的id,参数2:商品的属性,参数3:购买数量
    public function addCart($goods_id, $goods_attr_id, $goods_count)
    {
        //取出登录的id
        $user_id = $_SESSION['user_id']+0;
        if ($user_id > 0) {
            //已经登录,把数据存储到数据苦力
            //在存储之前要饭段购物车表里面是否有该商品,如果有,则修改购买数量,如果没有就添加
            $info = $this->where("user_id=$user_id and goods_id=$goods_id and goods_attr_id='$goods_attr_id'")->find();
            if ($info) {
                //该商品已经存在,则修改购买数量
                $this->where("user_id=$user_id and goods_id=$goods_id and goods_attr_id='$goods_attr_id'")->setInc('
                goods_count',$goods_count);
            } else {
                //该商品不存在,则直接添加cookie里面
                $cart = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
                //判断该商品是否已经存在cookie中,如果存在,则增加购买数量,如果没有就直接添加
                //构造键
                $key = $goods_id.'-'.$goods_attr_id;
                if (isset($cart[key])) {
                    //说明已经存在,则修改购买数量
                    $cart[$key] += $goods_count;
                } else {
                    //说明没有,就直接添加
                    $cart[$key] = $goods_count;
                }
                //把修改的数组,在保存早cookie里面
                setcookie('cart', serialize($cart), time() + 3600*24*7, '/');
            }
        }
    }
}
