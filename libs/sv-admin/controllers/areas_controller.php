<?php
/*****************************************************************************
 * SV-Cart 区域管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: areas_controller.php 4366 2009-09-18 09:49:37Z huangbo $
*****************************************************************************/
class AreasController extends AppController {
	var $name = 'Areas';
	var $helpers = array('Html');
	var $uses = array("Region","RegionI18n");

	function index($pid=0){
		/*判断权限*/
		$this->operator_privilege('zone_view');
		/*end*/
		$this->pageTitle = "区域管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'系统管理','url'=>'');
		$this->navigations[] = array('name'=>'区域管理','url'=>'/areas/');
		$area_list=$this->Region->getarealist($pid,$this->locale);
		$region_parents = $this->Region->get_parents($pid);
		$num = "1";
		if(!empty($region_parents)){
			$count = count($region_parents);
			for($i=$count-1;$i>=0;$i--){
				$num++;
				$this->navigations[] = array('name'=>$region_parents[$i]['name'],'url'=>'/areas/index/'.$region_parents[$i]['id']);
			}
		}
		switch ($num) {
			  case 1:
			    $num_name="一级地区";
			    break;
			  case 2:
			    $num_name="二级地区";
			    break;
			  case 3:
			    $num_name="三级地区";
			    break;
			  case 4:
			    $num_name="四级地区";
			    break;
			  default:
			    $num_name="未知地区";
			    break;
		}
		$languages=$this->Language->findall("","","id");
		$this->set('area_languages'	,$languages);
		$this->set('navigations',$this->navigations);
		$this->set('num_name',$num_name);
		$this->set('area_list',$area_list);
		$this->set('pid',$pid);
	}
	function edit($region_id){
		$Region_info = $this->Region->findById($region_id);
		$edit_region = $this->RegionI18n->findAll(array("region_id"=>$region_id));
		foreach($edit_region as $k=>$v){
			$arr[$k]['locale'] = $v['RegionI18n']['locale'];
			$arr[$k]['name'] = $v['RegionI18n']['name'];
			$arr[$k]['id'] = $v['RegionI18n']['id'];
			$arr[$k]['orderby'] = $Region_info['Region']['orderby'];
			$arr[$k]['region_id'] = $region_id;
			$arr[$k]['abbreviated'] = $Region_info['Region']['abbreviated'];
		}
		Configure::write('debug',0);
		die(json_encode($arr));
	}
/*------------------------------------------------------ */
//-- 新增地区
/*------------------------------------------------------ */
    function add(){
		$this->pageTitle = "添加地区-区域管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'系统管理','url'=>'');
		$this->navigations[] = array('name'=>'区域管理','url'=>'/areas/');
		$this->navigations[] = array('name'=>'添加地区','url'=>'');
		$Region_info = $this->Region->find("","","Region.id desc");
		$region_info=array(
				'id'=>isset($this->params['form']['region_id'])?$this->params['form']['region_id']:"",
				'parent_id'=>isset($this->params['form']['parent_id'])?$this->params['form']['parent_id']:0,
				'level'=>isset($this->params['form']['level'])?$this->params['form']['parent_id']:'0',
				'agency_id'=>isset($this->params['form']['agency_id'])?$this->params['form']['agency_id']:0,
				'param01'=>isset($this->params['form']['param01'])?$this->params['form']['param01']:'',
				'param02'=>isset($this->params['form']['param02'])?$this->params['form']['param02']:'',
				'param03'=>isset($this->params['form']['param03'])?$this->params['form']['param03']:'',
				'orderby'=>!empty($this->params['form']['orderby'])?$this->params['form']['orderby']:50,
				'abbreviated'=>!empty($this->params['form']['orderby'])?$this->params['form']['abbreviated']:"",
		);
		
    	$this->Region->save(array('Region'=>$region_info));
    	$id=$this->Region->id;
   		
    	if(is_array($this->data['RegionI18n'])){
			foreach($this->data['RegionI18n'] as $k => $v){
				$v['region_id']=$id;
				$v['description'] = "";
				$this->RegionI18n->save(array('RegionI18n'=>$v)); 
			}
			foreach( $this->data['RegionI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
		}
		$this->flash("地区 ".$userinformation_name." 编辑成功。",'/areas/index/'.$this->params['form']['parent_id'],10);
     }
/*------------------------------------------------------ */
//-- 删除地区
/*------------------------------------------------------ */
    function remove($id){
    	   $this->pageTitle = "删除地区-区域管理"." - ".$this->configs['shop_name'];
    	   $this->navigations[] = array('name'=>'系统管理','url'=>'');
		   $this->navigations[] = array('name'=>'区域管理','url'=>'/areas/');
		   $this->navigations[] = array('name'=>'删除地区','url'=>'');
    	   $this->Region->deleteAll("Region.id = '".$id."'",false);
		   $this->RegionI18n->deleteAll("RegionI18n.region_id = '".$id."'");
    	   $this->flash("删除成功",'/areas/',10);
    }
/*------------------------------------------------------ */
//-- ajax修改未命名的区域
/*------------------------------------------------------ */
    function ajaxeditregion($new_region_name,$regioni18n_id){
		if($new_region_name != '' && $regioni18n_id > 0){
			$this->RegionI18n->updateAll(
				array('RegionI18n.name' => "'".$new_region_name."'"),
				array('RegionI18n.id' => "'".$regioni18n_id."'")
			);
			$msg='区域新命名成功';
		}else{
			$msg='请重新确认你填写的区域名称';
		}
		Configure::write('debug',0);
		$result['type'] = "0";
		$result['msg'] = $msg;
		die(json_encode($result));
    }
}

?>