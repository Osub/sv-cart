<?php
/*****************************************************************************
 * SV-Cart 广告管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: advertisements_controller.php 946 2009-04-24 00:36:19Z huangbo $
*****************************************************************************/
class AdvertisementsController extends AppController {
	var $name = 'Advertisements';
	var $helpers = array('Html','Pagination');
	var $components = array('Pagination','RequestHandler');
	var $uses = array('Advertisement','AdvertisementI18n');
	
	function index(){
		$this->pageTitle = '广告管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'广告管理','url'=>'/advertisement/');
		$this->set('navigations',$this->navigations);
		
	    $this->Advertisement->set_locale($this->locale);
		$condition = '';
		$page = 1;
		$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);		
		$options = array();
		$total = $this->Advertisement->findCount($condition,0);
		$sortClass = 'Advertisement';
		$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		$data = $this->Advertisement->find('all',array('page'=>$page,'limit'=>$rownum,'conditions'=>$condition,'order'=>'Advertisement.orderby,Advertisement.id desc'));
		$this->set('advertisements',$data);
	}
	function edit( $id ){
		$this->pageTitle = "编辑广告- 广告管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'广告管理','url'=>'/advertisements/');
		$this->navigations[] = array('name'=>'编辑广告','url'=>'');
		$this->set('navigations',$this->navigations);
		
		$this->Advertisement->hasMany = array();
		$this->Advertisement->hasOne = array('AdvertisementI18n'=>
						array('className'  => 'AdvertisementI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'advertisement_id'							
						)
					);
		if($this->RequestHandler->isPost()){
			$this->Advertisement->saveAll($this->data); //保存
			$this->flash("编辑成功",'/advertisements/edit/'.$id,10);
		
		}
		
		$advertisement = $this->Advertisement->findbyid( $id );
		$this->set("advertisement",$advertisement);

	}
	
	function add(){
		$this->pageTitle = "编辑广告- 广告管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'广告管理','url'=>'/advertisements/');
		$this->navigations[] = array('name'=>'编辑广告','url'=>'');
		$this->set('navigations',$this->navigations);
		$this->Advertisement->hasMany = array();
		$this->Advertisement->hasOne = array('AdvertisementI18n'=>
						array('className'  => 'AdvertisementI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'advertisement_id'							
						)
					);
		
		if($this->RequestHandler->isPost()){
			
			$this->data['Advertisement']['ad_width'] = !empty($this->data['Advertisement']['ad_width'])?$this->data['Advertisement']['ad_width']:"0";
			$this->data['Advertisement']['ad_height'] = !empty($this->data['Advertisement']['ad_height'])?$this->data['Advertisement']['ad_height']:"0";

			$this->Advertisement->saveall($this->data); //保存
			$this->flash("添加成功",'/advertisements/edit/'.$this->Advertisement->getLastInsertId(),10);
		
		}
		
	    if(isset($this->params['url']['title']) && $this->params['url']['title'] != ''){
	   	   $this->set( "titles" ,$this->params['url']['title']);
	    }
	    if(isset($this->params['url']['id']) && $this->params['url']['id'] != ''){
	   	    $topics_url = "/topics/edit/".$this->params['url']['id'];
	   	    $this->set( "topics_url" ,$topics_url);
	    }
	
	}
		
	function remove( $id ){
		$this->Advertisement->deleteall("Advertisement.id = '".$id."'",false); 
		$this->AdvertisementI18n->deleteall("AdvertisementI18n.advertisement_id = '".$id."'",false);
		$this->flash("删除成功",'/advertisements/',10);
	}
}

?>