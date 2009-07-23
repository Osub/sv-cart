<?php
/*****************************************************************************
 * SV-Cart 配送管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: shippingments_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
class ShippingmentsController extends AppController {
	var $name = 'Shippingments';

	var $helpers = array('Html','Pagination');

	var $components = array('Pagination','RequestHandler');
	
	var $uses = array('ShippingI18n','Shipping','ShippingArea','ShippingAreaI18n','ShippingAreaRegion','Region');

	function index(){
		/*判断权限*/
		$this->operator_privilege('ship_view');
		/*end*/
		$this->pageTitle = '配送方式'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'配送方式','url'=>'/shippingments/');
		$this->set('navigations',$this->navigations);
		
		$this->Shipping->hasOne = array();
		$this->Shipping->hasOne = array('ShippingI18n' =>   
                        array('className'    => 'ShippingI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'shipping_id'  
                        )
                  );
        
        $this->Shipping->set_locale($this->locale);
		$condition = '';
		$page = 1;
		$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);		
		$options = array();
		$total = $this->Shipping->findCount($condition,0);
		$sortClass = 'Shipping';
		$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		
		$data = $this->Shipping->find('all',array('page'=>$page,'limit'=>$rownum,'conditions'=>$condition,'order'=>'Shipping.created,Shipping.id'));

		$this->set('shippings',$data);
	}
	function edit($id){
		$this->pageTitle = "编辑配送方式- 配送方式"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'配送方式','url'=>'/shippingments/');
		$this->navigations[] = array('name'=>'编辑配送方式','url'=>'');
	
		$this->Shipping->hasOne = array();
        $this->Shipping->hasMany = array('ShippingI18n'     =>array
												( 
												  'className'    => 'ShippingI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'shipping_id'
					                        	 ) 
                 	   );
		if($this->RequestHandler->isPost()){
			$php_code = serialize(@$this->data['php_code']);
			$shipping['insure_fee'] = $this->data['Shipping']['insure_fee'];
			$shipping['support_cod'] = $this->data['Shipping']['support_cod'];
			$shipping['php_code'] = $php_code;
	  	    $shipping['id'] = $id;
			$this->Shipping->save($shipping);			
			foreach( $this->data["ShippingI18n"] as $k=>$v ){
				$ShippingI18n = array(
					"id"=>!empty($v["id"])?$v["id"]:"",
					"shipping_id"=>$id,
					"locale"=>$v["locale"],
					"name"=>$v["name"],
					"description"=>$v["description"]
				);
				if($v["locale"]==$this->locale){
					$name = $v["name"];
				}
				$this->ShippingI18n->save(array("ShippingI18n"=>$ShippingI18n));
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑配送方式:'.$name ,'operation');
    	    }
			$this->flash("配送方式 ".$name." 编辑成功。点击继续编辑该配送方式。",'/shippingments/edit/'.$id,10);

		}
		$Shipping_info = $this->Shipping->findById($id);
		if($Shipping_info['Shipping']['code'] == "usps"){
			$php_code = unserialize(StripSlashes($Shipping_info['Shipping']['php_code']));
			$this->set('php_code',$php_code);
		//	pr($php_code);
		}
		
		
		foreach( $Shipping_info["ShippingI18n"] as $k=>$v ){
			$Shipping_info["ShippingI18n"][$v["locale"]] = $v;
		}
		//pr($Shipping_info);
		$this->set('Shipping_info',$Shipping_info);
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$Shipping_info["ShippingI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	function area_edit($id,$ids=""){
		$this->pageTitle = "编辑配送方式- 配送方式"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'配送方式','url'=>'/shippingments/');
		$this->Shipping->set_locale($this->locale);
		$Shipping_info = $this->Shipping->findById($ids);
		$this->navigations[] = array('name'=>$Shipping_info['ShippingI18n']['name'],'url'=>'/shippingments/area/'.$ids);
		if($this->RequestHandler->isPost()){
			$this->data['ShippingArea']['orderby'] = !empty($this->data['ShippingArea']['orderby'])?$this->data['ShippingArea']['orderby']:50;
			if( isset( $_REQUEST['items'] ) ){
				foreach($_REQUEST['items'] as $kv=>$vs){
					$datas[$kv]['ShippingAreaRegion']['shipping_area_id']=$id;
					$datas[$kv]['ShippingAreaRegion']['region_id']=$vs;
				
				}

				$this->ShippingAreaRegion->deleteall("shipping_area_id = '".$id."'",false);
				$this->ShippingAreaRegion->saveAll( $datas );
			}
			if(isset($_REQUEST['money']) && sizeof($_REQUEST['money'])>0){
				foreach($_REQUEST['money'] as $k=>$v){
					if($v['value'] == ""){
						$_REQUEST['money'][$k]['value'] = 0;
					}
				}
			}
		//	pr($_REQUEST['money']);exit;
        	$money = serialize( $_REQUEST['money'] );
        	$this->data['ShippingArea']['fee_configures'] = $money;
        	$this->ShippingAreaI18n->deleteall("shipping_area_id = '".$this->data['ShippingArea']['id']."'",false);
    	   	$this->ShippingArea->saveAll($this->data);
    	   	
    	   	
			foreach( $this->data['ShippingAreaI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑配送区域:'.$userinformation_name ,'operation');
    	    }
			$this->flash("配送区域 ".$userinformation_name." 编辑成功。点击继续编辑该配送区域。",'/shippingments/area/'.$_REQUEST['re_id'],10);


        }
        $shippingarearegion_edit = $this->ShippingAreaRegion->findall(array("shipping_area_id"=>$id));
        foreach( $shippingarearegion_edit as $kd=>$vd ){
        	$region_edit[] = $this->Region->locales_formated($vd['ShippingAreaRegion']['region_id']);
		}
		$shippingarea = $this->ShippingArea->findById( $id );
		foreach( $shippingarea['ShippingAreaI18n'] as $k=>$v ){
			$shippingarea['ShippingAreaI18n'][$v['locale']] = $v;
		}
		//pr($shippingarea);
		$money = unserialize($shippingarea['ShippingArea']['fee_configures']); 
		$this->set( "money",$money );
		$region_country = $this->Region->getarealist(0,$this->locale);
		//pr($region_country);
		$region = $this->Region->getarealist(1,$this->locale);
		ksort($region);
		if( isset( $region_edit ) ){
			$this->set('region_edit',$region_edit);
		}
		$this->set('area_id',$ids);
		$this->set('shippingarea',$shippingarea);
		//pr($shippingarea);
		$this->set('region',$region);
		$this->set('region_country',$region_country);
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$shippingarea["ShippingAreaI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	function remove($id){
		$pn = $this->ShippingAreaI18n->find('list',array('fields' => array('ShippingAreaI18n.shipping_area_id','ShippingAreaI18n.name'),'conditions'=> 
                       array('ShippingAreaI18n.shipping_area_id'=>$id,'ShippingAreaI18n.locale'=>$this->locale)));
		$this->ShippingArea->deleteAll("ShippingArea.id='$id'");
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除配送区域:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/shippingments/area/'.$_REQUEST['re_id'],10);
	
	}
	function province( $id ){
		$regions = $this->Region->getarealist($id,$this->locale);
		$i=0;ksort($regions);
	
		$number = count($regions);
		$this->set('regions',$regions);
		if( !empty($regions) ){
			foreach($regions as $k=>$v){
				Configure::write('debug',0);
		        $results['number'] = $number+$k;
		        $results['first_key'] =$k;
		        $results['message'] =$regions;
		       
		        die(json_encode($results));
		    }
	    }else{
	    		Configure::write('debug',0);
		        $results['number'] = $number+$k;
		        $results['first_key'] =$k;
		        $results['message'] =$regions;
		       
		        die(json_encode($results));
		    
	    }
	}
	function area( $id ){
		$this->pageTitle = "编辑配送方式- 配送方式"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'配送方式','url'=>'/shippingments/');
		$this->Shipping->set_locale($this->locale);
		$Shipping_info = $this->Shipping->findById($id);
		$this->navigations[] = array('name'=>$Shipping_info['ShippingI18n']['name'],'url'=>'');
		$this->set('navigations',$this->navigations);
		
		$shippingarea = $this->ShippingArea->findAll(array("shipping_id"=>$id));
		//pr($shippingarea);
		foreach( $shippingarea as $k=>$v ){
			$shippingarea[$k]['ShippingArea']['name'] = "";
			$shippingarea[$k]['ShippingArea']['areaname'] = "";
			
			foreach( $v['ShippingAreaI18n'] as $kk=>$vv ){
				if($vv['locale'] == $this->locale){
					$shippingarea[$k]['ShippingArea']['name'] = $vv['name'];
					$shippingarea[$k]['ShippingArea']['description'] = $vv['description'];
				}
			}
			$condition["shipping_area_id"] = $v["ShippingArea"]["id"];
			$shippingarearegion = $this->ShippingAreaRegion->findAll( $condition );
			//pr($shippingarearegion);
			foreach( $shippingarearegion as $kkk=>$vvv ){
				 $region_id = $vvv["ShippingAreaRegion"]["region_id"];
				$region = $this->Region->findAll(array("Region.id"=>$region_id));
				//pr($region);
				foreach( $region as $ka=>$val ){
						$shippingarea[$k]['ShippingArea']['areaname'].= $val['RegionI18n']['name']."|";
				}
			}	
		}
		
		$this->set( "ids",$id );
		$this->set('shippingarea',$shippingarea);
	}
	
	function area_add( $id ) {
		$this->pageTitle = "编辑配送区域- 配送方式"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'配送方式','url'=>'/shippingments/');
		$this->Shipping->set_locale($this->locale);
		$Shipping_info = $this->Shipping->findById($id);
		$this->navigations[] = array('name'=>$Shipping_info['ShippingI18n']['name'],'url'=>'/shippingments/area/'.$id);
		$this->set('navigations',$this->navigations);
	
		if($this->RequestHandler->isPost()){
			$this->data['ShippingArea']['orderby'] = !empty($this->data['ShippingArea']['orderby'])?$this->data['ShippingArea']['orderby']:50;
			if(isset($_REQUEST['money']) && sizeof($_REQUEST['money'])>0){
				foreach($_REQUEST['money'] as $k=>$v){
					if($v['value'] == ""){
						$_REQUEST['money'][$k]['value'] = 0;
					}
				}
			}
		
			$money = serialize( $_REQUEST['money'] );
        	$this->data['ShippingArea']['fee_configures'] = !empty($money)?$money:0;
			$this->data['ShippingArea']['free_subtotal'] = !empty($this->data['ShippingArea']['free_subtotal'])?$this->data['ShippingArea']['free_subtotal']:0;
    	   	$this->ShippingArea->saveAll($this->data);
			
			if( isset( $_REQUEST['items'] ) ){
				foreach($_REQUEST['items'] as $kv=>$vs){
					$datas[$kv]['ShippingAreaRegion']['shipping_area_id']=$this->ShippingArea->getLastInsertID();
					$datas[$kv]['ShippingAreaRegion']['region_id']=$vs;
				
				}
					$this->ShippingAreaRegion->saveAll( $datas );
			}
			//pr($datas);
			foreach( $this->data['ShippingAreaI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加配送区域:'.$userinformation_name ,'operation');
    	    }
			$this->flash("配送区域 ".$userinformation_name." 编辑成功。点击继续编辑该配送区域。",'/shippingments/area_edit/'.$this->ShippingArea->getLastInsertID().'/'.$id,10);

        	//pr($this->data);
        }
		
		$region_country = $this->Region->getarealist(0,$this->locale);
		//pr($region_country);
		$region = $this->Region->getarealist(1);
		ksort($region);
		$this->set('region',$region);
		$this->set('region_country',$region_country);
		$this->set('ids',$id);
	
	}


	
	function install( $id ){
		 $this->Shipping->updateAll(
			              array('Shipping.status' => 1),
			              array('Shipping.id' => $id)
			           );
		$this->Shipping->set_locale($this->locale);
		$ship_info = $this->Shipping->findById($id);
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'安装配送方式:'.$ship_info['ShippingI18n']['name'] ,'operation');
    	}
        $this->flash("安装成功",'/shippingments/',10);
	
	}
	function uninstall( $id ){
		 $this->Shipping->updateAll(
			              array('Shipping.status' => 0),
			              array('Shipping.id' => $id)
			           );
		$this->Shipping->set_locale($this->locale);
		$ship_info = $this->Shipping->findById($id);
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'卸载配送方式:'.$ship_info['ShippingI18n']['name'] ,'operation');
    	}
         $this->flash("卸载成功",'/shippingments/',10);
	
	}
}

?>