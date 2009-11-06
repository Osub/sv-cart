<?php
/*****************************************************************************
 * SV-Cart 专题管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: topics_controller.php 3634 2009-08-14 07:52:08Z huangbo $
*****************************************************************************/
class ShopsController extends AppController {
	var $name = 'Shops';
    var $components = array ('Pagination','RequestHandler');
   	var $helpers = array('Pagination','Html', 'Form', 'Javascript'); 
	var $uses = array('Store');
	var $cacheQueries = true;
	var $cacheAction = "1 hour";
   
    function index(){
    	$this->full_page_init();
    	$this->pageTitle = $this->languages['physical_store']." - ".$this->configs['shop_title'];
		$this->layout = 'default_full';
		$this->Store->set_locale($this->locale);
		$stores = $this->Store->cache_find('all',array('conditions'=>array('Store.status'=>1)),'all_stores_'.$this->locale);
		$this->set('stores',$stores);
	}
	
	function view($id){
    	$this->full_page_init();
    	$this->pageTitle = $this->languages['physical_store']." - ".$this->configs['shop_title'];
		$this->layout = 'default_full';
		$this->Store->set_locale($this->locale);
		$store_info = $this->Store->findbyid($id);
		$stores = $this->Store->cache_find('all',array('conditions'=>array('Store.status'=>1)),'all_stores_'.$this->locale);
		$this->set('stores',$stores);		
		$this->set('store_info',$store_info);
	}
	
	
}

?>