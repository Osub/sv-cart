<?php
/*****************************************************************************
 * SV-Cart 广告条
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: advertisements_controller.php 5439 2009-10-26 10:10:48Z huangbo $
*****************************************************************************/

class AdvertisementsController extends AppController {
	var $name = 'Advertisements';
	var $helpers = array('Html','Pagination','Tinymce','fck');
	var $components = array('Pagination','RequestHandler');
	var $uses = array('Advertisement','AdvertisementI18n','AdvertisementPosition','Language');
	function index(){
		/*判 断 权 限*/
		$this->operator_privilege('advertisment_view');
		/*end*/
		$this->pageTitle = '广告条'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'广告条','url'=>'/advertisement/');
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
		$data = $this->Advertisement->find('all',array('page'=>$page,'limit'=>$rownum,'conditions'=>$condition,'order'=>'Advertisement.id desc'));
		$this->set('advertisements',$data);
		
	}
	function edit( $id ){
		$this->pageTitle = "编辑广告- 广告条"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'广告条','url'=>'/advertisements/');
		$this->navigations[] = array('name'=>'编辑广告','url'=>'');
		if($this->RequestHandler->isPost()){
			$data1 = array();
			$url = isset($this->data['AdvertisementI18n']['url'])?$this->data['AdvertisementI18n']['url']:'';
			$url_type = isset($this->data['AdvertisementI18n']['url_type'])?$this->data['AdvertisementI18n']['url_type']:'0';
			$enddate = !empty($this->data['AdvertisementI18n']['end_time'])?$this->data['AdvertisementI18n']['end_time']:
			date("Y-m-d",strtotime($this->data['AdvertisementI18n']['end_time']))." 23:59:59";
			
			$data1 = array(		           'Advertisement.advertisement_position_id'=>"'".$this->data['Advertisement']['advertisement_position_id']."'",
				           'Advertisement.contact_name'=>"'".$this->data['Advertisement']['contact_name']."'",
				           'Advertisement.contact_tele'=>"'".$this->data['Advertisement']['contact_tele']."'",
				           'Advertisement.contact_email'=>"'".$this->data['Advertisement']['contact_email']."'",
				           'Advertisement.status'=>"'".$this->data['Advertisement']['status']."'",
				           'Advertisement.orderby'=>!empty($this->data['Advertisement']['orderby'])?$this->data['Advertisement']['orderby']:50
				);
			$this->Advertisement->updateAll($data1,array('Advertisement.id'=>$id)); //更新
			
            //更新广告名称
            $adinid = $this->AdvertisementI18n->find('list',array('fields'=>array('AdvertisementI18n.locale','AdvertisementI18n.id'),'conditions'=>array('AdvertisementI18n.advertisement_id'=>$id)));
            if(is_array($this->data['AdvertisementI18n']['mutilan'])){
			foreach($this->data['AdvertisementI18n']['mutilan'] as $k => $v){
		    $data2 = array();
		    			           $data2=array('AdvertisementI18n.description'=>"'".$this->data['AdvertisementI18n']['description']."'",
				           'AdvertisementI18n.start_time'=>"'".$this->data['AdvertisementI18n']['start_time']."'",
				           'AdvertisementI18n.end_time'=>"'".$enddate."'",
				           'AdvertisementI18n.url_type'=>"'".$url_type."'",
				           'AdvertisementI18n.url'=>"'".$url."'",
				           'AdvertisementI18n.code'=>"'".$this->data['AdvertisementI18n']['code']."'",
				           'AdvertisementI18n.name' => "'".$v['name']."'",
				           'AdvertisementI18n.advertisement_id' => "'".$id."'",
				           'AdvertisementI18n.locale' => "'".$k."'");
		     
	        $this->AdvertisementI18n->updateAll($data2,array('AdvertisementI18n.id'=>$adinid[$k]));
				if($this->locale==$k){
					$advertisement_name = $v['name'];
				}
			}
			}
				
			$this->flash("广告 ".$advertisement_name." 编辑成功",'/advertisements/edit/'.$id,10);
			//操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	     $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑广告:'.$advertisement_name ,'operation');
    	    }
		}
		$this->Advertisement->set_locale($this->locale);
		$advertisement = $this->Advertisement->findbyid($id);
		
		//取得所有语言广告
		$this->AdvertisementI18n->hasOne = array('Language' =>   
                        array('className'    => 'Language', 
                              'conditions'   =>'Language.locale = AdvertisementI18n.locale',
                              'order'        =>'',   
                              'dependent'    =>true,   
                              'foreignKey'   => ''  
                        )
                  );
        
        $alllanadvertisement = $this->AdvertisementI18n->find('list',array('fields'=>array('AdvertisementI18n.locale','AdvertisementI18n.name'),'conditions'=>array('AdvertisementI18n.advertisement_id'=>$id)));

		//取得广告位
	    $advertisement_positions = $this->AdvertisementPosition->find('all',array('fields' => array('id','name')));
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$advertisement["AdvertisementI18n"]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);
	    
		$this->set('advertisement_positions',$advertisement_positions);
		$this->set("advertisement",$advertisement);
		$this->set("alllanadvertisement",$alllanadvertisement);

	}
	
	function add(){
		$this->pageTitle = "添加广告- 广告条" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'广告条','url'=>'/advertisements/');
		$this->navigations[] = array('name'=>'添加广告','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$data1 = array();
			$data2 = array();
			$data2['Advertisement'] = $this->data['Advertisement'];
			$this->Advertisement->save($data2);
			$id=$this->Advertisement->id;
			
			if($this->data['Advertisement']['media_type']=='0')
			{
				$data1['AdvertisementI18n']['description'] = $this->data['AdvertisementI18n']['description'];
				$data1['AdvertisementI18n']['start_time'] = $this->data['AdvertisementI18n']['start_time'];
				$data1['AdvertisementI18n']['end_time'] =!empty($this->data['AdvertisementI18n']['end_time'])?$this->data['AdvertisementI18n']['end_time']:date("Y-m-d",strtotime($this->data['AdvertisementI18n']['end_time']))." 23:59:59";
				$data1['AdvertisementI18n']['code'] = $this->data['AdvertisementI18n']['code_0'];
				$data1['AdvertisementI18n']['url'] = $this->data['AdvertisementI18n']['url_0'];
				$data1['AdvertisementI18n']['url_type'] = $this->data['AdvertisementI18n']['url_type'];
				
			}
			elseif($this->data['Advertisement']['media_type']=='1')
			{
				$data1['AdvertisementI18n']['description'] = $this->data['AdvertisementI18n']['description'];
				$data1['AdvertisementI18n']['start_time'] = $this->data['AdvertisementI18n']['start_time'];
				$data1['AdvertisementI18n']['end_time'] = 
				date("Y-m-d",strtotime($this->data['AdvertisementI18n']['end_time']))." 23:59:59";
				$data1['AdvertisementI18n']['code'] = $this->data['AdvertisementI18n']['code_1'];
			}
			elseif($this->data['Advertisement']['media_type']=='2')
			{
				$data1['AdvertisementI18n']['description'] = $this->data['AdvertisementI18n']['description'];
				$data1['AdvertisementI18n']['start_time'] = $this->data['AdvertisementI18n']['start_time'];
				$data1['AdvertisementI18n']['end_time'] = 
				date("Y-m-d",strtotime($this->data['AdvertisementI18n']['end_time']))." 23:59:59";
				$data1['AdvertisementI18n']['code'] = $this->data['AdvertisementI18n']['code'];
			}
			elseif($this->data['Advertisement']['media_type']=='3')
			{
				$data1['AdvertisementI18n']['description'] = $this->data['AdvertisementI18n']['description'];
				$data1['AdvertisementI18n']['start_time'] = $this->data['AdvertisementI18n']['start_time'];
				$data1['AdvertisementI18n']['end_time'] = 
				date("Y-m-d",strtotime($this->data['AdvertisementI18n']['end_time']))." 23:59:59";
				$data1['AdvertisementI18n']['code'] = $this->data['AdvertisementI18n']['code_3'];
				$data1['AdvertisementI18n']['url'] = $this->data['AdvertisementI18n']['url_3'];
			}
			
			if(is_array($this->data['AdvertisementI18n']['mutilan']))
			foreach($this->data['AdvertisementI18n']['mutilan'] as $k => $v){
				$data1['AdvertisementI18n']['advertisement_id']=$id;
				$this->AdvertisementI18n->id='';
				$data1['AdvertisementI18n']['locale'] = $k;
				$data1['AdvertisementI18n']['name'] = $v['name'];
				$this->AdvertisementI18n->save($data1);
				if($this->locale==$k){
					$advertisement_name = $v['name'];
				}
			}
			
			$this->flash("广告  ".$advertisement_name."  添加成功。点击这里继续编辑该广告。",'/advertisements/edit/'.$this->Advertisement->getLastInsertId(),10);
			//操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	     $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加广告:'.$advertisement_name,'operation');
    	    }
		}
	    
	    //取得广告位
	    $advertisement_positions = $this->AdvertisementPosition->find('all',array('fields' => array('id','name')));
		$this->set('advertisement_positions',$advertisement_positions);
	    
	}
	function remove($id){
		$pn = $this->AdvertisementI18n->find('list',array('fields' => array('AdvertisementI18n.advertisement_id','AdvertisementI18n.name'),'conditions'=> 
                                        array('AdvertisementI18n.advertisement_id'=>$id,'AdvertisementI18n.locale'=>$this->locale)));
		$this->Advertisement->deleteall("Advertisement.id = '".$id."'",false); 
		$this->AdvertisementI18n->deleteall("AdvertisementI18n.advertisement_id = '".$id."'",false);
		
		//操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除广告:'.$pn[$id],'operation');
    	}
		$this->flash("删除成功",'/advertisements/',10);
	}
}

?>