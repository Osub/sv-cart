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
 * $Id: app_controller.php 1883 2009-05-31 11:20:54Z huangbo $
*****************************************************************************/
class AppController extends Controller {
	var $view = 'Theme'; 
	var $locale = '';
	var $lang = '';
	var $helpers = array('Html','Javascript','Form','Svshow','Minify');
	var $uses = array('Language','Config','Navigation','Brand','Category','Article','LanguageDictionary','Template','UserConfig');
	var $configs = array();
	var $navigations = array();
	
	function beforeFilter(){
		if(isset($_COOKIE['locale']) && $_COOKIE['locale'] != $this->Session->read('Config.locale') ){
			$locale=$this->Language->findbylocale($_COOKIE['locale']);
		//	pr($locale);
			if(isset($locale['Language']['locale'])){
				$this->Session->write('Config.locale',$_COOKIE['locale']);
				$this->Session->write('Config.language',$_COOKIE['locale']);
			}
		}
			$this->UserConfig->set_locale($this->locale);
			$user_config_infos = $this->UserConfig->findall('UserConfig.user_id = 0');
			$this->set('user_config_count',count($user_config_infos));
			
		//	echo $this->Session->read('Config.language');
			$this->locale = $this->Session->read('Config.locale');
		//	echo $this->locale ;
		
		if($this->locale == ""){
			$language=$this->Language->find("map like '%".Configure::read('Config.language')."%'",'locale');
			$this->locale = $language['Language']['locale'];
			$this->Session->write('Config.locale',$this->locale);
			//pr($locale);
		}
		
		//可选语言
		$this->set('languages',$this->Language->findall("Language.front = '1' "));

				//官网导航
		$this->Category->set_locale($this->locale);
		$navigate = $this->Category->tree('A',0);
		$this->set('articles_tree',$navigate['tree']);

		//系统全局参数
		$this->Config->set_locale($this->locale);
		$this->configs = $this->Config->getformatcode();
		$this->set('SVConfigs',$this->configs);
		ini_set('date.timezone','Etc/GMT'.$this->configs['default_timezone']);
	
		
	//	date_default_timezone_set('PRC'); 
		/*
		字典语言
		
		*/
/*		if(ereg('gzip',$_SERVER['HTTP_ACCEPT_ENCODING']))
		{
		 header('Content-type: text/html; charset: UTF-8');
		 //ob_start('ob_gzip');
		 header('Cache-Control: must-revalidate'); 		 
	//	ob_start('ob_gzhandler');
		}
		else
		{
			ob_start();
		}		*/
	//	ob_end_flush();
/* 判断是否支持 Gzip 模式 */
		if ($this->gzip_enabled())
		{
		    @ob_start('ob_gzhandler');
		}
		else
		{
		    @ob_start();
		}
	
		
		$this->Config->set_locale($this->locale);
		$this->languages = $this->LanguageDictionary->getformatcode($this->locale);
		$this->set('SCLanguages',$this->languages);
		
		if($this->params['action'] !="closed"){
			if($this->configs['shop_temporal_closed'] == 1){
				$this->redirect('/../closed');
				exit;
			}
		}
		
		$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		$is_url = "http://".$host.$this->webroot."login/";
		if($this->params['action'] =="register" && isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != $is_url){
 			$_SESSION['cart_back_url'] = $_SERVER['HTTP_REFERER'];
 		}

		$template_list=$this->Template->findAll("where status='1'",'DISTINCT Template.name');
		$template_default=$this->Template->find("where is_default='1'",'DISTINCT Template.name');//数据库模板信息
		if(empty($_SESSION['template_use'])){
			$template_use=$template_default['Template']['name'];
			$_SESSION['template_use'] = $template_use;
		}else{
			$template_use=$_SESSION['template_use'];
		}

		
		if(isset($_GET['themes'])){
			$filter = "1=1";
			$filter .= " and Template.status = '1' and Template.name='".$_GET['themes']."'";
			$select_temp = $this->Template->find($filter);
			if(is_array($select_temp) && sizeof($select_temp) > 0){
				$_SESSION['template_use'] = $_GET['themes'];
				$template_use=$_SESSION['template_use'];
			}else{
				$_SESSION['template_use'] =	$template_default['Template']['name'];
				$template_use=$_SESSION['template_use'];
			}
		}
		$this->set('template_list',$template_list);
		$this->set('template_use',$template_use);	

		if(isset($_SERVER['HTTP_REFERER'])){
			$referer_arr =array();
			$referer_arr = explode('/',$_SERVER['HTTP_REFERER']);
			$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
			if(!in_array($host,$referer_arr)){
				$this->Cookie->write('referer',$_SERVER['HTTP_REFERER'],false,time()+3600 * 24 * 365);
			}
		}
	}
	
	function page_init(){
		
		//可选语言
		$this->set('languages',$this->Language->findall("Language.front = '1' "));
		
		//分类信息
 		$this->Category->set_locale($this->locale);
 		$this->Category->tree('P',0);
 		$this->set('categories_tree', $this->Category->allinfo['tree']);
 		$this->set('categories', $this->Category->allinfo['assoc']);
		
		//品牌信息
 		$this->Brand->set_locale($this->locale);
 		$this->set('brands',$this->Brand->findassoc());
		
		//导航信息
		$this->Navigation->set_locale($this->locale);
		$navigations = $this->Navigation->get_types();
		/*
		$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		if(isset($navigations['T']) && count($navigations['T'])>0){
			foreach($navigations['T'] as $k=>$v){
				if(substr($navigations['T'][$k]['NavigationI18n']['url'],0,4) != 'java'){
				$navigations['T'][$k]['NavigationI18n']['url'] =  "http://".$host.$navigations['T'][$k]['NavigationI18n']['url'];
	 			}
	 		}
 		}*/
 		
 		$this->set('navigations',$navigations);
 		
 		//滚动文章
 		$this->Article->set_locale($this->locale);
 		$this->set('scroll_articles',$this->Article->findscroll());
 		
 		//导航初始化
 		$this->navigations[0]=array('name'=>$this->languages['user_center'],'url'=>"/");
 		

	}

    function beforeRender() {
 	    $this->Config->set_locale($this->locale);
		$data =$this->Template->find("where is_default ='1'");		
		if(empty($_SESSION['template_use'])){
			if($data){
				$code = $data['Template']['name'];	
			}else{
				$code = "SV_G00";	
			}
		}else{
			$code = $_SESSION['template_use'];	
		}			
        $this->theme = $code;
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