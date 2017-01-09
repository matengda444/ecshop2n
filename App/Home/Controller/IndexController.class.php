<?php
namespace Home\Controller;

use Think\controller;

class Indexcontroller extends Controller
{
    //前台首页
    public function index()
    {
        //取出精品 热卖 新品数据
        $goodsmodel = D("Admin/Goods");//跨模块调用模型
        $newdata = $goodsmodel->getGoods('new', 3);
        $hotdata = $goodsmodel->getGoods('hot', 3);
        $bestdata = $goodsmodel->getGoods('best', 3);
        $this->assign(array(
            'newdata' => $newdata,
            'hotdata' => $hotdata,
            'bestdata' => $bestdata
        ));
        //取出栏目数据
        $catemodel = M('Category');
        $catedata = $catemodel -> select();
        $this->assign('catedata', $catedata);
        $this->display();
    }
    //栏目列表
    public function category()
    {
        //接受传递栏目id
        $cat_id = $_GET['id']+0;
        if ($cat_id == 0) {
            //如果参数有误,跳转到首页
            header("location:/index.php");
        }
        //根据传递栏目id,查找出子孙栏目id
        $catemodel = D("Admin/Category");
        $ids = $catemodel->getChildId($cat_id);//取出子孙栏目id
        //if (empty($ids)) {
            //说明自己就是子孙栏目
            $ids[] = $cat_id;//把自己的id天加到$ids数组里面
        //}
        $goodsmodel = M('Goods');
        $ids = implode(',', $ids);
        $goodsdata = $goodsmodel->field("id, cat_id, goods_name, goods_thumb, shop_price")->where("cat_id in
        ($ids)")->select();
        $this->assign('goodsdata', $goodsdata);
        $this->display();
    }
    //商品详情
    public function detail()
    {
        $this->display();
    }
}
