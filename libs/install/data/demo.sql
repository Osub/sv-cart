-- -------------------------------演示数据----------------------------------------------------------------------------------------------

--
-- 导出表中的数据 `svcart_categories`
--

INSERT INTO `svcart_categories` (`id`, `parent_id`, `type`, `flash_config`, `orderby`, `status`, `link`, `img01`, `img02`, `created`, `modified`) VALUES
(10, 0, 'P', '', 5, '1', '', '', '', '2009-03-16 05:02:27', '2009-04-23 05:21:56');

--
-- 导出表中的数据 `svcart_category_i18ns`
--

INSERT INTO `svcart_category_i18ns` (`locale`, `category_id`, `name`, `meta_keywords`, `meta_description`, `detail`, `img01`, `img02`, `img03`, `created`, `modified`) VALUES
( 'chi', 10, '饰品与配件', '饰品与配件', '饰品与配件', '', '', '', NULL, '2009-03-16 05:02:27', '2009-04-23 05:21:56');
--
-- 导出表中的数据 `svcart_brands`
--

INSERT INTO `svcart_brands` (`id`, `orderby`, `img01`, `img02`, `flash_config`, `status`, `url`, `created`, `modified`) VALUES
(1, 0, ' ', '', '', '1', '', '2009-04-09 05:39:46', '2009-04-09 05:39:46');


--
-- 导出表中的数据 `svcart_brand_i18ns`
--

INSERT INTO `svcart_brand_i18ns` (`id`, `locale`, `brand_id`, `name`, `description`, `meta_keywords`, `meta_description`, `img01`, `img02`, `img03`, `created`, `modified`) VALUES
(1, 'chi', 1, '品牌01', '品牌01', '品牌01', '品牌01', NULL, '', NULL, '2009-04-09 05:45:26', '2009-04-09 05:45:26');


--
-- 导出表中的数据 `svcart_products`
--

INSERT INTO `svcart_products` (`id`,`category_id`, `brand_id`, `provider_id`, `code`, `product_name_style`, `img_thumb`, `img_detail`, `img_original`, `recommand_flag`, `min_buy`, `max_buy`, `admin_id`, `alone`, `forsale`, `status`, `weight`, `market_price`, `shop_price`, `promotion_price`, `promotion_start`, `promotion_end`, `promotion_status`, `view_stat`, `sale_stat`, `product_type_id`, `product_rank_id`, `quantity`, `created`, `modified`) VALUES
(1,10, 1, 0, 'svcart000001', '+', '/img/products/svcart000001/49b0623e.jpg', '/img/products/svcart000001/detail/49b0623e.jpg', '/img/products/svcart000001/original/49b0623e.jpg', '0', 1, 100, 0, '1', '1', '1', 20.000, 20000.00, 20000.00, 0.00, '2008-01-01 00:00:00', '2008-01-01 00:00:00', '0', 0, 0, 0, 0, 5, '2009-04-09 05:48:31', '2009-04-10 03:58:30'),
(2, 10,1, 0, 'svcart000002', '+', '/img/products/svcart000002/49b6c124.jpg', '/img/products/svcart000002/detail/49b6c124.jpg', '/img/products/svcart000002/original/49b6c124.jpg', '0', 1, 100, 0, '1', '1', '1', 45.000, 50000.00, 50000.00, 0.00, '2008-01-01 00:00:00', '2008-01-01 00:00:00', '0', 0, 0, 0, 0, 5, '2009-04-09 09:20:36', '2009-04-10 03:57:49'),
(3, 10,1, 0, 'svcart000003', '+', '/img/products/svcart000003/49b75709.jpg', '/img/products/svcart000003/detail/49b75709.jpg', '/img/products/svcart000003/original/49b75709.jpg', '0', 1, 100, 0, '1', '1', '1', 0.000, 10000.00, 10000.00, 0.00, '2008-01-01 00:00:00', '2008-01-01 00:00:00', '0', 0, 0, 0, 0, 5, '2009-04-09 09:22:57', '2009-04-10 03:56:34'),
(4, 10,1, 0, 'svcart000004', '+', '/img/products/svcart000004/49ba9400.jpg', '/img/products/svcart000004/detail/49ba9400.jpg', '/img/products/svcart000004/original/49ba9400.jpg', '0', 1, 100, 0, '1', '1', '1', 0.000, 6660.00, 6660.00, 0.00, '2008-01-01 00:00:00', '2008-01-01 00:00:00', '0', 0, 0, 0, 0, 5, '2009-04-09 09:25:42', '2009-04-10 03:54:43'),
(5, 10,1, 0, 'svcart000005', '+', '/img/products/svcart000005/49b00d3b.jpg', '/img/products/svcart000005/detail/49b00d3b.jpg', '/img/products/svcart000005/original/49b00d3b.jpg', '0', 1, 100, 0, '1', '1', '1', 0.000, 3000.00, 3000.00, 0.00, '2008-01-01 00:00:00', '2008-01-01 00:00:00', '0', 0, 0, 0, 0, 5, '2009-04-09 09:27:43', '2009-04-10 03:53:02'),
(6, 10,1, 0, 'svcart000006', '+', '/img/products/svcart000006/49b6086e.jpg', '/img/products/svcart000006/detail/49b6086e.jpg', '/img/products/svcart000006/original/49b6086e.jpg', '0', 1, 100, 0, '1', '1', '1', 0.000, 2000.00, 2000.00, 0.00, '2008-01-01 00:00:00', '2008-01-01 00:00:00', '0', 0, 0, 0, 0, 5, '2009-04-09 09:28:16', '2009-04-10 03:52:04'),
(7, 10,1, 0, 'svcart000007', '+', '/img/products/svcart000007/49bd0029.jpg', '/img/products/svcart000007/detail/49bd0029.jpg', '/img/products/svcart000007/original/49bd0029.jpg', '0', 1, 100, 0, '1', '1', '1', 0.000, 29999.00, 29999.00, 0.00, '2008-01-01 00:00:00', '2008-01-01 00:00:00', '0', 0, 0, 0, 0, 5, '2009-04-09 09:28:50', '2009-04-10 03:43:58'),
(8, 10,1, 0, 'svcart000008', '+', '/img/products/svcart000008/49b584a2.jpg', '/img/products/svcart000008/detail/49b584a2.jpg', '/img/products/svcart000008/original/49b584a2.jpg', '0', 1, 100, 0, '1', '1', '1', 0.000, 3000.00, 3000.00, 0.00, '2008-01-01 00:00:00', '2008-01-01 00:00:00', '0', 0, 0, 0, 0, 5, '2009-04-09 09:29:40', '2009-04-10 03:43:13'),
(9, 10,1, 0, 'svcart000009', '+', '/img/products/svcart000009/49b9b1d0.jpg', '/img/products/svcart000009/detail/49b9b1d0.jpg', '/img/products/svcart000009/original/49b9b1d0.jpg', '0', 1, 100, 0, '1', '1', '1', 0.000, 3000.00, 3000.00, 0.00, '2008-01-01 00:00:00', '2008-01-01 00:00:00', '0', 0, 0, 0, 0, 5, '2009-04-09 09:30:15', '2009-04-10 03:42:14'),
(10,10, 1, 0, 'svcart000010', '+', '/img/products/svcart000010/49bfa424.jpg', '/img/products/svcart000010/detail/49bfa424.jpg', '/img/products/svcart000010/original/49bfa424.jpg', '0', 1, 100, 0, '1', '1', '1', 0.000, 4999.00, 4999.00, 0.00, '2008-01-01 00:00:00', '2008-01-01 00:00:00', '0', 0, 0, 0, 0, 5, '2009-04-09 09:30:48', '2009-04-10 03:41:19');


