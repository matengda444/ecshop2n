<?php
namespace Admin\Controller;

use Think\Controller;

class AttributeController extends Controller
{
    public function add()
    {
        if (IS_POST) {
            $attrmodel = D('Attribute');
            if ($attrmodel->create()) {
                if ($attrmodel->add()) {
                    $this->success('添加成功', U('lst'));
                    exit;
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($attrmodel->getError());
            }
        }
        $typemodel = D('Type');
        $typedata = $typemodel->select();
        $this->assign('typedata', $typedata);
        $this->display();
    }
    public function lst() {
        $type_id = $_GET['type_id']+0; //接受商品类型id
        if ($ytpe_id == 0) { //商品类型id=0显示所有属性
            $where = 1;
        } else {
            $where = "a.type_id=$type_id";
        }
        $typemodel = D('Type');
        $typedata = $typemodel->select();
        $this->assign('type_id', $type_id);
        $this->assign('typedata', $typedata);
        $attrmodel = D('Attribute');
        $count = $attrmodel->where($where)->count(); //查询满足要求的记录数
        $Page = new \Think\Page($count, 2); //实例化分页类,传入总记录数和煤业显示的记录数
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $show = $Page->show(); //分页显示输出
        $attrdata = $attrmodel->field("a.*,b.type_name")->join("a left join e2_type b on
        a.type_id=b.id")->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('attrdata', $attrdata);
        $this->assign('show', $show);
        $this->display();
    }
}
