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
 * $Id: app_controller.php 1116 2009-04-28 11:04:43Z huangbo $
*****************************************************************************/
class AppController extends Controller {
	var $view = 'Theme'; 
	var $locale = '';
	var $lang = '';
//	var $lang_dictionarie = '';
	var $helpers = array('Html','Javascript','Form','Svshow');
	var $uses = array('Language','Config','Navigation','Brand','Category','Article','LanguageDictionary','Template','Link');
	var $configs = array();
	var $languages = array();
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
		
		//	echo $this->Session->read('Config.language');
			$this->locale = $this->Session->read('Config.locale');
		//	echo $this->locale ;
		
		if($this->locale == ""){
			$language=$this->Language->find("map like '%".Configure::read('Config.language')."%'",'locale');
			$this->locale = $language['Language']['locale'];
			$this->Session->write('Config.locale',$this->locale);
			//pr($locale);
		}
			
		//ϵͳȫֲ
		$this->Config->set_locale($this->locale);
		$this->configs = $this->Config->getformatcode();
		$this->set('SVConfigs',$this->configs);
		ini_set('date.timezone','Etc/GMT'.$this->configs['default_timezone']);
		/*
		字典语言
		*/
		$this->Config->set_locale($this->locale);
		
		$this->languages = $this->LanguageDictionary->getformatcode($this->locale);
		$this->set('SCLanguages',$this->languages);
		//print_r($this->languages);
		
		//官网导航
		$this->Category->set_locale($this->locale);
		$navigate = $this->Category->tree('A',0);
		$this->set('articles_tree',$navigate['tree']);
		
		//友情链接
		$this->Link->set_locale($this->locale);
		$link_info = $this->Link->findall('Link.status = 1');
		$this->set('link_info',$link_info);
		
		if($this->params['action'] !="closed"){
			if($this->configs['shop_temporal_closed'] == 1){
				$this->redirect('/closed');
				exit;
			}
		}
		if(isset($this->configs['shop_notice'])){
			$this->set('shop_notice',$this->configs['shop_notice']);
		}
		
		//if(count($_SERVER['argv']) > 0){
			if(isset($this->configs['access_right']) && $this->configs['access_right'] == 1){
				if(!isset($_SESSION['User'])){
					$this->redirect('/user/login');
					exit;
				}
			}
		//}
		
		//快速搜索图片大小
		if(isset($this->configs['search_autocomplete_image_height'])){
			$search_autocomplete_image = array("search_autocomplete_image_height"=>$this->configs['search_autocomplete_image_height'],
						"search_autocomplete_image_width" => $this->configs['search_autocomplete_image_width'],
						"page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']
			);
			$this->set("search_autocomplete_image",$search_autocomplete_image);
		}
		
		/* 判断是否支持 Gzip 模式 */
		if ($this->gzip_enabled())
		{
		  //  ob_start('ob_gzhandler');
		}
		else
		{
		    ob_start();
		}
		$template_list=$this->Template->findAll('where status=1','DISTINCT Template.name');
		$template_default=$this->Template->find('where is_default=1','DISTINCT Template.name');//数据库模板信息
		if(empty($_SESSION['template_use'])){
			$template_use=$template_default['Template']['name'];
			$_SESSION['template_use'] = $template_use;
		}else{
			$template_use=$_SESSION['template_use'];
		}

		
		if(isset($_GET['themes'])){
			$filter = "1=1";
			$filter .= " and Template.status = 1 and Template.name='".$_GET['themes']."'";
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
	//	$_SESSION['cart_back_url'] = "/..".$this->here;
	////	pr($this->here);
	//	pr($_SESSION['cart_back_url']);
	}

	
	function page_init(){

		//ѡ
		$this->set('languages',$this->Language->findall("Language.front = 1 "));
		//pr($this->Language->findall("Language.front = 1 "));
		//Ϣ
		$this->Navigation->set_locale($this->locale);
 		$this->set('navigations',$this->Navigation->get_types());
 		
 		//Ϣ
 		$this->Category->set_locale($this->locale);
 		$this->Category->tree('P',0);
 		$this->set('categories_tree', $this->Category->allinfo['tree']);
 		$this->set('categories', $this->Category->allinfo['assoc']);
 		
 		//ƷϢ
 		$this->Brand->set_locale($this->locale);
 		$this->set('brands',$this->Brand->findassoc());

 		//
 		$this->Article->set_locale($this->locale);
 		$this->set('scroll_articles',$this->Article->findscroll());
 		//ʼ
 		$this->navigations[0]=array('name'=>$this->languages['home'],'url'=>"/");
	}
	
	function beforeRender() {
	//	$this->webroot=WEBROOT_DIR;
 	    $this->Config->set_locale($this->locale);
//		$data = $this->Config->findByGroup('themed');
//		$code = $data['Config']['code'];
		$data =$this->Template->find('where is_default =1');
		
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
?>