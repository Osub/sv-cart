<?php
/*****************************************************************************
 * SV-Cart 站点地图
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: sitemaps_controller.php 4691 2009-09-28 10:11:57Z huangbo $
*****************************************************************************/

class SitemapsController extends AppController {
	var $name = 'Sitemaps';
	var $helpers = array('Html','Pagination');
	var $components = array('Pagination','RequestHandler');
	var $uses = array('Sitemap');
	function index(){
		/*判 断 权 限*/
		$this->operator_privilege('sitemap_view');
		/*end*/
		$this->pageTitle = '站点地图'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'系统管理','url'=>'');
		$this->navigations[] = array('name'=>'站点地图','url'=>'/sitemap/');
		$this->set('navigations',$this->navigations);
		$condition = '';
		$data = $this->Sitemap->find('all',array('conditions'=>$condition,'order'=>'Sitemap.id,Sitemap.created'));
		$this->set('sitemaps',$data);	
	}

	function cycle(){
		$cycle = array('always' => '一直更新','hourly' => '小时','daily' => '天','weekly' => '周','monthly' => '月','yearly' => '年','never' => '从不更新');		
		return $cycle;
	}
	function frequency(){
		$frequency = array('1.0' => '1.0','0.9' => '0.9','0.8' => '0.8','0.7' => '0.7','0.6' => '0.6','0.5' => '0.5','0.4' => '0.4','0.3' => '0.3','0.2' => '0.2','0.1' => '0.1',);		
		return $frequency;
	}
		
	function add(){
		$this->operator_privilege('sitemap_add');
		$this->pageTitle = "新增模块- 站点地图" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'系统管理','url'=>'');
		$this->navigations[] = array('name'=>'站点地图','url'=>'/sitemaps/');
		$this->navigations[] = array('name'=>'新增模块','url'=>'');
		$this->set('navigations',$this->navigations);
		$this->set('cycle',$this->cycle());
		$this->set('frequency',$this->frequency());
		if($this->RequestHandler->isPost()){
			if( !empty($this->data['Sitemap']['name']) ){
				$this->Sitemap->save($this->data['Sitemap']); //保存
				$id=$this->Sitemap->id;
				//操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加模块:'.$this->data['Sitemap']['name'] ,'operation');
    	        }
				$this->flash("模块  ".$this->data['Sitemap']['name']." 添加成功。点击这里继续编辑该模块。",'/sitemaps/edit/'.$id,10);
			}else{
			
			}
		}
	}
	
	function edit($id){
		/*判断权限*/
		$this->operator_privilege('sitemap_edit');
		/*end*/
		$this->pageTitle = "编辑模块 - 站点地图"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'系统管理','url'=>'');
		$this->navigations[] = array('name'=>'站点地图','url'=>'/sitemaps/');
		$this->navigations[] = array('name'=>'编辑模块','url'=>'');
		
		$this->set('cycle',$this->cycle());
		$this->set('frequency',$this->frequency());		
		if($this->RequestHandler->isPost()){
			if( !empty($this->data['Sitemap']['name']) ){
				$this->Sitemap->deleteall("id = ".$this->data['Sitemap']['id'],false); 
				$this->Sitemap->saveall($this->data); //保存
				//操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑模块:'.$this->data['Sitemap']['name'] ,'operation');
    	        }
				$this->flash("模块 ".$this->data['Sitemap']['name']." 编辑成功。点击这里继续编辑该模块。",'/sitemaps/edit/'.$id,10);
			}
		}
		$provider_edit=$this->Sitemap->findbyid( $id );
	
		$condition['Sitemap.id'] = $id;
		$sitemap_info = $this->Sitemap->find( $condition );
		$this->set('sitemap_info',$sitemap_info);
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$provider_edit["Sitemap"]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}	
	
	function remove( $id ){
		$this->operator_privilege('sitemap_edit');
		$sitemap_info = $this->Sitemap->findById($id);
		$this->Sitemap->deleteall("Sitemap.id = '".$id."'",false);
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除模块:'.$sitemap_info['Sitemap']['name'] ,'operation');
    	}
		$this->flash("删除成功",'/sitemaps/',10);
	}	
	
}

?>