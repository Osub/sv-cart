<?php
/*****************************************************************************
 * SV-CART Ecshops
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: pages_controller.php 678 2009-04-16 02:22:25Z zhengli $
*****************************************************************************/
class ImportEcshopsController extends EcshopAppController {
	var $name 		= 'ImportEcshops';
    var $components = array ('Pagination','RequestHandler'); 
    var $helpers 	= array('Pagination'); 
	var $uses 		= array("ProductAttribute","ProductType","ProductTypeI18n","ProductTypeAttributeI18n","ProductTypeAttribute","ProdcutVolume","User","Config","ConfigI18n","Product","ProductI18n","Category","CategoryI18n","Brand","BrandI18n","Article","ArticleI18n","Order","OrderProduct");
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('import_ecshop_view');
		/*end*/
		$this->pageTitle = "ecshop导入 - ecshop导入"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'ecshop导入','url'=>'');
		$this->navigations[] = array('name'=>'设置数据库连接','url'=>'');
		$this->set('navigations',$this->navigations);
		$import_ecshop_mysql_table = array(
			"brand"=>"品牌",
			"Category"=>"商品分类",
			"goods"=>"商品",
			"article_cat"=>"文章分类",
			"article"=>"文章",
			"order_info"=>"订单",
			"order_goods"=>"订单商品",
			"users"=>"会员",
			"volume_price"=>"商品优惠价",
			"attribute"=>"商品属性",
			"goods_type"=>"商品类型",
			"goods_attr"=>"商品属性关联"
		);
		$this->set('import_ecshop_mysql_table',$import_ecshop_mysql_table);
	}
	
	//数据库配置
	function ecshop_database_config(){
		$this->pageTitle = "ecshop导入 - ecshop导入"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'ecshop导入','url'=>'');
		$this->navigations[] = array('name'=>'导入ecshop数据','url'=>'');
		$this->set('navigations',$this->navigations);
		$result["error"] = 0;
		$result["message"] = "";
		if($this->RequestHandler->isPost())
		{	
			
			$ecshop_host 		= $_REQUEST["ecshop_host"];//数据库主机
			$ecshop_login 		= $_REQUEST["ecshop_login"];//用户名
			$ecshop_password 	= $_REQUEST["ecshop_password"];//密码
			$ecshop_database 	= $_REQUEST["ecshop_database"];//数据库名
			$ecshop_prefix 		= $_REQUEST["ecshop_prefix"];//表前缀
			$database_config 	= $this->txt_read(ROOT."database.php");
			$fp = fopen(ROOT . '/database.php', 'wb+');
		    $new_database = "";
		    $new_database_status = 0;
		    foreach( $database_config as $k=>$v )
		    {
		    	if( trim($v) == "}" )
		    	{
		    		$new_database.="var \$ecshop = array(\n";
		    		$new_database.="'driver' => 'mysql',\n";
		    		$new_database.="'persistent' => false,\n";
		    		$new_database.="'host' => '$ecshop_host',\n";
		    		$new_database.="'login' => '$ecshop_login',\n";
		    		$new_database.="'password' => '$ecshop_password',\n";
		    		$new_database.="'database' => '$ecshop_database',\n";
		    		$new_database.="'prefix' => '$ecshop_prefix',\n";
		    		$new_database.="'encoding' => 'UTF8'\n";
		    		$new_database.=");\n";
		    		$new_database.="}\n";
		    	}else
		    	{
		    		if(strstr($v,"\$ecshop"))
		    		{
		    			$new_database_status=1;
		    		}
		    		if( $new_database_status == 0 )
		    		{
		    			$new_database.= $v;
		    		}
		    		if(strstr($v,");"))
		    		{
		    			$new_database_status=0;
		    		}
		    	}
		    	

		    }
		    fwrite($fp, $new_database);
		}
		$result["error"] = 1;
		$result["message"] = "数据库连接保存成功，点击确定开始数据库连接测试.";
		Configure::write('debug', 0);
		die(json_encode($result));

	}
	//检测ECSHOP数据库连接
	function check_ecshop_database_config(){
		//创建数据库连接
		@$db =& ConnectionManager::getDataSource('ecshop');
		if($db->connected){
			$result["error"] = 1;
			$result["message"] = "数据库连接成功，点击确定开始ecshop数据导入.";
		
		}else{
			$result["error"] = 0;
			$result["message"] = "数据库连接失败,请重新输入数据库连接信息!";
		}
		Configure::write('debug', 0);
		die(json_encode($result));
	}
	//ecshop数据导入
	function import_ecshop(){
		set_time_limit(3600000);
		//要导入的数据表
		$import_ecshop_mysql_table_value = $_REQUEST["import_ecshop_mysql_table_value"];
		$import_ecshop_mysql_table = explode(",",$import_ecshop_mysql_table_value);//数据表组数
		if(in_array("users",$import_ecshop_mysql_table)){
			$user_id = $this->ecshop_import_users();//用户
		}
		else{
			$user_id = 0;
		}
		if(in_array("brand",$import_ecshop_mysql_table)){
			$brand_id	= $this->ecshop_import_brand();//品牌
		}
		else{
			$brand_id = 0;
		}
		if(in_array("Category",$import_ecshop_mysql_table)){
			$product_category_id 	= $this->ecshop_import_product_category();//商品分类
		}
		else{
			$product_category_id = 0;
		}
		if(in_array("goods",$import_ecshop_mysql_table)){
			$product_id = $this->ecshop_import_goods($product_category_id,$brand_id);//商品
		}
		else{
			$product_id = "";
		}
		if(in_array("article_cat",$import_ecshop_mysql_table)){
			$article_category_id 	= $this->ecshop_import_article_category();//文章分类
		}
		else{
			$article_category_id = 0;
		}
		if(in_array("article",$import_ecshop_mysql_table)){
			$this->ecshop_import_article($article_category_id);//文章
		}
		
		if(in_array("order_info",$import_ecshop_mysql_table)){
			$order_id = $this->ecshop_import_order($user_id);//订单
		}
		else{
			$order_id = 0;
		}
		if(in_array("order_goods",$import_ecshop_mysql_table)){
			$this->ecshop_import_order_goods($order_id,$product_id);//订单商品
		}
		if(in_array("goods_type",$import_ecshop_mysql_table)){
			$product_type_id = $this->ecshop_import_goods_type();//商品类型
		}
		else{
			$product_type_id = 0;
		}
			
		if(in_array("volume_price",$import_ecshop_mysql_table)){
			$this->ecshop_import_volume_price($product_id);//优惠价
		}
		if(in_array("attribute",$import_ecshop_mysql_table)){
			$product_type_attribute_id = $this->ecshop_import_attribute($product_type_id);//商品属性
		}
		else{
			$product_type_attribute_id = 0;
		}
		if(in_array("goods_attr",$import_ecshop_mysql_table)){
			$this->ecshop_import_goods_attr($product_id,$product_type_attribute_id);//商品属性关联
		}
		
		Configure::write('debug', 0);
    	die("ecshop数据导成功！");
	}
	//读文件
	function txt_read($file){
		$fp = fopen ($file, "r");
		$buffer = "";
		while (!feof($fp)) {          
	    	$buffer[]= fgets($fp, 40960); 
		}
		fclose($fp);
		return $buffer;
	}
	
	//商品分类导入
	function ecshop_import_product_category(){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;
		//分类导入
		$sql = "select * from ".$data_base_config["prefix"]."category";
		$ecshop_category_list = $db->query($sql);
		$this->Category->hasOne = array();
		$category_num = $this->Category->find("first",array("order"=>"id desc"));
		
		foreach( $ecshop_category_list as $k=>$v ){
			$category = array(
				"id"		=>$v[$data_base_config["prefix"]."category"]["cat_id"]+$category_num["Category"]["id"],
				"parent_id"	=>$v[$data_base_config["prefix"]."category"]["parent_id"]==0?$v[$data_base_config["prefix"]."category"]["parent_id"]:$v[$data_base_config["prefix"]."category"]["parent_id"]+$category_num["Category"]["id"],
				"type"		=>"P",
				"orderby"	=>$v[$data_base_config["prefix"]."category"]["sort_order"],
				"status"	=>$v[$data_base_config["prefix"]."category"]["is_show"]
			);
			$this->Category->saveAll(array("Category"=>$category));
			foreach($this->languages as $lk=>$lv){
			$categoryI18n = array(
				"locale"			=>$lv["Language"]["locale"],
				"category_id"		=>$this->Category->getLastInsertId(),
				"name"				=>$v[$data_base_config["prefix"]."category"]["cat_name"],
				"meta_keywords"		=>$v[$data_base_config["prefix"]."category"]["keywords"],
				"meta_description"	=>$v[$data_base_config["prefix"]."category"]["cat_desc"],
			);
			$this->CategoryI18n->saveAll(array("CategoryI18n"=>$categoryI18n));
			}
		}
		return $category_num["Category"]["id"];
	}
	//文章分类导入
	function ecshop_import_article_category(){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;
		//分类导入
		$sql = "select * from ".$data_base_config["prefix"]."article_cat";
		$ecshop_article_category_list = $db->query($sql);
		$this->Category->hasOne = array();
		$category_num = $this->Category->find("first",array("order"=>"id desc"));
		
		foreach( $ecshop_article_category_list as $k=>$v ){
			$category = array(
				"id"		=>$v[$data_base_config["prefix"]."article_cat"]["cat_id"]+$category_num["Category"]["id"],
				"parent_id"	=>$v[$data_base_config["prefix"]."article_cat"]["parent_id"]==0?$v[$data_base_config["prefix"]."article_cat"]["parent_id"]:$v[$data_base_config["prefix"]."article_cat"]["parent_id"]+$category_num["Category"]["id"],
				"type"		=>"A",
				"orderby"	=>$v[$data_base_config["prefix"]."article_cat"]["sort_order"]
			);
			$this->Category->saveAll(array("Category"=>$category));
			foreach($this->languages as $lk=>$lv){
			$categoryI18n = array(
				"locale"			=>$lv["Language"]["locale"],
				"category_id"		=>$this->Category->getLastInsertId(),
				"name"				=>$v[$data_base_config["prefix"]."article_cat"]["cat_name"],
				"meta_keywords"		=>$v[$data_base_config["prefix"]."article_cat"]["keywords"],
				"meta_description"	=>$v[$data_base_config["prefix"]."article_cat"]["cat_desc"],
			);
			$this->CategoryI18n->saveAll(array("CategoryI18n"=>$categoryI18n));
			}
		}
		return $category_num["Category"]["id"];
	}
	
	//品牌导入
	function ecshop_import_brand(){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;		
		//品牌导入
		$this->Brand->hasOne=array();
		$brand_info = $this->Brand->find("first",array("order"=>"id desc"));
		$sql = "select * from ".$data_base_config["prefix"]."brand";
		$ecshop_brand_list = $db->query($sql);
		foreach( $ecshop_brand_list as $k=>$v ){
			$brand = array(
				"id"		=>	$v[$data_base_config["prefix"]."brand"]["brand_id"]+$brand_info["Brand"]["id"],
				"orderby"	=>	$v[$data_base_config["prefix"]."brand"]["sort_order"],
				"status"	=>	$v[$data_base_config["prefix"]."brand"]["is_show"],
				"url"		=>	$v[$data_base_config["prefix"]."brand"]["site_url"],
				"img01"		=>	$v[$data_base_config["prefix"]."brand"]["brand_logo"]
			);
			$this->Brand->saveAll(array("Brand"=>$brand));
			foreach($this->languages as $lk=>$lv){
				$brandi18n = array(
					"locale"		=>	$lv["Language"]["locale"],
					"brand_id"		=>	$this->Brand->getLastInsertId(),
					"name"			=>	$v[$data_base_config["prefix"]."brand"]["brand_name"],
					"description"	=>	$v[$data_base_config["prefix"]."brand"]["brand_desc"]
				);
				$this->BrandI18n->saveAll(array("BrandI18n"=>$brandi18n));
			}
		}
		return $brand_info["Brand"]["id"];
	}
	
	//商品导入
	function ecshop_import_goods($category_id,$brand_id){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;
		$this->Product->hasOne=array();
		$product_info = $this->Product->find("first",array("order"=>"id desc"));
		$sql = "select * from ".$data_base_config["prefix"]."goods";
		$ecshop_goods_list = $db->query($sql);
		foreach( $ecshop_goods_list as $k=>$v ){
			$product = array(
				"id"				=>	$v[$data_base_config["prefix"]."goods"]["goods_id"]+$product_info["Product"]["id"],
				"brand_id"			=>	$v[$data_base_config["prefix"]."goods"]["brand_id"]==0?$v[$data_base_config["prefix"]."goods"]["brand_id"]:$v[$data_base_config["prefix"]."goods"]["brand_id"]+$brand_id,
				"category_id"		=>	$v[$data_base_config["prefix"]."goods"]["cat_id"]==0?$v[$data_base_config["prefix"]."goods"]["cat_id"]:$v[$data_base_config["prefix"]."goods"]["cat_id"]+$category_id,
				"code"				=>	$v[$data_base_config["prefix"]."goods"]["goods_sn"],
				"product_name_style"=>	$v[$data_base_config["prefix"]."goods"]["goods_name_style"],
				"img_thumb"			=>	$v[$data_base_config["prefix"]."goods"]["goods_thumb"],
				"img_detail"		=>	$v[$data_base_config["prefix"]."goods"]["goods_img"],
				"img_original"		=>	$v[$data_base_config["prefix"]."goods"]["original_img"],
				"admin_id"			=>	$_SESSION["Operator_Info"]["Operator"]["id"],
				"alone"				=>	$v[$data_base_config["prefix"]."goods"]["is_alone_sale"],
				"forsale"			=>	$v[$data_base_config["prefix"]."goods"]["is_on_sale"],
				"status"			=>	$v[$data_base_config["prefix"]."goods"]["is_delete"]==0?1:2,
				"weight"			=>	$v[$data_base_config["prefix"]."goods"]["goods_weight"],
				"market_price"		=>	$v[$data_base_config["prefix"]."goods"]["market_price"],
				"shop_price"		=>	$v[$data_base_config["prefix"]."goods"]["shop_price"],
				"promotion_price"	=>	$v[$data_base_config["prefix"]."goods"]["promote_price"],
				"promotion_start"	=>	$v[$data_base_config["prefix"]."goods"]["promote_start_date"],
				"promotion_end"		=>	$v[$data_base_config["prefix"]."goods"]["promote_end_date"],
				"point"				=>	$v[$data_base_config["prefix"]."goods"]["give_integral"],
				"point_fee"			=>	$v[$data_base_config["prefix"]."goods"]["integral"],
				"view_stat"			=>	$v[$data_base_config["prefix"]."goods"]["click_count"],
				//"sale_stat"=>$v[$data_base_config["prefix"]."goods"]["promote_price"],
				"quantity"			=>	$v[$data_base_config["prefix"]."goods"]["goods_number"],
				"extension_code"	=>	$v[$data_base_config["prefix"]."goods"]["extension_code"],
			);
			$this->Product->saveAll(array("Product"=>$product));
			foreach($this->languages as $lk=>$lv){
			$producti18n = array(
				"locale"			=>	$lv["Language"]["locale"],
				"product_id"		=>	$this->Product->getLastInsertId(),
				"name"				=>	$v[$data_base_config["prefix"]."goods"]["goods_name"],
				"description"		=>	$v[$data_base_config["prefix"]."goods"]["goods_desc"],
				"market_price"		=>	$v[$data_base_config["prefix"]."goods"]["market_price"],
				"shop_price"		=>	$v[$data_base_config["prefix"]."goods"]["shop_price"],
				"meta_description"	=>	$v[$data_base_config["prefix"]."goods"]["goods_brief"],
				"meta_keywords"		=>	$v[$data_base_config["prefix"]."goods"]["keywords"]
			);
			$this->ProductI18n->saveAll(array("ProductI18n"=>$producti18n));
			}
		}
		return $product_info["Product"]["id"];
	}
	
	//文章导入
	function ecshop_import_article($cat_id){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;
		$this->Article->hasOne=array();
		$article_info = $this->Article->find("first",array("order"=>"id desc"));
		$sql = "select * from ".$data_base_config["prefix"]."article";
		$ecshop_article_list = $db->query($sql);
		
		foreach( $ecshop_article_list as $k=>$v ){
			$article = array(
				"id"=>$v[$data_base_config["prefix"]."article"]["article_id"]+$article_info["Article"]["id"],
				"category_id"=>$v[$data_base_config["prefix"]."article"]["cat_id"]+$cat_id,
				"author_email"=>$v[$data_base_config["prefix"]."article"]["author_email"],
				"file_url"=>$v[$data_base_config["prefix"]."article"]["file_url"],
				"status"=>$v[$data_base_config["prefix"]."article"]["is_open"],
				"importance"=>$v[$data_base_config["prefix"]."article"]["article_type"],
			);
			$this->Article->saveAll(array("Article"=>$article));
			foreach($this->languages as $lk=>$lv){
			$articlei18n = array(
				"locale"=>$lv["Language"]["locale"],
				"article_id"=>$this->Article->getLastInsertId(),
				"title"=>$v[$data_base_config["prefix"]."article"]["title"],
				"meta_keywords"=>$v[$data_base_config["prefix"]."article"]["keywords"],
				"content"=>$v[$data_base_config["prefix"]."article"]["content"],
				"author"=>$v[$data_base_config["prefix"]."article"]["author"],
				"meta_keywords"=>$v[$data_base_config["prefix"]."article"]["keywords"],
			);
			$this->ArticleI18n->saveAll(array("ArticleI18n"=>$articlei18n));
			}

		}
	}
	
	
	//订单导入
	function ecshop_import_order($user_id){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;
		$this->Order->hasOne=array();
		$this->Order->hasMany=array();
		$order_info = $this->Order->find("first",array("order"=>"id desc"));
		$sql = "select * from ".$data_base_config["prefix"]."order_info";
		$ecshop_order_info_list = $db->query($sql);
		foreach( $ecshop_order_info_list as $k=>$v ){
			$order = array(
				"id"				=>	$v[$data_base_config["prefix"]."order_info"]["order_id"]+$order_info["Order"]["id"],
				"order_code"		=>	$v[$data_base_config["prefix"]."order_info"]["order_sn"],
				"user_id"			=>	$v[$data_base_config["prefix"]."order_info"]["user_id"]+$user_id,
				"status"			=>	$v[$data_base_config["prefix"]."order_info"]["order_status"],
				"shipping_id"		=>	$v[$data_base_config["prefix"]."order_info"]["shipping_id"],
				"shipping_name"		=>	$v[$data_base_config["prefix"]."order_info"]["shipping_name"],
				"shipping_status"	=>	$v[$data_base_config["prefix"]."order_info"]["shipping_status"],
				"shipping_time"		=>	$v[$data_base_config["prefix"]."order_info"]["shipping_time"],
				"shipping_fee"		=>	$v[$data_base_config["prefix"]."order_info"]["shipping_fee"],
				"point_fee"			=>	$v[$data_base_config["prefix"]."order_info"]["integral_money"],
				"point_use"			=>	$v[$data_base_config["prefix"]."order_info"]["integral"],
				"payment_id"		=>	$v[$data_base_config["prefix"]."order_info"]["pay_id"],
				"payment_name"		=>	$v[$data_base_config["prefix"]."order_info"]["pay_name"],
				"payment_status"	=>	$v[$data_base_config["prefix"]."order_info"]["pay_status"],
				"payment_time"		=>	$v[$data_base_config["prefix"]."order_info"]["pay_time"],
				"payment_fee"		=>	$v[$data_base_config["prefix"]."order_info"]["pay_fee"],
				"coupon_id"			=>	$v[$data_base_config["prefix"]."order_info"]["bonus_id"],
				"consignee"			=>	$v[$data_base_config["prefix"]."order_info"]["consignee"],
				"address"			=>	$v[$data_base_config["prefix"]."order_info"]["address"],
				"zipcode"			=>	$v[$data_base_config["prefix"]."order_info"]["zipcode"],
				"telephone"			=>	$v[$data_base_config["prefix"]."order_info"]["tel"],
				"mobile"			=>	$v[$data_base_config["prefix"]."order_info"]["mobile"],
				"email"				=>	$v[$data_base_config["prefix"]."order_info"]["email"],
				"best_time"			=>	$v[$data_base_config["prefix"]."order_info"]["best_time"],
				"sign_building"		=>	$v[$data_base_config["prefix"]."order_info"]["sign_building"],
				"postscript"		=>	$v[$data_base_config["prefix"]."order_info"]["postscript"],
				"money_paid"		=>	$v[$data_base_config["prefix"]."order_info"]["money_paid"],
				"discount"			=>	$v[$data_base_config["prefix"]."order_info"]["discount"],
				"total"				=>																	//订单总金额=
										$v[$data_base_config["prefix"]."order_info"]["goods_amount"]	//商品总金额
										-$v[$data_base_config["prefix"]."order_info"]["discount"]		//折扣
										+$v[$data_base_config["prefix"]."order_info"]["tax"]			//发票税额
										+$v[$data_base_config["prefix"]."order_info"]["shipping_fee"]   //配送费用
										+$v[$data_base_config["prefix"]."order_info"]["insure_fee"]   	//保价费用
										+$v[$data_base_config["prefix"]."order_info"]["pay_fee"]   		//支付费用
										+$v[$data_base_config["prefix"]."order_info"]["pack_fee"]   	//包装费用
										+$v[$data_base_config["prefix"]."order_info"]["card_fee"]   	//贺卡费用
										,
				"subtotal"			=>	$v[$data_base_config["prefix"]."order_info"]["goods_amount"],
				"from_ad"			=>	$v[$data_base_config["prefix"]."order_info"]["from_ad"],
				"referer"			=>	$v[$data_base_config["prefix"]."order_info"]["referer"],
				"tax"				=>	$v[$data_base_config["prefix"]."order_info"]["tax"],
				"insure_fee"		=>	$v[$data_base_config["prefix"]."order_info"]["insure_fee"],
				"pack_fee"			=>	$v[$data_base_config["prefix"]."order_info"]["pack_fee"],
				"card_fee"			=>	$v[$data_base_config["prefix"]."order_info"]["card_fee"],
				"invoice_type"		=>	$v[$data_base_config["prefix"]."order_info"]["inv_type"],
				"invoice_payee"		=>	$v[$data_base_config["prefix"]."order_info"]["inv_payee"],
				"invoice_content"	=>	$v[$data_base_config["prefix"]."order_info"]["inv_content"],
				"how_oos"			=>	$v[$data_base_config["prefix"]."order_info"]["how_oos"],
				"pack_name"			=>	$v[$data_base_config["prefix"]."order_info"]["pack_name"],
				"card_name"			=>	$v[$data_base_config["prefix"]."order_info"]["card_name"],
				"card_message"		=>	$v[$data_base_config["prefix"]."order_info"]["card_message"],
				"to_buyer"			=>	$v[$data_base_config["prefix"]."order_info"]["to_buyer"],
				"confirm_time"		=>	$v[$data_base_config["prefix"]."order_info"]["confirm_time"]
			);
			$this->Order->saveAll(array("Order"=>$order));
		}
		return $order_info["Order"]["id"];

	}
	
	//ecshop订单商品导入
	function ecshop_import_order_goods($order_id,$goods_id){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;
		$sql = "select * from ".$data_base_config["prefix"]."order_goods";
		$ecshop_order_goods_list = $db->query($sql);
		foreach( $ecshop_order_goods_list as $k=>$v ){
			$order_product = array(
				"order_id"=>$v[$data_base_config["prefix"]."order_goods"]["order_id"]+$order_id,
				"product_id"=>$v[$data_base_config["prefix"]."order_goods"]["goods_id"]+$goods_id,
				"product_name"=>$v[$data_base_config["prefix"]."order_goods"]["goods_name"],
				"product_code"=>$v[$data_base_config["prefix"]."order_goods"]["goods_sn"],
				"product_quntity"=>$v[$data_base_config["prefix"]."order_goods"]["goods_number"],
				"product_price"=>$v[$data_base_config["prefix"]."order_goods"]["goods_price"],
				"product_attrbute"=>$v[$data_base_config["prefix"]."order_goods"]["goods_attr"],
				"extension_code"=>$v[$data_base_config["prefix"]."order_goods"]["extension_code"],
				"send_quntity"=>$v[$data_base_config["prefix"]."order_goods"]["send_number"]
			);
			$this->OrderProduct->saveAll(array("OrderProduct"=>$order_product));
		}
	}
	
	//会员导入
	function ecshop_import_users(){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;		
		//会员导入
		$this->User->hasOne=array();
		$user_info = $this->User->find("first",array("order"=>"id desc"));
		$sql = "select * from ".$data_base_config["prefix"]."users";
		$ecshop_users_list = $db->query($sql);
		foreach( $ecshop_users_list as $k=>$v ){
			$users = array(
				"id"			=>	$v[$data_base_config["prefix"]."users"]["user_id"]+$user_info["User"]["id"],
				"locale"		=>	"chi",
				"name"			=>	$v[$data_base_config["prefix"]."users"]["user_name"],
				"password"		=>	$v[$data_base_config["prefix"]."users"]["password"],
				"email"			=>	$v[$data_base_config["prefix"]."users"]["email"],
				"question"		=>	$v[$data_base_config["prefix"]."users"]["question"],
				"answer"		=>	$v[$data_base_config["prefix"]."users"]["answer"],
				"balance"		=>	$v[$data_base_config["prefix"]."users"]["user_money"],
				"frozen"		=>	$v[$data_base_config["prefix"]."users"]["frozen_money"],
				"point"			=>	$v[$data_base_config["prefix"]."users"]["pay_points"],
				"user_point"	=>	$v[$data_base_config["prefix"]."users"]["rank_points"],
				"login_times"	=>	$v[$data_base_config["prefix"]."users"]["visit_count"],
				"login_ipaddr"	=>	$v[$data_base_config["prefix"]."users"]["last_ip"],
				"rank"	=>	$v[$data_base_config["prefix"]."users"]["user_rank"],
				"birthday"	=>	$v[$data_base_config["prefix"]."users"]["birthday"],
				"sex"	=>	$v[$data_base_config["prefix"]."users"]["sex"]
			);
			$this->User->saveAll(array("User"=>$users));
		}
		return $user_info["User"]["id"];
	}
	//优惠价导入
	function ecshop_import_volume_price($product_id){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;		
		//优惠价导入
		$sql = "select * from ".$data_base_config["prefix"]."volume_price";
		$ecshop_volume_price_list = $db->query($sql);
		foreach( $ecshop_volume_price_list as $k=>$v ){
			$volume_price = array(
				"product_id"		=>	$v[$data_base_config["prefix"]."volume_price"]["goods_id"]+$product_id,
				"volume_number"		=>	$v[$data_base_config["prefix"]."volume_price"]["volume_number"],
				"volume_price"		=>	$v[$data_base_config["prefix"]."volume_price"]["volume_price"]
			);
			$this->ProdcutVolume->saveAll(array("ProdcutVolume"=>$volume_price));
		}
		return true;

	}
	//商品属性导入
	function ecshop_import_attribute($product_type_id){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;		
		//品牌导入
		$this->ProductTypeAttribute->hasOne=array();
		$producttypeattribute_info = $this->ProductTypeAttribute->find("first",array("order"=>"id desc"));
		$sql = "select * from ".$data_base_config["prefix"]."attribute";
		$ecshop_attribute_list = $db->query($sql);
		foreach( $ecshop_attribute_list as $k=>$v ){
			$attribute = array(
				"product_type_id"=>$v[$data_base_config["prefix"]."attribute"]["cat_id"]+$product_type_id,
				"attr_value"	=>	$v[$data_base_config["prefix"]."attribute"]["attr_values"],
				"orderby"	=>	$v[$data_base_config["prefix"]."attribute"]["sort_order"],
				"attr_input_type"	=>	$v[$data_base_config["prefix"]."attribute"]["attr_input_type"],
				"attr_type"	=>	$v[$data_base_config["prefix"]."attribute"]["attr_type"]
			);
			$this->ProductTypeAttribute->saveAll(array("ProductTypeAttribute"=>$attribute));
			foreach($this->languages as $lk=>$lv){
				$attributei18n = array(
					"locale"						=>	$lv["Language"]["locale"],
					"product_type_attribute_id"		=>	$this->ProductTypeAttribute->getLastInsertId(),
					"name"							=>	$v[$data_base_config["prefix"]."attribute"]["attr_name"]
				);
				$this->ProductTypeAttributeI18n->saveAll(array("ProductTypeAttributeI18n"=>$attributei18n));
			}
		}
		return $producttypeattribute_info["ProductTypeAttribute"]["id"];

	}
	//商品类型导入
	function ecshop_import_goods_type(){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;		
		//商品类型导入
		$this->ProductType->hasOne=array();
		$ProductType_info = $this->ProductType->find("first",array("order"=>"id desc"));
		$sql = "select * from ".$data_base_config["prefix"]."goods_type";
		$ecshop_goods_type_list = $db->query($sql);
		foreach( $ecshop_goods_type_list as $k=>$v ){
			$ProductType = array(
				"group_code"	=>	$v[$data_base_config["prefix"]."goods_type"]["attr_group"],
				"status"	=>	$v[$data_base_config["prefix"]."goods_type"]["enabled"],
				"orderby"	=>	"50"
			);
			$this->ProductType->saveAll(array("ProductType"=>$ProductType));
			foreach($this->languages as $lk=>$lv){
				$ProductTypeI18n = array(
					"locale" 	=>	$lv["Language"]["locale"],
					"type_id"	=>	$this->ProductType->getLastInsertId(),
					"name"		=>	$v[$data_base_config["prefix"]."goods_type"]["cat_name"]
				);
				$this->ProductTypeI18n->saveAll(array("ProductTypeI18n"=>$ProductTypeI18n));
			}
		}
		return $ProductType_info["ProductType"]["id"];

	}
	//商品属性关联
	function ecshop_import_goods_attr($product_id,$product_type_attribute_id){
		$db =& ConnectionManager::getDataSource('ecshop');
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;		
		//商品类型导入
		$this->ProductAttribute->hasOne=array();
		$ProductAttribute_info = $this->ProductAttribute->find("first",array("order"=>"id desc"));
		$sql = "select * from ".$data_base_config["prefix"]."goods_attr";
		$ecshop_goods_attr_list = $db->query($sql);
		foreach( $ecshop_goods_attr_list as $k=>$v ){
			$ProductAttribute = array(
				"product_id"	=>	$v[$data_base_config["prefix"]."goods_attr"]["goods_id"]+$product_id,
				"product_type_attribute_id"	=>	$v[$data_base_config["prefix"]."goods_attr"]["attr_id"]+$product_type_attribute_id,
				"product_type_attribute_value"	=>	$v[$data_base_config["prefix"]."goods_attr"]["attr_value"],
				"product_type_attribute_price"	=>empty($v[$data_base_config["prefix"]."goods_attr"]["attr_price"])?"0":$v[$data_base_config["prefix"]."goods_attr"]["attr_price"],
			);
			$this->ProductAttribute->saveAll(array("ProductAttribute"=>$ProductAttribute));
		}
		return $ProductAttribute_info["ProductAttribute"]["id"];

	}
	function category_change($product_type_id){
		$db =& ConnectionManager::getDataSource('ecshop');
		include_once(ROOT."cake/libs/model/model.php");
		$data_base_config = new DATABASE_CONFIG();
		$data_base_config = $data_base_config->ecshop;
		$sql = "select * from ".$data_base_config["prefix"]."category ";
		$cat_info = $db->query($sql);
		pr($cat_info);
	}
}

?>
