<?php
namespace Admin\Model;

use Think\Model;

class CategoryModel extends Model
{
    public function getTree($id=0) //定义一个方法,用于取出栏目
    {
        $arr = $this->select();
        return $this->_getTree($arr, $id);
    }
    public function _getTree($arr, $id, $value=0)
    {
        static $list=array();
        foreach($arr as $v) {
            if ($v['parent_id']  == $id) {
                $v['lev'] = $lev;
                $list[] = $v;
                $this->_getTree($arr, $v['id'], $lev+1);
            }
        }
        return $list;
    }
}
