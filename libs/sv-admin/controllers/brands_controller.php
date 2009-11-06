<?php
/*****************************************************************************
 * SV-Cart 品牌管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: brands_controller.php 5199 2009-10-20 07:08:27Z huangbo $
*****************************************************************************/
class BrandsController extends AppController {

	var $name = 'Brands';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Pagination','Tinymce','fck'); // Added 
	var $uses = array('Brand','BrandI18n','SeoKeyword',"Category","Product");

   function index(){
		/*判断权限*/
		$this->operator_privilege('brand_view');
		/*end*/
   	   $this->pageTitle = '品牌管理' ." - ".$this->configs['shop_name'];
   	    $this->navigations[] = array('name'=>'产品管理','url'=>'');
	   $this->navigations[] = array('name'=>'品牌管理','url'=>'/brands/');
	   $this->set('navigations',$this->navigations);
	   //echo ($this->locale);
	   $this->Brand->set_locale($this->locale);
   	   $condition='';
   	   $keyword_value = "";
   	   $brand_name = "";
   	   $category_id = "";
   	   if( !empty($_REQUEST["keyword_value"]) ){
   	   	   	$keyword_value = $_REQUEST["keyword_value"];
   	   		$condition["and"]["or"]["Brandi18n.name like"]='%'.$keyword_value.'%';
   	   		$condition["and"]["or"]["Brandi18n.description like"]='%'.$keyword_value.'%';
   	   		$condition["and"]["or"]["Brandi18n.meta_description like"]='%'.$keyword_value.'%';
   	   }
   	   if( !empty($_REQUEST["brand_name"]) ){
   	   	   	$brand_name = $_REQUEST["brand_name"];
   	   		$condition["and"]["and"]["Brandi18n.name like"]='%'.$brand_name.'%';
   	   }
       if(isset($this->params['url']['category_id']) && $this->params['url']['category_id']!=0){
        	$category_id = $this->params['url']['category_id'];
    	    $this->Category->hasOne=array();
		  	$this->Category->tree_p('P',$category_id,$this->locale);
    	  	$category_ids = isset($this->Category->allinfo['subids'][$category_id])?$this->Category->allinfo['subids'][$category_id]:$category_id;
    	  	
    	  	$this->Product->hasOne = array();
    	  	$this->Product->hasMany = array();
    	  	$product_info = $this->Product->find("all",array("conditions"=>array("category_id"=>$category_ids,"status"=>"1"),"fields"=>array("brand_id DISTINCT")));
    	 
    	  	$brand_id[]=0;
    	  	foreach( $product_info as $k=>$v ){
    	  		$brand_id[] = $v["Product"]["brand_id"];
    	  	}
    	  
			$condition["and"]["and"]["Brand.id"] = $brand_id;
       }

	   $total = $this->Brand->findCount($condition,0);
	   $sortClass='Brand';
	   $page=1;
	   $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
   	   $res=$this->Brand->findAll($condition,'',"Brand.orderby asc,BrandI18n.name",$rownum,$page);
        //商品分类
        $this->Category->hasOne = array('CategoryI18n' =>   
                        array('className'    => 'CategoryI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,
                              'foreignKey'   => 'category_id'  
                        )
                  );
       $product_cat=$this->Category->get_categories_tree("P",$this->locale);
		//pr($brand_list);
   	   $this->set('brand_list',$res);
   	   $this->set('product_cat',$product_cat);
   	   $this->set('brand_name',$brand_name);
   	   $this->set('category_id',$category_id);
   	   $this->set('navigations',$this->navigations);
   	   
   }
   function remove($id){
		/*判断权限*/
		$this->operator_privilege('brand_edit');
		/*end*/
   	    $this->pageTitle = "删除品牌-品牌管理"." - ".$this->configs['shop_name'];
   	    $this->navigations[] = array('name'=>'产品管理','url'=>'');
		$this->navigations[] = array('name'=>'品牌管理','url'=>'/users/');
		$this->navigations[] = array('name'=>'删除品牌','url'=>'');
		$pn = $this->BrandI18n->find('list',array('fields' => array('BrandI18n.brand_id','BrandI18n.name'),'conditions'=> 
                                        array('BrandI18n.brand_id'=>$id,'BrandI18n.locale'=>$this->locale)));
		$this->Brand->deleteAll("Brand.id='".$id."'");
	
		//操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除品牌:'.$pn[$id] ,'operation');
        }
		$this->flash("删除成功",'/brands/',10);
   }
   function view($id){
		/*判断权限*/
		$this->operator_privilege('brand_edit');
		/*end*/
		$this->pageTitle = "编辑品牌- 品牌管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'产品管理','url'=>'');
		$this->navigations[] = array('name'=>'品牌管理','url'=>'/brands/');
		$this->navigations[] = array('name'=>'编辑品牌','url'=>'');
		
		if($this->RequestHandler->isPost()){
   	   	    $this->data['Brand']['flash_config'] = !empty($this->data['Brand']['flash_config'])?$this->data['Brand']['orderby']:"0";
			//$this->BrandI18n->deleteall("brand_id = '".$this->data['Brand']['id']."'",false); //删除原有多语言
		foreach($this->data['BrandI18n'] as $v){
              	     	    $brandi18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'brand_id'=> $id,
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                           'meta_keywords'=> $v['meta_keywords'],
		                           'meta_description'=>$v['meta_description'],
		                           'description'=>	$v['description'],
		                           'img01'=>$v['img01']
		                     );
		                     $this->BrandI18n->saveall(array('BrandI18n'=>$brandi18n_info));//更新多语言
         }
			$this->Brand->save($this->data); //关联保存
			$this->Brand->set_locale($this->locale);
			$brand_info = $this->Brand->findById($id);
            
            $brand_name = $brand_info['BrandI18n']['name'];
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑品牌:'.$brand_name ,'operation');
            }
			$this->flash("品牌 ".$brand_name."  编辑成功。点击这里继续编辑该品牌。",'/brands/'.$id,10);
			
		}
		$this->data=$this->Brand->localeformat($id);

		$this->set('brands_info',$this->data);
			//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["BrandI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);
		//关键字
		$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>array("status"=>1)));
		$this->set("seokeyword_data",$seokeyword_data);

   }
   function add(){
		/*判断权限*/
		$this->operator_privilege('brand_add');
		/*end*/		
		$this->pageTitle = "添加品牌- 品牌管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'产品管理','url'=>'');
		$this->navigations[] = array('name'=>'品牌管理','url'=>'/brands/');
		$this->navigations[] = array('name'=>'添加品牌','url'=>'');
		$this->set('navigations',$this->navigations);
   	   if($this->RequestHandler->isPost()){
   	   	   
   	   	    $this->data['Brand']['orderby'] = !empty($this->data['Brand']['orderby'])?$this->data['Brand']['orderby']:"50";
   	   	    $this->data['Brand']['flash_config'] = !empty($this->data['Brand']['flash_config'])?$this->data['Brand']['orderby']:"0";
			$this->Brand->save($this->data['Brand']); //关联保存
			$id=$this->Brand->id;
			
			if(is_array($this->data['BrandI18n']))
			foreach($this->data['BrandI18n'] as $k => $v){
				$v['brand_id']=$id;
				$this->BrandI18n->id='';
				$this->BrandI18n->save($v);
				if($this->locale==$v['locale']){
					$brand_name = $v['name'];
				}
			}
			//操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'增加品牌:'.$brand_name ,'operation');
            }
			$this->flash("品牌 ".$brand_name."  编辑成功。点击这里继续编辑该品牌。",'/brands/'.$id,10);
		}
            
		
		//取树形结构
		$brands_list=$this->Brand->findAll();

		$this->set('brands_list',$brands_list);
		//关键字
		$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>array("status"=>1)));
		$this->set("seokeyword_data",$seokeyword_data);

   }
	function batch(){
		$brand_id=!empty($_REQUEST["checkboxes"]) ? $_REQUEST["checkboxes"]: 0;
		$condition['Brand.id']=$brand_id;
        $this->Brand->deleteAll($condition);
        $this->BrandI18n->deleteAll(array("BrandI18n.brand_id"=>$brand_id));
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
         	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量删除品牌','operation');
       	}
       	$this->flash("品牌批量删除成功",'/brands/','');

	}
}

?>