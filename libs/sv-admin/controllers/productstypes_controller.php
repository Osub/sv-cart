<?php
/*****************************************************************************
 * SV-Cart 类型管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: productstypes_controller.php 5433 2009-10-26 09:49:14Z huangbo $
 *****************************************************************************/
class ProductstypesController extends AppController{
    var $name='Productstypes';
    var $helpers=array('Html','Pagination');
    var $components=array('Pagination','RequestHandler');
    var $uses=array('ProductType','ProductTypeI18n','ProductTypeAttribute','ProductTypeAttributeI18n','SystemResource');
    function index(){
        /*判断权限*/
        $this->operator_privilege('goods_type_view');
        /*end*/
        $this->pageTitle='类型管理'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '类型管理','url' => '/productstypes/');
        $this->set('navigations',$this->navigations);
        $condition='';
        $page=1;
        $rownum=10;
        $parameters=array($rownum,$page);
        $options=array();
        $total=$this->ProductType->findCount($condition,0);
        $sortClass='ProductType';
        list($page)=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $data=$this->ProductType->find('all',array('page' => $page,'limit' => $rownum,'conditions' => $condition,'order' => 'ProductType.orderby,ProductType.created,ProductType.id'));
        foreach($data as $k => $v){
            $data[$k]['ProductType']['name']='';
            $data[$k]['ProductType']['num']=count($v['ProductTypeAttribute']);
            if(!empty($v['ProductTypeI18n']))
            foreach($v['ProductTypeI18n']as $vv){
                if($vv['locale']==$this->locale){
                    $data[$k]['ProductType']['name']=$vv['name'];
                }
            }
        }
        $this->set('productstype',$data);
    }
    function edit($id){
        /*判断权限*/
        $this->operator_privilege('goods_type_view');
        /*end*/
        $this->pageTitle="编辑商品类型 - 类型管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '类型管理','url' => '/productstypes/');
        $this->navigations[]=array('name' => '编辑商品类型','url' => '');
        
        if($this->RequestHandler->isPost()){
            $this->ProductTypeI18n->deleteAll("type_id='".$this->data['ProductType']['id']."'",false);
            $this->ProductType->saveAll($this->data);
            foreach($this->data['ProductTypeI18n']as $k => $v){
                if($v['locale']==$this->locale){
                    $userinformation_name=$v['name'];
                }
            }
            $id=$this->ProductType->id;
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑商品类型:'.$userinformation_name,'operation');
            }
            $this->flash("商品类型".$userinformation_name."编辑成功。点击这里继续编辑该商品类型。",'/productstypes/edit/'.$id,10);
        }
        $this->data=$this->ProductType->findById($id);
        foreach($this->data['ProductTypeI18n']as $k => $v){
            $this->data['ProductTypeI18n'][$v['locale']]=$v;
        }
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["ProductTypeI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

    }
    function add(){
        /*判断权限*/
        $this->operator_privilege('goods_type_add');
        /*end*/
        $this->pageTitle="编辑商品类型 - 类型管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '类型管理','url' => '/productstypes/');
        $this->navigations[]=array('name' => '编辑商品类型','url' => '');
        $this->set('navigations',$this->navigations);
        if($this->RequestHandler->isPost()){
            $this->ProductType->saveAll($this->data);
            foreach($this->data['ProductTypeI18n']as $k => $v){
                if($v['locale']==$this->locale){
                    $userinformation_name=$v['name'];
                }
            }
            $id=$this->ProductType->id;
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加商品类型:'.$userinformation_name,'operation');
            }
            $this->flash("商品类型".$userinformation_name."添加成功。点击这里继续编辑该商品类型。",'/productstypes/edit/'.$id,10);
        }
    }
    function look($id){
        $this->pageTitle='属性列表'." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '属性列表','url' => '/productstypes/');
        $this->ProductTypeAttribute->set_locale($this->locale);
        if($id>0){
	        $ProductType_info=$this->ProductType->findById($id);
	        foreach($ProductType_info['ProductTypeI18n']as $k => $v){
	            if($v['locale']==$this->locale){
	                $name=$v['name'];
	            }
	        }
        }
        else{
        	$name="公共类型";
        }
        $this->navigations[]=array('name' => $name,'url' => '/productstypes/');
        $this->set('navigations',$this->navigations);
        
		$this->ProductTypeAttribute->hasOne = array('ProductTypeAttributeI18n' =>   
                        array('className'    => 'ProductTypeAttributeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'product_type_attribute_id'  
                        )
                  );
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();
       	//

        $this->set("systemresource_info",$systemresource_info);

        $this->ProductTypeAttribute->set_locale($this->locale);
        $attribute=$this->ProductTypeAttribute->find("all",array("conditions"=>array("product_type_id" => $id),"order"=>"orderby,name"));
       
        $this->set("id",$id);
        $this->set("attribute",$attribute);
    }
    function lookedit($id,$product_type_id){
        $this->pageTitle="编辑属性 - 属性管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '属性管理','url' => '/productstypes/look/'.$product_type_id);
        $this->navigations[]=array('name' => '编辑属性','url' => '');
        $this->ProductTypeAttribute->set_locale($this->locale);
        if($product_type_id>0){
	        $ProductType_info=$this->ProductType->findById($product_type_id);
	        foreach($ProductType_info['ProductTypeI18n']as $k => $v){
	            if($v['locale']==$this->locale){
	                $name=$v['name'];
	            }
	        }
        }
        else{
        	$name="公共类型";
        }
        $this->navigations[]=array('name' => $name,'url' => '/productstypes/');
        $this->set('navigations',$this->navigations);
        
        if($this->RequestHandler->isPost()){
            $this->data['ProductTypeAttribute']['orderby']=!empty($this->data['ProductTypeAttribute']['orderby']) ? $this->data['ProductTypeAttribute']['orderby']: 50;
            $this->ProductTypeAttributeI18n->deleteAll("ProductTypeAttributeI18n.product_type_attribute_id='".$this->data['ProductTypeAttribute']['id']."'",false);
            $this->ProductTypeAttribute->deleteAll("ProductTypeAttribute.id='".$this->data['ProductTypeAttribute']['id']."'",false);
            $this->ProductTypeAttribute->saveAll($this->data['ProductTypeAttribute']);
            $Attr_name='';
            foreach($this->data['ProductTypeAttributeI18n']as $v){
                $p_I18n_info=array('id' => '','locale' => $v['locale'],'product_type_attribute_id' => $this->data['ProductTypeAttribute']['id'],'name' => $v['name']);
                $Attr_name.=(' '.$v['name']);
                $this->ProductTypeAttributeI18n->saveall(array('ProductTypeAttributeI18n' => $p_I18n_info)); //更新多语言
            }
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑商品属性:'.$Attr_name,'operation');
            }
            
           
            foreach( $this->data['ProductTypeAttributeI18n'] as $k=>$v ){
            	if($v["locale"]==$this->locale){
            		$locale_name = $v["name"];
            	}
            }
            $this->flash('属性 '.$locale_name.' 编辑成功 点击这里继续编辑该属性','/productstypes/lookedit/'.$id."/".$product_type_id."/",'');
            //pr($this->data);
        }
        $this->ProductTypeAttribute->set_locale($this->locale);
		$this->ProductTypeAttribute->hasMany = array('ProductTypeAttributeI18n' =>   
                        array('className'    => 'ProductTypeAttributeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'product_type_attribute_id'  
                        )
                  );
		$this->ProductTypeAttribute->hasOne = array(
        				'ProductAttribute' =>
        				array('className'    => 'ProductAttribute', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'product_type_attribute_id'  
                        )
                  );

        $attribute=$this->ProductTypeAttribute->findById($id);
        foreach( $attribute["ProductTypeAttributeI18n"] as $k=>$v ){
        	$attribute["ProductTypeAttributeI18n"][$v["locale"]] = $v;
        }
        $this->ProductType->hasOne = array('ProductTypeI18n'=>
						array('className'  => 'ProductTypeI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'type_id'							
						),
					
					);
        $this->ProductType->hasMany = array();
		$this->ProductType->set_locale($this->locale);
        $ProductType_info = $this->ProductType->find("all",array("conditions"=>array("ProductType.status"=>1)));
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();
       	//

        $this->set("systemresource_info",$systemresource_info);
        $this->set("ProductType_info",$ProductType_info);
        $this->set("attribute",$attribute);
        $this->set("product_type_id",$product_type_id);
    }
    function lookadd($id){
        $this->pageTitle="新增属性 - 属性管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'产品管理','url'=>'');
        $this->navigations[]=array('name' => '属性管理','url' => '/productstypes/look/'.$id);
        $this->navigations[]=array('name' => '新增属性','url' => '');
        $this->set('navigations',$this->navigations);
        //		$this->ProductTypeAttribute->hasOne = array();
        if($this->RequestHandler->isPost()){
            $this->data['ProductTypeAttribute']['orderby']=!empty($this->data['ProductTypeAttribute']['orderby']) ? $this->data['ProductTypeAttribute']['orderby']: 50;
            $this->ProductTypeAttribute->save($this->data['ProductTypeAttribute']);
            $pid=$this->ProductTypeAttribute->id;
            $Attr_name='';
            foreach($this->data['ProductTypeAttributeI18n']as $v){
                $p_I18n_info=array('id' => '','locale' => $v['locale'],'product_type_attribute_id' => $pid,'name' => $v['name']);
                $Attr_name.=(' '.$v['name']);
                $this->ProductTypeAttributeI18n->saveall(array('ProductTypeAttributeI18n' => $p_I18n_info)); //更新多语言
            }
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加商品属性:'.$Attr_name,'operation');
            }
            $this->flash('属性'.$Attr_name.'添加成功 点击这里继续编辑该属性','/productstypes/lookedit/'.$pid."/".$_POST['back_id']."/",'');
        }
        $dataes=$this->ProductType->findAll();
        $s="";
        foreach($dataes as $k => $v){
            foreach($v["ProductTypeI18n"]as $kk => $vv){
                if($vv['locale']==$this->locale){
                    $s=$vv['name'];
                }
            }
            $ss[$v['ProductType']['id']]=$s;
            $s="";
        }
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated();
       	//
        $this->set("systemresource_info",$systemresource_info);
        $this->set("ss",$ss);
        $this->set("id",$id);
    }
    function remove($id){
        /*判断权限*/
        $this->operator_privilege('goods_type_view');
        /*end*/
        $this->ProductType->deleteAll("ProductType.id='".$id."'");
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除商品类型','operation');
        }
        $this->flash('删除成功','/productstypes',5);
    }
    function lookremove($id,$ids){
        $this->ProductTypeAttribute->deleteAll("ProductTypeAttribute.id='".$id."'");
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除商品属性','operation');
        }
        $this->flash('删除成功','/productstypes/look/'.$ids,5);
    }
}
?>