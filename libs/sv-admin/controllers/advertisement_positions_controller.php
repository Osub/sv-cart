<?php
/*****************************************************************************
 * SV-Cart 广告位置管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: advertisement_positions_controller.php 4691 2009-09-28 10:11:57Z huangbo $
*****************************************************************************/

class AdvertisementPositionsController extends AppController {
	var $name = 'AdvertisementPositions';
	var $helpers = array('Html','Pagination');
	var $components = array('Pagination','RequestHandler');
	var $uses = array('Advertisement','AdvertisementI18n','AdvertisementPosition');
	function index(){
		/*判 断 权 限*/
		$this->operator_privilege('advertisment_view');
		/*end*/
		$this->pageTitle = '广告位'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'广告位','url'=>'/advertisement_positions/');
		$this->set('navigations',$this->navigations);
		$condition = '';
		$page = 1;
		$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);		
		$options = array();
		$total = $this->AdvertisementPosition->findCount($condition,0);
		$sortClass = 'AdvertisementPosition';
		$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		$data = $this->AdvertisementPosition->find('all',array('page'=>$page,'limit'=>$rownum,'conditions'=>$condition,'order'=>'AdvertisementPosition.orderby,AdvertisementPosition.id desc'));
		$this->set('advertisement_positions',$data);
		
	}
	function edit($id){
		$this->pageTitle = "编辑广告位- 广告位"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'广告位','url'=>'/advertisement_positions/');
		$this->navigations[] = array('name'=>'编辑广告位','url'=>'');
		
		if($this->RequestHandler->isPost()){
			$this->data['AdvertisementPosition']['position_desc'] = !empty($this->data['AdvertisementPosition']['position_desc'])?$this->data['AdvertisementPosition']['position_desc']:" ";
			
			$data1=array('AdvertisementPosition.name'=>"'".$this->data['AdvertisementPosition']['name']."'",
				         'AdvertisementPosition.ad_width'=>!empty($this->data['AdvertisementPosition']['ad_width'])?$this->data['AdvertisementPosition']['ad_width']:100,
				         'AdvertisementPosition.ad_height'=>!empty($this->data['AdvertisementPosition']['ad_height'])?$this->data['AdvertisementPosition']['ad_height']:100,
				         'AdvertisementPosition.position_desc'=>"'".$this->data['AdvertisementPosition']['position_desc']."'",
				   
				         'AdvertisementPosition.orderby'=>!empty($this->data['AdvertisementPosition']['orderby'])?$this->data['AdvertisementPosition']['orderby']:50
			);
			$this->AdvertisementPosition->updateAll($data1,array('AdvertisementPosition.id'=>$id)); //保存
			$this->flash("广告 ".$this->data['AdvertisementPosition']['name']." 编辑成功。点击这里继续编辑该广告。",'/advertisement_positions/edit/'.$id,10);
			//操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	     $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑广告:'.$this->data['AdvertisementPosition']['name'] ,'operation');
    	    }
		}
		
		$js_code  = "<script";
		$js_code .= ' src='.'"'.$this->server_host.$this->cart_webroot.'advertisements/show/'.$id.'"'.'></script>';
		
		$site_url = $this->server_host.$this->cart_webroot.'advertisements/show/'.$id;
		
		$this->set('js_code',     $js_code);

		$advertisement_position = $this->AdvertisementPosition->findbyid($id);
		$this->set("advertisement_position",$advertisement_position);
		$this->navigations[] = array('name'=>$advertisement_position["AdvertisementPosition"]["name"],'url'=>'');
		$this->set('navigations',$this->navigations);
	}
	
	function add(){
		$this->pageTitle = "添加广告位- 广告管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'广告位','url'=>'/advertisement_positions/');
		$this->navigations[] = array('name'=>'添加广告位','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->data['AdvertisementPosition']['id']	= "";
			$this->data['AdvertisementPosition']['position_desc'] = !empty($this->data['AdvertisementPosition']['position_desc'])?$this->data['AdvertisementPosition']['position_desc']:" ";
			$this->data['AdvertisementPosition']['orderby'] = !empty($this->data['AdvertisementPosition']['orderby'])?$this->data['AdvertisementPosition']['orderby']:50;
			$this->AdvertisementPosition->saveall($this->data);
			$this->flash("广告位  ".$this->data['AdvertisementPosition']['name']."  添加成功。点击这里继续编辑该广告。",'/advertisement_positions/edit/'.$this->AdvertisementPosition->getLastInsertId(),10);
			//操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	     $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加广告位:'.$this->data['AdvertisementPosition']['name'] ,'operation');
    	    }
		}
	}
	
	
	function remove($id){
		$pn = $this->AdvertisementPosition->find('list',array('fields' =>
			                  array('AdvertisementPosition.id','AdvertisementPosition.name'),'conditions'=> 
                                                        array('AdvertisementPosition.id'=>$id)));
		$this->AdvertisementPosition->deleteall("AdvertisementPosition.id = '".$id."'",false); 
		//操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除广告位:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/advertisement_positions/',10);
	}
}
?>