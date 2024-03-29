<?php
/*****************************************************************************
 * SV-Cart flash
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: flashes_controller.php 3949 2009-08-31 07:34:05Z huangbo $
*****************************************************************************/
App::import('Core', 'xml');

class FlashesController extends AppController {
	var $name = 'Flashes';
	var $helpers = array('Xml');
    var $uses = array('Flash','ProductGallery'); 
	var $cacheQueries = true;
	var $cacheAction = "1 hour";

 	function index($type,$type_id=0){
 	  $this->page_init();
 	  $this->Flash->set_locale($this->locale);
 	  if($type == "P"){
 		  $flash_info=$this->Flash->find("type = '$type'");
 	  }else{
 		  $flash_info=$this->Flash->find("type = '$type' and type_id = $type_id ");
 	  }
	  $flash_info['Flash']['titlebgcolor']=hexdec($flash_info['Flash']['titlebgcolor']);
	  $flash_info['Flash']['titletextcolor']=hexdec($flash_info['Flash']['titletextcolor']);
	  $flash_info['Flash']['btntextcolor']=hexdec($flash_info['Flash']['btntextcolor']);
	  $flash_info['Flash']['btndefaultcolor']=hexdec($flash_info['Flash']['btndefaultcolor']);
	  $flash_info['Flash']['btnhovercolor']=hexdec($flash_info['Flash']['btnhovercolor']);
	  $flash_info['Flash']['btnfocuscolor']=hexdec($flash_info['Flash']['btnfocuscolor']);
 	  $config = $flash_info['Flash'];

	
	  if($type == "P"){
			$this->ProductGallery->set_locale($this->locale);
		    $galleries = $this->ProductGallery->findall("ProductGallery.product_id = '$type_id'",null,"orderby");
		    if(isset($galleries) && sizeof($galleries)>0){
		    	foreach($galleries as $k=>$v){
			 	  	  $flash_info['FlashImage'][$k]['image'] = $this->url($v['ProductGallery']['img_detail'],false);
			 	  	  if(Configure::read('App.baseUrl')){
			 	  	  	  $flash_info['FlashImage'][$k]['image'] = str_replace('index.php/','',$flash_info['FlashImage'][$k]['image']);
			 	  	  }
			 	  	  $flash_info['FlashImage'][$k]['flash_id']=1;
			 	  	  $flash_info['FlashImage'][$k]['link']="#";
			 	  	  $flash_info['FlashImage'][$k]['title']="";
		    	}
		    }
	  }elseif($flash_info['FlashImage']){
		 	  foreach($flash_info['FlashImage'] as $k => $v){
		 	  	  $flash_info['FlashImage'][$k]['image'] = $this->url($v['image'],false);
		 	  	  if(Configure::read('App.baseUrl'))
		 	  	  	  $flash_info['FlashImage'][$k]['image'] = str_replace('index.php/','',$flash_info['FlashImage'][$k]['image']);
		 	  	  if(isset($v['url']) && $v['url'] !=""){
		 	  	  	$flash_info['FlashImage'][$k]['link'] = $this->url($v['url'],false);
		 	  	  	unset($flash_info['FlashImage'][$k]['url']);
		 	  	  }else{
		 	  	  	  $flash_info['FlashImage'][$k]['link']="#";
		 	  	  }
		 	  }
 	  }
 	  
 	  $channel = $flash_info['FlashImage'];
 	  
 	 // pr($channel);
 	  $flash = array('channel'=>array('item'=>$channel),'config'=>$config);
 	  $xml_array = array('data'=>$flash);
 	  $xml = new Xml($xml_array, array('format' => 'tags'));
 //	  pr($xml_array);
 //	  pr($xml);
 	  $result = $xml->toString(array('cdata'=>true));
 //	  pr($result);
	  $this->set('result',$result);
//	  pr($flash);
      Configure::write('debug',0);
		$this->layoutPath = 'xml';
		$this->layout = 'default'; 
 	}
 	
 	function url($url = null, $full = false) {
		return h(Router::url($url, $full));
	}
 	
}

?>