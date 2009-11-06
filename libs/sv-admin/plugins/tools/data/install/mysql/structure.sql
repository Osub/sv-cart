-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 11 月 04 日 02:38
-- 服务器版本: 5.1.33
-- PHP 版本: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `svcart_business_install`
--

-- --------------------------------------------------------

--
-- 表的结构 `svcart_advertisements`
--

DROP TABLE IF EXISTS `svcart_advertisements`;
CREATE TABLE `svcart_advertisements` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
  `advertisement_position_id` int(11) NOT NULL DEFAULT '0' COMMENT '0站外广告 从1开始代表的是该广告所处的广告位 同表svcart_advertisement_positions 中的字段id的值',
  `media_type` char(1) NOT NULL DEFAULT '0' COMMENT '广告类型，0，图片；1，flash;2,代码；3，文字',
  `contact_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '广告联系人',
  `contact_email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '广告联系人的邮箱',
  `contact_tele` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '广告联系人的电话',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `click_count` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `advertisement_position_id` (`advertisement_position_id`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_advertisement_i18ns`
--

DROP TABLE IF EXISTS `svcart_advertisement_i18ns`;
CREATE TABLE `svcart_advertisement_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `advertisement_id` int(11) NOT NULL DEFAULT '0' COMMENT '广告编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '该条广告记录的广告名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '广告描述',
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '广告链接地址',
  `url_type` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '链接类型：0直接连接，1间接链接',
  `start_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '广告开始时间',
  `end_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '广告结束时间',
  `code` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '广告链接的表现，文字广告就是文字或图片和flash就是它们的地址，代码广告就是代码内容',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`advertisement_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_advertisement_positions`
--

DROP TABLE IF EXISTS `svcart_advertisement_positions`;
CREATE TABLE `svcart_advertisement_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '广告位编号',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '广告位名称',
  `ad_width` smallint(5) NOT NULL DEFAULT '0' COMMENT '广告位宽度',
  `ad_height` smallint(5) NOT NULL DEFAULT '0' COMMENT '广告位高度',
  `position_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '广告位描述',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_affiliate_logs`
--

DROP TABLE IF EXISTS `svcart_affiliate_logs`;
CREATE TABLE `svcart_affiliate_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `user_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现金分成',
  `point` int(10) NOT NULL COMMENT '积分分成',
  `separate_type` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '分成类型 0：注册分成，1：订单分成',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='推荐分成日志';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_articles`
--

DROP TABLE IF EXISTS `svcart_articles`;
CREATE TABLE `svcart_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '主分类ID',
  `author_email` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '文章作者的email',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章类型',
  `file_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '外部链接',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0:无效;1:有效;2:删除',
  `front` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '首页显示 1:显示 0:不显示',
  `importance` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '文章重要性[0:普通;1:置顶;2:滚动显示;3:置顶且滚动显示]',
  `recommand` char(1) NOT NULL DEFAULT '0' COMMENT '是否推荐[0:否,1:是]',
  `comment` char(1) NOT NULL DEFAULT '0' COMMENT '是否可评论[0:否,1:是]',
  `clicked` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章被点击数',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `type` (`type`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_article_categories`
--

DROP TABLE IF EXISTS `svcart_article_categories`;
CREATE TABLE `svcart_article_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类编号',
  `article_id` int(11) NOT NULL DEFAULT '0' COMMENT '文章编号',
  `orderby` smallint(4) NOT NULL DEFAULT '500' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_article_i18ns`
--

DROP TABLE IF EXISTS `svcart_article_i18ns`;
CREATE TABLE `svcart_article_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `article_id` int(11) NOT NULL DEFAULT '0' COMMENT '文章编号 取文章article主表自增ID',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '文章题目',
  `meta_keywords` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '文章的关键字',
  `meta_description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '文章描述',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '文章内容',
  `author` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '文章作者',
  `img01` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片1',
  `img02` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片2',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`article_id`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `content` (`content`),
  FULLTEXT KEY `author` (`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_batches`
--

DROP TABLE IF EXISTS `svcart_batches`;
CREATE TABLE `svcart_batches` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `provider_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商ID',
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '批次号',
  `create_operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建人',
  `update_operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '更新人ID',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '描述',
  `param01` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性1',
  `param02` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性2',
  `param03` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性3',
  `param04` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性4',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1有效0无效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `provider_id` (`provider_id`),
  KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='批次';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_batch_products`
--

DROP TABLE IF EXISTS `svcart_batch_products`;
CREATE TABLE `svcart_batch_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `batch_id` int(11) NOT NULL DEFAULT '0' COMMENT '批号ID',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL DEFAULT '1' COMMENT '1有效0无效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `batch_id` (`batch_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='批次商品表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_booking_products`
--

DROP TABLE IF EXISTS `svcart_booking_products`;
CREATE TABLE `svcart_booking_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增Ｉｄ',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登记该缺货记录的用户的id存svcart_users用户表自增ID',
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '页面填的用户的email，默认取值于svcart_users的email',
  `contact_man` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '页面填的用户的姓名，默认取值于svcart_users的name',
  `telephone` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '页面填的用户的电话，默认取值于svcart_users的tel',
  `product_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '登记缺货的商品ID',
  `product_desc` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '缺货登记时留的订购描述',
  `product_number` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '订购数量',
  `booking_time` datetime DEFAULT NULL COMMENT '缺货登记的时间',
  `is_dispose` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否已经被处理',
  `dispose_operation_id` int(11) NOT NULL DEFAULT '0' COMMENT '处理操作员编号',
  `dispose_time` datetime DEFAULT NULL COMMENT '处理时间',
  `dispose_note` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '处理时管理员留的备注',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_brands`
--

DROP TABLE IF EXISTS `svcart_brands`;
CREATE TABLE `svcart_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '品牌编号',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `img01` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `img02` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片2',
  `flash_config` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'flash参数',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '品牌网址',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_brand_i18ns`
--

DROP TABLE IF EXISTS `svcart_brand_i18ns`;
CREATE TABLE `svcart_brand_i18ns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '品牌名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '品牌描述',
  `meta_keywords` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO品牌关键字',
  `meta_description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO品牌描述',
  `img01` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片1',
  `img02` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片2',
  `img03` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片3',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`brand_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_cards`
--

DROP TABLE IF EXISTS `svcart_cards`;
CREATE TABLE `svcart_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '贺卡编号',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `img01` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `img02` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片2',
  `fee` decimal(6,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '贺卡所需费用',
  `free_money` decimal(6,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单达到该字段的值后使用此贺卡免费',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_card_i18ns`
--

DROP TABLE IF EXISTS `svcart_card_i18ns`;
CREATE TABLE `svcart_card_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '贺卡多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `card_id` int(11) NOT NULL DEFAULT '0' COMMENT '贺卡编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '贺卡名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '贺卡描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`,`card_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_carts`
--

DROP TABLE IF EXISTS `svcart_carts`;
CREATE TABLE `svcart_carts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `session_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '进程编号',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户编号',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `product_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品代码',
  `product_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品名称',
  `product_price` float(12,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `product_quantity` smallint(6) NOT NULL DEFAULT '0' COMMENT '购买商品数量',
  `product_attrbute` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '商品属性',
  `extension_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'virtual_card：虚拟商品',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_categories`
--

DROP TABLE IF EXISTS `svcart_categories`;
CREATE TABLE `svcart_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类编号',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类编号(0是根目录)',
  `type` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'P' COMMENT '分类类型[A:文章,P:商品]',
  `sub_type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'G' COMMENT '系统参数',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0:无效;1:有效;2:删除',
  `new_show` char(1) NOT NULL DEFAULT '0' COMMENT '1显示0隐藏',
  `link` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '超级链接',
  `img01` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片1',
  `img01_link` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '分类图超链接01',
  `img02` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片2',
  `img02_link` varchar(200) DEFAULT NULL COMMENT '分类图超链接02',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`,`status`),
  KEY `parent_id_2` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_category_filters`
--

DROP TABLE IF EXISTS `svcart_category_filters`;
CREATE TABLE `svcart_category_filters` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类筛选',
  `category_id` int(11) NOT NULL COMMENT '分类ID',
  `product_attribute` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '商品属性',
  `filter_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '商品价格区间',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_category_i18ns`
--

DROP TABLE IF EXISTS `svcart_category_i18ns`;
CREATE TABLE `svcart_category_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `meta_keywords` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO分类关键字',
  `meta_description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO分类描述',
  `detail` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '分类详细',
  `img01` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片1',
  `img01_link` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'img01链接',
  `img02` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片2',
  `img02_link` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'img02链接',
  `img03` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图片3',
  `img03_link` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'img03链接',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_comments`
--

DROP TABLE IF EXISTS `svcart_comments`;
CREATE TABLE `svcart_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论编号',
  `type` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '评论类型[商品，分类，品牌，文章，商店]',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '类型编号',
  `email` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '评论时提交的email地址，默认取的users的email',
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '姓名',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `parent_id` mediumint(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复的评论ID',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '评论状态[0-不显示，1-显示，2-删除]',
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '内容',
  `rank` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '评论等级',
  `ipaddr` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'ip地址',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户编号',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `user_id` (`user_id`),
  KEY `type_id` (`type_id`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_configs`
--

DROP TABLE IF EXISTS `svcart_configs`;
CREATE TABLE `svcart_configs` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '参数ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号[0:系统]',
  `group_code` varchar(100) NOT NULL DEFAULT '' COMMENT '设置参数组',
  `code` varchar(60) NOT NULL DEFAULT '' COMMENT '参数名称',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT '参数类型',
  `section` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '版本标识',
  `orderby` int(4) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `type` (`type`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_config_i18ns`
--

DROP TABLE IF EXISTS `svcart_config_i18ns`;
CREATE TABLE `svcart_config_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '配置多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `config_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '配送名称',
  `value` text COMMENT '值',
  `options` text COMMENT '可选值',
  `description` text COMMENT '描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `locale_2` (`locale`,`config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_contacts`
--

DROP TABLE IF EXISTS `svcart_contacts`;
CREATE TABLE `svcart_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `company` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '公司名',
  `company_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '域名',
  `company_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '行业',
  `contact_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系人',
  `contact_type` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '联系的类型 0：电话 1：email',
  `is_send` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '需要我们结您邮寄样本',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '地址',
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Email地址',
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系电话',
  `qq` varchar(20) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'qq',
  `msn` varchar(20) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'msn',
  `skype` varchar(20) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'skype',
  `from` tinyint(3) NOT NULL COMMENT '您是如何获知我们的',
  `content` text COLLATE utf8_unicode_ci COMMENT '内容',
  `ip_address` varchar(15) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'ip地址',
  `browser` varchar(100) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '用户使用浏览器',
  `locale` varchar(20) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '语言',
  `resolution` varchar(100) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '分辨率',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_coupons`
--

DROP TABLE IF EXISTS `svcart_coupons`;
CREATE TABLE `svcart_coupons` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `coupon_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券类型编号',
  `sn_code` varchar(20) NOT NULL DEFAULT '0' COMMENT '优惠券类型使用码',
  `max_buy_quantity` int(11) NOT NULL DEFAULT '0' COMMENT '最大使用数',
  `max_use_quantity` int(11) NOT NULL DEFAULT '0' COMMENT '已使用数',
  `order_amount_discount` int(11) NOT NULL DEFAULT '100' COMMENT 'coupon 的红包折扣',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `used_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '使用时间',
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号',
  `emailed` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '邮件通知标志',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_coupon_types`
--

DROP TABLE IF EXISTS `svcart_coupon_types`;
CREATE TABLE `svcart_coupon_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '优惠券类型编号',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '发放金额',
  `send_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发放类型',
  `prefix` varchar(10) NOT NULL DEFAULT '' COMMENT '红包前缀',
  `min_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最小金额',
  `max_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最大金额',
  `min_products_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最低商品价钱',
  `send_start_date` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '发放开始时间',
  `send_end_date` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '发放结束时间',
  `use_start_date` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '使用开始时间',
  `use_end_date` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '使用结束时间',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `send_type` (`send_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_coupon_type_i18ns`
--

DROP TABLE IF EXISTS `svcart_coupon_type_i18ns`;
CREATE TABLE `svcart_coupon_type_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '优惠券多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `coupon_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券类型编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '优惠券名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`coupon_type_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_currencies`
--

DROP TABLE IF EXISTS `svcart_currencies`;
CREATE TABLE `svcart_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '货币代码',
  `rate` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '比率',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0:无效1：有效',
  `is_default` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否默认',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='货币管理';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_currency_i18ns`
--

DROP TABLE IF EXISTS `svcart_currency_i18ns`;
CREATE TABLE `svcart_currency_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `currency_id` int(11) NOT NULL COMMENT '货币ID',
  `locale` varchar(10) CHARACTER SET latin1 NOT NULL COMMENT '语言编码',
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `format` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '货币格式',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '0：无效 1：有效',
  `created` datetime NOT NULL COMMENT '创建时间',
  `modified` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `currency_id` (`currency_id`,`locale`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='多货币多语言表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_departments`
--

DROP TABLE IF EXISTS `svcart_departments`;
CREATE TABLE `svcart_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '部门编号',
  `contact_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系人',
  `contact_email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Email地址',
  `contact_tele` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系电话',
  `contact_mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系人手机',
  `contact_fax` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系传真',
  `contact_remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '联系备注',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_department_i18ns`
--

DROP TABLE IF EXISTS `svcart_department_i18ns`;
CREATE TABLE `svcart_department_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `department_id` int(11) NOT NULL DEFAULT '0' COMMENT '部门编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '部门名称',
  `description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '部门描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`department_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_domains`
--

DROP TABLE IF EXISTS `svcart_domains`;
CREATE TABLE `svcart_domains` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `locale` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '对应语言',
  `domain` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '域名',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态（0:有效，1:无效）',
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '注释',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='域名表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_flashes`
--

DROP TABLE IF EXISTS `svcart_flashes`;
CREATE TABLE `svcart_flashes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '类型[H:首页;PC:分类;B:品牌;AC:文章分类]',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT 'image类型ID',
  `roundcorner` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '圆角',
  `autoplaytime` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '自动播放时间',
  `isheightquality` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '高品质',
  `blendmode` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '混合模式',
  `transduration` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '跨期',
  `windowopen` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '窗口打开',
  `btnsetmargin` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'btnsetmargin',
  `btndistance` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '距离',
  `titlebgcolor` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '标题颜色',
  `titletextcolor` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '标题文本颜色',
  `titlebgalpha` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '标题透明度',
  `titlemoveduration` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '标题移动时间',
  `btnalpha` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '按钮透明度',
  `btntextcolor` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '按钮文本颜色',
  `btndefaultcolor` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '按钮默认颜色',
  `btnhovercolor` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '按钮悬停颜色',
  `btnfocuscolor` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '按钮重点颜色',
  `changimagemode` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '图像模式',
  `isshowbtn` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '显示按钮',
  `isshowtitle` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '显示标题',
  `scalemode` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '缩放模式',
  `transform` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '变换',
  `isshowabout` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否显示关于',
  `titlefont` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '标题字体',
  `height` int(11) NOT NULL DEFAULT '314' COMMENT '长',
  `width` int(11) NOT NULL DEFAULT '741' COMMENT '宽',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_2` (`type`,`type_id`),
  KEY `type` (`type`,`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_flash_images`
--

DROP TABLE IF EXISTS `svcart_flash_images`;
CREATE TABLE `svcart_flash_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言代码',
  `flash_id` int(10) NOT NULL DEFAULT '0' COMMENT 'svcart_flashes表ＩＤ',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题文字',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '描述',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `locale` (`locale`),
  KEY `flash_id` (`flash_id`),
  KEY `locale_2` (`locale`,`flash_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_inbounds`
--

DROP TABLE IF EXISTS `svcart_inbounds`;
CREATE TABLE `svcart_inbounds` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `warehouses_id` int(11) NOT NULL DEFAULT '0' COMMENT '仓库ID',
  `provider_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商ID',
  `batch_id` int(11) NOT NULL DEFAULT '0' COMMENT '批号ID',
  `created_operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作员ID',
  `update_operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '修改人',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `product_type` int(11) NOT NULL DEFAULT '0' COMMENT '商品种类',
  `inbound_type` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '进库类型',
  `remark` text COLLATE utf8_unicode_ci COMMENT '备注',
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '原因',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1有效0无效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='进库日志';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_inbound_products`
--

DROP TABLE IF EXISTS `svcart_inbound_products`;
CREATE TABLE `svcart_inbound_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `inbound_id` int(11) NOT NULL DEFAULT '0' COMMENT '进库ID',
  `batch_id` int(11) NOT NULL DEFAULT '0' COMMENT '批次ID',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `purchase_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '进货价',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '进库数量',
  `remark` text COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `param01` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性1',
  `param02` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性2',
  `param03` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性3',
  `param04` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性4',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `inbound_id` (`inbound_id`),
  KEY `product_id` (`product_id`),
  KEY `batch_id` (`batch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='进库商品明细表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_information_resources`
--

DROP TABLE IF EXISTS `svcart_information_resources`;
CREATE TABLE `svcart_information_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '资源ID',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '资源上级ID',
  `code` varchar(60) NOT NULL DEFAULT '' COMMENT '资源代码',
  `information_value` varchar(30) DEFAULT NULL COMMENT '资源代码的值',
  `status` char(1) DEFAULT '1' COMMENT '状态0:无效1:有效',
  `orderby` tinyint(3) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_information_resource_i18ns`
--

DROP TABLE IF EXISTS `svcart_information_resource_i18ns`;
CREATE TABLE `svcart_information_resource_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '资源多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `information_resource_id` int(11) NOT NULL DEFAULT '0' COMMENT '资源编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '资源名称',
  `description` text NOT NULL COMMENT '描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`information_resource_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_invoice_types`
--

DROP TABLE IF EXISTS `svcart_invoice_types`;
CREATE TABLE `svcart_invoice_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tax_point` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '发票税点',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_invoice_type_i18ns`
--

DROP TABLE IF EXISTS `svcart_invoice_type_i18ns`;
CREATE TABLE `svcart_invoice_type_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `invoice_type_id` int(11) NOT NULL COMMENT '类型ID',
  `locale` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '语言',
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `direction` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '发票说明',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `invoice_type_id` (`invoice_type_id`,`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_languages`
--

DROP TABLE IF EXISTS `svcart_languages`;
CREATE TABLE `svcart_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言代码',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言',
  `charset` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字符集',
  `map` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '系统映射',
  `img01` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片01',
  `img02` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片02',
  `front` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '前台显示',
  `backend` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '后台显示',
  `is_default` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '1为默认',
  `google_translate_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'google 翻译接口',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `front` (`front`),
  KEY `backend` (`backend`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_language_dictionaries`
--

DROP TABLE IF EXISTS `svcart_language_dictionaries`;
CREATE TABLE `svcart_language_dictionaries` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言代码',
  `location` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'front' COMMENT '前后台参数区分',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '类型',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '描述',
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '内容',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_links`
--

DROP TABLE IF EXISTS `svcart_links`;
CREATE TABLE `svcart_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '友情链接编号',
  `contact_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系人',
  `contact_email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Email地址',
  `contact_tele` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系电话',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_link_i18ns`
--

DROP TABLE IF EXISTS `svcart_link_i18ns`;
CREATE TABLE `svcart_link_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '友情链接编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `link_id` int(11) NOT NULL DEFAULT '0' COMMENT '友情链接编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '友情链接名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '友情链接描述',
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '友情链接地址',
  `click_stat` int(11) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `img01` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
  `img02` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片2',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`link_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_mail_send_histories`
--

DROP TABLE IF EXISTS `svcart_mail_send_histories`;
CREATE TABLE `svcart_mail_send_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `sender_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '发送人姓名',
  `receiver_email` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '接收人地址',
  `cc_email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '抄送地址',
  `bcc_email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '暗送人地址',
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '主题',
  `html_body` text COLLATE utf8_unicode_ci COMMENT '邮件内容',
  `text_body` text COLLATE utf8_unicode_ci COMMENT '邮件内容',
  `sendas` char(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text' COMMENT 'html,text',
  `flag` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '1.发送成功，0.发送失败',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='邮件发送队列表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_mail_send_queues`
--

DROP TABLE IF EXISTS `svcart_mail_send_queues`;
CREATE TABLE `svcart_mail_send_queues` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `sender_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '发送人姓名',
  `receiver_email` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '接收人地址',
  `cc_email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '抄送地址',
  `bcc_email` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '暗送人地址',
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '主题',
  `html_body` text COLLATE utf8_unicode_ci COMMENT '邮件内容',
  `text_body` text COLLATE utf8_unicode_ci COMMENT '邮件内容',
  `sendas` char(4) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text' COMMENT 'html,text',
  `flag` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0.未发送 1234.发送失败生发超过5删除',
  `pri` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '优先级 0 普通， 1 高 ',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='邮件发送队列表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_mail_templates`
--

DROP TABLE IF EXISTS `svcart_mail_templates`;
CREATE TABLE `svcart_mail_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '邮件模板编号',
  `code` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '编号',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `last_send` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '最后发送时间',
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '模板类型',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_mail_template_i18ns`
--

DROP TABLE IF EXISTS `svcart_mail_template_i18ns`;
CREATE TABLE `svcart_mail_template_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '邮件模板多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `mail_template_id` int(11) NOT NULL DEFAULT '0' COMMENT '邮件模板编号',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '邮件模板名称',
  `description` varchar(255) DEFAULT NULL COMMENT '模板说明',
  `text_body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '邮件模板text模板',
  `html_body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '邮件模板HTML模板',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`mail_template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_navigations`
--

DROP TABLE IF EXISTS `svcart_navigations`;
CREATE TABLE `svcart_navigations` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '导航编号',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级导航',
  `type` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '导航类型[H;T;M;B...]',
  `orderby` tinyint(4) NOT NULL DEFAULT '10' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `icon` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略图',
  `target` enum('_self','_blank') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '_self' COMMENT '打开位置',
  `controller` enum('pages','categories','brands','products','articles','cars') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pages' COMMENT '系统内容',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_navigation_i18ns`
--

DROP TABLE IF EXISTS `svcart_navigation_i18ns`;
CREATE TABLE `svcart_navigation_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '导航多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `navigation_id` mediumint(9) NOT NULL DEFAULT '0' COMMENT '导航编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '导航栏名称',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'URL链接',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`navigation_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_newsletter_lists`
--

DROP TABLE IF EXISTS `svcart_newsletter_lists`;
CREATE TABLE `svcart_newsletter_lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '邮件订阅编号',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '邮件地址',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operators`
--

DROP TABLE IF EXISTS `svcart_operators`;
CREATE TABLE `svcart_operators` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员名称',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员密码',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员邮件',
  `mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员手机',
  `department_id` int(10) NOT NULL DEFAULT '0' COMMENT '部门ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号[0:系统管理员]',
  `role_id` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '角色编号',
  `actions` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '功能权限',
  `default_lang` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'zh_cn' COMMENT '管理员默认语言',
  `desktop` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '桌面设置',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '状态[0:无效;1:有效;2:冻结]',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登入时间',
  `last_login_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '最后登入IP',
  `time_zone` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '-8' COMMENT '时区',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `store_id` (`store_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_actions`
--

DROP TABLE IF EXISTS `svcart_operator_actions`;
CREATE TABLE `svcart_operator_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '功能编号',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '功能等级',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父编号',
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '代码',
  `section` varchar(20) DEFAULT NULL COMMENT '版本标识',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '状态[0:无效 1:有效]',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `level` (`level`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_action_i18ns`
--

DROP TABLE IF EXISTS `svcart_operator_action_i18ns`;
CREATE TABLE `svcart_operator_action_i18ns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `operator_action_id` int(11) NOT NULL DEFAULT '0' COMMENT '功能编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '功能名称',
  `operator_action_values` varchar(500) NOT NULL COMMENT '值',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '功能描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时\r\n\r\n\r\n\r\n间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时\r\n\r\n\r\n\r\n间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`operator_action_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_logs`
--

DROP TABLE IF EXISTS `svcart_operator_logs`;
CREATE TABLE `svcart_operator_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志编号',
  `operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员编号',
  `ipaddress` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'IP地址',
  `action_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '访问地址',
  `info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '备注',
  `remark` text COMMENT '存放post和get的参数',
  `type` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '类型',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `admin_id` (`operator_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_menus`
--

DROP TABLE IF EXISTS `svcart_operator_menus`;
CREATE TABLE `svcart_operator_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '菜单编号',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级菜单编号',
  `operator_action_code` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '权限代码',
  `type` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '类型',
  `link` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '连接地址',
  `section` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '版本标识',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_menu_i18ns`
--

DROP TABLE IF EXISTS `svcart_operator_menu_i18ns`;
CREATE TABLE `svcart_operator_menu_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '菜单多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `operator_menu_id` int(11) NOT NULL DEFAULT '0' COMMENT '菜单编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`operator_menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_roles`
--

DROP TABLE IF EXISTS `svcart_operator_roles`;
CREATE TABLE `svcart_operator_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理员角色编号',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号',
  `actions` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '功能权限',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '状态[0:无效;1:有效;2:冻结]',
  `orderby` smallint(4) NOT NULL DEFAULT '500' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_operator_role_i18ns`
--

DROP TABLE IF EXISTS `svcart_operator_role_i18ns`;
CREATE TABLE `svcart_operator_role_i18ns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `operator_role_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员角色编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `locale_2` (`locale`,`operator_role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_orders`
--

DROP TABLE IF EXISTS `svcart_orders`;
CREATE TABLE `svcart_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详细信息自增id',
  `order_code` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '订单号，唯一',
  `order_locale` varchar(10) NOT NULL DEFAULT ' ' COMMENT '订单语言',
  `order_currency` varchar(10) NOT NULL DEFAULT ' ' COMMENT '订单货币',
  `order_domain` varchar(255) NOT NULL DEFAULT ' ' COMMENT '订单来源域名',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id，同users表的id',
  `operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作员ID(处理operator表 的ID)',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '订单状态。0，未确认；1，已确认；2，已取消；3，无效；4，退货；',
  `shipping_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户选择的配送方式id，取值表svcart_shipping',
  `shipping_name` varchar(120) NOT NULL COMMENT '用户选择的配送方式的名称，取值表svcart_shipping',
  `shipping_status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '商品配送情况，0，未发货；1，已发货；2，已收货；3，备货中',
  `shipping_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '配送时间',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '配送时间',
  `point_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分费用',
  `point_use` int(11) NOT NULL DEFAULT '0' COMMENT '积分数',
  `payment_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户选择的支付方式的id，取值表svcart_payment',
  `payment_name` varchar(120) NOT NULL COMMENT '用户选择的支付方式的名称，取值表svcart_payment',
  `payment_status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '支付状态；0，未付款；1，付款中；2，已付款',
  `payment_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '支付时间',
  `payment_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支付费用,跟支付方式的配置相关，取值表svcart_payment',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '红包ID',
  `consignee` varchar(60) NOT NULL COMMENT '收货人的姓名，用户页面填写，默认取值于表user_address',
  `address` varchar(255) NOT NULL COMMENT '收货人的详细地址，用户页面填写，默认取值于表user_address',
  `zipcode` varchar(60) NOT NULL COMMENT '收货人的邮编，用户页面填写，默认取值于表user_address',
  `telephone` varchar(60) NOT NULL COMMENT '收货人的电话，用户页面填写，默认取值于表user_address',
  `mobile` varchar(60) NOT NULL COMMENT '收货人的手机，用户页面填写，默认取值于表user_address',
  `email` varchar(60) NOT NULL COMMENT '收货人的email，用户页面填写，默认取值于表user_address',
  `best_time` varchar(120) NOT NULL COMMENT '收货人的最佳送货时间，用户页面填写，默认取值于表user_address',
  `sign_building` varchar(120) NOT NULL COMMENT '收货人的地址的标志性建筑，用户页面填写，默认取值于表user_address',
  `postscript` varchar(255) NOT NULL COMMENT '订单附言，由用户提交订单前填写',
  `invoice_no` varchar(50) NOT NULL COMMENT '发货单号，发货时填写，可在订单查询查看',
  `note` varchar(255) NOT NULL COMMENT '备注',
  `money_paid` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已付款金额',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '折扣',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总计',
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总金额',
  `from_ad` smallint(5) NOT NULL DEFAULT '0' COMMENT '广告来源',
  `referer` varchar(255) NOT NULL COMMENT '网站来源',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '发票税额',
  `is_separate` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0，未分成或等待分成；1，已分成；2，取消分成；',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '能获得分成的用户ID',
  `insure_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '保价费用',
  `pack_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '包装费用，取值表取值表svcart_packages',
  `card_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '贺卡费用，取值svcart_cards',
  `invoice_type` varchar(60) NOT NULL COMMENT '发票类型，用户页面选择，',
  `invoice_payee` varchar(120) NOT NULL COMMENT '发票抬头，用户页面填写',
  `invoice_content` varchar(120) NOT NULL COMMENT '发票内容',
  `how_oos` varchar(120) NOT NULL COMMENT '缺货处理方式，等待所有商品备齐后再发； 取消订单；与店主协商',
  `pack_name` varchar(120) NOT NULL DEFAULT '' COMMENT '包装',
  `card_name` varchar(120) NOT NULL COMMENT '贺卡的名称，取值svcart_cards',
  `card_message` varchar(255) NOT NULL COMMENT '贺卡内容，由用户提交',
  `to_buyer` varchar(255) NOT NULL COMMENT '商家给客户的留言,当该字段有值时可以在订单查询看到',
  `confirm_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '订单确认时间',
  `regions` varchar(200) NOT NULL DEFAULT '' COMMENT '区域集',
  `union_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '网站联盟用户ID',
  `express_status` char(1) NOT NULL DEFAULT '0' COMMENT '0;未打印1：已打印',
  `express_date` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '打印时间',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_code` (`order_code`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`,`shipping_status`,`payment_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_order_actions`
--

DROP TABLE IF EXISTS `svcart_order_actions`;
CREATE TABLE `svcart_order_actions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被操作的交易号svcart_orders的ＩＤ',
  `from_operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作员编号',
  `to_operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '指派给',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员编号',
  `order_status` char(1) NOT NULL DEFAULT '0' COMMENT '作何操作.0，未确认；1，已确认；2，已取消；3，无效；4，退货；',
  `shipping_status` char(1) NOT NULL DEFAULT '0' COMMENT '发货状态。0，未发货；1，已发货；2，已收货；3，备货中',
  `payment_status` char(1) NOT NULL DEFAULT '0' COMMENT '支付状态.0,未付款;1,付款中;2,已付款;',
  `action_note` text NOT NULL COMMENT '操作备注',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_order_cards`
--

DROP TABLE IF EXISTS `svcart_order_cards`;
CREATE TABLE `svcart_order_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `card_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '贺卡ID',
  `card_name` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '贺卡名称',
  `card_quntity` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '贺卡数量',
  `card_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '贺卡价格',
  `note` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[单独商品发货用]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `card_id` (`card_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_order_packagings`
--

DROP TABLE IF EXISTS `svcart_order_packagings`;
CREATE TABLE `svcart_order_packagings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `packaging_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '包装ID',
  `packaging_name` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '包装名称',
  `packaging_quntity` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '包装数量',
  `packaging_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '包装价格',
  `note` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[单独商品发货用]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `packaging_id` (`packaging_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_order_products`
--

DROP TABLE IF EXISTS `svcart_order_products`;
CREATE TABLE `svcart_order_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单商品信息自增id',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单商品信息对应的详细信息id，取值svcart_orders的order_id',
  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品的的id，取值表svcart_products 的id',
  `product_name` varchar(120) NOT NULL COMMENT '商品的名称，取值表svcart_products ',
  `product_code` varchar(60) NOT NULL COMMENT '商品的唯一货号，取值svcart_products ',
  `product_quntity` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '商品的购买数量',
  `product_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品的本店售价，取值svcart_products',
  `product_attrbute` text COMMENT '购买该商品时所选择的属性',
  `product_weight` decimal(10,3) NOT NULL COMMENT '商品重量',
  `note` varchar(200) NOT NULL COMMENT '备注',
  `delivery_note` varchar(255) DEFAULT NULL COMMENT '发货备注',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态[单独商品发货用]',
  `extension_code` varchar(20) NOT NULL COMMENT '商品的扩展属性，比如像虚拟卡。取值svcart_products',
  `send_quntity` int(11) NOT NULL DEFAULT '0' COMMENT '虚拟卡已发送数量虚拟卡已发送数量',
  `provider_send_quantity` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '供应商发货数量',
  `provider_return_quantity` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '供应商退货数量',
  `provider_send_modified` datetime DEFAULT NULL COMMENT '供应商发货修改时间',
  `provider_return_modified` datetime DEFAULT NULL COMMENT '供应商退货修改时间',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_outbounds`
--

DROP TABLE IF EXISTS `svcart_outbounds`;
CREATE TABLE `svcart_outbounds` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `warehouses_id` int(11) NOT NULL DEFAULT '0' COMMENT '仓库ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺号',
  `provider_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商ID',
  `batch_id` int(11) NOT NULL DEFAULT '0' COMMENT '批次ID',
  `created_operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作员ID',
  `update_operator_id` int(11) NOT NULL DEFAULT '0' COMMENT '修改人',
  `stock_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '进货价',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `product_type` int(11) NOT NULL DEFAULT '0' COMMENT '商品种类',
  `outbound_type` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '出库类型 ',
  `remark` text COLLATE utf8_unicode_ci COMMENT '备注',
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '原因',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1有效0无效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='出库日志';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_outbound_products`
--

DROP TABLE IF EXISTS `svcart_outbound_products`;
CREATE TABLE `svcart_outbound_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `batch_sn` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '批次号',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺号',
  `outbound_id` int(11) NOT NULL DEFAULT '0' COMMENT '出库ID',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `purchase_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '进货价',
  `product_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '出库价',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '出库数量',
  `remark` text COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '出库原因',
  `sales_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '销售类型',
  `sku` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '货号SKU',
  `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `param01` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性1',
  `param02` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性2',
  `param03` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性3',
  `param04` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性4',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='出库商品明细表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_packagings`
--

DROP TABLE IF EXISTS `svcart_packagings`;
CREATE TABLE `svcart_packagings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '包装编号',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `img01` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '包装图纸',
  `img02` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '包装图纸2',
  `fee` decimal(6,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '包装的费用',
  `free_money` decimal(6,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单达到此金额可以免除该包装费用',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_packaging_i18ns`
--

DROP TABLE IF EXISTS `svcart_packaging_i18ns`;
CREATE TABLE `svcart_packaging_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '包装多语言编号自增id',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `packaging_id` int(11) NOT NULL DEFAULT '0' COMMENT '包装编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '包装名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '包装描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`packaging_id`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_payments`
--

DROP TABLE IF EXISTS `svcart_payments`;
CREATE TABLE `svcart_payments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '已安装的支付方式自增id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号',
  `code` varchar(20) NOT NULL COMMENT '支付方式的英文缩写，其实就是该支付方式处理插件的不带后缀的文件名部分',
  `fee` varchar(10) NOT NULL DEFAULT '0' COMMENT '支付费用',
  `orderby` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式在页面的显示顺序',
  `config` text COMMENT '支付方式的配置信息，包括商户号和密钥什么的',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '是否可用，0，否；1，是',
  `is_cod` char(1) NOT NULL DEFAULT '0' COMMENT '是否货到付款，0，否；1，是',
  `is_online` char(1) NOT NULL DEFAULT '0' COMMENT '是否在线支付，0，否；1，是',
  `supply_use_flag` char(1) NOT NULL DEFAULT '1' COMMENT '充值可用标志',
  `order_use_flag` char(1) NOT NULL DEFAULT '1' COMMENT '订单可用标志',
  `php_code` text COMMENT '接口代码',
  `version` varchar(40) NOT NULL DEFAULT '' COMMENT '插件版本',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_payment_api_logs`
--

DROP TABLE IF EXISTS `svcart_payment_api_logs`;
CREATE TABLE `svcart_payment_api_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '支付记录自增id',
  `payment_code` varchar(100) NOT NULL COMMENT '支付代码',
  `type` char(1) NOT NULL DEFAULT '0' COMMENT '支付类型(购买/充值)',
  `type_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单编号',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `is_paid` char(1) NOT NULL DEFAULT '0' COMMENT '是否已支付，0，否；1，是',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `payment_code` (`payment_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_payment_i18ns`
--

DROP TABLE IF EXISTS `svcart_payment_i18ns`;
CREATE TABLE `svcart_payment_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '支付方式多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `payment_id` int(11) NOT NULL DEFAULT '0' COMMENT '支付编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '支付方式名称',
  `payment_values` varchar(500) NOT NULL COMMENT '值',
  `description` varchar(255) DEFAULT NULL COMMENT '支付方式描述',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态[0:无效 1:有效]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时\r\n\r\n间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时\r\n\r\n间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`payment_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_plugins`
--

DROP TABLE IF EXISTS `svcart_plugins`;
CREATE TABLE `svcart_plugins` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '插件id',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '插件名称',
  `directory` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '插件描述',
  `copyright` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '版权信息',
  `author` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '作者',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '作者地址',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '插件排序',
  `version` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '插件版本',
  `code` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '参数',
  `contents` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '插件相关目录',
  `app_contents` text COMMENT '插件app文件夹名称',
  `install` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '插件安装',
  `uninstall` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '插件卸载',
  `function` varchar(255) DEFAULT NULL COMMENT '插件要调用的函数',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否有效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_prodcut_volumes`
--

DROP TABLE IF EXISTS `svcart_prodcut_volumes`;
CREATE TABLE `svcart_prodcut_volumes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品数量优惠ID',
  `product_id` int(11) NOT NULL COMMENT '分类ID',
  `volume_number` int(11) NOT NULL COMMENT '购买数量',
  `volume_price` decimal(10,2) NOT NULL COMMENT '商品优惠价',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_products`
--

DROP TABLE IF EXISTS `svcart_products`;
CREATE TABLE `svcart_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品编号',
  `coupon_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券关联',
  `brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌编号',
  `provider_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商编号',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类ID',
  `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '分类编号',
  `style_code` varchar(20) DEFAULT NULL COMMENT '款号',
  `is_colors_gallery` char(1) NOT NULL DEFAULT '0' COMMENT '是否显示相同款号下的颜色图片',
  `product_name_style` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '+' COMMENT '商品名称样式',
  `img_thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略图',
  `img_detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '详细图',
  `img_original` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '原图',
  `colors_gallery` varchar(255) DEFAULT NULL COMMENT '款号颜色图',
  `recommand_flag` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '推荐标志位',
  `min_buy` int(11) NOT NULL DEFAULT '1' COMMENT '最小购买数',
  `max_buy` int(11) NOT NULL DEFAULT '100' COMMENT '最大购买数',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '添加管理员',
  `alone` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效 1:有效]',
  `forsale` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效 1:有效]',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效 1:有效 2:进回收站]',
  `bestbefore` char(1) NOT NULL DEFAULT '0' COMMENT '过往精品',
  `weight` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '商品重量',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '本店价',
  `promotion_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价',
  `purchase_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '进货价',
  `promotion_start` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '促销开始时间',
  `promotion_end` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '促销结束时间',
  `promotion_status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '促销标志[0:无效;1:有效;2:自动]',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '赠送积分数',
  `point_fee` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '积分购买额度',
  `view_stat` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `sale_stat` int(11) NOT NULL DEFAULT '0' COMMENT '销售次数',
  `product_type_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型',
  `product_rank_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品会员价',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `warn_quantity` int(11) NOT NULL DEFAULT '0' COMMENT '商品报警数量',
  `frozen_quantity` int(11) NOT NULL DEFAULT '0' COMMENT '冻结库存',
  `extension_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'virtual_card：虚拟商品',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_2` (`code`),
  KEY `brand_id` (`brand_id`),
  KEY `provider_id` (`provider_id`),
  KEY `recommand_flag` (`recommand_flag`),
  KEY `status` (`status`),
  KEY `forsale` (`forsale`),
  KEY `category_id` (`category_id`),
  FULLTEXT KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_products_categories`
--

DROP TABLE IF EXISTS `svcart_products_categories`;
CREATE TABLE `svcart_products_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增长编号',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '类型编号',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`category_id`,`product_id`),
  KEY `category_id` (`category_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_alsoboughts`
--

DROP TABLE IF EXISTS `svcart_product_alsoboughts`;
CREATE TABLE `svcart_product_alsoboughts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `alsobought_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '其他购买的商品ID',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户购买商品关联表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_articles`
--

DROP TABLE IF EXISTS `svcart_product_articles`;
CREATE TABLE `svcart_product_articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `article_id` int(11) NOT NULL DEFAULT '0' COMMENT '文章编号',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `is_double` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否是双向关联',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_attributes`
--

DROP TABLE IF EXISTS `svcart_product_attributes`;
CREATE TABLE `svcart_product_attributes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `product_type_attribute_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '属性ID',
  `product_type_attribute_value` text COMMENT '属性值',
  `product_type_attribute_price` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '属性价格',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`product_id`),
  KEY `attr_id` (`product_type_attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_downloads`
--

DROP TABLE IF EXISTS `svcart_product_downloads`;
CREATE TABLE `svcart_product_downloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `start_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '开始时间',
  `end_time` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '结束时间',
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '开启状态',
  `url` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '连接地址',
  `download_count` int(11) NOT NULL DEFAULT '0' COMMENT '下载总数',
  `allow_downloadtimes` int(11) NOT NULL COMMENT '允许下载次数',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_download_logs`
--

DROP TABLE IF EXISTS `svcart_product_download_logs`;
CREATE TABLE `svcart_product_download_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单号',
  `download_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0' COMMENT '用户ip',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_galleries`
--

DROP TABLE IF EXISTS `svcart_product_galleries`;
CREATE TABLE `svcart_product_galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片编号',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `img_thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略图',
  `img_detail` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '详细图',
  `img_original` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '原始图',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_gallery_i18ns`
--

DROP TABLE IF EXISTS `svcart_product_gallery_i18ns`;
CREATE TABLE `svcart_product_gallery_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品相册多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `product_gallery_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品相册编号',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '商品相册描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`product_gallery_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_i18ns`
--

DROP TABLE IF EXISTS `svcart_product_i18ns`;
CREATE TABLE `svcart_product_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品名称',
  `style_name` varchar(30) DEFAULT NULL COMMENT '款号名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '详细描述',
  `seller_note` varchar(255) DEFAULT NULL COMMENT '商家备注',
  `delivery_note` varchar(255) DEFAULT NULL COMMENT '发货备注',
  `market_price` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `shop_price` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '本店价',
  `meta_keywords` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO关键字',
  `meta_description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO描述',
  `api_site_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品网站网址',
  `api_cart_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '购物车快捷网址',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`product_id`),
  KEY `locale` (`locale`),
  FULLTEXT KEY `name` (`name`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_locale_prices`
--

DROP TABLE IF EXISTS `svcart_product_locale_prices`;
CREATE TABLE `svcart_product_locale_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '语言',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否有效0:无效,1:有效',
  `product_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价',
  `param01` varchar(255) NOT NULL DEFAULT '0' COMMENT '属性1',
  `param02` varchar(255) NOT NULL DEFAULT '0' COMMENT '属性2',
  `param03` varchar(255) NOT NULL DEFAULT '0' COMMENT '属性3',
  `param04` varchar(255) NOT NULL DEFAULT '0' COMMENT '属性4',
  `param05` varchar(255) NOT NULL DEFAULT '0' COMMENT '属性5',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id` (`product_id`,`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_ranks`
--

DROP TABLE IF EXISTS `svcart_product_ranks`;
CREATE TABLE `svcart_product_ranks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `rank_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员等级ID',
  `is_default_rank` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否使用会员初始的比例 0:禁用 1:使用',
  `product_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品会员价',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `rank_id` (`rank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_relations`
--

DROP TABLE IF EXISTS `svcart_product_relations`;
CREATE TABLE `svcart_product_relations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `related_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '相关商品编号',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `is_double` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否是双向关联',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_services`
--

DROP TABLE IF EXISTS `svcart_product_services`;
CREATE TABLE `svcart_product_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '开启状态',
  `url` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '连接地址',
  `service_cycle` int(11) NOT NULL COMMENT '服务期限 （天）',
  `view_count` int(11) NOT NULL DEFAULT '0' COMMENT '观看总数',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_service_logs`
--

DROP TABLE IF EXISTS `svcart_product_service_logs`;
CREATE TABLE `svcart_product_service_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `product_id` int(11) NOT NULL COMMENT '商品ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `order_id` int(11) NOT NULL COMMENT '订单号',
  `user_ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '用户ip',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_shipping_fees`
--

DROP TABLE IF EXISTS `svcart_product_shipping_fees`;
CREATE TABLE `svcart_product_shipping_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '语言',
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `shipping_id` int(11) NOT NULL COMMENT '配送方式id',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '是否有效0:无效,1:有效',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_types`
--

DROP TABLE IF EXISTS `svcart_product_types`;
CREATE TABLE `svcart_product_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类编号',
  `code` varchar(30) NOT NULL COMMENT '编码',
  `group_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分组',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0:无效;1:有效;2:删除',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `cat_id` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_type_attributes`
--

DROP TABLE IF EXISTS `svcart_product_type_attributes`;
CREATE TABLE `svcart_product_type_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '属性编号',
  `code` varchar(30) NOT NULL COMMENT '编码',
  `type` varchar(30) NOT NULL DEFAULT 'basic' COMMENT '属性类型',
  `product_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品类型编号',
  `attr_value` text COMMENT '属性值',
  `default_value` varchar(100) DEFAULT NULL COMMENT '默认值',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0:无效;1:有效;2:删除',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `attr_input_type` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '属性输入类型',
  `attr_type` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '属性是否可选',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `cat_id` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_type_attribute_i18ns`
--

DROP TABLE IF EXISTS `svcart_product_type_attribute_i18ns`;
CREATE TABLE `svcart_product_type_attribute_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '属性多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `product_type_attribute_id` int(11) NOT NULL DEFAULT '0' COMMENT '属性编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '属性名称',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`product_type_attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_product_type_i18ns`
--

DROP TABLE IF EXISTS `svcart_product_type_i18ns`;
CREATE TABLE `svcart_product_type_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '类型多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_promotions`
--

DROP TABLE IF EXISTS `svcart_promotions`;
CREATE TABLE `svcart_promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '促销编号',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '促销类型[0:减免;1:折扣;2:特惠品]',
  `type_ext` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '为0表示不限数量',
  `start_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '促销开始时间',
  `end_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '促销结束时间',
  `user_rank` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '促销类型',
  `min_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最小金额',
  `max_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最大金额',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0:无效;1:有效;2:删除',
  `clicked` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '促销被点击数',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_promotion_i18ns`
--

DROP TABLE IF EXISTS `svcart_promotion_i18ns`;
CREATE TABLE `svcart_promotion_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '促销多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `promotion_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销编号',
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `meta_keywords` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO分类关键字',
  `meta_description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO分类描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`promotion_id`),
  KEY `locale` (`locale`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_promotion_products`
--

DROP TABLE IF EXISTS `svcart_promotion_products`;
CREATE TABLE `svcart_promotion_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号',
  `promotion_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销编号',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `start_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '促销开始时间',
  `end_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '促销结束时间',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0:无效;1:有效;2:删除',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_providers`
--

DROP TABLE IF EXISTS `svcart_providers`;
CREATE TABLE `svcart_providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '供应商编号',
  `provider_sn` varchar(60) DEFAULT NULL COMMENT '供应商编号',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '供应商名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '供应商描述',
  `meta_keywords` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO关键字',
  `meta_description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO描述',
  `contact_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系人',
  `contact_email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人EMAIL',
  `contact_tele` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系电话',
  `contact_mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系人手机',
  `contact_fax` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系传真',
  `contact_address` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系地址',
  `contact_zip` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系邮编',
  `contact_remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '联系备注',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `provider_sn` (`provider_sn`),
  KEY `status` (`status`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_provider_products`
--

DROP TABLE IF EXISTS `svcart_provider_products`;
CREATE TABLE `svcart_provider_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `provider_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商编号',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `price` float(12,2) NOT NULL COMMENT '价格',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `min_buy` int(11) NOT NULL DEFAULT '1' COMMENT '最小进货量',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `provider_id` (`provider_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_regions`
--

DROP TABLE IF EXISTS `svcart_regions`;
CREATE TABLE `svcart_regions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父地区ID',
  `level` char(1) NOT NULL DEFAULT '2' COMMENT '等级',
  `agency_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '目前暂未用到',
  `abbreviated` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '简写',
  `param01` varchar(200) NOT NULL DEFAULT '' COMMENT '参数1',
  `param02` varchar(200) NOT NULL DEFAULT '' COMMENT '参数2',
  `param03` varchar(200) NOT NULL DEFAULT '' COMMENT '参数3',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `level` (`level`),
  KEY `agency_id` (`agency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_region_i18ns`
--

DROP TABLE IF EXISTS `svcart_region_i18ns`;
CREATE TABLE `svcart_region_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '区域多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `region_id` int(11) NOT NULL DEFAULT '0' COMMENT '文章编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `description` text COMMENT '描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`region_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_seo_keywords`
--

DROP TABLE IF EXISTS `svcart_seo_keywords`;
CREATE TABLE `svcart_seo_keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '关键字名称',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `lasthittime` datetime DEFAULT NULL COMMENT '最后访问',
  `usetimes` int(11) NOT NULL DEFAULT '0' COMMENT '引用次数',
  `lastusetime` datetime DEFAULT NULL COMMENT '最后引用',
  `orderby` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1有效0无效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_sessions`
--

DROP TABLE IF EXISTS `svcart_sessions`;
CREATE TABLE `svcart_sessions` (
  `id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '序列化后的sessionid',
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '序列化后的session数据',
  `expires` int(11) DEFAULT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_shippings`
--

DROP TABLE IF EXISTS `svcart_shippings`;
CREATE TABLE `svcart_shippings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号',
  `code` varchar(100) NOT NULL COMMENT '配送方式的字符串代号',
  `insure` char(1) NOT NULL DEFAULT '0' COMMENT '价费用，单位元，或者是百分数，该值直接输出为报价费用',
  `support_cod` char(1) NOT NULL DEFAULT '0' COMMENT '是否支持货到付款，1，支持；0，不支持',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '该配送方式是否被禁用，1，可用；0，禁用',
  `php_code` text COMMENT '接口代码',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `insure_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '保价费用，单位元，或者是百分数，该值直接输出为报价费用',
  `version` varchar(40) NOT NULL COMMENT '插件版本',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_shipping_areas`
--

DROP TABLE IF EXISTS `svcart_shipping_areas`;
CREATE TABLE `svcart_shipping_areas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号',
  `shipping_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '该配送区域所属的配送方式，同svcart_shippings的id',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '状态1有效0无效',
  `fee_configures` text COMMENT '序列化的该配送区域的费用配置信息',
  `free_subtotal` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '免费额度',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `shipping_id` (`shipping_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_shipping_area_i18ns`
--

DROP TABLE IF EXISTS `svcart_shipping_area_i18ns`;
CREATE TABLE `svcart_shipping_area_i18ns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '语言',
  `shipping_area_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送区域ID',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '配送方式中的配送区域的名字',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '配送区域描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`shipping_area_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_shipping_area_regions`
--

DROP TABLE IF EXISTS `svcart_shipping_area_regions`;
CREATE TABLE `svcart_shipping_area_regions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `shipping_area_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送区域ID',
  `region_id` int(11) NOT NULL DEFAULT '0' COMMENT '地区ID',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `shipping_area_id` (`shipping_area_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_shipping_i18ns`
--

DROP TABLE IF EXISTS `svcart_shipping_i18ns`;
CREATE TABLE `svcart_shipping_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '配送方式多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `shipping_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '配送名称',
  `description` text COMMENT '配送描述',
  `param` varchar(200) NOT NULL DEFAULT '' COMMENT '参数',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`,`shipping_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_sitemaps`
--

DROP TABLE IF EXISTS `svcart_sitemaps`;
CREATE TABLE `svcart_sitemaps` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `cycle` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '周期',
  `url` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '链接地址',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '类型',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1：有效0：无效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_sms_send_histories`
--

DROP TABLE IF EXISTS `svcart_sms_send_histories`;
CREATE TABLE `svcart_sms_send_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机号码',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '短信内容',
  `send_date` datetime NOT NULL COMMENT '发送时间',
  `flag` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0;未发送',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_sms_send_queues`
--

DROP TABLE IF EXISTS `svcart_sms_send_queues`;
CREATE TABLE `svcart_sms_send_queues` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机号码',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '短信内容',
  `send_date` datetime NOT NULL COMMENT '发送时间',
  `flag` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0;未发送',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_sms_words`
--

DROP TABLE IF EXISTS `svcart_sms_words`;
CREATE TABLE `svcart_sms_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `word` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '敏感字',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_stocks`
--

DROP TABLE IF EXISTS `svcart_stocks`;
CREATE TABLE `svcart_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '库存主键',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品ID',
  `batch_id` int(11) NOT NULL DEFAULT '0' COMMENT '批号ID',
  `provider_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商ID',
  `warehouses_id` int(11) NOT NULL DEFAULT '0' COMMENT '仓库ID',
  `quantity` int(11) NOT NULL DEFAULT '0' COMMENT '库存数量',
  `param01` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性1',
  `param02` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性2',
  `param03` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性3',
  `param04` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '属性4',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `batch_id` (`batch_id`),
  KEY `warehouses_id` (`warehouses_id`),
  KEY `provider_id` (`provider_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='库存表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_stores`
--

DROP TABLE IF EXISTS `svcart_stores`;
CREATE TABLE `svcart_stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '店铺编号',
  `store_sn` varchar(60) DEFAULT NULL COMMENT '店铺编号',
  `store_type` char(1) NOT NULL DEFAULT '0' COMMENT '0.虚拟店，1.实体店',
  `contact_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人名称',
  `contact_email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人EMAIL',
  `contact_tele` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人电话',
  `contact_mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人手机',
  `contact_fax` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '传真',
  `url` varchar(255) DEFAULT NULL COMMENT '网址',
  `remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '备注',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `store_sn` (`store_sn`),
  UNIQUE KEY `store_sn_2` (`store_sn`),
  UNIQUE KEY `store_sn_3` (`store_sn`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_store_i18ns`
--

DROP TABLE IF EXISTS `svcart_store_i18ns`;
CREATE TABLE `svcart_store_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '店铺多语言编号',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '店铺名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '店铺描述',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '地址',
  `telephone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '联系电话',
  `zipcode` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '邮编',
  `transport` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '交通',
  `map` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '地图',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '链接',
  `meta_keywords` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO关键字',
  `meta_description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `locale_2` (`locale`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_store_products`
--

DROP TABLE IF EXISTS `svcart_store_products`;
CREATE TABLE `svcart_store_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺编号',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `price` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效;1:有效;]',
  `start_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '有效时间',
  `end_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '结束时间',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_system_resources`
--

DROP TABLE IF EXISTS `svcart_system_resources`;
CREATE TABLE `svcart_system_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '资源上级ID',
  `code` varchar(60) NOT NULL DEFAULT '' COMMENT '资源代码',
  `resource_value` varchar(30) DEFAULT NULL COMMENT '资源代码的值',
  `status` char(1) DEFAULT '1' COMMENT '状态0:无效1:有效',
  `section` varchar(20) NOT NULL COMMENT '版本标识',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_system_resource_i18ns`
--

DROP TABLE IF EXISTS `svcart_system_resource_i18ns`;
CREATE TABLE `svcart_system_resource_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `system_resource_id` int(11) NOT NULL DEFAULT '0' COMMENT '资源编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '资源名称',
  `description` text NOT NULL COMMENT '描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`system_resource_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_tags`
--

DROP TABLE IF EXISTS `svcart_tags`;
CREATE TABLE `svcart_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `type_id` int(11) NOT NULL COMMENT '相关id',
  `type` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '类型 P：商品  A：文章',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '是否有效 0:无效 1:有效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_tag_i18ns`
--

DROP TABLE IF EXISTS `svcart_tag_i18ns`;
CREATE TABLE `svcart_tag_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `tag_id` int(11) NOT NULL COMMENT '标签id',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '标签名',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_templates`
--

DROP TABLE IF EXISTS `svcart_templates`;
CREATE TABLE `svcart_templates` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '模板名',
  `description` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '模版的名称',
  `template_style` varchar(50) NOT NULL COMMENT '模版的颜色样式',
  `url` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'http://www.seevia.cn/' COMMENT '作者地址',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '是否有效',
  `is_default` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否默认',
  `author` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '版本',
  `style` varchar(55) NOT NULL COMMENT '模板样式',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_topics`
--

DROP TABLE IF EXISTS `svcart_topics`;
CREATE TABLE `svcart_topics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `start_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '促销开始时间',
  `end_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '促销结束时间',
  `template` varchar(255) NOT NULL COMMENT '模板',
  `css` text COMMENT '主题样式',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_topic_i18ns`
--

DROP TABLE IF EXISTS `svcart_topic_i18ns`;
CREATE TABLE `svcart_topic_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `topic_id` int(11) NOT NULL DEFAULT '0' COMMENT '专题编号',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '专题名称',
  `intro` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '专题介绍',
  `meta_keywords` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO分类关键字',
  `meta_description` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'SEO分类描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`topic_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_topic_products`
--

DROP TABLE IF EXISTS `svcart_topic_products`;
CREATE TABLE `svcart_topic_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商店编号',
  `topic_id` int(11) NOT NULL DEFAULT '0' COMMENT '促销编号',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `orderby` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0:无效;1:有效;2:删除',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `store_id_3` (`store_id`,`topic_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_users`
--

DROP TABLE IF EXISTS `svcart_users`;
CREATE TABLE `svcart_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员资料自增id',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '注册语言',
  `domain` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '注册域名',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '昵称',
  `first_name` varchar(20) DEFAULT NULL COMMENT 'first_name',
  `last_name` varchar(20) DEFAULT NULL COMMENT 'last_name',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '用户密码',
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '会员邮箱',
  `address_id` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '收货信息id，取值表user_address',
  `question` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '安全问题答案',
  `answer` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '安全问题',
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '用户现有资金',
  `frozen` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '用户冻结资金',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '消费积分',
  `user_point` int(11) DEFAULT NULL COMMENT '会员等级积分',
  `login_times` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `login_ipaddr` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '最后一次登录ip',
  `last_login_time` datetime DEFAULT '2008-01-01 00:00:00' COMMENT '最后一次登录时间',
  `rank` int(11) NOT NULL DEFAULT '0' COMMENT '会员登记id，取值user_rank',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效 1:有效 2:冻结 3:注销 ]',
  `verify_status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '会员认证状态[0 未认证 1已认证 2 取消认证]',
  `unvalidate_note` varchar(60) NOT NULL COMMENT '会员认证备注',
  `birthday` date DEFAULT NULL COMMENT '生日日期',
  `sex` char(1) NOT NULL DEFAULT '0' COMMENT '性别，0，保密；1，男；2，女',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '推荐人会员id',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_accounts`
--

DROP TABLE IF EXISTS `svcart_user_accounts`;
CREATE TABLE `svcart_user_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户登录后保存在session中的id号，跟users表中的user_id对应',
  `user_note` varchar(255) NOT NULL COMMENT '用户注释',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '资金的数目，正数为增加，负数为减少',
  `paid_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '支付时间',
  `admin_user` varchar(255) NOT NULL COMMENT '管理员名称',
  `admin_note` varchar(255) NOT NULL COMMENT '管理员注释',
  `process_type` char(1) NOT NULL DEFAULT '0' COMMENT '操作类型，1，退款；0，预付费，其实就是充值',
  `payment` varchar(90) NOT NULL COMMENT '支付渠道的名称，取自payment的pay_name字段',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '是否已经付款，０，未付；１，已付',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_addresses`
--

DROP TABLE IF EXISTS `svcart_user_addresses`;
CREATE TABLE `svcart_user_addresses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名称',
  `first_name` varchar(20) DEFAULT NULL COMMENT '名',
  `last_name` varchar(20) DEFAULT NULL COMMENT '姓',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户表中的流水号',
  `consignee` varchar(60) NOT NULL COMMENT '收货人的名字',
  `email` varchar(60) NOT NULL COMMENT '收货人的email',
  `address` varchar(120) NOT NULL COMMENT '收货人的详细地址',
  `zipcode` varchar(60) NOT NULL COMMENT '收货人的邮编',
  `telephone` varchar(60) NOT NULL COMMENT '收货人的电话',
  `mobile` varchar(60) NOT NULL COMMENT '收货人的手机',
  `sign_building` varchar(120) NOT NULL COMMENT '收货地址的标志性建筑名',
  `best_time` varchar(120) NOT NULL COMMENT '收货人的最佳收货时间',
  `regions` varchar(200) NOT NULL DEFAULT '' COMMENT '区域集',
  `region_param01` varchar(120) DEFAULT NULL COMMENT '地区参数1',
  `region_param02` varchar(120) DEFAULT NULL COMMENT '地区参数2',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_balance_logs`
--

DROP TABLE IF EXISTS `svcart_user_balance_logs`;
CREATE TABLE `svcart_user_balance_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `admin_user` varchar(255) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `admin_note` varchar(255) NOT NULL DEFAULT '' COMMENT '管理员注释',
  `system_note` varchar(255) NOT NULL DEFAULT '' COMMENT '系统注释',
  `log_type` char(1) NOT NULL DEFAULT '0' COMMENT '日志类型[O:订单;B:充值;R:退款]',
  `type_id` varchar(90) NOT NULL DEFAULT '' COMMENT '关联编号',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_configs`
--

DROP TABLE IF EXISTS `svcart_user_configs`;
CREATE TABLE `svcart_user_configs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `user_rank` int(11) NOT NULL DEFAULT '0' COMMENT '用户等级',
  `code` varchar(30) NOT NULL COMMENT '用户设置代码',
  `type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `value` varchar(200) NOT NULL DEFAULT '' COMMENT '参数值',
  `orderby` tinyint(4) unsigned NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_rank` (`user_rank`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_config_i18ns`
--

DROP TABLE IF EXISTS `svcart_user_config_i18ns`;
CREATE TABLE `svcart_user_config_i18ns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `user_config_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户参数号',
  `code` varchar(30) NOT NULL DEFAULT '' COMMENT '配置编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '配送名称',
  `description` text COMMENT '配送描述',
  `user_config_values` text COMMENT '可选值',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`user_config_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_favorites`
--

DROP TABLE IF EXISTS `svcart_user_favorites`;
CREATE TABLE `svcart_user_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '收藏编号',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户编号',
  `type` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '收藏类型[商品(p)，商品分类(pc)，文章分类(ac)，品牌(b)，文章(a)]',
  `type_id` int(11) NOT NULL DEFAULT '0' COMMENT '收藏id号',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效 1:有效]',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `type_2` (`type`,`type_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_friends`
--

DROP TABLE IF EXISTS `svcart_user_friends`;
CREATE TABLE `svcart_user_friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '好友分组ID',
  `contact_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人姓名',
  `contact_mobile` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人电话',
  `contact_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人email',
  `contact_user_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人用户名',
  `birthday` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '好友生日',
  `birthday_wishes` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '祝福语',
  `remark` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '备注',
  `last_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '最后登入时间',
  `address` varchar(220) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '好友地址',
  `constellation` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '好友星座',
  `personality` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '个性',
  `sex` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '性别',
  `contact_other_email` varchar(100) NOT NULL DEFAULT '' COMMENT '好友备用邮箱',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_friend_cats`
--

DROP TABLE IF EXISTS `svcart_user_friend_cats`;
CREATE TABLE `svcart_user_friend_cats` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `cat_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '好友分组名称',
  `cat_desc` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '好友分组描述',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级分组 ',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ＩＤ',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_infos`
--

DROP TABLE IF EXISTS `svcart_user_infos`;
CREATE TABLE `svcart_user_infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'html类型',
  `status` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '状态[0:无效 1:有效]',
  `front` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '前台显示',
  `backend` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '后台显示',
  `section` varchar(20) NOT NULL COMMENT '版本标识',
  `orderby` smallint(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_info_i18ns`
--

DROP TABLE IF EXISTS `svcart_user_info_i18ns`;
CREATE TABLE `svcart_user_info_i18ns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '语言编码',
  `user_info_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `user_info_values` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '可选值',
  `message` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '提示信息',
  `remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '备注',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`user_info_id`),
  KEY `locale` (`locale`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_info_values`
--

DROP TABLE IF EXISTS `svcart_user_info_values`;
CREATE TABLE `svcart_user_info_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户编号',
  `user_info_id` int(11) NOT NULL DEFAULT '0' COMMENT '信息项目编号',
  `value` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '项目值',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`user_id`,`user_info_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_messages`
--

DROP TABLE IF EXISTS `svcart_user_messages`;
CREATE TABLE `svcart_user_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复ID 0为留言',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `user_name` varchar(60) NOT NULL COMMENT '用户名',
  `user_email` varchar(60) NOT NULL COMMENT '留言者EMAIL',
  `msg_title` varchar(200) NOT NULL COMMENT '留言标题',
  `msg_type` tinyint(5) unsigned NOT NULL DEFAULT '0' COMMENT '5.商家留言',
  `type` char(1) NOT NULL COMMENT '留言对象类型',
  `msg_content` text COMMENT '留言内容 或 回复内容',
  `message_img` varchar(255) NOT NULL DEFAULT '0' COMMENT '留言图片',
  `value_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型编号',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '状态0无效，1有效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_point_logs`
--

DROP TABLE IF EXISTS `svcart_user_point_logs`;
CREATE TABLE `svcart_user_point_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '金额',
  `admin_user` varchar(255) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `admin_note` varchar(255) NOT NULL DEFAULT '' COMMENT '管理员注释',
  `system_note` varchar(255) NOT NULL DEFAULT '' COMMENT '系统注释',
  `log_type` char(1) NOT NULL DEFAULT '0' COMMENT 'R.注册赠送 B.购买赠送 O.购买消费 A.管理员操作',
  `type_id` varchar(90) NOT NULL DEFAULT '' COMMENT '关联编号',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_product_galleries`
--

DROP TABLE IF EXISTS `svcart_user_product_galleries`;
CREATE TABLE `svcart_user_product_galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0:无效;1:有效;',
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '上传的图片',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_ranks`
--

DROP TABLE IF EXISTS `svcart_user_ranks`;
CREATE TABLE `svcart_user_ranks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员等级编号，其中0是非会员',
  `min_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '该等级的最低积分',
  `max_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '该等级的最高积分',
  `discount` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '该会员等级的商品折扣',
  `show_price` char(1) NOT NULL DEFAULT '1' COMMENT '是否在不是该等级会员购买页面显示该会员等级的折扣价格.1,显示;0,不显示',
  `allow_buy` char(1) NOT NULL DEFAULT '1' COMMENT '有权购买',
  `special_rank` char(1) NOT NULL DEFAULT '0' COMMENT '是否事特殊会员等级组.0,不是;1,是',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_user_rank_i18ns`
--

DROP TABLE IF EXISTS `svcart_user_rank_i18ns`;
CREATE TABLE `svcart_user_rank_i18ns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `locale` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '语言编码',
  `user_rank_id` int(11) NOT NULL DEFAULT '0' COMMENT 'svcart_user_ranks用户等级主表ID',
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '会员等级名称',
  `descrption` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '会员等级描述',
  `img` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '会员等级图片',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale_2` (`locale`,`user_rank_id`),
  KEY `locale` (`locale`),
  KEY `user_rank_id` (`user_rank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_virtual_cards`
--

DROP TABLE IF EXISTS `svcart_virtual_cards`;
CREATE TABLE `svcart_virtual_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '虚拟卡卡号自增id',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '该虚拟卡对应的商品id，取值于表svcart_products',
  `card_sn` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '加密后的卡号',
  `card_password` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '加密后的密码',
  `end_date` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '卡号截至使用日期',
  `is_saled` char(1) NOT NULL DEFAULT '0' COMMENT '是否已售出：0：否，1：是',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '卖出该卡号的交易号，取值表svcart_orders',
  `crc32` varchar(30) NOT NULL DEFAULT '0' COMMENT 'crc32后的key',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间，就是虚拟卡发送时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_sn` (`card_sn`),
  UNIQUE KEY `card_sn_2` (`card_sn`),
  UNIQUE KEY `card_sn_3` (`card_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `svcart_votes`
--

DROP TABLE IF EXISTS `svcart_votes`;
CREATE TABLE `svcart_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '在线调查自增id',
  `start_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '在线调查开始时间',
  `end_time` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '在线调查结束时间',
  `can_multi` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '能否多选，0，可以；1，不可以',
  `vote_count` int(11) NOT NULL DEFAULT '0' COMMENT '投票人数',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1:有效,0:无效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='在线调查';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_vote_i18ns`
--

DROP TABLE IF EXISTS `svcart_vote_i18ns`;
CREATE TABLE `svcart_vote_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '语言编码',
  `vote_id` int(11) NOT NULL DEFAULT '0' COMMENT '投票主题ID',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '在线调查主题',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '主题描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`vote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='在线调查多语言表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_vote_logs`
--

DROP TABLE IF EXISTS `svcart_vote_logs`;
CREATE TABLE `svcart_vote_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投票记录自增id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID,0:匿名用户',
  `vote_id` int(11) NOT NULL DEFAULT '0' COMMENT '投票主题id',
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '投票的ip地址',
  `system` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户所用的操作系统',
  `browser` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户所用的浏览器',
  `resolution` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '用户所用的分辨率',
  `vote_option_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '多选时逗号分割',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '前台是否显示1:显示,0:不显示',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `vote_id` (`vote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='投票记录表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_vote_options`
--

DROP TABLE IF EXISTS `svcart_vote_options`;
CREATE TABLE `svcart_vote_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '投票选项自增id',
  `vote_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联的投票主题id，取值表svcart_votes',
  `option_count` int(8) NOT NULL DEFAULT '0' COMMENT '该选项的票数',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1:有效,0:无效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `vote_id` (`vote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='投票的选项表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_vote_option_i18ns`
--

DROP TABLE IF EXISTS `svcart_vote_option_i18ns`;
CREATE TABLE `svcart_vote_option_i18ns` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '语言编码',
  `vote_option_id` int(11) NOT NULL DEFAULT '0' COMMENT '选项表ID',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ' ' COMMENT '投票选项的名字',
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '选项描述',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `locale` (`locale`,`vote_option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='在线调查选项多语言表';

-- --------------------------------------------------------

--
-- 表的结构 `svcart_warehouses`
--

DROP TABLE IF EXISTS `svcart_warehouses`;
CREATE TABLE `svcart_warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '仓库代码',
  `warehouse_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '仓库名称',
  `contact_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL COMMENT '联系人',
  `contact_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'email',
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '仓库地址',
  `zipcode` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮编',
  `telephone` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT '联系电话',
  `remark` text COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `orderby` int(4) NOT NULL DEFAULT '50' COMMENT '排序',
  `status` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1有效0无效',
  `created` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '创建时间',
  `modified` datetime NOT NULL DEFAULT '2008-01-01 00:00:00' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='仓库表';
