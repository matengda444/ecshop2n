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
}