--
-- 导出表中的数据 `svcart_product_i18ns`
--

INSERT INTO `svcart_product_i18ns` (`id`, `locale`, `product_id`, `name`, `description`, `market_price`, `shop_price`, `meta_keywords`, `meta_description`, `api_site_url`, `api_cart_url`, `created`, `modified`) VALUES
(1, 'chi', 1, '梦幻紫水晶耳扣', '', 0.00, 0.00, '梦幻紫水晶耳扣', '梦幻紫水晶耳扣', '', '', '2009-04-09 05:48:31', '2009-04-09 05:48:31'),
(2, 'chi', 2, '天海蓝钻戒', '', 0.00, 0.00, '天海蓝钻戒', '天海蓝钻戒', '', '', '2009-04-09 09:20:36', '2009-04-09 09:21:22'),
(3, 'chi', 3, '传统玻璃手镯', '', 0.00, 0.00, '传统玻璃手镯', '传统玻璃手镯', '', '', '2009-04-09 09:22:57', '2009-04-09 09:24:53'),
(4, 'chi', 4, '观音琉璃挂件', '', 0.00, 0.00, '观音琉璃挂件', '观音琉璃挂件', '', '', '2009-04-09 09:25:42', '2009-04-09 09:26:55'),
(5, 'chi', 5, '东方古典翡翠玉耳环', '', 0.00, 0.00, '东方古典翡翠玉耳环', '东方古典翡翠玉耳环', '', '', '2009-04-09 09:27:43', '2009-04-09 09:32:56'),
(6, 'chi', 6, '中国柱状玉耳环', '', 0.00, 0.00, '中国柱状玉耳环', '中国柱状玉耳环', '', '', '2009-04-09 09:28:16', '2009-04-09 09:32:40'),
(7, 'chi', 7, '观音玉坠', '', 0.00, 0.00, '观音玉坠', '观音玉坠', '', '', '2009-04-09 09:28:50', '2009-04-09 09:32:23'),
(8, 'chi', 8, '银龙玉坠', '', 0.00, 0.00, '银龙玉坠', '银龙玉坠', '', '', '2009-04-09 09:29:40', '2009-04-09 09:31:43'),
(9, 'chi', 9, '中国佛琉璃挂件', '', 0.00, 0.00, '中国佛琉璃挂件', '中国佛琉璃挂件', '', '', '2009-04-09 09:30:15', '2009-04-09 09:31:26'),
(10, 'chi', 10, '活动贝壳项链', '', 0.00, 0.00, '活动贝壳项链', '活动贝壳项链', '', '', '2009-04-09 09:30:48', '2009-04-09 09:31:10');



