<?php
/*****************************************************************************
 * SV-Cart 用户中心控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * 开发人员: test $
 * $Id: app_controller.php 5209 2009-10-20 08:40:13Z huangbo $
*****************************************************************************/
class AppController extends Controller {
	var $view = 'Theme'; 
	var $locale = '';
	var $lang = '';
	var $currencie = '';
	var $information_info = array();
	var $useDbConfig = 'default';
	var $systemresource_info =array();
	var $helpers = array('Html','Javascript','Form','Svshow','Minify');
	var $uses = array('Language','Config','Navigation','Brand','Category','Article','LanguageDictionary','Template','UserConfig','SystemResource','Currency','InformationResource','Domain','Advertisement','AdvertisementI18n','AdvertisementPosition');
	var $configs = array();
	var $navigations = array();
	var $components = array('RequestHandler','Cookie','Session');
	//
	function beforeFilter(){
		$this->Session->path='/';
	//	pr(mt_rand (50,100));exit;
	//	$this->Session->start();
		/* rewrite 模块关闭特殊处理webroot */
		$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		$this->server_host = "http://".$host;
    	if(Configure::read('App.baseUrl')){
        	$this->webroot = $webroot = str_replace("index.php","",$this->base);
        	$this->root_all = str_replace( WEBROOT_DIR . '/','',$this->webroot);//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/index.php/';
        	$this->user_webroot = $this->root_all . 'user/index.php/';
        	$this->cart_webroot = $this->root_all . 'index.php/';
        }
        else{
        	$this->root_all = str_replace(WEBROOT_DIR."/","",$this->webroot);//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/';
        	$this->user_webroot = $this->root_all . 'user/';
        	$this->cart_webroot = $this->root_all;
        }
        
        $this->set('root_all',$this->root_all);
        $this->set('server_host',$this->server_host);
        $this->set('admin_webroot',$this->admin_webroot);
        $this->set('user_webroot',$this->user_webroot);
        $this->set('cart_webroot',$this->cart_webroot);
        //pr($this->server_host);
        
		$this->locale = $this->Session->read('Config.locale');
		$cookie_locale = $this->Cookie->read('locale');
		$SVlanguages = $this->Language->findalllang();
		$this->data['user_lang_locale'] = $SVlanguages;
		$this->set('languages',$SVlanguages);
		if(isset($_GET['locale'])){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['locale'] == $_GET['locale']){
					$this->locale = $_GET['locale'];
				}
			}
		}elseif(isset($cookie_locale) && $cookie_locale != $this->Session->read('Config.locale') ){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['locale'] == $cookie_locale){
					$this->locale = $cookie_locale;
					$this->Session->write('Config.locale',$cookie_locale);
					$this->Session->write('Config.language',$cookie_locale);
				}
			}
		}
		if($this->locale == ""){
			foreach($SVlanguages as $k=>$v){
				if($v['Language']['is_default'] == 1){
					$this->locale = $v['Language']['locale'];
				}
			}
			$this->Cookie->write('SV-Cart.locale',$this->locale);
			$this->Session->write('Config.locale',$this->locale);
		}
		/* 新增域名表 */
		$domains = $this->Domain->cache_find('first',array('conditions'=>array('Domain.status'=>1,'Domain.domain'=>$host)),'domains');
		if(!empty($domains)){
			$this->locale= $domains['Domain']['locale'];
			$this->Cookie->write('locale',$this->locale);
			$this->Session->write('Config.locale',$this->locale);
		}
        $this->SystemResource->set_locale($this->locale);
        $this->systemresource_info = $this->SystemResource->resource_formated(true,$this->locale);
        $this->set('systemresource_info',$this->systemresource_info);
		
				//官网导航
		$this->Category->set_locale($this->locale);
	//	$navigate = $this->Category->tree('A',0,$this->locale);
	//	$this->set('articles_tree',$navigate['tree']);

		//系统全局参数
		$this->Config->set_locale($this->locale);
		$this->configs = $this->Config->getformatcode();
		$this->set('SVConfigs',$this->configs);
		ini_set('date.timezone','Etc/GMT'.$this->configs['default_timezone']);

		
		/* 判断是否支持 Gzip 模式 */
		if ($this->gzip_enabled())
		{
			$this->set('gzip_is_start',1);
		    @ob_start('ob_gzhandler');
		}
		else
		{
			$this->set('gzip_is_start',0);
		    @ob_start();
		}
	
		
		$this->Config->set_locale($this->locale);
		$this->languages = $this->LanguageDictionary->getformatcode($this->locale);
		$this->set('SCLanguages',$this->languages);
		
		//快速搜索图片大小
		if(isset($this->configs['search_autocomplete_image_height'])){
			$search_autocomplete_image = array("search_autocomplete_image_height"=>$this->configs['search_autocomplete_image_height'],
						"search_autocomplete_image_width" => $this->configs['search_autocomplete_image_width'],
						"page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']
			);
			$this->set("search_autocomplete_image",$search_autocomplete_image);
		}		
		
		if($this->params['action'] !="closed"){
			if($this->configs['shop_temporal_closed'] == 1){
				$this->redirect($this->server_host . $this->cart_webroot .'closed');
				exit;
			}
		}
		$is_url3 = $this->server_host.$this->user_webroot."register/";
		$is_url = $this->server_host.$this->user_webroot."login/";
		$is_url2 = $this->server_host.$this->user_webroot."/";
		if(($this->params['action'] =="register" || $this->params['action'] =="login")&& isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != $is_url && $_SERVER['HTTP_REFERER'] != $is_url2 && $_SERVER['HTTP_REFERER'] != $is_url3){
 			$_SESSION['cart_back_url'] = $_SERVER['HTTP_REFERER'];
 		}


		if(isset($_SERVER['HTTP_REFERER'])){
			$referer_arr =array();
			$referer_arr = explode('/',$_SERVER['HTTP_REFERER']);
			$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
			if(!in_array($host,$referer_arr)){
				$this->Cookie->write('referer',$_SERVER['HTTP_REFERER'],false,time()+3600 * 24 * 365);
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
			 																											'rate'=> $v['Currency']['rate']
																								));
							}
			 			}
			 		}
			 	}
			 	$this->currencie = $this->Session->read('currencies');
				$cookie_currencie = $this->Cookie->read('currencies');
				
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
			 				$this->currencie = $k;
							$this->Session->write('currencies',$k);
							$this->Cookie->write('currencies',$k);													
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

		
		
		
				if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
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
				}else{
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
		
		
		
		$alp=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
   		$this->set('alp',$alp);	
		
        $this->InformationResource->set_locale($this->locale);
        $this->information_info = $this->InformationResource->information_formated(true,$this->locale);
        $this->set('information_info',$this->information_info);
		//所有有效的广告
		$this->Advertisement->set_locale($this->locale);
		$this->data['advertisement_list'] = $this->Advertisement->get_all($this);
		
		
		$this->set('dlocal',$this->locale);
		$this->data['dlocal'] = $this->locale;
		$this->data['languages'] = $this->languages;
        $this->data['root_all'] = $this->root_all;
        $this->data['server_host'] = $this->server_host;
        $this->data['admin_webroot'] = $this->admin_webroot;
        $this->data['user_webroot'] = $this->user_webroot;
        $this->data['cart_webroot'] = $this->cart_webroot;
       	$this->data['language_locale'] = $SVlanguages;
		$this->data['configs'] = $this->configs;		
		
	}
	
	function page_init(){
		
		//分类信息
 		$this->Category->set_locale($this->locale);
 		$this->Category->tree('P',0,$this->locale);
 		$this->set('categories_tree', $this->Category->allinfo['tree']);
 	//	$this->set('categories', $this->Category->allinfo['assoc']);
		
		//品牌信息
 		$this->Brand->set_locale($this->locale);
 		
 		$this->set('brands',$this->Brand->findassoc($this->locale));
		
		//导航信息
		$this->Navigation->set_locale($this->locale);
		$navigations = $this->Navigation->get_types($this->locale);
		/*
		if(isset($navigations['T']) && count($navigations['T'])>0){
			foreach($navigations['T'] as $k=>$v){
				if(substr($navigations['T'][$k]['NavigationI18n']['url'],0,4) != 'java'){
				$navigations['T'][$k]['NavigationI18n']['url'] =  $this->server_host.$this->user_webroot.$navigations['T'][$k]['NavigationI18n']['url'];
	 			}
	 		}
 		}*/
 		
 		$this->set('navigations',$navigations);
 		
 		//滚动文章
 		$this->Article->set_locale($this->locale);
 		$this->set('scroll_articles',$this->Article->findscroll($this->locale));
 		
 		//导航初始化
 		$this->navigations[0]=array('name'=>$this->languages['user_center'],'url'=>"/");
 		

	}

    function beforeRender() {
    	
		$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		$this->server_host = "http://".$host;
    	if(Configure::read('App.baseUrl')){
        	$this->webroot = $webroot = str_replace("index.php","",$this->base);
        	$this->root_all = str_replace(WEBROOT_DIR."/","",$this->webroot);//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/index.php/';
        	$this->user_webroot = $this->root_all . 'user/index.php/';
        	$this->cart_webroot = $this->root_all . 'index.php/';
        }
        else{
        	$this->root_all = str_replace(WEBROOT_DIR."/","",$this->webroot);//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/';
        	$this->user_webroot = $this->root_all . 'user/';
        	$this->cart_webroot = $this->root_all;
        }
        $_SESSION['server_host']  =  $this->server_host;
        $_SESSION['user_webroot'] =  $this->user_webroot;
        $_SESSION['cart_webroot'] =  $this->cart_webroot;
        
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
    	
		$this->set('memory_useage',number_format((memory_get_usage()/1048576), 3, '.', ''));//占用内存 						
		$this->data['memory_useage'] = 	number_format((memory_get_usage()/1048576), 3, '.', '');
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
		
	
		
	//	$this->webroot=WEBROOT_DIR;
		//模版信息
		$cache_key = md5("template_list_");
		$template_list = cache::read($cache_key);
		if (!$template_list){
			$template_list=$this->Template->findAll("where status='1'");
			cache::write($cache_key,$template_list);
		}
		foreach($template_list as $k=>$v){
			if($v['Template']['is_default'] == 1){
				$default_template = $v;
			}
		}
		//多模版
		if(empty($_SESSION['template_use'])){
			$template_use=$default_template['Template']['name'];
			$_SESSION['template_use'] = $template_use;
		}else{
			$template_use=$_SESSION['template_use'];
		}
		if(isset($_GET['themes'])){
			$_SESSION['template_use'] =	$default_template['Template']['name'];
			$template_use=$_SESSION['template_use'];
			foreach($template_list as $k=>$v){
				if($v['Template']['name'] == $_GET['themes']){
					$_SESSION['template_use'] = $_GET['themes'];
					$template_use=$_SESSION['template_use'];
				}
			}
		}
		if(empty($_SESSION['template_use'])){
			if($default_template){
				$code = $default_template['Template']['name'];	
			}else{
				$code = "SV_DEFAULT";
			}
		}else{
			$code = $_SESSION['template_use'];	
		}			
		$template_style ="";
		foreach($template_list as $k=>$v){
				if($v['Template']['name'] == $code){
					$template_style = $v['Template']['template_style'];
				}
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
			$this->set("img_style_url",$_GET['theme_style']);
		}elseif(isset($_SESSION['template_style'])){
			$template_style = $_SESSION['template_style'];
			$this->set("img_style_url",$_SESSION['template_style']);
		}elseif($template_style != ""){
			$_SESSION['template_style'] = $template_style;
			$this->set("img_style_url",$template_style);
		}else{
			$_SESSION['template_style'] = 'green';
			$this->set("img_style_url","green");
		}

        $this->theme = $code;
		$viewPaths = Configure::read('viewPaths');
		$viewPath[] = WWW_ROOT.'/themed/'.$code.'/';
		Configure::write('viewPaths',array_merge($viewPath,$viewPaths));
        
		/*********** 	获得可选的模版信息  	 **********/
		$template_name_arr = array();
		if(isset($template_list) && sizeof($template_list)>0){
			foreach($template_list as $k=>$v){
				$template_name_arr[] = $v['Template']['name'];
			}
		}		
		
		
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
        
       	$this->Cookie->write('template_style',$template_style);
		$this->Cookie->write('template',$code);        
      	$this->set('template_style',$template_style);		
		
      	$this->set('template_list',$template_list);
		$this->set('template_use',$code);	
		if(isset($this->configs['gears_setting']) && $this->configs['gears_setting'] == 1){
        $cache_key = md5("gears_file");
		$gears_file = cache::read($cache_key);
		if (!$gears_file){		
		$gears_file = array(); 
        $svcart_dir = (dirname(dirname(dirname(dirname(__FILE__)))));
        if($template_style == ""){
//        	$img_dir = $svcart_dir."/themed/".$code."/img/";
        	$user_img_dir = $svcart_dir."/user/themed/".$code."/img/green/";
        }else{
//        	$img_dir = $svcart_dir."/themed/".$code."/img/".$template_style."/";
        	$user_img_dir = $svcart_dir."/user/themed/".$code."/img/".$template_style."/";
        }
        $template_style_dir = $template_style."/";
//	    $file_js_dir        = @opendir($svcart_dir."/themed/".$code."/js/");
//	    $file_css_dir        = @opendir($svcart_dir."/themed/".$code."/css/");
//	    $file_img_dir        = @opendir($img_dir);
	    $file_user_js_dir        = @opendir($svcart_dir."/user/themed/".$code."/js/");
	    $file_user_css_dir        = @opendir($svcart_dir."/user/themed/".$code."/css/");
	    $file_user_img_dir        = @opendir($user_img_dir);
	    
      	if(Configure::read('App.baseUrl')){
			$min_url = "min/index.php?f=";
		}else{
			$min_url = "min/f=";
		}	   
		$gears_file[] = "/user/../".$min_url.$this->root_all."user/themed/SV_DEFAULT/css/layout.css,".$this->root_all."user/themed/SV_DEFAULT/css/component.css,".$this->root_all."user/themed/SV_DEFAULT/css/login.css,".$this->root_all."user/themed/SV_DEFAULT/css/menu.css,".$this->root_all."user/themed/SV_DEFAULT/css/containers.css,".$this->root_all."user/themed/SV_DEFAULT/css/autocomplete.css,".$this->root_all."user/themed/SV_DEFAULT/css/calendar.css,".$this->root_all."user/themed/SV_DEFAULT/css/treeview.css,".$this->root_all."user/themed/SV_DEFAULT/css/container.css,".$this->root_all."user/themed/SV_DEFAULT/css/style_".$template_style.".css,".$this->root_all."user/themed/SV_DEFAULT/css/chi.css";
		$gears_file[] = "/user/../".$min_url.$this->root_all."user/../js/yui/yahoo-dom-event.js,".$this->root_all."user/../js/yui/container_core-min.js,".$this->root_all."user/../js/yui/menu-min.js,".$this->root_all."user/../js/yui/element-beta-min.js,".$this->root_all."user/../js/yui/animation-min.js,".$this->root_all."user/../js/yui/connection-min.js,".$this->root_all."user/../js/yui/container-min.js,".$this->root_all."user/../js/yui/json-min.js,".$this->root_all."user/../js/yui/button-min.js,".$this->root_all."user/../js/yui/calendar-min.js,".$this->root_all."user/../js/yui/yahoo-min.js,".$this->root_all."user/../js/yui/treeview-min.js,".$this->root_all."user/themed/SV_DEFAULT/js/regions.js,".$this->root_all."user/themed/SV_DEFAULT/js/common.js";
	    
	    $file_js_str = $this->server_host."/min/index.php?f=";
 
       	while ($file = readdir($file_user_img_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn' && $file != 'Thumbs.db' && !is_dir($svcart_dir."/user/themed/".$code."/img/".$template_style_dir.$file))
	        {	    	
        		$gears_file[] = $this->root_all."user/themed/".$code."/img/".$template_style_dir.$file;
        	}
        }   	    
	    
	    while ($file = readdir($file_user_js_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn')
	        {	    	
        		$gears_file[] =  $this->root_all."user/themed/".$code."/js/".$file;
        	}
        }     
        
       	while ($file = readdir($file_user_css_dir))
	    {        
	        if ($file != '.' && $file != '..'&& $file != '.svn')
	        {	    	
        	    $gears_file[] =  $this->root_all."user/themed/".$code."/css/".$file;
        	}
        }
   
     
			cache::write($cache_key,$gears_file);
		}
        	$this->set('gears_file',$gears_file);
        }
        
       	/* 底部帮助文章导航 */
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
		if(isset($affiliate_config["ConfigI18n"]) && sizeof($affiliate_config["ConfigI18n"])>0){
			foreach( $affiliate_config["ConfigI18n"] as $k=>$v ){
				if($v['value'] != ""){
				//	pr($v);
					$affiliate_config["ConfigI18n"][$this->locale] = $v;//设置语言
					$affiliate_config["ConfigI18n"][$this->locale]['value'] =  unserialize($v["value"]);//返序列化
					if($affiliate_config["ConfigI18n"][$this->locale]['value']['on'] == 1){
					$this->set('can_affiliate',1);
					}
				}
			}   
		}
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
        $content = gzencode($content,9);
        header("Content-Encoding: gzip");
        header("Vary: Accept-Encoding");
        header("Content-Length: ".strlen($content));
    }
    	return $content;
	} 


?>