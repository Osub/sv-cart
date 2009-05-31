<?php
/*****************************************************************************
 * SV-Cart FLASH管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: flashes_controller.php 1670 2009-05-25 00:47:18Z huangbo $
*****************************************************************************/
class FlashesController extends AppController {
	var $name = 'Flashes';

	var $helpers = array('Html','Pagination');

	var $components = array('Pagination','RequestHandler');
	
	var $uses = array('FlashImage','Flash','Flashe','Brand','Category','Language');

	function index(){
		/*判断权限*/
		$this->operator_privilege('flash_play_view');
		/*end*/
		$this->pageTitle = 'Flash轮播管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'Flash轮播管理','url'=>'/flashes/');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->Flashe->hasMany=array();
			$this->Flashe->saveAll( $this->data );	
			$this->flash("Flsah参数编辑成功","/".$_SESSION['cart_back_url'],10);
		}else{
			$_SESSION['cart_back_url'] = str_replace($this->webroot, "", $_SERVER['REQUEST_URI']); 
		}
	
		
		$condition = "Flash.type='H'";
		$type = '';
		$language = '';
		$typeid = '';
		if(isset($this->params['url']['flashtype']) && $this->params['url']['flashtype'] != ''){
			$condition = "";
			$type = $this->params['url']['flashtype'];
			$condition = "Flash.type='$type'";
			if(isset($this->params['url']['language']) && $this->params['url']['language'] != ''){
				$language = $this->params['url']['language'];
				$condition .= "and FlashImage.locale='$language'";
			}
			switch($type){
				case 'PC': $typeid = $this->params['url']['pctypeid'];break;
				case 'B': $typeid = $this->params['url']['btypeid'];break;
				case 'AC': $typeid = $this->params['url']['actypeid'];break;
				default :$typeid ='';
			}
			if(!empty($typeid)){
				$condition .= "and Flash.type_id='$typeid'";
			}	
		}
		
