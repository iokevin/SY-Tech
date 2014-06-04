20140604
order表增加字段yinghuikuan
  `yinghuikuan` decimal(10,2) NOT NULL DEFAULT '0.00',
admin/template/manage/order.html
admin/module/manageMod.class.php

20140531
order表增加字段status,desc
 `status` tinyint(2) NOT NULL DEFAULT '1',
  `desc` varchar(255) DEFAULT NULL,
后台增加订单对账功能
admin/module/manageMod.class.php
admin/template/manage/order.html
admin/template/manage/orderEdit.html
admin/template/manage/orderSets.html
admin/template/menu/apply.php

20140508 
后台增加订单查询条件为 成功-未结算 和 退货-未结算 
admin/template/manage/index.html
admin/module/manageMod.class.php

///////////////////////////////////////////////////////////////////////////////

20140502
添加产品查看功能：
1.增加产品表 adm_goods
CREATE TABLE `adm_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `vprice` decimal(10,0) DEFAULT NULL,
  `pprice` decimal(10,0) DEFAULT NULL,
  `mprice` decimal(10,0) DEFAULT NULL,
  `wholesaleprice` decimal(10,0) DEFAULT NULL,
  `desc` varchar(50) DEFAULT NULL,
  `stock` tinyint(2) DEFAULT NULL,
  `hot` tinyint(2) DEFAULT NULL,
  `new` tinyint(2) DEFAULT NULL,
  `promo` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC

2.增加module
admin/module/goodsMod.class.php
module/goodsMod.class.php


///////////////////////////////////////////////////////////////////////////

添加订单：
1. 电话号码录入改为发QQ
2. 快递公司选择下拉框增加 顺丰COD和宅急送COD
3. 增加LC号输入 （数据库订单表增加LC号字段) alicod varchar30
4. 增加发货状态：成功-未结算 退货-未结算 问题件（已加） 批发价为0
5. 盈利计算 & VIP盈利计算 VIP账户显示

360浏览器登录后白屏问题

20140320
增加黑名单功能：
/admin/template/user/index.html & add.html & edit.html
/admin/template/manage/index.html & edit.html
/admin/module/manageMod.class.php
/module/manageMod.class.php  &  accountsMod.class.php & indexMod.class.php
/template/user_index.html header.html (加VIP）




/////////////////////////////////////////////////
IP黑名单库功能： （取消）

1.增加黑名单IP表 adm_ipblack
CREATE TABLE `adm_ipblack` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

2.订单表adm_order 增加 ip 字段 
`ip` varchar(15) DEFAULT '0'

修改：/module/manageMod.class.php
////////////////////////////////////////////////////
