<?php
/**
 * Created by PhpStorm.
 * User: MY
 * Date: 2016/12/27
 * Time: 0:21
 */
namespace Admin\Model;

use Think\Model;

class RoleModel extends Model
{
    protected $_validate = array(
        array('role_name', 'require', '角色名称不能为空')
    );
    protected function _after_insert($data, $options)
    {
        p($data);
        p($options);
        exit;
    }
}
