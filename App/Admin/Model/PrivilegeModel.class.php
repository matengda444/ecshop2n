<?php
/**
 * Created by PhpStorm.
 * User: MY
 * Date: 2016/12/26
 * Time: 19:45
 */
namespace Admin\Model;

use Think\Model;

class PrivilegeModel extends Model
{
    //静态方式完成数据验证
    protected $_validate = array(
        array('priv_name', 'require', '权限名称不能为空'),
        array('parent_id', 'number', '上级权限不合法')
    );
    //定义一个方法,用于取出栏目
    public function getTree($id = 0)
    {
        $arr = $this->select();
        return $this->_getTree($arr, $id);
    }
    public function _getTree($arr, $id = 0, $lev = 0)
    {
        static $list = array();
        foreach ($arr as $v) {
            if ($v['parent_id'] == $id) {
                $v['lev'] = $lev;
                $list[] = $v;
                $this->_getTree($arr, $v['id'], $lev+1);
            }
        }
        return $list;
    }
}
