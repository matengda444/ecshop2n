<?php
namespace Admin\Controller;

use Think\Controller;

class CategoryController extends Controller
{
    public function add()
    {
        $catemodel = D('Category');
        if (IS_POST) {
            if ($catemodel->create()) {
                if ($catemodel->add()) {
                    $this->success('添加成功', U('lst'));
                    exit;
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($catemodel->getError());
            }
        }
        $catedata = $catemodel->getTree();
        $this->assign('catedata', $catedata);
        $this->display();
    }
    public function lst()
    {
        $catemodel = D('Category');
        $catedata = $catemodel->getTree();
        $this->assign('catedata', $catedata);
        $this->display();
    }
    public function del()
    {
        $cat_id = $_GET['cat_id']+0; //接受传递的栏目id
        $catemodel = D('Category');
        $info = $catemodel->where("parent_id=$cat_id")->select();
        if ($info) {
            $this->error('该栏目下面有子栏目,不能删除');
        }
        if ($catemodel->delete($cat_id) !== false) { //返回的值是受影响的行数
            $this->success('删除成功', U('lst'));
        } else {
            $this->error('删除失败');
        }
    }
    public function update()
    {
        $catemodel = D('Category');
        if (IS_POST) {
            if ($catemodel->create()) {
                $parent_id = I('post.parent_id');
                $id = I('post.id');
                $ids = $catemodel->getChildId($id);
                $ids[] = $id;
                if (in_array($parent_id, $ids)) {
                    $this->error('不能把自己的子孙栏目当自己的父栏目');
                }
                if ($catemodel->save() !== false) {
                    $this->success('修改成功', U('lst'));
                    exit;
                } else {
                    $this->error('修改失败');
                }
            } else {
                $this->error($catemodel->getError());
            }
        }
        $cat_id = $_GET['cat_id']+0;
        $info = $catemodel->find($cat_id);
        $this->assign('info',$info);
        $this->assign('ids', $ids);
        $catemodel = D('Category');
        $catedata = $catemodel->getTree();
        $this->assign('catedata',$catedata);
        $this->display();
    }
}
