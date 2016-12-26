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
//        p($data);
//        p($options);
//        exit;
        $role_id = $data['id'];
        $priv_ids = I('post.priv_id');//返回的是一维数组
        foreach ($priv_ids as $v) {
            M('RolePrivilege')->add(array(
                'role_id' => $role_id,
                'priv_id' => $v
            ));
    }
    }
}
