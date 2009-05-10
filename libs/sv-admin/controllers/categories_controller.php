<?php
/*****************************************************************************
 * SV-Cart 文章和商品分类管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: categories_controller.php 899 2009-04-22 15:03:02Z huangbo $
*****************************************************************************/
class CategoriesController extends AppController {

	var $name = 'Categories';

	var $helpers = array('Html','Javascript', 'Fck');

	var $uses = array('Category','Product','ProductsCategory','CategoryI18n','ArticleCategory');

	var $components = array('RequestHandler');
 
 function index($type='P'){
		
		/*判断权限*/
		//$user->controller('categories_display');
		$this->pageTitle = "分类管理" ." - ".$this->configs['shop_name'];
		
	    if($type=='P'){ //统计商品小计
	    	$this->navigations[] = array('name'=>'商品分类管理','url'=>'/categories/index/P');
			$this->set('navigations',$this->navigations);
		    $categories_products_count=$this->ProductsCategory->findcountassoc();
		    $categories_tree=$this->Category->tree($type,$this->locale);
		    //pr($categories_products_count);
		    $this->set('categories_tree',$categories_tree);
		    $this->set('categories_products_count',$categories_products_count);
		}
	    
	   	if($type=='A'){ //统计文章小计
	   		$this->navigations[] = array('name'=>'文章分类管理','url'=>'/categories/index/A');
	   		$this->set('navigations',$this->navigations);
		    $categories_articles_count = $this->ArticleCategory->findcountassoc();
		    $categories_trees=$this->Category->tree($type,$this->locale);
		   // pr();
		    $this->set('categories_trees',$categories_trees);
		    $this->set('categories_articles_count',$categories_articles_count);
		 	//pr($categories_articles_count);
		  	//exit;
		}
		
	//	pr($categories_tree);
	 	$this->set('type',$type);
		
	}

	function edit($type='P',$id){
		
		/*判断权限*/
		//	$user->controller('categories_edit');
		if($type == 'P'){
			$this->pageTitle = "编辑商品分类 - 商品分类管理" ." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'商品分类管理','url'=>'/categories/index/P');
			$this->navigations[] = array('name'=>'编辑商品分类','url'=>'');
			$this->set('navigations',$this->navigations);
			
			if($this->RequestHandler->isPost()){
			//	pr($this->data);
				//$this->CategoryI18n->deleteall("category_id = '".$this->data['Category']['id']."'",false); //删除原有多语言
				foreach($this->data['CategoryI18n'] as $v){
              	     	    $categoryI18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'category_id'=> isset($v['category_id'])?$v['category_id']:'',
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                           'meta_keywords'=> $v['meta_keywords'],
		                           'meta_description'=>$v['meta_description'],
		                        	'detail'=>$v['detail'],
		                           'img01'=>	$v['img01'],
		                           'img02'=>	$v['img02']
		                     );
		                 $this->CategoryI18n->saveall(array('CategoryI18n'=>$categoryI18n_info));//更新多语言
              	     	 if( $this->locale==$v['locale'] ){
              	     	 	$category_name = $v['name'];
              	     	 }
              	     }
				$this->Category->save($this->data); //关联保存
				
				
				$this->flash("编辑成功",'/categories/edit/P/'.$id,10);
				
			}
		}
		
