DROP TABLE IF EXISTS `svcart_cards`;
CREATE TABLE `svcart_cards` (
  `id` int(11) NOT NULL auto_increment COMMENT '贺卡编号',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `img01` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片',
  `img02` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片2',
  `fee` decimal(6,2) unsigned NOT NULL default '0.00',
  `free_money` decimal(6,2) unsigned NOT NULL default '0.00',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='贺卡';
INSERT INTO `svcart_cards` VALUES  ( '10', '50', '10', '10', '0.00', '0.00', '1', '2008-01-01 00:00:00', '2008-01-01 00:00:00' ),
 ( '20', '50', '20', '20', '0.00', '0.00', '1', '2008-01-01 00:00:00', '2008-01-01 00:00:00' );
DROP TABLE IF EXISTS `svcart_carts`;
CREATE TABLE `svcart_carts` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `session_id` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '进程编号',
  `user_id` int(11) NOT NULL default '0' COMMENT '用户编号',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号',
  `product_id` int(11) NOT NULL COMMENT '商品编号',
  `product_code` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '商品代码',
  `product_name` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '商品名称',
  `product_price` float(12,2) NOT NULL COMMENT '商品价格',
  `product_quantity` smallint(6) NOT NULL COMMENT '购买商品数量',
  `product_attrbute` text collate utf8_unicode_ci NOT NULL COMMENT '商品属性',
  `type` char(1) collate utf8_unicode_ci default NULL,
  `extension_code` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT 'virtual_card：虚拟商品',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='购物车表';
INSERT INTO `svcart_carts` VALUES  ( '1', '1', '1', '1', '1', '1', '1', '1.00', '1', '1', '1', '1', '2008-01-01 00:00:00', '2008-01-01 00:00:00' ),
 ( '2', '2', '2', '2', '2', '2', '2', '2.00', '2', '2', '2', '2', '2008-01-01 00:00:00', '2008-01-01 00:00:00' ),
 ( '3', '3', '3', '1', '1', '1', '1', '1.00', '1', '1', '1', '1', '2008-01-01 00:00:00', '2008-01-01 00:00:00' ),
 ( '4', '4', '4', '2', '2', '2', '2', '2.00', '2', '2', '2', '2', '2008-01-01 00:00:00', '2008-01-01 00:00:00' ),
 ( '5', '3', '5', '1', '1', '1', '1', '1.00', '1', '1', '1', '1', '2008-01-01 00:00:00', '2008-01-01 00:00:00' ),
 ( '6', '4', '6', '2', '2', '2', '2', '2.00', '2', '2', '2', '2', '2008-01-01 00:00:00', '2008-01-01 00:00:00' );
