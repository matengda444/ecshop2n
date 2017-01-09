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
        $this->display();
    }
    //商品详情
    public function detail()
    {
        $this->display();
    }
}
