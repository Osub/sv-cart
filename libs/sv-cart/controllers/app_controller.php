<?php
/*****************************************************************************
 * SV-Cart 前台控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: app_controller.php 5493 2009-11-03 10:47:49Z huangbo $
*****************************************************************************/
class AppController extends Controller {
	var $view = 'Theme'; 
	var $locale = '';
	var $currencie = '';
	var $lang = '';
	var $useDbConfig = 'default';
	var $information_info = array();
//	var $lang_dictionarie = '';
	var $helpers = array('Html','Javascript','Form','Svshow','Minify','Cache');
	var $uses = array('Plugin','Language','Config','Navigation','Brand','Category','Article','LanguageDictionary','Template','Link','Product','Currency','SystemResource','User','InformationResource','Advertisement','AdvertisementI18n','AdvertisementPosition','Domain');
	var $configs = array();
	var $languages = array();
	var $affiliate_config = array();
	var $navigations = array();
	var $components = array('RequestHandler','Cookie','Session');

	function beforeFilter(){
		$this->Session->path='/';
		//echo $this->base;die();
		/* rewrite 模块关闭特殊处理webroot */
		$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		$this->server_host = "http://".$host;
    	if(Configure::read('App.baseUrl')){
        	$this->webroot = $webroot = str_replace("index.php","",$this->base);
        	$this->root_all = $this->webroot;//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/index.php/';
        	$this->user_webroot = $this->root_all . 'user/index.php/';
        	$this->cart_webroot = $this->root_all . 'index.php/';
        }
        else{
        	$this->root_all = $this->webroot;//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/';
        	$this->user_webroot = $this->root_all . 'user/';
        	$this->cart_webroot = $this->root_all;
        }


        $this->set('root_all',$this->root_all);
        $this->set('server_host',$this->server_host);
        $this->set('admin_webroot',$this->admin_webroot);
        $this->set('user_webroot',$this->user_webroot);
        $this->set('cart_webroot',$this->cart_webroot);
        
		//pr($this->user_webroot);
		//读取语言
		$cookie_locale = $this->Cookie->read('locale');
	//	pr($_COOKIE);exit;
		$this->locale = $this->Session->read('Config.locale');
		$SVlanguages = $this->Language->findalllang();
		$this->set('languages',$SVlanguages);
		if(isset($_GET['locale'])){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['locale'] == $_GET['locale']){
					$this->locale = $_GET['locale'];
					$this->Cookie->write('locale',$_GET['locale']);
					$this->Session->write('Config.locale',$_GET['locale']);
				}
			}	
		}elseif(isset($cookie_locale) && $cookie_locale != $this->Session->read('Config.locale')){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['locale'] == $cookie_locale){
					$this->locale = $cookie_locale;
					$this->Session->write('Config.locale',$cookie_locale);
			//		$this->Session->write('Config.language',$cookie_locale);
					$this->Cookie->write('locale',$this->locale);
				}
			}
		}else if($this->locale == ""){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['is_default'] == 1){
					$this->locale = $v['Language']['locale'];
				}
			}
			$this->Cookie->write('locale',$this->locale);
			$this->Session->write('Config.locale',$this->locale);
		}
		/* 新增域名表 */
		$domains = $this->Domain->cache_find('first',array('conditions'=>array('Domain.status'=>1,'Domain.domain'=>$host)),'domains');
		if(!empty($domains)){
			$this->locale= $domains['Domain']['locale'];
			$this->Cookie->write('locale',$this->locale);
			$this->Session->write('Config.locale',$this->locale);
		}
		//商店配置
		$this->Config->set_locale($this->locale);
		$this->configs = $this->Config->getformatcode($this->locale);
		//商店是否关闭
		if($this->params['action'] !="closed"){
			if($this->configs['shop_temporal_closed'] == 1){
				$this->redirect('/closed');
				exit;
			}
		}
		
		//多货币
		if(isset($this->configs['currencies_setting']) && $this->configs['currencies_setting'] == 1){
			 $currencies = $this->Currency->cache_find('all',array('conditions'=>array('Currency.status'=>1)),'currencies');
			 $this->data['currencies'] = array();
			 if(isset($currencies) && sizeof($currencies)>0){
			 	foreach($currencies as $k=>$v){
			 		if(isset($v['CurrencyI18n']) && sizeof($v['CurrencyI18n'])>0){
			 			foreach($v['CurrencyI18n'] as $kk=>$vv){
			 				if($vv['status'] == '1'){
			 				$this->data['currencies'][$v['Currency']['code']][$vv['locale']] = array('Currency'=>array(
			 																											'code'=> $v['Currency']['code'],
			 																											'name'=> $vv['name'],
			 																											'format'=> $vv['format'],
			 																											'rate'=> $v['Currency']['rate'],
			 																											'is_default'=> $v['Currency']['is_default']
																								));
							}
			 			}
			 		}
			 	}

			 	
			 	
			 	$this->currencie = $this->Session->read('currencies');
				$cookie_currencie = $this->Cookie->read('currencies');
			 	if(!isset($this->data['currencies'][$this->currencie]) || !isset($this->data['currencies'][$this->currencie][$this->locale])){
			 		$this->currencie = "";
			 		unset($cookie_currencie);
			 	}				
				
			 	if(isset($cookie_currencie) && $cookie_currencie != $this->currencie){
				 	foreach($this->data['currencies'] as $k=>$v){
				 		if($k == $cookie_currencie){
			 				$this->currencie = $cookie_currencie;
							$this->Session->write('currencies',$cookie_currencie);
							$this->Cookie->write('currencies',$cookie_currencie);
				 		}
				 	}			 		
			 	}elseif($this->currencie == ""){
					foreach($this->data['currencies'] as $k=>$v){
			 			if(isset($v[$this->locale]) && $v[$this->locale]['Currency']['is_default'] == 1){
			 				$this->currencie = $k;
							$this->Session->write('currencies',$k);
							$this->Cookie->write('currencies',$k);	
						}											
					}			 		
			 	}
			 	
				if($this->currencie == ""){
					foreach($this->data['currencies'] as $k=>$v){
			 			if(isset($v[$this->locale])){
			 				$this->currencie = $k;
							$this->Session->write('currencies',$k);
							$this->Cookie->write('currencies',$k);	
						}											
					}			 		
			 	}			 	
			 	
			 }
		}
	/*	$this->currencie = 'chi';
		$this->Session->write('currencies','chi');
		$this->Cookie->write('currencies','chi');
	*/	
		// 判断未登录用户
		if(isset($this->configs['access_right']) && $this->configs['access_right'] == 1){
			if(!isset($_SESSION['User'])){
				$this->redirect('/user/login');
				exit;
			}
		}		
		
		//单独运费 sku 地区语言价
		if(!isset($this->configs['use_product_shipping_fee'])){
			$this->configs['use_product_shipping_fee'] = 0;
		}
		if(!isset($this->configs['mlti_currency_module'])){
			$this->configs['mlti_currency_module'] = 0;
		}
		if(!isset($this->configs['use_sku'])){
			$this->configs['use_sku'] = 0;
		}
		$this->set('SVConfigs',$this->configs);
		//取完config 设置商店配置
		$time_zone = @include ROOT."time_zone.php";
		ini_set('date.timezone',$time_zone[$this->configs['default_timezone']]);
		unset($time_zone);
		/*
		字典语言
		*/		
		$this->languages = $this->LanguageDictionary->getformatcode($this->locale);
		
		
		$this->data['languages'] = $this->languages;
        $this->data['root_all'] = $this->root_all;
        $this->data['server_host'] = $this->server_host;
        $this->data['admin_webroot'] = $this->admin_webroot;
        $this->data['user_webroot'] = $this->user_webroot;
        $this->data['cart_webroot'] = $this->cart_webroot;
       	$this->data['language_locale'] = $SVlanguages;
		$this->data['configs'] = $this->configs;		
        $this->SystemResource->set_locale($this->locale);
        $this->systemresource_info = $this->SystemResource->resource_formated(true,$this->locale);
        $this->InformationResource->set_locale($this->locale);
        $this->information_info = $this->InformationResource->information_formated(true,$this->locale);
        $this->set('information_info',$this->information_info);
        $this->set('systemresource_info',$this->systemresource_info);
    //    pr($this->systemresource_info);
		$this->set('SCLanguages',$this->languages);
		
		//官网文章导航
		$this->Category->set_locale($this->locale);
		$navigate = $this->Category->tree('A',0,$this->locale);
