<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/styles/main.css" rel="stylesheet" type="text/css" />
<script type = 'text/javascript' src = '/app/view/js/jquery-1.4.2.min.js'></script>
    <script type="text/javascript" src="/Public/Js/jquery.js"></script>
    <script>
        $(function(){
            //采用动态绑定的方式来完成
            $(":button").click(function(){
                //取出当前行
                var curr_tr = $(this).parent().parent();
                //判断button里面的值,如果是加号就自我复制,如果是减号就自我删除
                if($(this).val()=='+'){
                    //自我复制
                    var new_tr = curr_tr.clone(true);//使用ture,表示深度克隆,包含克隆对象和事件
                    //把新行里面的button按钮的值改成减号
                    new_tr.find(":button").val('-');
                    //把新行放到当前行的前面
                    curr_tr.before(new_tr);
                }else{
                    //自我删除
                    curr_tr.remove();
                }
            });
        });
    </script>
</head>
<body>

<h1>
<span class="action-span"><a href="cateadd.html">添加分类</a></span>
<span class="action-span1"><a href="#">ECSHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 商品分类 </span>
<div style="clear:both"></div>
</h1>
<form method="post" action="" name="listForm">
<div class="list-div" id="listDiv">

<table width="100%" cellspacing="1" cellpadding="2" id="list-table">
  <tr>
      <?php foreach ($list as $v) { ?>
    <th><?php echo $v[0]['attr_name'] ?></th>
      <?php } ?>
    <th>库存</th>
      <th>操作</th>
  </tr>

    <tr>
        <?php foreach ($list as $v) { ?>
        <td><select name=''>
            <option value=''>请选择</option>
            <?php foreach($v as $v1) { ?>
            <option value='<?php echo $v1["id"] ?>'><?php echo $v1['attr_value'] ?></option>
            <?php } ?>
        </select></td>
        <?php } ?>
        <td><input type="text" name="goods_number[]" /></td>
        <td><input type="button" value="+" /></td>
    </tr>
  </table>
</div>
</form>
</body>
</html>