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
 * $Id: brands_controller.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class BrandsController extends AppController {

	var $name = 'Brands';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array('Brand','BrandI18n');

   function index(){
		/*判断权限*/
		$this->operator_privilege('brand_view');
		/*end*/
   	   $this->pageTitle = '品牌管理' ." - ".$this->configs['shop_name'];
	   $this->navigations[] = array('name'=>'品牌管理','url'=>'/brands/');
	   $this->set('navigations',$this->navigations);
	   //echo ($this->locale);
	   $this->Brand->set_locale($this->locale);
   	   $condition='';
	   $total = $this->Brand->findCount($condition,0);
	   $sortClass='Brand';
	   $page=1;
	   $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   $parameters=Array($rownum,$page);
	   $options=Array();
	   $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
   	   $res=$this->Brand->findAll($condition,'',"Brand.orderby DESC",$rownum,$page);
	   //商品名称格式调整
	 
   	   $brand_list=array();
  	   if(is_array($res)){
			foreach($res as $k=>$v)
			{
				$brand_list[$v['Brand']['id']]['Brand']=$v['Brand'];
				if(is_array($v['BrandI18n'])){
				    $brand_list[$v['Brand']['id']]['BrandI18n'][]=$v['BrandI18n'];
				}
				$brand_list[$v['Brand']['id']]['Brand']['name']="";
				$brand_list[$v['Brand']['id']]['Brand']['description']="";
			    if(is_array($brand_list[$v['Brand']['id']]['BrandI18n'])){
					//foreach($brand_list[$v['Brand']['id']]['BrandI18n'] as $key => $val){
					 	   $brand_list[$v['Brand']['id']]['Brand']['name']=$v['BrandI18n']['name'];
					 	   $brand_list[$v['Brand']['id']]['Brand']['description'] =$v['BrandI18n']['description'];
					 //}
			     }
			}
		}
       //pr($brand_list);
   	   $this->set('brand_list',$brand_list);
   	   $this->set('navigations',$this->navigations);
   	   
   }
   function remove($id){
		/*判断权限*/
		$this->operator_privilege('brand_edit');
		/*end*/
   	    $this->pageTitle = "删除品牌-品牌管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'品牌管理','url'=>'/users/');
		$this->navigations[] = array('name'=>'删除品牌','url'=>'');
		$this->Brand->deleteAll("Brand.id='".$id."'");
		$this->flash("删除成功",'/brands/',10);
   }
   function view($id){
		/*判断权限*/
		$this->operator_privilege('brand_edit');
		/*end*/
		$this->pageTitle = "编辑品牌- 品牌管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'品牌管理','url'=>'/brands/');
		$this->navigations[] = array('name'=>'编辑品牌','url'=>'');
		$this->set('navigations',$this->navigations);
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
			$this->flash("品牌 ".$brand_name."  编辑成功。点击继续编辑该品牌。",'/brands/'.$id,10);
			
		}
		$this->data=$this->Brand->localeformat($id);

	$this->set('brands_info',$this->data);
   }
   function add(){
		/*判断权限*/
		$this->operator_privilege('brand_add');
		/*end*/		
		$this->pageTitle = "添加品牌- 品牌管理" ." - ".$this->configs['shop_name'];
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
			$this->flash("品牌 ".$brand_name."  编辑成功。点击继续编辑该品牌。",'/brands/'.$id,10);
		}
            
		
		//取树形结构
		$brands_list=$this->Brand->findAll();

		$this->set('brands_list',$brands_list);
   	   
   }

}

?>