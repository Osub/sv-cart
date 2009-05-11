--
-- 表的结构 `svcart_advertisements`
--

DROP TABLE IF EXISTS `svcart_advertisements`;
CREATE TABLE IF NOT EXISTS `svcart_advertisements` (
  `id` int(11) NOT NULL auto_increment COMMENT '广告编号',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号[多店用]',
  `media_type` tinyint(3) unsigned NOT NULL default '0',
  `ad_width` smallint(5) unsigned NOT NULL default '0',
  `ad_height` smallint(5) unsigned NOT NULL default '0',
  `contact_name` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系人',
  `contact_email` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT 'Email地址',
  `contact_tele` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系电话',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `is_showimg` tinyint(1) NOT NULL default '0' COMMENT '是否显示图片',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `click_count` mediumint(8) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='广告' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_advertisement_i18ns`
--

DROP TABLE IF EXISTS `svcart_advertisement_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_advertisement_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '广告编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `advertisement_id` int(11) NOT NULL COMMENT '广告编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '广告名称',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '广告描述',
  `url` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '广告地址',
  `start_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL default '0000-00-00 00:00:00',
  `code` text collate utf8_unicode_ci NOT NULL,
  `img01` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片',
  `img02` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片2',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`advertisement_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='广告多语言描述表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_articles`
--

DROP TABLE IF EXISTS `svcart_articles`;
CREATE TABLE IF NOT EXISTS `svcart_articles` (
  `id` int(11) NOT NULL auto_increment COMMENT '文章编号',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号',
  `author_email` varchar(60) collate utf8_unicode_ci NOT NULL COMMENT '作者E-mail',
  `type` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '文章类型',
  `file_url` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '外部链接',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '0:无效;1:有效;2:删除',
  `front` tinyint(1) NOT NULL default '0' COMMENT '首页显示 1:显示 0:不显示',
  `importance` tinyint(1) NOT NULL default '0' COMMENT '文章重要性[0:普通;1:置顶;2:滚动显示;3:置顶且滚动显示]',
  `clicked` int(11) unsigned NOT NULL default '0' COMMENT '文章被点击数',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `store_id` (`store_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='文章详细表' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_article_categories`
--

DROP TABLE IF EXISTS `svcart_article_categories`;
CREATE TABLE IF NOT EXISTS `svcart_article_categories` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `category_id` int(11) NOT NULL COMMENT '分类编号',
  `article_id` int(11) NOT NULL COMMENT '文章编号',
  `orderby` smallint(4) NOT NULL default '500' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='文章分类关联' AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_article_i18ns`
--

DROP TABLE IF EXISTS `svcart_article_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_article_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '文章多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `article_id` int(11) NOT NULL COMMENT '文章编号',
  `title` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '分类名称',
  `meta_keywords` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO分类关键字',
  `meta_description` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO分类描述',
  `content` longtext collate utf8_unicode_ci NOT NULL COMMENT '内容',
  `author` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '作者',
  `img01` varchar(100) collate utf8_unicode_ci default NULL COMMENT '图片1',
  `img02` varchar(100) collate utf8_unicode_ci default NULL COMMENT '图片2',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale_2` (`locale`,`article_id`),
  KEY `locale` (`locale`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `content` (`content`),
  FULLTEXT KEY `author` (`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='文章详细多语言表' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_booking_products`
--

DROP TABLE IF EXISTS `svcart_booking_products`;
CREATE TABLE IF NOT EXISTS `svcart_booking_products` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `user_id` mediumint(8) unsigned NOT NULL default '0',
  `email` varchar(60) collate utf8_unicode_ci NOT NULL default '',
  `contact_man` varchar(60) collate utf8_unicode_ci NOT NULL default '',
  `telephone` varchar(60) collate utf8_unicode_ci NOT NULL default '',
  `product_id` mediumint(8) unsigned NOT NULL default '0',
  `product_desc` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `product_number` smallint(5) unsigned NOT NULL default '0',
  `booking_time` datetime default NULL COMMENT '登记时间',
  `is_dispose` tinyint(1) unsigned NOT NULL default '0',
  `dispose_operation_id` int(11) NOT NULL COMMENT '处理操作员编号',
  `dispose_time` datetime default NULL COMMENT '处理时间',
  `dispose_note` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_brands`
--

DROP TABLE IF EXISTS `svcart_brands`;
CREATE TABLE IF NOT EXISTS `svcart_brands` (
  `id` int(11) NOT NULL auto_increment COMMENT '品牌编号',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `img01` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片',
  `img02` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片2',
  `flash_config` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'flash参数',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `url` varchar(100) character set utf8 NOT NULL COMMENT '品牌网址',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='品牌' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_brand_i18ns`
--

DROP TABLE IF EXISTS `svcart_brand_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_brand_i18ns` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `brand_id` int(11) NOT NULL COMMENT '品牌编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '品牌名称',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '品牌描述',
  `meta_keywords` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO品牌关键字',
  `meta_description` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO品牌描述',
  `img01` varchar(200) collate utf8_unicode_ci default NULL COMMENT '图片1',
  `img02` varchar(200) collate utf8_unicode_ci default NULL COMMENT '图片2',
  `img03` varchar(200) collate utf8_unicode_ci default NULL COMMENT '图片3',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`brand_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='品牌多语言描述表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_cards`
--

DROP TABLE IF EXISTS `svcart_cards`;
CREATE TABLE IF NOT EXISTS `svcart_cards` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='贺卡' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_card_i18ns`
--

DROP TABLE IF EXISTS `svcart_card_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_card_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '贺卡多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `card_id` int(11) NOT NULL COMMENT '贺卡编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '贺卡名称',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '贺卡描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`,`card_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='贺卡多语言描述表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_carts`
--

DROP TABLE IF EXISTS `svcart_carts`;
CREATE TABLE IF NOT EXISTS `svcart_carts` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='购物车表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_categories`
--

DROP TABLE IF EXISTS `svcart_categories`;
CREATE TABLE IF NOT EXISTS `svcart_categories` (
  `id` int(11) NOT NULL auto_increment COMMENT '分类编号',
  `parent_id` int(11) NOT NULL COMMENT '上级分类编号(0是根目录)',
  `type` char(1) collate utf8_unicode_ci NOT NULL default 'P' COMMENT '分类类型[A:文章,P:商品]',
  `flash_config` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT 'flash参数',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '0:无效;1:有效;2:删除',
  `link` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '超级链接',
  `img01` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片1',
  `img02` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片2',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='分类' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_category_i18ns`
--

DROP TABLE IF EXISTS `svcart_category_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_category_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '分类多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `category_id` int(11) NOT NULL COMMENT '分类编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '分类名称',
  `meta_keywords` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO分类关键字',
  `meta_description` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO分类描述',
  `detail` text collate utf8_unicode_ci NOT NULL,
  `img01` varchar(200) collate utf8_unicode_ci default NULL COMMENT '图片1',
  `img02` varchar(200) collate utf8_unicode_ci default NULL COMMENT '图片2',
  `img03` varchar(200) collate utf8_unicode_ci default NULL COMMENT '图片3',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='分类多语言描述表' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_comments`
--

DROP TABLE IF EXISTS `svcart_comments`;
CREATE TABLE IF NOT EXISTS `svcart_comments` (
  `id` int(11) NOT NULL auto_increment COMMENT '评论编号',
  `type` char(1) collate utf8_unicode_ci NOT NULL COMMENT '评论类型[商品，分类，品牌，文章，商店]',
  `type_id` int(11) NOT NULL COMMENT '类型编号',
  `email` varchar(60) collate utf8_unicode_ci NOT NULL,
  `name` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '姓名',
  `title` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '标题',
  `parent_id` mediumint(11) unsigned NOT NULL default '0' COMMENT '回复的评论ID',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '0' COMMENT '评论状态[0-不显示，1-显示，2-删除]',
  `content` text collate utf8_unicode_ci NOT NULL COMMENT '内容',
  `rank` tinyint(1) NOT NULL default '0' COMMENT '评论等级',
  `ipaddr` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT 'ip地址',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`),
  KEY `user_id` (`user_id`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户评论表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_configs`
--

DROP TABLE IF EXISTS `svcart_configs`;
CREATE TABLE IF NOT EXISTS `svcart_configs` (
  `id` smallint(5) unsigned NOT NULL auto_increment COMMENT '参数ID',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号[0:系统]',
  `group` varchar(100) NOT NULL COMMENT '设置参数组',
  `code` varchar(60) NOT NULL COMMENT '参数名称',
  `type` varchar(10) NOT NULL default '' COMMENT '参数类型',
  `orderby` tinyint(3) unsigned NOT NULL default '50' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `type` (`type`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统参数表' AUTO_INCREMENT=423 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_config_i18ns`
--

DROP TABLE IF EXISTS `svcart_config_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_config_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '配置多语言编号',
  `locale` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `config_id` int(11) NOT NULL COMMENT '配送编号',
  `name` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '配送名称',
  `value` text NOT NULL COMMENT '值',
  `options` text NOT NULL COMMENT '可选值',
  `description` text NOT NULL COMMENT '描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`),
  KEY `locale_2` (`locale`,`config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统参数值多语言表' AUTO_INCREMENT=879 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_coupons`
--

DROP TABLE IF EXISTS `svcart_coupons`;
CREATE TABLE IF NOT EXISTS `svcart_coupons` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `coupon_type_id` int(11) NOT NULL COMMENT '优惠券类型编号',
  `sn_code` varchar(20) NOT NULL default '0' COMMENT '优惠券类型使用码',
  `max_buy_quantity` int(11) NOT NULL default '0' COMMENT '最大使用数',
  `max_use_quantity` int(11) NOT NULL default '0' COMMENT '已使用数',
  `order_amount_discount` int(11) NOT NULL default '100' COMMENT 'coupon 的红包折扣',
  `user_id` mediumint(8) NOT NULL default '0',
  `used_time` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '使用时间',
  `order_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '订单编号',
  `emailed` tinyint(3) unsigned NOT NULL default '0' COMMENT '邮件通知标志',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='优惠券表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_coupon_types`
--

DROP TABLE IF EXISTS `svcart_coupon_types`;
CREATE TABLE IF NOT EXISTS `svcart_coupon_types` (
  `id` int(11) NOT NULL auto_increment COMMENT '优惠券类型编号',
  `money` decimal(10,2) NOT NULL default '0.00' COMMENT '发放金额',
  `send_type` tinyint(3) unsigned NOT NULL default '0' COMMENT '发放类型',
  `prefix` varchar(10) NOT NULL COMMENT '红包前缀',
  `min_amount` decimal(10,2) unsigned NOT NULL COMMENT '最小金额',
  `max_amount` decimal(10,2) unsigned NOT NULL COMMENT '最大金额',
  `min_products_amount` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '最低商品价钱',
  `send_start_date` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '发放开始时间',
  `send_end_date` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '发放结束时间',
  `use_start_date` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '使用开始时间',
  `use_end_date` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '使用结束时间',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='优惠券类型' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_coupon_type_i18ns`
--

DROP TABLE IF EXISTS `svcart_coupon_type_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_coupon_type_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '优惠券多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `coupon_type_id` int(11) NOT NULL COMMENT '优惠券类型编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '优惠券名称',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale_2` (`locale`,`coupon_type_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='优惠券多语言表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_departments`
--

DROP TABLE IF EXISTS `svcart_departments`;
CREATE TABLE IF NOT EXISTS `svcart_departments` (
  `id` int(11) NOT NULL auto_increment COMMENT '部门编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '部门名称',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '部门描述',
  `contact_name` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系人',
  `contact_email` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT 'Email地址',
  `contact_tele` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系电话',
  `contact_mobile` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系人手机',
  `contact_fax` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系传真',
  `contact_remark` text collate utf8_unicode_ci NOT NULL COMMENT '联系备注',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='部门' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_department_i18ns`
--

DROP TABLE IF EXISTS `svcart_department_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_department_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '分类多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `department_id` int(11) NOT NULL COMMENT '部门编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '部门名称',
  `description` tinytext collate utf8_unicode_ci NOT NULL COMMENT '部门描述',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='部门多语言描述表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_flashes`
--

DROP TABLE IF EXISTS `svcart_flashes`;
CREATE TABLE IF NOT EXISTS `svcart_flashes` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '类型[H:首页;PC:分类;B:品牌;AC:文章分类]',
  `type_id` int(11) NOT NULL,
  `roundCorner` varchar(20) collate utf8_unicode_ci NOT NULL,
  `autoPlayTime` varchar(20) collate utf8_unicode_ci NOT NULL,
  `isHeightQuality` varchar(20) collate utf8_unicode_ci NOT NULL,
  `blendMode` varchar(20) collate utf8_unicode_ci NOT NULL,
  `transDuration` varchar(20) collate utf8_unicode_ci NOT NULL,
  `windowOpen` varchar(20) collate utf8_unicode_ci NOT NULL,
  `btnSetMargin` varchar(20) collate utf8_unicode_ci NOT NULL,
  `btnDistance` varchar(20) collate utf8_unicode_ci NOT NULL,
  `titleBgColor` varchar(20) collate utf8_unicode_ci NOT NULL,
  `titleTextColor` varchar(20) collate utf8_unicode_ci NOT NULL,
  `titleBgAlpha` varchar(20) collate utf8_unicode_ci NOT NULL,
  `titleMoveDuration` varchar(20) collate utf8_unicode_ci NOT NULL,
  `btnAlpha` varchar(20) collate utf8_unicode_ci NOT NULL,
  `btnTextColor` varchar(20) collate utf8_unicode_ci NOT NULL,
  `btnDefaultColor` varchar(20) collate utf8_unicode_ci NOT NULL,
  `btnHoverColor` varchar(20) collate utf8_unicode_ci NOT NULL,
  `btnFocusColor` varchar(20) collate utf8_unicode_ci NOT NULL,
  `changImageMode` varchar(20) collate utf8_unicode_ci NOT NULL,
  `isShowBtn` varchar(20) collate utf8_unicode_ci NOT NULL,
  `isShowTitle` varchar(20) collate utf8_unicode_ci NOT NULL,
  `scaleMode` varchar(20) collate utf8_unicode_ci NOT NULL,
  `transform` varchar(20) collate utf8_unicode_ci NOT NULL,
  `isShowAbout` varchar(20) collate utf8_unicode_ci NOT NULL,
  `titleFont` varchar(20) collate utf8_unicode_ci NOT NULL,
  `height` int(11) NOT NULL default '314' COMMENT '长',
  `width` int(11) NOT NULL default '741' COMMENT '宽',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `type_2` (`type`,`type_id`),
  KEY `type` (`type`,`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_flash_images`
--

DROP TABLE IF EXISTS `svcart_flash_images`;
CREATE TABLE IF NOT EXISTS `svcart_flash_images` (
  `id` int(11) NOT NULL auto_increment COMMENT '图片编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言代码',
  `flash_id` int(10) NOT NULL,
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `image` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片',
  `title` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '标题文字',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '描述',
  `url` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '链接地址',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `locale` (`locale`),
  KEY `flash_id` (`flash_id`),
  KEY `locale_2` (`locale`,`flash_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='FLASH图片表' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_languages`
--

DROP TABLE IF EXISTS `svcart_languages`;
CREATE TABLE IF NOT EXISTS `svcart_languages` (
  `id` int(11) NOT NULL auto_increment COMMENT '语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言代码',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '语言',
  `charset` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '字符集',
  `map` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '系统映射',
  `img01` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片01',
  `img02` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片02',
  `front` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '前台显示',
  `backend` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '后台显示',
  `default` char(1) collate utf8_unicode_ci NOT NULL COMMENT '1为默认',
  `google_translate_code` varchar(255) collate utf8_unicode_ci NOT NULL default '0' COMMENT 'google 翻译接口',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `front` (`front`),
  KEY `backend` (`backend`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='语言表' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_language_dictionaries`
--

DROP TABLE IF EXISTS `svcart_language_dictionaries`;
CREATE TABLE IF NOT EXISTS `svcart_language_dictionaries` (
  `id` int(11) NOT NULL auto_increment COMMENT 'id',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言代码',
  `location` varchar(10) collate utf8_unicode_ci NOT NULL default 'front' COMMENT '前后台参数区分',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '名称',
  `type` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '类型',
  `description` varchar(255) collate utf8_unicode_ci default NULL COMMENT '描述',
  `value` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '内容',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1696 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_links`
--

DROP TABLE IF EXISTS `svcart_links`;
CREATE TABLE IF NOT EXISTS `svcart_links` (
  `id` int(11) NOT NULL auto_increment COMMENT '友情链接编号',
  `contact_name` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系人',
  `contact_email` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT 'Email地址',
  `contact_tele` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系电话',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='友情链接' AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_link_i18ns`
--

DROP TABLE IF EXISTS `svcart_link_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_link_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '友情链接编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `link_id` int(11) NOT NULL COMMENT '友情链接编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '友情链接名称',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '友情链接描述',
  `url` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '友情链接地址',
  `click_stat` int(11) NOT NULL default '0' COMMENT '点击次数',
  `img01` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片',
  `img02` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '图片2',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`link_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='友情链接多语言描述表' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_mail_templates`
--

DROP TABLE IF EXISTS `svcart_mail_templates`;
CREATE TABLE IF NOT EXISTS `svcart_mail_templates` (
  `id` int(11) NOT NULL auto_increment COMMENT '邮件模板编号',
  `code` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '编号',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='邮件模板' AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_mail_template_i18ns`
--

DROP TABLE IF EXISTS `svcart_mail_template_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_mail_template_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '邮件模板多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `mail_template_id` int(11) NOT NULL COMMENT '邮件模板编号',
  `title` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '邮件模板名称',
  `text_body` text collate utf8_unicode_ci NOT NULL COMMENT '邮件模板text模板',
  `html_body` text collate utf8_unicode_ci NOT NULL COMMENT '邮件模板HTML模板',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`mail_template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='邮件模板多语言描述表' AUTO_INCREMENT=89 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_navigations`
--

DROP TABLE IF EXISTS `svcart_navigations`;
CREATE TABLE IF NOT EXISTS `svcart_navigations` (
  `id` mediumint(9) NOT NULL auto_increment COMMENT '导航编号',
  `type` char(1) collate utf8_unicode_ci NOT NULL COMMENT '导航类型[H;T;M;B...]',
  `orderby` tinyint(4) NOT NULL default '10' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `icon` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '缩略图',
  `target` enum('_self','_blank') collate utf8_unicode_ci NOT NULL default '_self' COMMENT '打开位置',
  `controller` enum('pages','categories','brands','products','articles','cars') collate utf8_unicode_ci NOT NULL COMMENT '系统内容',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='导航栏' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_navigation_i18ns`
--

DROP TABLE IF EXISTS `svcart_navigation_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_navigation_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '导航多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `navigation_id` mediumint(9) NOT NULL COMMENT '导航编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '导航栏名称',
  `url` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'URL链接',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale_2` (`locale`,`navigation_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='导航栏多语言描述表' AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_newsletter_lists`
--

DROP TABLE IF EXISTS `svcart_newsletter_lists`;
CREATE TABLE IF NOT EXISTS `svcart_newsletter_lists` (
  `id` int(11) NOT NULL auto_increment COMMENT '邮件订阅编号',
  `email` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '邮件地址',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='邮件订阅表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operators`
--

DROP TABLE IF EXISTS `svcart_operators`;
CREATE TABLE IF NOT EXISTS `svcart_operators` (
  `id` int(11) NOT NULL auto_increment COMMENT '管理员编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '管理员名称',
  `password` varchar(64) collate utf8_unicode_ci NOT NULL COMMENT '管理员密码',
  `email` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '管理员邮件',
  `mobile` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '管理员手机',
  `department_id` int(10) NOT NULL,
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号[0:系统管理员]',
  `role_id` varchar(200) collate utf8_unicode_ci NOT NULL default '0' COMMENT '角色编号',
  `actions` text collate utf8_unicode_ci NOT NULL COMMENT '功能权限',
  `default_lang` varchar(10) collate utf8_unicode_ci NOT NULL default 'zh_cn' COMMENT '管理员默认语言',
  `desktop` text collate utf8_unicode_ci NOT NULL COMMENT '桌面设置',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '0' COMMENT '状态[0:无效;1:有效;2:冻结]',
  `last_login_time` datetime default NULL,
  `last_login_ip` varchar(20) collate utf8_unicode_ci default NULL,
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `store_id` (`store_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_actions`
--

DROP TABLE IF EXISTS `svcart_operator_actions`;
CREATE TABLE IF NOT EXISTS `svcart_operator_actions` (
  `id` int(11) NOT NULL auto_increment COMMENT '功能编号',
  `level` tinyint(4) NOT NULL COMMENT '功能等级',
  `parent_id` int(11) NOT NULL COMMENT '父编号',
  `code` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '代码',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '0' COMMENT '状态[0:无效 1:有效]',
  `orderby` tinyint(4) NOT NULL default '50',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `level` (`level`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员权限表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_action_i18ns`
--

DROP TABLE IF EXISTS `svcart_operator_action_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_operator_action_i18ns` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `locale` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `operator_action_id` int(11) NOT NULL COMMENT '功能编号',
  `name` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '功能名称',
  `values` varchar(500) NOT NULL COMMENT '值',
  `description` varchar(255) NOT NULL COMMENT '功能描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时\r\n\r\n\r\n\r\n间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时\r\n\r\n\r\n\r\n间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale_2` (`locale`,`operator_action_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员权限语言表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_logs`
--

DROP TABLE IF EXISTS `svcart_operator_logs`;
CREATE TABLE IF NOT EXISTS `svcart_operator_logs` (
  `id` int(11) NOT NULL auto_increment COMMENT '日志编号',
  `operator_id` int(11) NOT NULL COMMENT '管理员编号',
  `ipaddress` varchar(30) collate utf8_unicode_ci NOT NULL COMMENT 'IP地址',
  `action_url` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '访问地址',
  `info` text collate utf8_unicode_ci NOT NULL COMMENT '备注',
  `type` char(1) collate utf8_unicode_ci NOT NULL COMMENT '类型',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `admin_id` (`operator_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员操作日志表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_menus`
--

DROP TABLE IF EXISTS `svcart_operator_menus`;
CREATE TABLE IF NOT EXISTS `svcart_operator_menus` (
  `id` int(11) NOT NULL COMMENT '菜单编号',
  `parent_id` int(11) NOT NULL default '0' COMMENT '上级菜单编号',
  `name` varchar(50) collate utf8_unicode_ci NOT NULL COMMENT '菜单名称',
  `operator_action_code` varchar(250) collate utf8_unicode_ci NOT NULL COMMENT '权限代码',
  `type` varchar(1) collate utf8_unicode_ci NOT NULL COMMENT '类型',
  `link` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '连接地址',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员菜单表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_menu_i18ns`
--

DROP TABLE IF EXISTS `svcart_operator_menu_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_operator_menu_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '菜单多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `operator_menu_id` int(11) NOT NULL COMMENT '菜单编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '菜单名称',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`operator_menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='菜单多语言描述表' AUTO_INCREMENT=257 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_roles`
--

DROP TABLE IF EXISTS `svcart_operator_roles`;
CREATE TABLE IF NOT EXISTS `svcart_operator_roles` (
  `id` int(11) NOT NULL auto_increment COMMENT '管理员角色编号',
  `store_id` int(11) NOT NULL COMMENT '商店编号',
  `actions` text collate utf8_unicode_ci NOT NULL COMMENT '功能权限',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '0' COMMENT '状态[0:无效;1:有效;2:冻结]',
  `orderby` smallint(4) NOT NULL default '500' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员角色' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_role_i18ns`
--

DROP TABLE IF EXISTS `svcart_operator_role_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_operator_role_i18ns` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `operator_role_id` int(11) NOT NULL COMMENT '管理员角色编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '角色名称',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理员角色多语言表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_orders`
--

DROP TABLE IF EXISTS `svcart_orders`;
CREATE TABLE IF NOT EXISTS `svcart_orders` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT '订单ID',
  `order_code` varchar(60) character set utf8 collate utf8_unicode_ci NOT NULL default '0' COMMENT '订单code',
  `user_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '用户ID',
  `operator_id` int(11) NOT NULL default '0' COMMENT '操作员编号(处理)',
  `status` tinyint(5) unsigned NOT NULL default '0' COMMENT '订单状态',
  `shipping_id` tinyint(3) NOT NULL default '0' COMMENT '配送ID',
  `shipping_name` varchar(120) NOT NULL default '' COMMENT '配送名称',
  `shipping_status` tinyint(5) unsigned NOT NULL default '0' COMMENT '配送状态',
  `shipping_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '配送时间',
  `shipping_fee` decimal(10,2) NOT NULL default '0.00' COMMENT '配送时间',
  `point_fee` decimal(10,2) NOT NULL default '0.00' COMMENT '积分费用',
  `point_use` int(11) NOT NULL default '0' COMMENT '积分数',
  `payment_id` tinyint(3) NOT NULL default '0' COMMENT '支付方式',
  `payment_name` varchar(120) NOT NULL default '' COMMENT '支付名称',
  `payment_status` tinyint(5) unsigned NOT NULL default '0' COMMENT '支付状态',
  `payment_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '支付时间',
  `payment_fee` decimal(10,2) NOT NULL default '0.00' COMMENT '支付费用',
  `coupon_id` int(11) NOT NULL default '0' COMMENT '红包ID',
  `consignee` varchar(60) NOT NULL default '' COMMENT '真是姓名',
  `address` varchar(255) NOT NULL default '' COMMENT '地址',
  `zipcode` varchar(60) NOT NULL default '' COMMENT '邮政编码',
  `telephone` varchar(60) NOT NULL default '' COMMENT '电话',
  `mobile` varchar(60) NOT NULL default '' COMMENT '手机',
  `email` varchar(60) NOT NULL default '' COMMENT '电子邮箱',
  `best_time` varchar(120) NOT NULL default '' COMMENT '最佳配送时间',
  `sign_building` varchar(120) NOT NULL default '' COMMENT '标志性建筑',
  `postscript` varchar(255) NOT NULL default '' COMMENT '***********************************************',
  `invoice_no` varchar(50) NOT NULL default '' COMMENT '发票号',
  `note` varchar(255) NOT NULL default '' COMMENT '备注',
  `money_paid` decimal(10,2) NOT NULL default '0.00' COMMENT '已付金额',
  `discount` decimal(10,2) NOT NULL default '0.00' COMMENT '折扣',
  `total` decimal(10,2) NOT NULL default '0.00' COMMENT '总计',
  `subtotal` decimal(10,2) NOT NULL default '0.00' COMMENT '纯商品总价格的小计',
  `from_ad` smallint(5) NOT NULL default '0' COMMENT '广告来源',
  `referer` varchar(255) NOT NULL COMMENT '网站来源',
  `tax` decimal(10,2) NOT NULL COMMENT '发票税额',
  `insure_fee` decimal(10,2) NOT NULL default '0.00' COMMENT '保价费用',
  `pack_fee` decimal(10,2) NOT NULL default '0.00' COMMENT '包装费用',
  `card_fee` decimal(10,2) NOT NULL default '0.00' COMMENT '贺卡费用',
  `invoice_type` varchar(60) NOT NULL COMMENT '发票类型',
  `invoice_payee` varchar(120) NOT NULL COMMENT '发票抬头',
  `invoice_content` varchar(120) NOT NULL COMMENT '发票内容',
  `how_oos` varchar(120) NOT NULL COMMENT '缺货处理',
  `pack_name` varchar(120) NOT NULL COMMENT '包装',
  `card_name` varchar(120) NOT NULL COMMENT '贺卡',
  `card_message` varchar(255) NOT NULL COMMENT '贺卡祝福语',
  `to_buyer` varchar(255) NOT NULL COMMENT '商家给客户的留言',
  `confirm_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '订单确认时间',
  `regions` varchar(200) NOT NULL COMMENT '区域集',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_order_actions`
--

DROP TABLE IF EXISTS `svcart_order_actions`;
CREATE TABLE IF NOT EXISTS `svcart_order_actions` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `order_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '订单ID',
  `from_operator_id` int(11) NOT NULL COMMENT '操作员编号',
  `to_operator_id` int(11) NOT NULL default '0' COMMENT '指派给',
  `user_id` int(11) NOT NULL default '0' COMMENT '会员编号',
  `order_status` tinyint(5) unsigned NOT NULL default '0' COMMENT '订单状态',
  `shipping_status` tinyint(3) unsigned NOT NULL default '0' COMMENT '配送状态',
  `payment_status` tinyint(2) unsigned NOT NULL default '0' COMMENT '支付状态',
  `action_note` varchar(255) NOT NULL COMMENT '操作备注',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单操作日志' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_order_cards`
--

DROP TABLE IF EXISTS `svcart_order_cards`;
CREATE TABLE IF NOT EXISTS `svcart_order_cards` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '订单ID',
  `card_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '贺卡ID',
  `card_name` varchar(120) collate utf8_unicode_ci NOT NULL default '' COMMENT '贺卡名称',
  `card_quntity` smallint(5) unsigned NOT NULL default '1' COMMENT '贺卡数量',
  `card_fee` decimal(10,2) NOT NULL default '0.00' COMMENT '贺卡价格',
  `note` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '备注',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[单独商品发货用]',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`),
  KEY `card_id` (`card_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_order_packagings`
--

DROP TABLE IF EXISTS `svcart_order_packagings`;
CREATE TABLE IF NOT EXISTS `svcart_order_packagings` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '订单ID',
  `packaging_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '包装ID',
  `packaging_name` varchar(120) collate utf8_unicode_ci NOT NULL default '' COMMENT '包装名称',
  `packaging_quntity` smallint(5) unsigned NOT NULL default '1' COMMENT '包装数量',
  `packaging_fee` decimal(10,2) NOT NULL default '0.00' COMMENT '包装价格',
  `note` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '备注',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[单独商品发货用]',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`),
  KEY `packaging_id` (`packaging_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_order_products`
--

DROP TABLE IF EXISTS `svcart_order_products`;
CREATE TABLE IF NOT EXISTS `svcart_order_products` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '订单ID',
  `product_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '商品ID',
  `product_name` varchar(120) NOT NULL default '' COMMENT '商品名称',
  `product_code` varchar(60) NOT NULL default '' COMMENT '商品编号',
  `product_quntity` smallint(5) unsigned NOT NULL default '1' COMMENT '商品数量',
  `product_price` decimal(10,2) NOT NULL default '0.00' COMMENT '商品价格',
  `product_attrbute` text NOT NULL COMMENT '商品属性',
  `note` varchar(200) NOT NULL COMMENT '备注',
  `status` char(1) NOT NULL default '1' COMMENT '状态[单独商品发货用]',
  `extension_code` varchar(20) NOT NULL COMMENT 'virtual_card：虚拟商品',
  `send_quntity` int(11) NOT NULL default '0' COMMENT '虚拟卡已发送数量',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单商品' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_packagings`
--

DROP TABLE IF EXISTS `svcart_packagings`;
CREATE TABLE IF NOT EXISTS `svcart_packagings` (
  `id` int(11) NOT NULL auto_increment COMMENT '包装编号',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='包装' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_packaging_i18ns`
--

DROP TABLE IF EXISTS `svcart_packaging_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_packaging_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '包装多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `packaging_id` int(11) NOT NULL COMMENT '包装编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '包装名称',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '包装描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`packaging_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='包装多语言描述表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_payments`
--

DROP TABLE IF EXISTS `svcart_payments`;
CREATE TABLE IF NOT EXISTS `svcart_payments` (
  `id` tinyint(3) unsigned NOT NULL auto_increment COMMENT 'ID',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号',
  `code` varchar(20) NOT NULL COMMENT '支付代码',
  `fee` varchar(10) NOT NULL default '0' COMMENT '手续费',
  `orderby` tinyint(3) unsigned NOT NULL default '0' COMMENT '排序',
  `config` text NOT NULL COMMENT '参数',
  `status` tinyint(1) unsigned NOT NULL default '0' COMMENT '状态',
  `is_cod` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否是货到付款',
  `is_online` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否在线支付',
  `supply_use_flag` char(1) NOT NULL default '1' COMMENT '充值可用标志',
  `order_use_flag` char(1) NOT NULL default '1' COMMENT '订单可用标志',
  `php_code` text NOT NULL COMMENT '接口代码',
  `version` varchar(40) NOT NULL COMMENT '插件版本',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='支付方式' AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_payment_api_logs`
--

DROP TABLE IF EXISTS `svcart_payment_api_logs`;
CREATE TABLE IF NOT EXISTS `svcart_payment_api_logs` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `payment_code` varchar(100) NOT NULL COMMENT '支付代码',
  `type` tinyint(1) unsigned NOT NULL default '0' COMMENT '支付类型(购买/充值)',
  `type_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '订单编号',
  `amount` decimal(10,2) unsigned NOT NULL COMMENT 'amount',
  `is_paid` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否已付款',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`),
  KEY `payment_code` (`payment_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='支付记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_payment_i18ns`
--

DROP TABLE IF EXISTS `svcart_payment_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_payment_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '支付方式多语言编号',
  `locale` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `payment_id` int(11) NOT NULL COMMENT '支付编号',
  `name` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '支付名称',
  `values` varchar(500) NOT NULL COMMENT '值',
  `description` varchar(255) default NULL COMMENT '支付描述',
  `status` char(1) NOT NULL default '1' COMMENT '状态[0:无效 1:有效]',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时\r\n\r\n间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时\r\n\r\n间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`payment_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='支付方式多语言' AUTO_INCREMENT=79 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_products`
--

DROP TABLE IF EXISTS `svcart_products`;
CREATE TABLE IF NOT EXISTS `svcart_products` (
  `id` int(11) NOT NULL auto_increment COMMENT '商品编号',
  `coupon_type_id` int(11) NOT NULL COMMENT '优惠券关联',
  `brand_id` int(11) NOT NULL default '0' COMMENT '品牌编号',
  `provider_id` int(11) NOT NULL default '0' COMMENT '供应商编号',
  `category_id` int(11) NOT NULL default '0' COMMENT '商品分类ID',
  `code` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '分类编号',
  `product_name_style` varchar(60) collate utf8_unicode_ci NOT NULL default '+' COMMENT '商品名称样式',
  `img_thumb` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '缩略图',
  `img_detail` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '详细图',
  `img_original` varchar(255) collate utf8_unicode_ci NOT NULL,
  `recommand_flag` char(1) collate utf8_unicode_ci NOT NULL default '0' COMMENT '推荐标志位',
  `min_buy` int(11) NOT NULL default '1' COMMENT '最小购买数',
  `max_buy` int(11) NOT NULL default '100' COMMENT '最大购买数',
  `admin_id` int(11) NOT NULL default '0' COMMENT '添加管理员',
  `alone` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效 1:有效]',
  `forsale` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效 1:有效]',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效 1:有效 2:进回收站]',
  `weight` decimal(10,3) unsigned NOT NULL default '0.000',
  `market_price` float(10,2) NOT NULL default '0.00' COMMENT '市场价',
  `shop_price` float(10,2) NOT NULL default '0.00' COMMENT '本店价',
  `promotion_price` float(10,2) NOT NULL default '0.00' COMMENT '促销价',
  `promotion_start` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '促销开始时间',
  `promotion_end` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '促销结束时间',
  `promotion_status` char(1) collate utf8_unicode_ci NOT NULL default '0' COMMENT '促销标志[0:无效;1:有效;2:自动]',
  `point` int(11) NOT NULL default '0' COMMENT '赠送积分数',
  `point_fee` varchar(11) collate utf8_unicode_ci NOT NULL default '0' COMMENT '积分购买额度',
  `view_stat` int(11) NOT NULL default '0' COMMENT '浏览次数',
  `sale_stat` int(11) NOT NULL default '0' COMMENT '销售次数',
  `product_type_id` smallint(5) unsigned NOT NULL default '0' COMMENT '商品类型',
  `product_rank_id` int(11) NOT NULL COMMENT '商品会员价',
  `quantity` int(11) NOT NULL COMMENT '库存',
  `extension_code` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT 'virtual_card：虚拟商品',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `brand_id` (`brand_id`),
  KEY `provider_id` (`provider_id`),
  KEY `recommand_flag` (`recommand_flag`),
  KEY `status` (`status`),
  KEY `forsale` (`forsale`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_products_categories`
--

DROP TABLE IF EXISTS `svcart_products_categories`;
CREATE TABLE IF NOT EXISTS `svcart_products_categories` (
  `id` int(11) NOT NULL auto_increment COMMENT '自增长编号',
  `category_id` int(11) NOT NULL COMMENT '类型编号',
  `product_id` int(11) NOT NULL COMMENT '商品编号',
  `orderby` smallint(4) NOT NULL default '500' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`category_id`,`product_id`),
  KEY `category_id` (`category_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品分类关联' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_articles`
--

DROP TABLE IF EXISTS `svcart_product_articles`;
CREATE TABLE IF NOT EXISTS `svcart_product_articles` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `article_id` int(11) NOT NULL COMMENT '文章编号',
  `product_id` int(11) NOT NULL COMMENT '商品编号',
  `orderby` smallint(4) NOT NULL default '500' COMMENT '排序',
  `is_double` tinyint(1) unsigned NOT NULL COMMENT '是否是双向关联',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `product_id` (`product_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品文章关联' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_attributes`
--

DROP TABLE IF EXISTS `svcart_product_attributes`;
CREATE TABLE IF NOT EXISTS `svcart_product_attributes` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '商品属性ID',
  `product_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '商品ID',
  `product_type_attribute_id` int(11) unsigned NOT NULL default '0' COMMENT '属性ID',
  `product_type_attribute_value` text NOT NULL COMMENT '属性值',
  `product_type_attribute_price` float(10,2) NOT NULL default '0.00' COMMENT '属性价格',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `goods_id` (`product_id`),
  KEY `attr_id` (`product_type_attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品属性表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_galleries`
--

DROP TABLE IF EXISTS `svcart_product_galleries`;
CREATE TABLE IF NOT EXISTS `svcart_product_galleries` (
  `id` int(11) NOT NULL auto_increment COMMENT '图片编号',
  `product_id` int(11) NOT NULL COMMENT '商品编号',
  `description` tinytext collate utf8_unicode_ci NOT NULL COMMENT '图片描述',
  `img_thumb` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '缩略图',
  `img_detail` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '详细图',
  `img_original` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '原始图',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `product_id` (`product_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品相册' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_i18ns`
--

DROP TABLE IF EXISTS `svcart_product_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_product_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '商品多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `product_id` int(11) NOT NULL COMMENT '商品编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '商品名称',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '详细描述',
  `market_price` float(10,2) NOT NULL default '0.00' COMMENT '市场价',
  `shop_price` float(10,2) NOT NULL default '0.00' COMMENT '本店价',
  `meta_keywords` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO关键字',
  `meta_description` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO描述',
  `api_site_url` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '商品网站网址',
  `api_cart_url` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '购物车快捷网址',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale_2` (`locale`,`product_id`),
  KEY `locale` (`locale`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品多语言描述表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_ranks`
--

DROP TABLE IF EXISTS `svcart_product_ranks`;
CREATE TABLE IF NOT EXISTS `svcart_product_ranks` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT 'ID',
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `rank_id` tinyint(3) NOT NULL COMMENT '会员等级ID',
  `is_default_rank` char(1) collate utf8_unicode_ci NOT NULL default '0' COMMENT '是否使用会员初始的比例 0:禁用 1:使用',
  `product_price` float(10,2) NOT NULL COMMENT '商品会员价',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `product_id` (`product_id`),
  KEY `rank_id` (`rank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_relations`
--

DROP TABLE IF EXISTS `svcart_product_relations`;
CREATE TABLE IF NOT EXISTS `svcart_product_relations` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `product_id` int(11) NOT NULL COMMENT '商品编号',
  `related_product_id` int(11) NOT NULL COMMENT '相关商品编号',
  `orderby` smallint(4) NOT NULL default '500' COMMENT '排序',
  `is_double` tinyint(1) unsigned NOT NULL COMMENT '是否是双向关联',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品关联表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_types`
--

DROP TABLE IF EXISTS `svcart_product_types`;
CREATE TABLE IF NOT EXISTS `svcart_product_types` (
  `id` int(11) NOT NULL auto_increment COMMENT '分类编号',
  `group` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '分组',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '0:无效;1:有效;2:删除',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `cat_id` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品类型' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_type_attributes`
--

DROP TABLE IF EXISTS `svcart_product_type_attributes`;
CREATE TABLE IF NOT EXISTS `svcart_product_type_attributes` (
  `id` int(11) NOT NULL auto_increment COMMENT '属性编号',
  `product_type_id` int(11) NOT NULL default '0' COMMENT '商品类型编号',
  `attr_value` text character set utf8 NOT NULL COMMENT '属性值',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '0:无效;1:有效;2:删除',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `attr_input_type` tinyint(1) unsigned NOT NULL default '1' COMMENT '属性输入类型',
  `attr_type` tinyint(1) unsigned NOT NULL default '1' COMMENT '属性是否可选',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `cat_id` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='属性' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_type_attribute_i18ns`
--

DROP TABLE IF EXISTS `svcart_product_type_attribute_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_product_type_attribute_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '属性多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `product_type_attribute_id` int(11) NOT NULL COMMENT '属性编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '属性名称',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`product_type_attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='分类多语言描述表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_type_i18ns`
--

DROP TABLE IF EXISTS `svcart_product_type_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_product_type_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '类型多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `type_id` int(11) NOT NULL COMMENT '分类编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '分类名称',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品类型多语言描述表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_promotions`
--

DROP TABLE IF EXISTS `svcart_promotions`;
CREATE TABLE IF NOT EXISTS `svcart_promotions` (
  `id` int(11) NOT NULL auto_increment COMMENT '促销编号',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号',
  `type` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '促销类型[0:减免;1:折扣;2:特惠品]',
  `type_ext` decimal(10,2) NOT NULL default '0.00' COMMENT '为0表示不限数量',
  `start_time` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '促销开始时间',
  `end_time` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '促销结束时间',
  `user_rank` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '促销类型',
  `min_amount` decimal(10,2) unsigned NOT NULL COMMENT '最小金额',
  `max_amount` decimal(10,2) unsigned NOT NULL COMMENT '最大金额',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '0:无效;1:有效;2:删除',
  `clicked` int(11) unsigned NOT NULL default '0' COMMENT '促销被点击数',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `store_id` (`store_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='促销详细表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_promotion_i18ns`
--

DROP TABLE IF EXISTS `svcart_promotion_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_promotion_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '促销多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `promotion_id` int(11) NOT NULL COMMENT '促销编号',
  `title` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '分类名称',
  `meta_keywords` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO分类关键字',
  `meta_description` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO分类描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='促销详细多语言表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_promotion_products`
--

DROP TABLE IF EXISTS `svcart_promotion_products`;
CREATE TABLE IF NOT EXISTS `svcart_promotion_products` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号',
  `promotion_id` int(11) NOT NULL COMMENT '促销编号',
  `product_id` int(11) NOT NULL COMMENT '商品编号',
  `price` decimal(10,2) unsigned NOT NULL COMMENT '价格',
  `start_time` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '促销开始时间',
  `end_time` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '促销结束时间',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '0:无效;1:有效;2:删除',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='促销商品表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_providers`
--

DROP TABLE IF EXISTS `svcart_providers`;
CREATE TABLE IF NOT EXISTS `svcart_providers` (
  `id` int(11) NOT NULL auto_increment COMMENT '供应商编号',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '供应商名称',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '供应商描述',
  `meta_keywords` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO关键字',
  `meta_description` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO描述',
  `contact_name` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系人',
  `contact_email` varchar(200) collate utf8_unicode_ci NOT NULL,
  `contact_tele` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系电话',
  `contact_mobile` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系人手机',
  `contact_fax` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系传真',
  `contact_address` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '联系地址',
  `contact_zip` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系邮编',
  `contact_remark` text collate utf8_unicode_ci NOT NULL COMMENT '联系备注',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='供应商' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_provider_products`
--

DROP TABLE IF EXISTS `svcart_provider_products`;
CREATE TABLE IF NOT EXISTS `svcart_provider_products` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `provider_id` int(11) NOT NULL COMMENT '供应商编号',
  `product_id` int(11) NOT NULL COMMENT '商品编号',
  `price` float(12,2) NOT NULL COMMENT '价格',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `min_buy` int(11) NOT NULL COMMENT '最小进货量',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='供应商商品' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_regions`
--

DROP TABLE IF EXISTS `svcart_regions`;
CREATE TABLE IF NOT EXISTS `svcart_regions` (
  `id` smallint(5) unsigned NOT NULL auto_increment COMMENT 'ID',
  `parent_id` smallint(5) unsigned NOT NULL default '0' COMMENT '父地区ID',
  `level` tinyint(1) NOT NULL default '2' COMMENT '等级',
  `agency_id` smallint(5) unsigned NOT NULL default '0' COMMENT '***********************************************',
  `param01` varchar(200) NOT NULL COMMENT '参数1',
  `param02` varchar(200) NOT NULL COMMENT '参数2',
  `param03` varchar(200) NOT NULL COMMENT '参数3',
  `orderby` smallint(6) NOT NULL default '0' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `level` (`level`),
  KEY `agency_id` (`agency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='地区' AUTO_INCREMENT=419 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_region_i18ns`
--

DROP TABLE IF EXISTS `svcart_region_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_region_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '区域多语言编号',
  `locale` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `region_id` int(11) NOT NULL COMMENT '文章编号',
  `name` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '分类名称',
  `description` text NOT NULL COMMENT '描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale_2` (`locale`,`region_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='地区多语言' AUTO_INCREMENT=1261 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_sessions`
--

DROP TABLE IF EXISTS `svcart_sessions`;
CREATE TABLE IF NOT EXISTS `svcart_sessions` (
  `id` varchar(255) collate utf8_unicode_ci NOT NULL default '',
  `data` text collate utf8_unicode_ci,
  `expires` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_shippings`
--

DROP TABLE IF EXISTS `svcart_shippings`;
CREATE TABLE IF NOT EXISTS `svcart_shippings` (
  `id` tinyint(3) unsigned NOT NULL auto_increment COMMENT 'ID',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号',
  `code` varchar(100) NOT NULL COMMENT '配送代码',
  `insure` char(1) NOT NULL default '0' COMMENT '是否保价',
  `support_cod` tinyint(1) unsigned NOT NULL default '0' COMMENT '支持货到付款',
  `status` tinyint(1) unsigned NOT NULL default '0' COMMENT '状态',
  `php_code` text NOT NULL COMMENT '接口代码',
  `orderby` tinyint(3) NOT NULL COMMENT '排序',
  `insure_fee` decimal(10,2) NOT NULL default '0.00' COMMENT '保价费用',
  `version` varchar(40) NOT NULL COMMENT '插件版本',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='配送方式' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_shipping_areas`
--

DROP TABLE IF EXISTS `svcart_shipping_areas`;
CREATE TABLE IF NOT EXISTS `svcart_shipping_areas` (
  `id` smallint(5) unsigned NOT NULL auto_increment COMMENT 'ID',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号',
  `shipping_id` tinyint(3) unsigned NOT NULL default '0' COMMENT '配送方法ID',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` tinyint(1) NOT NULL default '0',
  `fee_configures` text NOT NULL COMMENT '费用参数"0:5;5:10;100:20"',
  `free_subtotal` decimal(10,2) NOT NULL COMMENT '免费额度',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `shipping_id` (`shipping_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='配送地区' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_shipping_area_i18ns`
--

DROP TABLE IF EXISTS `svcart_shipping_area_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_shipping_area_i18ns` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言',
  `shipping_area_id` int(11) NOT NULL COMMENT '配送区域ID',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '配送区域名',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '配送区域描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale` (`locale`,`shipping_area_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_shipping_area_regions`
--

DROP TABLE IF EXISTS `svcart_shipping_area_regions`;
CREATE TABLE IF NOT EXISTS `svcart_shipping_area_regions` (
  `id` int(11) unsigned NOT NULL auto_increment COMMENT 'ID',
  `shipping_area_id` smallint(5) NOT NULL,
  `region_id` smallint(5) NOT NULL,
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `shipping_area_id` (`shipping_area_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_shipping_i18ns`
--

DROP TABLE IF EXISTS `svcart_shipping_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_shipping_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '配送方式多语言编号',
  `locale` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `shipping_id` int(11) NOT NULL COMMENT '配送编号',
  `name` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '配送名称',
  `description` text NOT NULL COMMENT '配送描述',
  `param` varchar(200) NOT NULL COMMENT '参数',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`,`shipping_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='配送方式多语言' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_stores`
--

DROP TABLE IF EXISTS `svcart_stores`;
CREATE TABLE IF NOT EXISTS `svcart_stores` (
  `id` int(11) NOT NULL auto_increment COMMENT '店铺编号',
  `contact_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `contact_email` varchar(200) collate utf8_unicode_ci NOT NULL,
  `contact_tele` varchar(20) collate utf8_unicode_ci NOT NULL,
  `contact_mobile` varchar(20) collate utf8_unicode_ci NOT NULL,
  `contact_fax` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '传真',
  `remark` text collate utf8_unicode_ci NOT NULL COMMENT '备注',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='店铺表[多店铺版用]' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_store_i18ns`
--

DROP TABLE IF EXISTS `svcart_store_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_store_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '店铺多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `store_id` int(11) NOT NULL COMMENT '店铺编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '店铺名称',
  `description` text collate utf8_unicode_ci NOT NULL COMMENT '店铺描述',
  `address` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '地址',
  `telephone` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '联系电话',
  `zipcode` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '邮编',
  `transport` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '交通',
  `map` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '地图',
  `url` varchar(255) collate utf8_unicode_ci NOT NULL,
  `meta_keywords` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO关键字',
  `meta_description` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`),
  KEY `locale_2` (`locale`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='店铺多语言描述表[多店铺版用]' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_store_products`
--

DROP TABLE IF EXISTS `svcart_store_products`;
CREATE TABLE IF NOT EXISTS `svcart_store_products` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `store_id` int(11) NOT NULL COMMENT '店铺编号',
  `product_id` int(11) NOT NULL COMMENT '商品编号',
  `price` float(12,2) NOT NULL COMMENT '价格',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效;1:有效;]',
  `start_time` datetime NOT NULL COMMENT '有效时间',
  `end_time` datetime NOT NULL COMMENT '结束时间',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `store_id` (`store_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='店铺商品[多店铺版用]' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_templates`
--

DROP TABLE IF EXISTS `svcart_templates`;
CREATE TABLE IF NOT EXISTS `svcart_templates` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(60) collate utf8_unicode_ci NOT NULL COMMENT '模板名',
  `url` varchar(100) collate utf8_unicode_ci NOT NULL default 'http://www.seevia.cn/' COMMENT '作者地址',
  `status` tinyint(1) NOT NULL default '1' COMMENT '是否有效',
  `is_default` tinyint(1) NOT NULL default '0' COMMENT '是否默认',
  `author` varchar(60) collate utf8_unicode_ci NOT NULL COMMENT '作者',
  `version` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '版本',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_topics`
--

DROP TABLE IF EXISTS `svcart_topics`;
CREATE TABLE IF NOT EXISTS `svcart_topics` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `start_time` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '促销开始时间',
  `end_time` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '促销结束时间',
  `template` varchar(255) NOT NULL default '',
  `css` text NOT NULL,
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_topic_i18ns`
--

DROP TABLE IF EXISTS `svcart_topic_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_topic_i18ns` (
  `id` int(11) NOT NULL auto_increment COMMENT '专题多语言编号',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `topic_id` int(11) NOT NULL COMMENT '专题编号',
  `title` varchar(255) collate utf8_unicode_ci NOT NULL default '' COMMENT '专题名称',
  `intro` text collate utf8_unicode_ci NOT NULL COMMENT '专题介绍',
  `meta_keywords` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO分类关键字',
  `meta_description` tinytext collate utf8_unicode_ci NOT NULL COMMENT 'SEO分类描述',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale_2` (`locale`,`topic_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='专题多语言表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_topic_products`
--

DROP TABLE IF EXISTS `svcart_topic_products`;
CREATE TABLE IF NOT EXISTS `svcart_topic_products` (
  `id` int(11) NOT NULL auto_increment COMMENT '编号',
  `store_id` int(11) NOT NULL default '0' COMMENT '商店编号',
  `topic_id` int(11) NOT NULL COMMENT '促销编号',
  `product_id` int(11) NOT NULL COMMENT '商品编号',
  `price` decimal(10,2) unsigned NOT NULL COMMENT '价格',
  `orderby` tinyint(4) NOT NULL default '50' COMMENT '排序',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '0:无效;1:有效;2:删除',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `store_id` (`store_id`),
  KEY `store_id_3` (`store_id`,`topic_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='专题商品表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_users`
--

DROP TABLE IF EXISTS `svcart_users`;
CREATE TABLE IF NOT EXISTS `svcart_users` (
  `id` int(11) NOT NULL auto_increment COMMENT '用户编号',
  `name` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '昵称',
  `password` varchar(64) collate utf8_unicode_ci NOT NULL COMMENT '登陆密码',
  `email` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '邮箱',
  `address_id` varchar(200) collate utf8_unicode_ci NOT NULL default '0' COMMENT '地址ID',
  `question` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '问题',
  `answer` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '密码',
  `balance` float(12,2) NOT NULL COMMENT '余额',
  `frozen` float(12,2) NOT NULL COMMENT '冻结余额',
  `point` int(11) NOT NULL default '0' COMMENT '积分',
  `login_times` int(11) NOT NULL COMMENT '登陆次数',
  `login_ipaddr` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT '登陆地址',
  `last_login_time` datetime default NULL COMMENT '最后登录时间',
  `rank` int(11) NOT NULL COMMENT '等级',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效 1:有效 2:冻结 3:注销 ]',
  `verify_status` tinyint(1) NOT NULL default '0' COMMENT '会员认证状态[0 未认证 1已认证 2 取消认证]',
  `unvalidate_note` varchar(60) character set utf8 NOT NULL COMMENT '会员认证备注',
  `birthday` date default NULL COMMENT '生日',
  `sex` tinyint(3) unsigned NOT NULL default '0' COMMENT '性别',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_accounts`
--

DROP TABLE IF EXISTS `svcart_user_accounts`;
CREATE TABLE IF NOT EXISTS `svcart_user_accounts` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `user_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '用户ID',
  `user_note` varchar(255) NOT NULL COMMENT '用户注释',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `paid_time` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '支付时间',
  `admin_user` varchar(255) NOT NULL COMMENT '管理员名称',
  `admin_note` varchar(255) NOT NULL COMMENT '管理员注释',
  `process_type` char(1) NOT NULL default '0' COMMENT '处理方式',
  `payment` varchar(90) NOT NULL COMMENT '支付方式',
  `status` tinyint(1) NOT NULL default '0' COMMENT '状态',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户账单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_addresses`
--

DROP TABLE IF EXISTS `svcart_user_addresses`;
CREATE TABLE IF NOT EXISTS `svcart_user_addresses` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `name` varchar(50) NOT NULL default '' COMMENT '用户名称',
  `user_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '用户ID',
  `consignee` varchar(60) NOT NULL default '' COMMENT '真是姓名',
  `email` varchar(60) NOT NULL default '' COMMENT '电子邮箱',
  `address` varchar(120) NOT NULL default '' COMMENT '地址',
  `zipcode` varchar(60) NOT NULL default '' COMMENT '邮政编码',
  `telephone` varchar(60) NOT NULL default '' COMMENT '电话',
  `mobile` varchar(60) NOT NULL default '' COMMENT '手机',
  `sign_building` varchar(120) NOT NULL default '' COMMENT '标志性建筑',
  `best_time` varchar(120) NOT NULL default '' COMMENT '最佳送货时间',
  `regions` varchar(200) NOT NULL COMMENT '区域集',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户地址' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_balance_logs`
--

DROP TABLE IF EXISTS `svcart_user_balance_logs`;
CREATE TABLE IF NOT EXISTS `svcart_user_balance_logs` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `user_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '用户ID',
  `amount` decimal(10,2) NOT NULL COMMENT '金额',
  `admin_user` varchar(255) NOT NULL COMMENT '管理员名称',
  `admin_note` varchar(255) NOT NULL COMMENT '管理员注释',
  `system_note` varchar(255) NOT NULL COMMENT '系统注释',
  `log_type` char(1) NOT NULL default '0' COMMENT '日志类型[O:订单;B:充值;R:退款]',
  `type_id` varchar(90) NOT NULL COMMENT '关联编号',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户资金日志表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_configs`
--

DROP TABLE IF EXISTS `svcart_user_configs`;
CREATE TABLE IF NOT EXISTS `svcart_user_configs` (
  `id` smallint(5) unsigned NOT NULL auto_increment COMMENT 'ID',
  `user_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '用户ID',
  `user_rank` int(11) NOT NULL default '0' COMMENT '用户等级',
  `code` varchar(30) NOT NULL default '' COMMENT '***********************************************',
  `type` varchar(10) NOT NULL default '' COMMENT '类型',
  `value` varchar(200) NOT NULL COMMENT '参数值',
  `orderby` tinyint(3) unsigned NOT NULL default '50' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `user_rank` (`user_rank`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户参数' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_config_i18ns`
--

DROP TABLE IF EXISTS `svcart_user_config_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_user_config_i18ns` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `locale` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `user_config_id` int(11) NOT NULL COMMENT '用户参数号',
  `code` varchar(30) NOT NULL COMMENT '配置编号',
  `name` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT '配送名称',
  `description` text NOT NULL COMMENT '配送描述',
  `values` text NOT NULL COMMENT '可选值',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户参数描述多语言' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_favorites`
--

DROP TABLE IF EXISTS `svcart_user_favorites`;
CREATE TABLE IF NOT EXISTS `svcart_user_favorites` (
  `id` int(11) NOT NULL auto_increment COMMENT '收藏编号',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `type` char(2) collate utf8_unicode_ci NOT NULL COMMENT '收藏类型[商品(p)，商品分类(pc)，文章分类(ac)，品牌(b)，文章(a)]',
  `type_id` int(11) NOT NULL COMMENT '收藏id号',
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效 1:有效]',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`),
  KEY `type_2` (`type`,`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户收藏' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_friends`
--

DROP TABLE IF EXISTS `svcart_user_friends`;
CREATE TABLE IF NOT EXISTS `svcart_user_friends` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` mediumint(9) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `contact_name` varchar(20) collate utf8_unicode_ci NOT NULL,
  `contact_mobile` varchar(20) collate utf8_unicode_ci NOT NULL,
  `contact_email` varchar(100) collate utf8_unicode_ci NOT NULL,
  `contact_user_name` varchar(60) collate utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL default '0000-00-00',
  `birthday_wishes` varchar(200) collate utf8_unicode_ci NOT NULL,
  `remark` tinytext collate utf8_unicode_ci NOT NULL,
  `last_time` datetime NOT NULL,
  `address` varchar(220) collate utf8_unicode_ci NOT NULL,
  `Constellation` varchar(20) collate utf8_unicode_ci NOT NULL,
  `personality` varchar(50) collate utf8_unicode_ci NOT NULL,
  `sex` tinyint(1) unsigned NOT NULL,
  `contact_other_email` varchar(100) character set utf8 NOT NULL COMMENT '好友备用邮箱',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_friend_cats`
--

DROP TABLE IF EXISTS `svcart_user_friend_cats`;
CREATE TABLE IF NOT EXISTS `svcart_user_friend_cats` (
  `id` mediumint(9) NOT NULL auto_increment,
  `cat_name` varchar(100) collate utf8_unicode_ci NOT NULL,
  `cat_desc` varchar(200) collate utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_infos`
--

DROP TABLE IF EXISTS `svcart_user_infos`;
CREATE TABLE IF NOT EXISTS `svcart_user_infos` (
  `id` int(11) NOT NULL auto_increment COMMENT '项目编号',
  `type` varchar(20) collate utf8_unicode_ci NOT NULL,
  `status` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '状态[0:无效 1:有效]',
  `front` char(1) collate utf8_unicode_ci NOT NULL default '1' COMMENT '前台显示',
  `backend` char(1) collate utf8_unicode_ci NOT NULL default '0' COMMENT '后台显示',
  `orderby` smallint(4) NOT NULL default '50' COMMENT '排序',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户项目表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_info_i18ns`
--

DROP TABLE IF EXISTS `svcart_user_info_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_user_info_i18ns` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `user_info_id` int(11) NOT NULL COMMENT '项目编号',
  `name` varchar(100) collate utf8_unicode_ci NOT NULL COMMENT '名称',
  `values` text collate utf8_unicode_ci NOT NULL COMMENT '可选值',
  `message` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '提示信息',
  `remark` text collate utf8_unicode_ci NOT NULL COMMENT '备注',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale_2` (`locale`,`user_info_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户项目多语言表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_info_values`
--

DROP TABLE IF EXISTS `svcart_user_info_values`;
CREATE TABLE IF NOT EXISTS `svcart_user_info_values` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT '用户编号',
  `user_info_id` int(11) NOT NULL COMMENT '信息项目编号',
  `value` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '项目值',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id_2` (`user_id`,`user_info_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户信息表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_messages`
--

DROP TABLE IF EXISTS `svcart_user_messages`;
CREATE TABLE IF NOT EXISTS `svcart_user_messages` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `parent_id` mediumint(8) unsigned NOT NULL default '0',
  `user_id` mediumint(8) unsigned NOT NULL default '0',
  `user_name` varchar(60) NOT NULL default '',
  `user_email` varchar(60) NOT NULL default '',
  `msg_title` varchar(200) NOT NULL default '',
  `msg_type` tinyint(5) unsigned NOT NULL default '0' COMMENT '5.商家留言',
  `msg_content` text NOT NULL,
  `message_img` varchar(255) NOT NULL default '0',
  `order_id` int(11) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_point_logs`
--

DROP TABLE IF EXISTS `svcart_user_point_logs`;
CREATE TABLE IF NOT EXISTS `svcart_user_point_logs` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `user_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '用户ID',
  `point` int(11) NOT NULL COMMENT '金额',
  `admin_user` varchar(255) NOT NULL COMMENT '管理员名称',
  `admin_note` varchar(255) NOT NULL COMMENT '管理员注释',
  `system_note` varchar(255) NOT NULL COMMENT '系统注释',
  `log_type` char(1) NOT NULL default '0' COMMENT '日志类型[O:订单消费;B:订单获得;R:注册;C:退还]',
  `type_id` varchar(90) NOT NULL COMMENT '关联编号',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户积分日志表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_ranks`
--

DROP TABLE IF EXISTS `svcart_user_ranks`;
CREATE TABLE IF NOT EXISTS `svcart_user_ranks` (
  `id` tinyint(3) unsigned NOT NULL auto_increment COMMENT 'ID',
  `min_points` int(10) unsigned NOT NULL default '0' COMMENT '最小点数',
  `max_points` int(10) unsigned NOT NULL default '0' COMMENT '最大点数',
  `discount` tinyint(3) unsigned NOT NULL default '0' COMMENT '折扣',
  `show_price` tinyint(1) unsigned NOT NULL default '1' COMMENT '显示价格',
  `allow_buy` tinyint(1) NOT NULL default '1' COMMENT '有权购买',
  `special_rank` tinyint(1) unsigned NOT NULL default '0' COMMENT '特殊等级',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户等级表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_rank_i18ns`
--

DROP TABLE IF EXISTS `svcart_user_rank_i18ns`;
CREATE TABLE IF NOT EXISTS `svcart_user_rank_i18ns` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT 'ID',
  `locale` varchar(10) collate utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `user_rank_id` int(11) NOT NULL COMMENT '文章编号',
  `name` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '等级名称',
  `descrption` text collate utf8_unicode_ci NOT NULL COMMENT '等级描述',
  `img` varchar(200) collate utf8_unicode_ci NOT NULL COMMENT '等级图片',
  `created` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL default '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale_2` (`locale`,`user_rank_id`),
  KEY `locale` (`locale`),
  KEY `user_rank_id` (`user_rank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户等级多语言表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_virtual_cards`
--

DROP TABLE IF EXISTS `svcart_virtual_cards`;
CREATE TABLE IF NOT EXISTS `svcart_virtual_cards` (
  `id` int(11) NOT NULL auto_increment COMMENT '虚拟卡id',
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `card_sn` varchar(30) collate utf8_unicode_ci NOT NULL COMMENT '虚拟卡卡号',
  `card_password` varchar(30) collate utf8_unicode_ci NOT NULL COMMENT '虚拟卡密码',
  `end_date` datetime NOT NULL COMMENT '有效时间',
  `is_saled` int(1) NOT NULL COMMENT '是否已售出：0：否，1：是',
  `order_id` int(11) NOT NULL COMMENT '订单号',
  `crc32` int(11) NOT NULL COMMENT 'crc32后的key',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间，就是虚拟卡发送时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