		$page = 1;
		$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);		
		$options = array();
		$total = $this->FlashImage->findCount($condition,0);
		$sortClass = 'FlashImage';
	    $page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
	
	
		$data = $this->FlashImage->find('all',array('page'=>$page,'limit'=>$rownum,'conditions'=>$condition,'order'=>'FlashImage.orderby,FlashImage.created,FlashImage.id'));

		
		$flashtypes = array('H'=>'首页','PC'=>'分类','B'=>'品牌','AC'=>'文章分类');
		$b = array();
		$this->Brand->set_locale($this->locale);
		$brands=$this->Brand->findAll();
		foreach($brands as $k => $v){
			$b[$v['Brand']['id']] = "";
			if(!empty($v['BrandI18n'])){
				@$b[$v['Brand']['id']] = $v['BrandI18n']['name'];
			} 
		}
		$this->Category->set_locale($this->locale);
		$pc = $this->Category->findAssoc('P');
		$ac = $this->Category->findAssoc('A');
		$pcs = $this->Category->findAssocs('P');
		$acs = $this->Category->findAssocs('A');
		//pr($b);
		foreach($data as $k=>$v){
			switch($v['Flash']['type']){
				case 'H': $v['Flash']['typename'] = "首页<br />";break;
				case 'PC': $v['Flash']['typename'] ="分类<br />".$pcs[$v['Flash']['type_id']];break;
				case 'B': $v['Flash']['typename'] = "品牌<br />".$b[$v['Flash']['type_id']];break;
				case 'AC': $v['Flash']['typename'] ="文章分类<br />".$acs[$v['Flash']['type_id']];break;
				default :$v['Flash']['typename'] = "未知分类";
			}
			$data[$k] = $v;
			$language = $this->Language->find(array('locale'=>$v['FlashImage']['locale']));
			$data[$k]['FlashImage']['locale'] = $language['Language']['name'];
			//pr($language);
		}
		
		
		$this->set('type',$type);
		$this->set('language',$language);
		$this->set('typeid',$typeid);
		$this->set('b',$b);
		$this->set('pc',$pc);
		$this->set('ac',$ac);
		$this->set('flashes',$data);
		//pr($data);
		$this->set('flashtypes',$flashtypes);
	}
	
	function edit( $id ){
		$this->pageTitle = "Flash轮播管理 - Flash轮播管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'Flash轮播管理','url'=>'/flashes/');
		$this->navigations[] = array('name'=>'编辑Flash轮播管理','url'=>'');
		$this->set('navigations',$this->navigations);
		//	$dataflasheimg = $this->FlashImage->findall();
		//	pr($dataflasheimg);
		if($this->RequestHandler->isPost()){
			$this->data["FlashImage"]["orderby"] = !empty($this->data["FlashImage"]["orderby"])?$this->data["FlashImage"]["orderby"]:50;
			$condition['type'] = $this->data['Flash']['type'];
			$condition['type_id'] = isset($this->data['Flash']['type_id'])?$this->data['Flash']['type_id']:"0";
			$values = $this->Flashe->find($condition);
			$dataflasheimg = $this->FlashImage->findById($id);
			
			$locale_arr = explode(";",substr($dataflasheimg['FlashImage']['locale'], 0, -1));
			//	pr($locale_arr);
			$dataflasheimg['Flash']['type'] = $this->data['Flash']['type'];
			$dataflasheimg['Flash']['type_id'] = isset($this->data['Flash']['type_id'])?$this->data['Flash']['type_id']:"0";
			$this->data['Flash'] = $dataflasheimg['Flash'];
			
			if(true){
				$zid = $this->data['FlashImage']['id'];
				$flash_id = $this->data['FlashImage']['flash_id'];
				$locale = $this->data['FlashImage']['locale'];
				$condition1['FlashImage.id !='] = $zid;
				$condition1['FlashImage.flash_id'] = $flash_id;
				$condition1['FlashImage.locale'] = $locale;
				$value = $this->FlashImage->find($condition1);
				
				if(empty($value)){
					$this->FlashImage->saveAll($this->data);
					$this->flash("Flash编辑成功。点击继续编辑该flash",'/flashes/edit/'.$id,10);
				}else{
					$this->FlashImage->belongsTo = array();
					$this->data['FlashImage']['flash_id'] = $values['Flashe']['id'];
					$this->FlashImage->save(array('FlashImage'=>$this->data['FlashImage']));
					$this->flash("Flash编辑成功。点击继续编辑该flash",'/flashes/edit/'.$id,10);

				}
			}else{
				$this->flash("该类型已经存在",'/flashes/edit/'.$id,10);
			}
		}

		$flashtypes = array('H'=>'首页','PC'=>'分类','B'=>'品牌','AC'=>'文章分类');
		$flashimage = $this->FlashImage->findById($id);
		$flashimages = $this->Flashe->findById($flashimage['FlashImage']['flash_id']);
		$b = array();
		$this->Brand->set_locale($this->locale);
		$brands=$this->Brand->findAll();
		foreach($brands as $k => $v){
			@$b[$v['Brand']['id']] =$v['BrandI18n']['name'] ;

		}
		$this->Category->set_locale($this->locale);
		$pc = $this->Category->findAssoc('P');
		$ac = $this->Category->findAssoc('A');
		//pr($pc);
		//pr($flashimage);
		$this->set('flashimage',$flashimage);
		$this->set('flashtypes',$flashtypes);
		$this->set('flashimages',$flashimages);
		$this->set('b',$b);
		$this->set('ac',$ac);
		$this->set('pc',$pc);
	}
	
	//删除FlashImage
	function remove( $id ){
		$this->FlashImage->deleteall("FlashImage.id = '".$id."'",false);
		$this->flash("删除成功",'/flashes/',10);
	}
	
	function add(){
		$this->pageTitle = "Flash轮播管理 - Flash轮播管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'Flash轮播管理','url'=>'/flashes/');
		$this->navigations[] = array('name'=>'编辑Flash轮播管理','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->data["FlashImage"]["orderby"] = !empty($this->data["FlashImage"]["orderby"])?$this->data["FlashImage"]["orderby"]:50;
			$this->data["FlashImage"]["title"] = !empty($this->data["FlashImage"]["title"])?$this->data["FlashImage"]["title"]:50;
			$locale = $this->data['FlashImage']['locale'];
			$condition['type'] = $this->data['Flash']['type'];
			$condition['type_id'] = isset($this->data['Flash']['type_id'])?$this->data['Flash']['type_id']:"0";
			$values = $this->Flashe->find($condition);
			$condition1['flash_id'] = $values['Flashe']['id'];
			$condition1['locale'] = $locale;
			$flasheimg = $this->FlashImage->find($condition1);
			$flashes = $this->Flash->findById(1);
			$flashes['Flash']['id'] = "''";
			$flashes['Flash']['type'] = $this->data['Flash']['type'];
			@$flashes['Flash']['type_id'] = @$this->data['Flash']['type_id'];
			$this->data['Flash'] = $flashes['Flash'];
			
			if(empty( $values )){
				$this->FlashImage->saveAll($this->data);
				
					$this->flash("Flash添加成功。点击继续编辑该flash",'/flashes/edit/'.$this->FlashImage->getLastInsertId(),10);
			}else{
				
				if(empty($flasheimg)){
					$data['FlashImage'] = $this->data['FlashImage'];
					$data['FlashImage']['flash_id'] = $values['Flashe']['id'];
					$this->data = $data;
					$this->FlashImage->saveAll($this->data);
					$this->flash("Flash添加成功。点击继续编辑该flash",'/flashes/edit/'.$this->FlashImage->getLastInsertId(),10);
				}else{
					$this->FlashImage->belongsTo = array();
					$this->data['FlashImage']['flash_id'] = $flasheimg['FlashImage']['flash_id'];
					$this->FlashImage->save(array('FlashImage'=>$this->data['FlashImage']));
					$this->flash("Flash添加成功。点击继续编辑该flash",'/flashes/edit/'.$this->FlashImage->getLastInsertId(),10);
				}
			}
		}
		if(isset($this->params['url']['id']) && $this->params['url']['id'] != ''){
	   	    $topics_url = "/topics/edit/".$this->params['url']['id'];
	   	    $this->set( "topics_url" ,$topics_url);
	    }
	    
	    
	    
	    
	    $condition1['flash_id'] = 1;
		$locale_list = $this->FlashImage->findAll($condition1);
		
		
		
		
		
		
		$flashtypes = array('H'=>'首页','PC'=>'分类','B'=>'品牌','AC'=>'文章分类');
		$this->set('flashtypes',$flashtypes);
		
		$b = array();
		$this->Brand->set_locale($this->locale);
		$brands=$this->Brand->findAll();
		foreach($brands as $k => $v){
			@$b[$v['Brand']['id']] =$v['BrandI18n']['name'];
		}
		$this->Category->set_locale($this->locale);
		$pc = $this->Category->findAssoc('P');
		$ac = $this->Category->findAssoc('A');
		$this->set('b',$b);
		$this->set('ac',$ac);
		$this->set('pc',$pc);
	}
	
	function flashe(){
			$type = $_REQUEST['type'];
		
			$type_id = $_REQUEST['type_id'];
		
		$this->Flashe->hasMany=array();
		$condition['type'] = $type;
		$condition['type_id'] = $type_id;
		$flashe = $this->Flashe->find( $condition );
		//pr($flashe);
		$this->set('flashe',$flashe);
		Configure::write('debug',0);
		$results['message'] = $flashe;
		die(json_encode($results));
	
	}
}

?>