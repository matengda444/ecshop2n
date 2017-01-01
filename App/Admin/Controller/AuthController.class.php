<?php
/**
 * Created by PhpStorm.
 * User: MY
 * Date: 2016/12/25
 * Time: 19:46
 */
namespace Admin\Controller;

use Think\Controller;

class AuthController extends Controller
{
    public function _initialize()
    {
        //获取当前操作的模块名称控制器名称方法名称
        $url = MODULE_NAME . '-' . CONTROLLER_NAME . '-' . ACTION_NAME;
        $admin_id = $_SESSION['admin_id'];
        if ($admin_id > 0) {
            //管理员已经登陆
            if ($admin_id == 1) {
                return true;
            }
            if (CONTROLLER_NAME == 'Index') {
                return true;
            }
            //普通管理员
            $sql = "select  concat(module_name,'-',controller_name,'-',action_name) url from   e2_admin_role  a left join 
            e2_role_privilege b on a.role_id = b.role_id left join e2_privilege c on b.priv_id=c.id  where   a.admin_id=9 having url='$url'";
            $info = M()->query($sql);
            if ($info) {
                return true;
            } else {
                $this->success('你无权操作', U('Index/index'));
            }
        } else {
            //没有登陆
            $this->success('必须登陆', U('Login/login'));
        }
    }
}