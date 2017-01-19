<?php
function oneFileupload($filename, $dir, $arr=array()) //定义一个单文件上传
{
    $root_path = C('UPLOAD_ROOT_PATH');
    $maxfilesize = (int)C('UPLOAD_MAX_FILESIZE');
    $allow_ext = C('UPLOAD_ALLOW_EXT');
    //提出php.ini文件里面的选项值
    $maxfile = (int)ini_get('upload_max_filesize');
    $allow_max_filesize = min($maxfilesize, $maxfile);
    $upload = new \Think\Upload(); //实例化上传类
    $upload->maxSize = $allow_max_filesize*1024*1024; //上传附件大小
    $upload->exts = $allow_ext; //上传类型
    $upload->rootPath = $root_path; //上传根路径
    $upload->savePath = $dir . '/'; // 上传目录
    $info = $upload->upload();
    if ($info) {
        //上传成功
        //获取原图
        $goods_ori = $info[$filename]['savepath'] . $info[$filename]['savename'];
        $img[] = $goods_ori;
        //判断是否要生成缩略图
        if (!empty($arr)) {
            //图像要生成缩略图
            //遍历$arr数组
            $image = new \Think\Image();
            foreach ($arr as $k => $v) {
                $image->open($root_path . $goods_ori);
                //定义缩略图文件的名称
                $a = $info[$filename]['savepath'] . 'thumb' . $k . $info[$filename]['savename'];
                $image->thumb($v[0], $v[1])->save($root_path . $a);
                $img[] = $a;
            }
        }
        return array(
            'status'    =>    0,
            'info'    =>    $img
        );
    } else { //上传失败
        return array(
            'status'    =>    1,
            'info'      =>    $upload->getError()
        );
    }
}
function p($a)
{
    echo '<pre>';
    print_r($a);
}
function sendEmail($title, $content, $fromuser, $address)//定义发送邮件的方法,参数1:信的标题,参数2:信的内容,参数3:署名,参数4:收件人的邮箱
{
    //引入邮件发送的类文件
    require_once './PHPMailer/class.phpmailer.php';//在批量发送邮件的时候,使用 require 或 include 的时候,会报错(Cannot redeclare class phpmailerException)
    $mail             = new PHPMailer();
    /*服务器相关信息*/
    $mail->IsSMTP();                        //设置使用SMTP服务器发送
    $mail->SMTPAuth   = true;               //开启SMTP认证
    $mail->Host       = 'smtp.163.com';   	    //设置 SMTP 服务器,自己注册邮箱服务器地址
    $mail->Username   = 'n1113d@163.com';  		//发信人的邮箱用户名
    $mail->Password   = 'lian08';          //发信人的邮箱密码
    /*内容信息*/
    $mail->IsHTML(true); 			         //指定邮件内容格式为：html
    $mail->CharSet    ="UTF-8";			     //编码
    $mail->From       = 'n1113d@163.com';	 		 //发件人完整的邮箱名称
    $mail->FromName   = $fromuser;			 //发信人署名
    $mail->Subject    = $title;  			 //信的标题
    $mail->MsgHTML($content);  				 //发信主体内容
    $mail->AddAttachment("test.jpg");	     //附件
    /*发送邮件*/
    $mail->AddAddress($address);  			 //收件人地址
    //使用send函数进行发送
    if($mail->Send()) {
        //发送成功关闭SMTP链接
        $mail->Smtpclose();
        //发送成功返回真
        return true;
    } else {
        return false;
    }
}
