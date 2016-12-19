create table e2_type(
    id tinyint unsigned primary key auto_increment,
    type_name varchar(32) not null comment '商品类型名称',
    index (type_name)
)engine myisam charset utf8;
--创建一个商品类型表
create table e2_attribute(
    id smallint unsigned primary key auto_increment,
    type_id tinyint unsigned not null comment '商品类型表id',
    attr_name varchar(32) not null comment '属性名称',
    attr_type tinyint not null comment '属性类型 0唯一属性,1列表选择',
    attr_input_type tinyint not null comment '属性值录入方式 0手工, 1列表选择',
    attr_value varchar(64) not null default '' comment '属性列表选择中的值',
    index(type_id)
)engine myisam charset utf8;
--创建一个商品属性表
create table e2_category(
    id smallint unsigned primary key auto_increment,
    cat_name varchar(32) not null comment '商品栏目名称',
    parent_id smallint not null default 0 comment '父级栏目id'
)engine myisam charset utf8;
--创建一个栏目表
create table e2_goods(
    id int unsigned primary key auto_increment,
    goods_name varchar(32) not null comment '商品名称',
    cat_id int not null comment '商品栏目id',
    goods_sn varchar(32) not null comment '商品货号',
    market_price decimal(9,2) not null default 0.0 comment '市场价格',
    shop_price decimal(9,2) not null default 0.0 comment '商城价格',
    goods_ori varchar(128) not null default '' comment '原图路径',
    goods_img varchar(128) not null default '' comment '中图路径',
    goods_thumb varchar(123) not null default '' comment '小图路径',
    is_best tinyint not null default 1 comment '是否精品(1精品)',
    is_hot tinyint not null default 1 comment '是否热卖',
    is_new tinyint not null default 1 comment '是否新品',
    is_sale tinyint not null default 1 comment '是否上架',
    is_delete tinyint not null default 0 comment '是否删除',
    add_time int not null default 0 comment '添加时间',
    goods_type tinyint unsigned not null default 0 comment '商品类型id',
    goods_number smallint not null default 0 comment '商品总库存',
    goods_desc varchar(256) not null default '' comment '商品描述'
)engine myisam charset utf8;
--创建一个商品表