--
-- 导出表中的数据 `svcart_products_categories`
--


--
-- 导出表中的数据 `svcart_product_galleries`
--

INSERT INTO `svcart_product_galleries` (`id`, `product_id`, `description`, `img_thumb`, `img_detail`, `img_original`, `orderby`, `status`, `created`, `modified`) VALUES
(1, 1, '梦幻紫水晶耳扣', '/img/products/svcart000001/49b0623e.jpg', '/img/products/svcart000001/detail/49b0623e.jpg', '/img/products/svcart000001/original/49b0623e.jpg', 5, '1', '2009-03-24 06:42:58', '2009-03-24 06:42:58'),
(2, 2, '天海蓝钻戒', '/img/products/svcart000002/49b6c124.jpg', '/img/products/svcart000002/detail/49b6c124.jpg', '/img/products/svcart000002/original/49b6c124.jpg', 5, '1', '2009-03-24 06:42:58', '2009-03-24 06:42:58'),
(3, 3, '传统玻璃手镯', '/img/products/svcart000003/49b75709.jpg', '/img/products/svcart000003/detail/49b75709.jpg', '/img/products/svcart000003/original/49b75709.jpg', 5, '1', '2009-03-24 06:42:58', '2009-03-24 06:42:58'),
(4, 4, '观音琉璃挂件', '/img/products/svcart000004/49ba9400.jpg', '/img/products/svcart000004/detail/49ba9400.jpg', '/img/products/svcart000004/original/49ba9400.jpg', 5, '1', '2009-03-24 06:42:58', '2009-03-24 06:42:58'),
(5, 5, '东方古典翡翠玉耳环', '/img/products/svcart000005/49b00d3b.jpg', '/img/products/svcart000005/detail/49b00d3b.jpg', '/img/products/svcart000005/original/49b00d3b.jpg', 5, '1', '2009-03-24 06:42:58', '2009-03-24 06:42:58'),
(6, 6, '中国柱状玉耳环', '/img/products/svcart000006/49b6086e.jpg', '/img/products/svcart000006/detail/49b6086e.jpg', '/img/products/svcart000006/original/49b6086e.jpg', 5, '1', '2009-03-24 06:42:58', '2009-03-24 06:42:58'),
(7, 7, '观音玉坠', '/img/products/svcart000007/49bd0029.jpg', '/img/products/svcart000007/detail/49bd0029.jpg', '/img/products/svcart000007/original/49bd0029.jpg', 5, '1', '2009-03-24 06:42:58', '2009-03-24 06:42:58'),
(8, 8, '银龙玉坠', '/img/products/svcart000008/49b584a2.jpg', '/img/products/svcart000008/detail/49b584a2.jpg', '/img/products/svcart000008/original/49b584a2.jpg', 5, '1', '2009-03-24 06:42:58', '2009-03-24 06:42:58'),
(9, 9, '中国佛琉璃挂件', '/img/products/svcart000009/49b9b1d0.jpg', '/img/products/svcart000009/detail/49b9b1d0.jpg', '/img/products/svcart000009/original/49b9b1d0.jpg', 5, '1', '2009-03-24 06:42:58', '2009-03-24 06:42:58'),
(10, 10, '活动贝壳项链', '/img/products/svcart000010/49bfa424.jpg', '/img/products/svcart000010/detail/49bfa424.jpg', '/img/products/svcart000010/original/49bfa424.jpg', 5, '1', '2009-03-24 06:42:58', '2009-03-24 06:42:58');



--
-- 导出表中的数据 `svcart_shipping_areas`
--

INSERT INTO `svcart_shipping_areas` (`id`,`store_id`, `shipping_id`, `orderby`, `status`, `fee_configures`, `free_subtotal`, `created`, `modified`) VALUES
(1000, 0, 1, 0, 1, 'a:3:{i:0;a:1:{s:5:"value";s:3:"454";}i:1;a:1:{s:5:"value";s:3:"454";}i:2;a:1:{s:5:"value";s:3:"545";}}', 454.00, '2009-04-14 09:53:44', '2009-04-14 10:18:52'),
(1001, 0, 2, 1, 1, 'a:3:{i:0;a:1:{s:5:"value";s:3:"454";}i:1;a:1:{s:5:"value";s:3:"454";}i:2;a:1:{s:5:"value";s:3:"545";}}', 454.00, '2009-04-14 09:53:44', '2009-04-14 10:18:52');


--
-- 导出表中的数据 `svcart_shipping_area_i18ns`
--

INSERT INTO `svcart_shipping_area_i18ns` (`locale`, `shipping_area_id`, `name`, `description`, `created`, `modified`) VALUES
( 'chi', 1000, '中国', '中国各地', '2009-04-14 06:01:07', '2009-04-14 06:01:07'),
( 'chi', 1001, '中国', '中国各地', '2009-04-14 06:01:07', '2009-04-14 06:01:07');