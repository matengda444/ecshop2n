create table e2_type(
    id tinyint unsigned primary key auto_increment,
    type_name varchar(32) not null comment '商品类型名称',
    index (type_name)
)engine myisam charset utf8;
--创建一个商品类型表