		if($type == 'A'){
			$this->pageTitle = "编辑文章分类 - 文章分类管理" ." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'文章分类管理','url'=>'/categories/index/A');
			$this->navigations[] = array('name'=>'编辑文章分类','url'=>'');
			$this->set('navigations',$this->navigations);
			
			if($this->RequestHandler->isPost()){
				
			//	$this->CategoryI18n->deleteall("category_id = '".$this->data['Category']['id']."'",false); //删除原有多语言
			    foreach($this->data['CategoryI18n'] as $v){
              	     	    $categoryI18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'category_id'=> isset($v['category_id'])?$v['category_id']:'',
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                           'meta_keywords'=> $v['meta_keywords'],
		                           'meta_description'=>$v['meta_description'],
		                        	'detail'=>$v['detail'],
		                           'img01'=>	$v['img01'],
		                           'img02'=>	$v['img02']
		                     );
							if( $this->locale==$v['locale'] ){
              	     	 		$category_name = $v['name'];
              	     	 	}
		                 $this->CategoryI18n->saveall(array('CategoryI18n'=>$categoryI18n_info));//更新多语言
              	     }
              	    
				$this->Category->save($this->data); //关联保存
				$this->params['controller'] = "categories/index/A";
				$this->flash("编辑成功",'/categories/edit/A/'.$id,10);
				
			}
		}	
			$this->data=$this->Category->localeformat($id);
			//取树形结构
			$categories_tree=$this->Category->tree($this->data['Category']['type'],$this->locale);
			$this->set('categories_tree',$categories_tree);
			$this->set('type',$type);
	}
	
	function add($type='P'){
		
		/*判断权限*/
		//	$user->controller('categories_edit');
		/*新增商品分类*/
		if($type=='P'){
			$this->pageTitle = "新增商品分类 - 商品分类管理"." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'商品分类管理','url'=>'/categories/index/P');
			$this->navigations[] = array('name'=>'新增商品分类','url'=>'');
			$this->set('navigations',$this->navigations);
		
			if($this->RequestHandler->isPost()){
			//	pr($this->data);
			//	$this->CategoryI18n->deleteall("category_id = '".$this->data['Category']['id']."'",false); //删除原有多语言

				$this->data['Category']['orderby'] = !empty($this->data['Category']['orderby'])?$this->data['Category']['orderby']:50;
				
				$this->Category->save($this->data['Category']); //关联保存
				$id=$this->Category->id;
				
				if(is_array($this->data['CategoryI18n']))
				foreach($this->data['CategoryI18n'] as $k => $v){
					$v['category_id']=$id;
					$this->CategoryI18n->id='';

					$this->CategoryI18n->save($v); 
				}
				$id = $this->Category->getLastInsertId();
			  	$category = $this->Category->findById($id);
             	$category_name = $category['CategoryI18n']['name'];
				$this->flash("添加成功",'/categories/edit/P/'.$id,10);

			}		
			//取树形结构
			$categories_tree=$this->Category->tree('P',$this->locale);
			$this->set('categories_tree',$categories_tree);
			}
			/*新增商品分类*/
			if($type=='A'){
				$this->pageTitle = "新增文章分类 - 文章分类管理"." - ".$this->configs['shop_name'];
				$this->navigations[] = array('name'=>'文章分类管理','url'=>'/categories/index/A');
				$this->navigations[] = array('name'=>'新增文章分类','url'=>'');
				$this->set('navigations',$this->navigations);
				if($this->RequestHandler->isPost()){
					$this->data['Category']['orderby'] = !empty($this->data['Category']['orderby'])?$this->data['Category']['orderby']:50;
					//print_r($this->data['Category']);
					$this->Category->save($this->data['Category']); //关联保存
					$id=$this->Category->id;
					if(is_array($this->data['CategoryI18n']))
					foreach($this->data['CategoryI18n'] as $k => $v){
						$v['category_id']=$id;
						$this->CategoryI18n->id='';
						$test = explode("/",$v['img01']);
						$test[3] = $id;
						$v['img01'] = implode('/',$test);
						$test = explode("/",$v['img02']);
						$test[3] = $id;
						$v['img02'] = implode('/',$test);
						$this->CategoryI18n->save($v); 
					}				
				
				$id = $this->Category->getLastInsertId();
			  	$category = $this->Category->findById($id);
             	$category_name = $category['CategoryI18n']['name'];
             	$this->params['controller'] = "categories/index/A";
				$this->flash("添加成功",'/categories/edit/A/'.$id,10);

				}
			$categories_tree=$this->Category->tree('A',$this->locale);
			$this->set('categories_tree',$categories_tree);
			}
			$this->set('type',$type);
	}

	function move_to($cat_id){
	if($cat_id!=0){
	$condition=" ProductsCategory.id='".$cat_id."'" ;
	$product_cat=array(
		'id'=>"'".$cat_id."'"
		);
	 //转移商品
	 if($this->ProductsCategory->updateAll($product_cat,$condition)){
	   $msg="转移商品成功！";
	 }else{
	   $msg="转移商品失败！";
	 }
	 $this->set('msg',$msg);;
	}	
	}
	function remove($type='P',$id){
		//判断子分类，子商品是否存在
		if($type == 'P'){
			$this->Category->del($id);
			$this->flash("删除成功",'/categories/index/P','');
		}
		if($type == 'A'){
			$this->Category->del($id);
			$this->flash("删除成功",'/categories/index/A','');
		}
	}
	
	function add_new(){
		$this->set(compact('page', 'subpage', 'title'));
	}

}

?>