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
