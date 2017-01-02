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
create table e2_goods_attr(
    id int unsigned primary key auto_increment,
    goods_id int not null comment '商品id',
    goods_attr_id smallint not null comment '属性id',
    attr_value varchar(32) not null comment '属性值'
)engine myisam charset utf8;
--创建属性值表
create table e2_admin(
    id int unsigned primary key auto_increment,
    admin_name varchar(32) not null comment '管理员名称',
    password char(32) not null comment '管理员密码',
    salt varchar(10) not null comment '盐'
)engine myisam charset utf8;
--创建一个管理员表
create table e2_role(
    id int unsigned primary key auto_increment,
    role_name varchar(32) not null comment '角色名称'
)engine myisam charset utf8;
--创建一个角色表
create table e2_privilege(
    id int unsigned primary key auto_increment,
    priv_name varchar(32) not null comment '权限名称',
    parent_id int not null default 0 comment '上级权限id',
    module_name varchar(32) not null default '' comment '权限对应模块',
    controller_name varchar(32) not null default '' comment '权限对应控制器',
    action_name varchar(32) not null default '' comment '权限对应方法'
)engine myisam charset utf8;
--创建一个权限表
create table  e2_role_privilege(
    role_id int unsigned not null comment '角色id',
    priv_id int unsigned not null comment '权限id'
)engine myisam charset utf8;
--创建一个角色与权限的中间表
create table e2_admin_role(
    admin_id int unsigned not null comment '管理员id',
    role_id int unsigned not null comment '橘色id'
)engine myisam charset utf8;
--创建一个管理员与角色的中间表
create table e2_product(
    id int unsigned primary key auto_increment,
    goods_id int not null comment '商品的id,就是e2_goods表里的id',
    goods_attr_id varchar(12) not null comment 'e2_goods_attr表里的id用于表示单选属性的值,多个用逗号隔开',
    goods_number int not null comment '库存'
)engine myisam charset utf8;
--创建一个库存表