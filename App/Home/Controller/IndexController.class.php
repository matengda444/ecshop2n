<?php
namespace Home\Controller;

use Think\controller;

class Indexcontroller extends Controller
{
    //前台首页
    public function index()
    {
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
