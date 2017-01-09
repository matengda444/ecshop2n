<?php
namespace Admin\Model;

use Think\Model;

class GoodsModel extends Model
{
    // protected function _before_insert(&$data, $options) //入库之前操作
    // {
    //     $data['add_time'] = time(); //接受的货号
    //     $goods_sn = I('post.goods_sn');
    //     if (empty($goods_sn)) {
    //         $goods_sn = 'sn_'.uniqid(); //uniqid()该函数会生成一个唯一的字符串
    //         $data['goods_sn'] = $goods_sn;
    //     }
    // $root_path = C('UPLOAD_ROOT_PATH');
    // $maxfilesize = (int)C('UPLOAD_MAX_FILESIZE');
    // $allow_ext = C('UPLOAD_ALLOW_EXT');
    // $maxfile = (int)ini_get('upload_max_filesize');
    // $allow_max_filesize = min($maxfilesize,$maxfile);
    // $upload = new \Think\Upload(); //实例化上传类
    // $upload->maxSize = $allow_max_filesize*1024*1024; //上传附件大小
    // $upload->exts = $allow_ext; //上传类型
    // $upload->rootPath = $root_path; //上传根路径
    // $upload->savePath = 'Goods/'; // 上传目录
    // $info = $upload->upload();
    // if ($info) { //上传成功
    //     $goods_ori = $info['goods_img']['savepath'].$info['goods_img']['savename'];
    //     $image = new \Think\Image();
    //     $image->open($root_path.$goods_ori);
    //     $goods_thumb = $info['goods_img']['savepath'].'thumb'.$info['goods_img']['savename'];
    //     $goods_img = $info['goods_img']['savepath'].'img'.$info['goods_img']['savename'];
    //     $image->thumb(250,250)->save($root_path.$goods_img);
    //     $image->thumb(150,150)->save($root_path.$goods_thumb);
    //     $data['goods_ori'] = $goods_ori;
    //     $data['goods_thumb'] = $goods_thumb;
    //     $data['goods_img'] = $goods_img;
    // } else { //上传失败
    //     $this->error = $upload->getError(); //上传失败错误提示赋值给模型error变量
    //     return false;
    // }
    // }

    protected function _before_insert(&$data, $options) //入库之前操作
    {
        $data['add_time'] = time(); //接受的货号
        $goods_sn = I('post.goods_sn');
        if (empty($goods_sn)) {
            $goods_sn = 'sn_'.uniqid(); //uniqid()该函数会生成一个唯一的字符串
            $data['goods_sn'] = $goods_sn;
        }
        if ($_FILES['goods_img']['error'] != 4) {
            $res =oneFileupload('goods_img', 'Goods', $arr=array(array(100,100), array(250,250)));
            if ($res['status'] == 0) {
                $data['goods_ori'] = $res['info'][0];
                $data['goods_thumb'] = $res['info'][1];
                $data['goods_img'] = $res['info'][2];
            } else {
                $this->error=$res['info'];
                return false;
            }
        }
    }
    protected function _after_insert($data,$options)
    {
        $attr = I('post.attr');
        //p($attr);
        //p($data);
        //p($options);
        $goods_id = $data['id'];
        foreach ($attr as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $v1) {
                    M("GoodsAttr")->add(array(
                        'goods_id' => $goods_id,
                        'goods_attr_id' => $k,
                        'attr_value' => $v1
                    ));
                }
                } else {
                    M("GoodsAttr")->add(array(
                        'goods_id' => $goods_id,
                        'goods_attr_id' => $k,
                        'attr_value' => $v
                    ));
                }
            }
    }
    //取出热卖,新品,精品的商品
    //参数1:是类型, (best hot new) 参数2:是取出的数量
    public function getGoods($type, $num)
    {
        if ($type == 'best' || $type == 'hot' || $type == 'new') {
            return $this->field("id, goods_name, goods_thumb, shop_price")->where("is_" . $type . "=1 and
            is_sale=1 and is_delete=0")->order("id desc")->limit($num)->select();
        }
        return;
    }
}
