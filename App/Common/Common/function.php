<?php
function oneFileupload($filename, $dir, $arr=array()) //定义一个单文件上传
{
    $root_path = C('UPLOAD_ROOT_PATH');
    $maxfilesize = (int)C('UPLOAD_MAX_FILESIZE');
    $allow_ext = C('UPLOAD_ALLOW_EXT');
    $maxfile = (int)ini_get('upload_max_filesize');
    $allow_max_filesize = min($maxfilesize,$maxfile);
    $upload = new \Think\Upload(); //实例化上传类
    $upload->maxSize = $allow_max_filesize*1024*1024; //上传附件大小
    $upload->exts = $allow_ext; //上传类型
    $upload->rootPath = $root_path; //上传根路径
    $upload->savePath = $dir.'/'; // 上传目录
    $info = $upload->upload();
    if ($info) { //上传成功
        $goods_ori = $info[$filename]['savepath'].$info[$filename]['savename']; //获取原图
        $img[] = $goods_ori;
        if (!empty($arr)) {
            $image = new \Think\Image();
            foreach ($arr as $k => $v) {
                $image->open($root_path.$goods_ori);
                $a = $info[$filename]['savepath'].'thumb'.$k.$info[$filename]['savename'];
                $image->thumb($v[0], $v[1])->save($root_path.$a);
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
