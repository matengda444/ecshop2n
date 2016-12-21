<?php
namespace Admin\Model;

use Think\Model;
class GoodsModel extends Model
{
    protected function _before_insert(&$data, $options) //入库之前操作
    {
        $data['add_time'] = time(); //接受的货号
        $goods_sn = I('post.goods_sn');
        if (empty($goods_sn)) {
            $goods_sn = 'sn_'.uniqid(); //uniqid()该函数会生成一个唯一的字符串
            $data['goods_sn'] = $goods_sn;
        }
    $root_path = C('UPLOAD_ROOT_PATH');
    $maxfilesize = (int)C('UPLOAD_MAX_FILESIZE');
    $allow_ext = C('UPLOAD_ALLOW_EXT');
    $maxfile = (int)ini_get('upload_max_filesize');
    $allow_max_filesize = min($maxfilesize,$maxfile);
    $upload = new \Think\Upload(); //实例化上传类
    $upload->maxSize = $allow_max_filesize*1024*1024; //上传附件大小
    $upload->exts = $allow_ext; //上传类型
    $upload->rootPath = $root_path; //上传根路径
    $upload->savePath = 'Goods/'; // 上传目录
    $info = $upload->upload();
    if ($info) { //上传成功
        $goods_ori = $info['goods_img']['savepath'].$info['goods_img']['savename'];
        $image = new \Think\Image();
        $image->open($root_path.$goods_ori);
        $goods_thumb = $info['goods_img']['savepath'].'thumb'.$info['goods_img']['savename'];
        $goods_img = $info['goods_img']['savepath'].'img'.$info['goods_img']['savename'];
        $image->thumb(250,250)->save($root_path.$goods_img);
        $image->thumb(150,150)->save($root_path.$goods_thumb);
        $data['goods_ori'] = $goods_ori;
        $data['goods_thumb'] = $goods_thumb;
        $data['goods_img'] = $goods_img;
    } else { //上传失败
        $this->error = $upload->getError();
        return false;
    }
    }
}
