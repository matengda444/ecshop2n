<?php
namespace Admin\Model;

use Think\Model;

class TypeModel extends Model //添加数据验证,并验证数据合法性
{
    protected $_validate = array(
        array('type_name','require','商品类型不能为空') //验证表单
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间])
    );
}