//		pr($navigate['tree']);
		$this->set('articles_tree',$navigate['tree']);
		
		//友情链接
		//快速搜索图片大小
		if(isset($this->configs['search_autocomplete_image_height'])){
			$search_autocomplete_image = array("search_autocomplete_image_height"=>$this->configs['search_autocomplete_image_height'],
						"search_autocomplete_image_width" => $this->configs['search_autocomplete_image_width'],
						"page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']
			);
			$this->set("search_autocomplete_image",$search_autocomplete_image);
		}

		// 订单来源
		if(isset($_SERVER['HTTP_REFERER'])){
			$referer_arr =array();
			$referer_arr = explode('/',$_SERVER['HTTP_REFERER']);
			$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
			if(!in_array($host,$referer_arr)){
				$this->Cookie->write('referer',$_SERVER['HTTP_REFERER'],false,time()+3600 * 24 * 365);
			}
		}
		//字母检索
		$alp=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
   		$this->set('alp',$alp);	
   		unset($_SESSION['back_url']);
		$this->set('dlocal',$this->locale);
		
		//商品数		
		
		$cache_key = md5('find_page_affiliate'.'_'.$this->locale);
		
		$affiliate_config = cache::read($cache_key);	
		if(!$affiliate_config){
			$this->Config->hasOne=array();
			$this->Config->hasMany=array('ConfigI18n' =>   
	                        array('className'    => 'ConfigI18n',
	                        	'conditions'    =>  '',   
	                              'order'        => '',   
	                              'dependent'    =>  true,   
	                              'foreignKey'   => 'config_id'  
	                        )   
	                  );
			$affiliate_config = $this->Config->findByCode("affiliate");//取推荐信息
			foreach( $affiliate_config["ConfigI18n"] as $k=>$v ){
			//	$affiliate_config["ConfigI18n"][$v["locale"]] = $v;//设置语言
				if($v['value'] != ""){
					$affiliate_config["ConfigI18n"][$this->locale] = $v;//设置语言
					$affiliate_config["ConfigI18n"][$this->locale]['value'] =  unserialize($v["value"]);//返序列化
				}					
			}
		//	foreach( $affiliate_config["ConfigI18n"] as $k=>$v ){
		//		$v["value"] = unserialize($v["value"]);//返序列化
		//		$affiliate_config["ConfigI18n"][$v["locale"]] = $v;
		//	}
			
			cache::write($cache_key,$affiliate_config);
			
			//重关联
			$this->Config->hasMany=array();
			$this->Config->hasOne=array('ConfigI18n' =>   
		                       array('className'    => 'ConfigI18n',
		                       	'conditions'    =>  '',   
		                             'order'        => 'Config.id',   
		                             'dependent'    =>  false,   
		                             'foreignKey'   => 'config_id'  
		                       )   
		                 );		
		
		}
		$this->affiliate_config = $affiliate_config;
		// 推荐 分成
		if(isset($_GET['u'])){
			$is_user = $this->User->findbyid($_GET['u']);
			if(isset($is_user['User'])){
			//	$affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire'];
			//	$affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'];
				if( $affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "hour"){
					$save_time = $affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60;
				}
				if( $affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "day"){
					$save_time = $affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60*24;
				}
				if( $affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "week"){
					$save_time = $affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60*24*7;
				}				
				$this->Cookie->write('affiliate_uid',$_GET['u'],false,time()+$save_time);
			}
		}	
		/*
		 $this->Category->bindModel(array(
			 'hasOne' => array(
			 'Product' => array(
			 'className' => 'Product',
			 'foreignKey' => false,
			 'conditions' => array('Category.id = Product.category_id')
		 ))));
		
		$categorie_test = $this->Category->find('count',array('conditions'=>array('Category.type'=>'P','Product.category_id = Category.id'),'group'=>array('Category.id','Product.id')),'Category_all_product_time_'.$this->locale);
		*/
		/*
		 $this->Product->bindModel(array(
			 'hasOne' => array(
			 'Product' => array(
			 'className' => 'Category',
			 'foreignKey' => false,
			 'conditions' => array('Category.id = Product.category_id')
		 ))));		
		$categorie_test = $this->Product->cache_find('list',array('conditions'=>array('1=1'),'group'=>array('Product.id','Category.id')),'Category_all_product_time_'.$this->locale);
		pr($categorie_test);
		
		*/
		
		//所有有效的广告
		$this->Advertisement->set_locale($this->locale);
		$this->data['advertisement_list'] = $this->Advertisement->get_all($this);

	//	pr($this->data['currencies']);
	}

	function full_page_init(){
		$this->Navigation->set_locale($this->locale);
 		$this->set('navigations',$this->Navigation->get_types($this->locale));
 		$this->navigations[0]=array('name'=>$this->languages['home'],'url'=>"/");
		//商品分类
 		$this->Category->set_locale($this->locale);
 		$category_tree = $this->Category->tree('P',0,$this->locale,$this);
 		$this->set('categories_tree', $this->Category->allinfo['tree']);
 		$this->set('categories', $this->Category->allinfo['assoc']);
 		$this->Brand->set_locale($this->locale);
 		$this->set('brands',$this->Brand->findassoc($this->locale));
 		
 		if(isset($this->configs['show_brand_by_category']) && $this->configs['show_brand_by_category'] == "1"){
	 		 $this->Product->hasOne = array();
			 $this->Product->bindModel(array(
				 'hasOne' => array(
					 'Brand' => array(
					 'className' => 'Brand',
					 'foreignKey' => false,
					 'conditions' => array('Brand.id = Product.brand_id')
					),
					 'BrandI18n' => array(
					 'className' => 'BrandI18n',
					 'foreignKey' => false,
					 'conditions' => array('BrandI18n.brand_id = Product.brand_id',"BrandI18n.locale = '".$this->locale."'")
					)
			 	)),false);
			
	 		//$all_category_brand = $this->Product->cache_find('list',array('conditions'=>array('Product.category_id'=>$category_tree['all_ids']),'fields'=>array('Product.id','Product.brand_id','Product.category_id')),'all_category_brand_'.$this->locale);
	 		$all_category_brand_list = $this->Product->cache_find('all',array('conditions'=>array('Product.status'=>1,'Product.forsale'=>1,'Brand.status'=>1,'Product.brand_id > '=>0,'Product.category_id <>'=>0),'order'=>array('Brand.orderby ASC','BrandI18n.name ASC'),'group'=>array('Product.brand_id','Brand.id','Product.category_id'),'fields'=>array('Product.brand_id','Product.category_id')),'all_category_brand_'.$this->locale);
	 		
	 		$this->Product->hasOne = array(
							'ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) 
                 	   );
	 		
	 		$all_category_brand = array();
	 		if(isset($all_category_brand_list) && sizeof($all_category_brand_list)>0){
	 			foreach($all_category_brand_list as $k=>$v){
	 				$all_category_brand[$v['Product']['category_id']][] = $v['Product']['brand_id'];
	 			}
	 		}
	 		if(isset($all_category_brand) && sizeof($all_category_brand)>0){
	 			foreach($all_category_brand as $k=>$v){
	 				$all_category_brand[$k]  = array_unique($all_category_brand[$k]);
	 			}
	 			$this->set('all_category_brand',$all_category_brand);
	 		}
		}
	}
	
	function page_init(){
		// 商品销售排行
		$condition = '1=1';
		if(isset($this->configs['product_top_number']) && isset($this->configs['use_product_top']) && $this->configs['use_product_top'] == 1 && $this->configs['product_top_number']>0){
			$condition = "1=1";
			$condition .= " and Product.status ='1' and Product.forsale = '1'" ;
			$this->Product->set_locale($this->locale);
			$top_products=$this->Product->top_products($this->locale,$this->configs['product_top_number']);
			if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
				foreach($top_products as $k=>$v){
					$top_products[$k]['ProductI18n']['name'] = $this->Product->sub_str($v['ProductI18n']['name'], $this->configs['products_name_length']);
				}
			}	    	
	    	$this->set('top_products',$top_products);
	    	$this->data['top_products']=$top_products;
		}
		
		$this->Link->set_locale($this->locale);
		$link_info = $this->Link->find_link($this->locale);
		$this->set('link_info',$link_info);
		
		//导航
		$this->Navigation->set_locale($this->locale);
 		$this->set('navigations',$this->Navigation->get_types($this->locale));
 		//pr($this->Navigation->get_types($this->locale));
 		//商品分类
 		$this->Category->set_locale($this->locale);
 		
 		$category_tree = $this->Category->tree('P',0,$this->locale,$this);
 	//	pr($this->Category->allinfo['tree']);
 //		pr($this->Category->allinfo['tree']);exit;
 		$this->set('categories_tree', $this->Category->allinfo['tree']);
 		$this->set('categories', $this->Category->allinfo['assoc']);
 		
 		//品牌
 		$this->Brand->set_locale($this->locale);
 		$this->set('brands',$this->Brand->findassoc($this->locale));
 		
 		if(isset($this->configs['show_brand_by_category']) && $this->configs['show_brand_by_category'] == "1"){
	 		 $this->Product->hasOne = array();
			 $this->Product->bindModel(array(
				 'hasOne' => array(
					 'Brand' => array(
					 'className' => 'Brand',
					 'foreignKey' => false,
					 'conditions' => array('Brand.id = Product.brand_id')
					),
					 'BrandI18n' => array(
					 'className' => 'BrandI18n',
					 'foreignKey' => false,
					 'conditions' => array('BrandI18n.brand_id = Product.brand_id',"BrandI18n.locale = '".$this->locale."'")
					)
			 	)),false);
			
	 		//$all_category_brand = $this->Product->cache_find('list',array('conditions'=>array('Product.category_id'=>$category_tree['all_ids']),'fields'=>array('Product.id','Product.brand_id','Product.category_id')),'all_category_brand_'.$this->locale);
	 		$all_category_brand_list = $this->Product->cache_find('all',array('conditions'=>array('Product.status'=>1,'Product.forsale'=>1,'Brand.status'=>1,'Product.brand_id > '=>0,'Product.category_id <>'=>0),'order'=>array('Brand.orderby ASC','BrandI18n.name ASC'),'group'=>array('Product.brand_id','Brand.id','Product.category_id'),'fields'=>array('Product.brand_id','Product.category_id')),'all_category_brand_'.$this->locale);
	 		
	 		$this->Product->hasOne = array(
							'ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'product_id'
					                        	 ) 
                 	   );
	 		
	 		$all_category_brand = array();
	 		if(isset($all_category_brand_list) && sizeof($all_category_brand_list)>0){
	 			foreach($all_category_brand_list as $k=>$v){
	 				$all_category_brand[$v['Product']['category_id']][] = $v['Product']['brand_id'];
	 			}
	 		}
	 		if(isset($all_category_brand) && sizeof($all_category_brand)>0){
	 			foreach($all_category_brand as $k=>$v){
	 				$all_category_brand[$k]  = array_unique($all_category_brand[$k]);
	 			}
	 			$this->set('all_category_brand',$all_category_brand);
	 		}
		}

		
 		//
 		$this->Article->set_locale($this->locale);
 		$this->set('scroll_articles',$this->Article->findscroll($this->locale));
 		//定义第一级导航
 		$this->navigations[0]=array('name'=>$this->languages['home'],'url'=>"/");
 		$ucdata = "";
 		if(!empty($_SESSION["ucdata"])){
 			$ucdata = $_SESSION["ucdata"];
 			$this->set("ucdata",$ucdata);
 			$_SESSION["ucdata"] = "";
 		}
	}
	
	
	
	
	function beforeRender() {
		
		$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		$this->server_host = "http://".$host;
    	if(Configure::read('App.baseUrl')){
        	$this->webroot = $webroot = str_replace("index.php","",$this->base);
        	$this->root_all = $this->webroot;//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/index.php/';
        	$this->user_webroot = $this->root_all . 'user/index.php/';
        	$this->cart_webroot = $this->root_all . 'index.php/';
        }
        else{
        	$this->root_all = $this->webroot;//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/';
        	$this->user_webroot = $this->root_all . 'user/';
        	$this->cart_webroot = $this->root_all;
        }
        $_SESSION['server_host']  =  $this->server_host;
        $_SESSION['user_webroot'] =  $this->user_webroot;
        $_SESSION['cart_webroot'] =  $this->cart_webroot;
        
		$this->data['this_locale'] = $this->locale;
        $this->set('root_all',$this->root_all);
        $this->set('server_host',$this->server_host);
        $this->set('admin_webroot',$this->admin_webroot);
        $this->set('user_webroot',$this->user_webroot);
        $this->set('cart_webroot',$this->cart_webroot);
        $this->data['root_all'] = $this->root_all;
        $this->data['server_host'] = $this->server_host;
        $this->data['admin_webroot'] = $this->admin_webroot;
        $this->data['user_webroot'] = $this->user_webroot;
        $this->data['cart_webroot'] = $this->cart_webroot;
		$plugin_union = $this->Plugin->find_union();
	//	pr($plugin_union['Plugin']['function']);
		if(isset($plugin_union['Plugin']) && isset($_GET['source'])){
			$this->requestAction($plugin_union['Plugin']['function'].$_GET['source']);
		}
		
		//    /union_apps/set_union_user/
		$this->set('memory_useage',number_format((memory_get_usage()/1048576), 3, '.', ''));//占用内存
		$this->data['memory_useage'] = 	number_format((memory_get_usage()/1048576), 3, '.', '');
	//	$this->webroot=WEBROOT_DIR;
		//模版信息
		$cache_key = md5("template_list_");
		
		$template_list = cache::read($cache_key);
		if (!$template_list){
			$template_list=$this->Template->find('all',array('conditions'=>array('Template.status '=>1)));
			cache::write($cache_key,$template_list);
		}
		foreach($template_list as $k=>$v){
			if($v['Template']['is_default'] == 1){
				$default_template = $v;
			}
		}
	//	pr($template_list);
		$template_name_arr = array();
		if(isset($template_list) && sizeof($template_list)>0){
			foreach($template_list as $k=>$v){
				$template_name_arr[] = $v['Template']['name'];
			}
		}
		/*********** 	获得可选的模版信息  	 **********/
	    $available_templates = array();
	    $theme_dir = dirname(dirname(dirname(dirname(__FILE__))));
	    
	    $theme_styles = array();
	    $template_dir        = @opendir($theme_dir.'/themed/');
	    while ($file = readdir($template_dir))
	    {
	        if ($file != '.' && $file != '..' && is_dir($theme_dir.'/themed/' . $file) && $file != '.svn' && $file != 'index.htm')
	        {
	            $available_templates[] = $this->get_template_info($file,$theme_dir);
	            //$theme_styles[$file] = $this->theme_styles($file);
	        }
	    }
	    $can_select_template = array();			
		if(isset($available_templates) && sizeof($available_templates)>0){
			foreach($available_templates as $k=>$v){
				if(in_array($v['code'],$template_name_arr)){
					$can_select_template[] =$v; 
				}
			}
		}
		//pr($can_select_template);
		$this->set('can_select_template',$can_select_template);
			
			
			
		/*********** 	获得可选的模版信息  END **********/
	
		//多模版
		if(empty($_SESSION['template_use']) && isset($default_template)){
				$template_use=$default_template['Template']['name'];
	//			$_SESSION['template_style'] = $default_template['Template']['style'];
		//		$template_style = $default_template['Template']['style'];
				$_SESSION['template_use'] = $template_use;
		}else{
			$template_use=$_SESSION['template_use'];
	//		$template_style = isset($_SESSION['template_style'])?$_SESSION['template_style']:'';
		}
		if(isset($_GET['themes'])){
	//		$_SESSION['template_use'] =	$default_template['Template']['name'];
	//		$template_use=$_SESSION['template_use'];
			foreach($template_list as $k=>$v){
				if($v['Template']['name'] == $_GET['themes']){
					$_SESSION['template_use'] = $_GET['themes'];
	//				$_SESSION['template_style'] = $v['Template']['style'];
					$template_use=$_SESSION['template_use'];
				}
			}
		}
		if(empty($_SESSION['template_use'])){
			if($default_template){
				$code = $default_template['Template']['name'];	
//				$template_style = $default_template['Template']['style'];
//				$_SESSION['template_style'] = $default_template['Template']['style'];
			}else{
				$code = "SV_DEFAULT";
	//			$_SESSION['template_style'] = "";
	//			$template_style = "";
			}
		}else{
			$code = $_SESSION['template_use'];
	//		$template_style = isset($_SESSION['template_style'])?$_SESSION['template_style']:'';
		}
		
	/*	if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
			$cart['quantity'] =0;
			$cart['total']=0;
			foreach($_SESSION['svcart']['products'] as $k=>$v){
				$cart['quantity'] += $v['quantity'];
				$cart['total'] += $v['subtotal'];
			}
			$cart['sizeof'] = sizeof($_SESSION['svcart']['products']);
			$this->data['header_cart'] = $cart;
			$this->set("header_cart",$cart);
		}*/
		
				if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0 && isset($this->languages['cart_total_product'])){
					$cart['quantity'] =0;
					$cart['total']=0;
					foreach($_SESSION['svcart']['products'] as $k=>$v){
						$cart['quantity'] += $v['quantity'];
						$cart['total'] += $v['subtotal'];
					}
					$cart['sizeof'] = sizeof($_SESSION['svcart']['products']);
					$result['header_msg'] = sprintf($this->languages['cart_total_product'],"<strong>".$cart['sizeof']."</strong>",isset($cart['quantity'])?"<strong>".
					$cart['quantity']."</strong>":"<strong>0</strong>")."<strong>".
					sprintf($this->configs['price_format'],isset($cart['total'])?$cart['total']:0)."</strong>";
					$_SESSION['header_cart'] = $cart;
					$this->data['header_cart'] = $_SESSION['header_cart'];
				}else if(isset($this->languages['cart_total_product'])){
					$_SESSION['header_cart'] = array('sizeof'=>0,'quantity'=>0,'total'=>0);
					$result['header_msg'] = sprintf($this->languages['cart_total_product'],"<strong>0</strong>","<strong>0</strong>")."<strong>".
					sprintf($this->configs['price_format'],0)."</strong>";
					$this->data['header_cart'] = $_SESSION['header_cart'];
				}				
				
								// dam add   购物车显示
				if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
					$cart['quantity'] =0;
					$cart['total']=0;
					foreach($_SESSION['svcart']['products'] as $k=>$v){
						$cart['quantity'] += $v['quantity'];
						$cart['total'] += $v['subtotal'];
					}
					$this->set("header_cart",$cart);
				}
				
				
		$template_style ="";
		foreach($template_list as $k=>$v){
				if($v['Template']['name'] == $code){
					$template_style = $v['Template']['template_style'];
				}
		}
		
		if(isset($_GET['theme_style'])){
			$_SESSION['template_style'] = $_GET['theme_style'];
			$template_style = $_GET['theme_style'];
			$this->data['img_style_url'] =$_GET['theme_style'];
			$this->set("img_style_url",$_GET['theme_style']);
		}elseif(isset($_SESSION['template_style'])){
			$template_style = $_SESSION['template_style'];
			$this->data['img_style_url'] = $_SESSION['template_style'];
			$this->set("img_style_url",$_SESSION['template_style']);
		}elseif($template_style != ""){
			$_SESSION['template_style'] = $template_style;
			$this->data['img_style_url'] = $template_style;
			$this->set("img_style_url",$template_style);
		}else{
			$_SESSION['template_style'] = 'green';
			$this->data['img_style_url'] = 'green';
			$this->set("img_style_url","green");
		}
		$viewPaths = Configure::read('viewPaths');
		$viewPath[] = WWW_ROOT.'/themed/'.$code.'/';
		Configure::write('viewPaths',array_merge($viewPath,$viewPaths));
	//	$this->viewPaths = array_merge($this->param['viewPaths'], array(WWW_ROOT.'/themed/'.$code.'/'));
        
        $this->theme = $code;
        $_SESSION['template_style'] = $template_style;
        
       	$this->Cookie->write('template_style',$template_style);
		$this->Cookie->write('template',$code);
        
      	$this->set('template_style',$template_style);
      	$this->set('template_list',$template_list);
		$this->set('template_use',$code);
		//页面压缩
	//	pr($this);
		if (@$this->gzip_enabled())
		{
			@$this->set('gzip_is_start',1);
		    @ob_start('ob_gzhandler');
		}
		else
		{
			@$this->set('gzip_is_start',0);
		    @ob_start();
		}       
		if(isset($this->configs['gears_setting']) && $this->configs['gears_setting'] == 1){
        $cache_key = md5("gears_file");
		$gears_file = cache::read($cache_key);
		if (!$gears_file){		
		$gears_file = array(); 
        $svcart_dir = (dirname(dirname(dirname(dirname(__FILE__)))));
        if($template_style == ""){
        	$img_dir = $svcart_dir."/themed/".$code."/img/";
//        	$user_img_dir = $svcart_dir."/user/themed/".$code."/img/";
        }else{
        	$img_dir = $svcart_dir."/themed/".$code."/img/".$template_style."/";
//        	$user_img_dir = $svcart_dir."/user/themed/".$code."/img/".$template_style."/";
        }
	    $file_js_dir        = @opendir($svcart_dir."/themed/".$code."/js/");
	    $file_css_dir        = @opendir($svcart_dir."/themed/".$code."/css/");
	    $file_img_dir        = @opendir($img_dir);
//	    $file_user_js_dir        = @opendir($svcart_dir."/user/themed/".$code."/js/");
//	    $file_user_css_dir        = @opendir($svcart_dir."/user/themed/".$code."/css/");
//	    $file_user_img_dir        = @opendir($user_img_dir);	    
	    while ($file = readdir($file_js_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn')
	        {	    	
        		$gears_file[] =  $this->root_all."themed/".$code."/js/".$file;
        	}
        }

       	while ($file = readdir($file_css_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn')
	        {	    	
        		$gears_file[] =  $this->root_all."themed/".$code."/css/".$file;
        	}
        }
      	if(Configure::read('App.baseUrl')){
			$min_url = "min/index.php?f=";
		}else{
			$min_url = "min/f=";
		}
		$gears_file[] = "/".$min_url.$this->root_all."themed/".$code."/css/layout.css,".$this->root_all."themed/".$code."/css/component.css,".$this->root_all."themed/".$code."/css/login.css,".$this->root_all."themed/".$code."/css/menu.css,".$this->root_all."themed/SV_DEFAULT/css/containers.css,".$this->root_all."themed/SV_DEFAULT/css/autocomplete.css,".$this->root_all."themed/".$code."/css/style_".$template_style.".css,".$this->root_all."themed/".$code."/css/chi.css";
		$gears_file[] =	 "/".$min_url.$this->root_all."js/yui/yahoo-dom-event.js,".$this->root_all."js/yui/container_core-min.js,".$this->root_all."js/yui/menu-min.js,".$this->root_all."js/yui/element-beta-min.js,".$this->root_all."js/yui/animation-min.js,".$this->root_all."js/yui/connection-min.js,".$this->root_all."js/yui/container-min.js,".$this->root_all."js/yui/json-min.js,".$this->root_all."themed/SV_DEFAULT/js/common.js,".$this->root_all."js/swfobject.js";
       	while ($file = readdir($file_img_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn' && $file != 'Thumbs.db' && !is_dir($svcart_dir."/themed/".$code."/img/".$template_style."/".$file))
	        {	    	
        		$gears_file[] = $this->server_host.$this->root_all."themed/".$code."/img/".$template_style."/".$file;
        	}
        }	    


			cache::write($cache_key,$gears_file);
		}

        $this->set('gears_file',$gears_file);
        }
        
       	/* 底部帮助文章导航 */
 		$this->Article->set_locale($this->locale);
		$navigations_data = $this->Category->find('all',array('conditions'=>array('Category.sub_type'=>'H','Category.status'=>'1','Category.type'=>'A'),'order'=>array('Category.orderby asc')));
		$navigations_data_ids=array();
		if(isset($navigations_data) && sizeof($navigations_data)>0){
			foreach($navigations_data as $k=>$v){
				$navigations_data_ids[] = $v['Category']['id'];
			}
		}
		$navigations_help = array();
		if(!empty($navigations_data_ids)){
			$arr_articles = $this->Article->find('all',array('order'=>'Article.orderby','conditions'=>array("Article.status" => '1' ,'Article.category_id' => $navigations_data_ids)));
		}
	//	pr($arr_articles);
		$arr_article_list = array();
		if(isset($arr_articles) && sizeof($arr_articles)>0){
			foreach($arr_articles as $k=>$v){
				$arr_article_list[$v['Article']['category_id']][] = $v;
			}
		}
	//	pr($arr_article_list);
		foreach($navigations_data as $k=>$v){
			$arr['navigation_name'] = $v['CategoryI18n']['name'];
			//$arr['articles'] = $arr_article_list[]
			if(isset($arr_article_list[$v['Category']['id']])){
				$arr['articles'] = $arr_article_list[$v['Category']['id']];
			}
			$navigations_help[] = $arr;
			unset($arr);
		}
	//	pr($navigations_help);
		$this->set('navigations_help',$navigations_help);
		//pr($db->_queriesCnt);pr($db->_queriesTime);
		$db = &ConnectionManager::getDataSource($this->useDbConfig);
		$this->set('queriesCnt',$db->_queriesCnt);$this->set('queriesTime',$db->_queriesTime);
    }
   
		/**
		 * 获得系统是否启用了 gzip
		 */
	function gzip_enabled()
	{
	    static $enabled_gzip = NULL;

	    if ($enabled_gzip === NULL)
		{
		    $enabled_gzip = ($this->configs['enable_gzip'] && function_exists('ob_gzhandler'));
		}

	    return $enabled_gzip;
	}   
   
	function get_template_info($template_name,$theme_dir)
	{
	    $info = array();
	    $ext  = array('png', 'gif', 'jpg', 'jpeg');
		
	    $info['code']       = $template_name;
	    $info['screenshot'] = '';



	    if (file_exists($theme_dir.'/themed/' . $template_name . '/readme.txt') && !empty($template_name))
	    {
	        $arr = array_slice(file($theme_dir.'/themed/'. $template_name. '/readme.txt'), 0, 8);
	        $template_name      = explode(': ', $arr[0]);
	        $template_style     = explode(': ', $arr[7]);
	        $template_uri       = explode(': ', $arr[1]);
	        $template_desc      = explode(': ', $arr[2]);
	        $template_version   = explode(': ', $arr[3]);
	        $template_author    = explode(': ', $arr[4]);
	        $author_uri         = explode(': ', $arr[5]);
	        $template_description     = explode(': ', $arr[6]);
	        
	        $info['description']     = isset($template_description[1]) ? trim($template_description[1]) : '';
	        $info['style']       = explode(',', $template_style[1]);
	        $info['name']       = isset($template_name[1]) ? trim($template_name[1]) : '';
	        $info['uri']        = isset($template_uri[1]) ? trim($template_uri[1]) : '';
	        $info['desc']       = isset($template_desc[1]) ? trim($template_desc[1]) : '';
	        $info['version']    = isset($template_version[1]) ? trim($template_version[1]) : '';
	        $info['author']     = isset($template_author[1]) ? trim($template_author[1]) : '';
	        $info['author_uri'] = isset($author_uri[1]) ? trim($author_uri[1]) : '';
	    }
	    else
	    {
	    	$info['description']= '';
	    	$info['style']      = '';
	        $info['name']       = '';
	        $info['uri']        = '';
	        $info['desc']       = '';
	        $info['version']    = '';
	        $info['author']     = '';
	        $info['author_uri'] = '';
	    }
	    $screenshot = isset($info['style'][0])?"screenshot_".$info['style'][0]:'screenshot';
	    foreach ($ext AS $val)
	    {
	        if (file_exists($theme_dir.'/themed/' .  $info['code'] . "/{$screenshot}.{$val}"))
	        {
	            $info['screenshot'] = '/themed/' .  $info['code'] . "/{$screenshot}.{$val}";
	            break;
	        }
	    }
	    return $info;
	}
	
	
	
	
	
	
	
}
	function ob_gzip($content){   
	
    if(    !headers_sent() &&
        extension_loaded("zlib") &&
        strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip"))
    {
        $content = gzencode($content." \n//此页已压缩",9);
        header("Content-Encoding: gzip");
        header("Vary: Accept-Encoding");
        header("Content-Length: ".strlen($content));
    }
    	return $content;
	} 
	


?>