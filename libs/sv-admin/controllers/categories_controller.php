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
 * $Id: categories_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
class CategoriesController extends AppController {

	var $name = 'Categories';

	var $helpers = array('Html','Javascript', 'Fck');

	var $uses = array('Article','Category','Product','ProductsCategory','CategoryI18n','ArticleCategory','ProductType','ProductTypeI18n','ProductTypeAttribute','ProductTypeAttributeI18n','CategoryFilter');

	var $components = array('RequestHandler');
 
 function index($type='P'){
	
		/*判断权限*/
		//$user->controller('categories_display');
		$this->pageTitle = "分类管理" ." - ".$this->configs['shop_name'];
		
	    if($type=='P'){ //统计商品小计
		    /*判断权限*/
			$this->operator_privilege('goods_category_view');
			/*end*/
	    	$this->navigations[] = array('name'=>'商品分类管理','url'=>'/categories/index/P');
			$this->set('navigations',$this->navigations);
			
			$product_count=$this->Product->product_count();
		    $categories_products_count=$this->ProductsCategory->findcountassoc();
		    $categories_tree=$this->Category->tree($type,$this->locale);
		    //pr($categories_products_count);
		    $this->set('categories_tree',$categories_tree);
		    $this->set('categories_products_count',$categories_products_count);
		    $this->set('product_count',$product_count);
		}
	    
	   	if($type=='A'){ //统计文章小计
		    /*判断权限*/
			$this->operator_privilege('article_category_view');
			/*end*/
	   		$this->navigations[] = array('name'=>'文章分类管理','url'=>'/categories/index/A');
	   		$this->set('navigations',$this->navigations);
		    $categories_articles_count = $this->ArticleCategory->findcountassoc();
		    $article_count = $this->Article->article_counts();
		    $categories_trees=$this->Category->tree($type,$this->locale);
		   // pr();
		    $this->set('categories_trees',$categories_trees);
		    $this->set('article_count',$article_count);
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
		    /*判断权限*/
			$this->operator_privilege('goods_category_edit');
			/*end*/
			$this->pageTitle = "编辑商品分类 - 商品分类管理" ." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'商品分类管理','url'=>'/categories/index/P');
			$this->navigations[] = array('name'=>'编辑商品分类','url'=>'');
			$first_price=array();//第一组价格
			$clone_price=array();//多组价格
			$clone_attr=array();//多组属性
			$check_id=array();
			$product_type=$this->ProductType->findall("where ProductType.status=1");
			foreach($product_type as $k => $v){
				if(!empty($v['ProductTypeI18n'])){
					 foreach($v['ProductTypeI18n']as $vv){
		                if($vv['locale']==$this->locale){
		                    $product_type[$k]['ProductType']['name']=$vv['name'];
		                    $product_type[$k]['ProductType']['type_id']=$vv['type_id'];
		                }
		            }
				}		
			}			

			$category_filter=$this->CategoryFilter->find("where CategoryFilter.category_id='".$id."'");
			if($category_filter){
				$this->set('filer_status',$category_filter['CategoryFilter']['status']);
				foreach($category_filter as $k=> $v){
					$arrt_group=explode(";",$v['product_attribute']);
				}
				$this->ProductTypeAttribute->hasOne = array();
				$this->ProductTypeAttribute->hasMany = array('ProductTypeAttributeI18n' =>
	                         array('className'     => 'ProductTypeAttributeI18n',
	                               'conditions'    => '',
	                               'order'         => '',
	                                'dependent'    =>  true,
	                               'foreignKey'    => 'product_type_attribute_id'
	                         )
	                  );

				if($arrt_group[0]!=""){
					foreach($arrt_group as $k => $v){
						$tem_arr=$this->ProductTypeAttribute->find("where ProductTypeAttribute.id='".$v."'");
						$tem_id=$tem_arr['ProductTypeAttribute']['product_type_id'];
						$check_id[$k]=$tem_id;
						$attr_list=$this->ProductTypeAttribute->findall("where ProductTypeAttribute.product_type_id='".$tem_id."'");
						foreach($attr_list as $kk => $vv){
							if(!empty($vv['ProductTypeAttributeI18n'])){
								 foreach($vv['ProductTypeAttributeI18n']as $vvv){
					                if($vvv['locale']==$this->locale){
					                    $attr_list[$kk]['ProductTypeAttribute']['name']=$vvv['name'];
					                    $attr_list[$kk]['ProductTypeAttribute']['attr_id']=$vvv['product_type_attribute_id'];
					                }
					            }
							}		
						}
						$data="<select name='data[Category][attr_filter][]' onchange='check_filter(this)'><option value='0'>请选择筛选属性</option>";
						foreach($attr_list as $kk => $vv){
							$data .= $vv['ProductTypeAttribute']['attr_id']==$v ? "<option value=".$vv['ProductTypeAttribute']['attr_id']." selected >".$vv['ProductTypeAttribute']['name']."</option>" : "<option value=".$vv['ProductTypeAttribute']['attr_id']." >".$vv['ProductTypeAttribute']['name']."</option>";
						}
						$data.="</select>";
						$clone_attr[$k]=$data;																
					}

				}

				foreach($category_filter as $k=> $v){
					$price_group=explode(";",$v['filter_price']);
				}	
				if(!empty($price_group)){
					foreach($price_group as $k=> $v){
						$filter_price[$k]=explode("-",$v);
					}
					$first_price=$filter_price[0];
					unset($filter_price[0]);
					if(!empty($filter_price)){
						$clone_price=$filter_price;
					}
				}
					
			}
			$this->set('first_price',$first_price);
			$this->set('clone_price',$clone_price);	
			$this->set('product_type',$product_type);
			$this->set('clone_attr',$clone_attr);
			$this->set('check_id',$check_id);

			if($this->RequestHandler->isPost()){
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
				foreach( $this->data['CategoryI18n'] as $k=>$v ){
					if($v['locale'] == $this->locale){
						$userinformation_name = $v['name'];
					}
				}
				$id=$this->Category->id;

				foreach($this->data['Category']['attr_filter'] as $k => $v){
					if($v=="0"){
						unset($this->data['Category']['attr_filter'][$k]);
					}
				}
				if(!empty($this->data['Category']['attr_filter'])){
					$this->data['CategoryFilter']['product_attribute'] = implode(";", $this->data['Category']['attr_filter']);
				}else{
					$this->data['CategoryFilter']['product_attribute']="";
				}

				foreach($this->data['Category']['start_price'] as $k => $v){
					$this->data['Category']['price'][$k]['start']=$v;
					$this->data['Category']['price'][$k]['end']=$this->data['Category']['end_price'][$k];
				}
				
				foreach($this->data['Category']['price'] as $k => $v){
					if($v['start']=="" ||$v['end']==""){
						unset($this->data['Category']['price'][$k]);
					}else{
						$this->data['Category']['price'][$k]=$v['start']."-".$v['end'];
					}
				}	
					
				if(!empty($this->data['Category']['price'])){
					$this->data['CategoryFilter']['filter_price'] = implode(";", $this->data['Category']['price']);
				}else{
					$this->data['CategoryFilter']['filter_price']="";
				}
				$this->data['CategoryFilter']['id']=$category_filter['CategoryFilter']['id'];
				$this->data['CategoryFilter']['status']=!empty($this->data['CategoryFilter']['status']) ? $this->data['CategoryFilter']['status']: "0";									
				$this->CategoryFilter->save(array("CategoryFilter"=>$this->data['CategoryFilter']));
			//	pr($this->data['CategoryFilter']);
                //操作员日志
        		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑商品分类:'.$userinformation_name ,'operation');
        		}
				$this->flash("商品分类  ".$userinformation_name." 编辑成功。点击继续编辑该商品分类。",'/categories/edit/P/'.$id,10);


				
			}
		}
		
		if($type == 'A'){
		    /*判断权限*/
			$this->operator_privilege('article_category_edit');
			/*end*/
			$this->pageTitle = "编辑文章分类 - 文章分类管理" ." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'文章分类管理','url'=>'/categories/index/A');
			$this->navigations[] = array('name'=>'编辑文章分类','url'=>'');
			
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
				foreach( $this->data['CategoryI18n'] as $k=>$v ){
					if($v['locale'] == $this->locale){
						$userinformation_name = $v['name'];
					}
				}
				$id=$this->Category->id;
                //操作员日志
        		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑文章分类:'.$userinformation_name ,'operation');
        		}
				$this->flash("文章分类  ".$userinformation_name." 编辑成功。点击继续编辑该文章分类。",'/categories/edit/A/'.$id,10);
				
			}
		}	
			$this->data=$this->Category->localeformat($id);
			//取树形结构
			$categories_tree=$this->Category->tree($this->data['Category']['type'],$this->locale,$id);
			
			$this->set('categories_tree',$categories_tree);
			$this->set('type',$type);
			//leo20090722导航显示
			$this->navigations[] = array('name'=>$this->data["CategoryI18n"][$this->locale]["name"],'url'=>'');
		    $this->set('navigations',$this->navigations);

	}
	
	function add($type='P'){ 
		//图片ID
		$this->set('categories_id',"temp");
		$category_info = $this->Category->find("","","Category.id desc"); 
	$this->Category->hasOne = array('CategoryI18n' =>   
                        array('className'    => 'CategoryI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,
                              'foreignKey'   => 'category_id'  
                        )
                  );

		//$this->set('categories_id',$category_info['Category']['id']+1);
		$new_id = $category_info['Category']['id']+1;
		
		$product_type=$this->ProductType->findall(array("ProductType.status"=>1));
		foreach($product_type as $k => $v){
			if(!empty($v['ProductTypeI18n'])){
				 foreach($v['ProductTypeI18n']as $vv){
	                if($vv['locale']==$this->locale){
	                    $product_type[$k]['ProductType']['name']=$vv['name'];
	                    $product_type[$k]['ProductType']['type_id']=$vv['type_id'];
	                }
	            }
			}		
		}
		
	//	pr($product_type);
		$this->set('product_type',$product_type);
		/*判断权限*/ 
		//	$user->controller('categories_edit');
		/*新增商品分类*/
		if($type=='P'){
		    /*判断权限*/
			$this->operator_privilege('goods_category_add');
			/*end*/
			$this->pageTitle = "新增商品分类 - 商品分类管理"." - ".$this->configs['shop_name'];
			$this->navigations[] = array('name'=>'商品分类管理','url'=>'/categories/index/P');
			$this->navigations[] = array('name'=>'新增商品分类','url'=>'');
			$this->set('navigations',$this->navigations);
		
			if($this->RequestHandler->isPost()){
				foreach($this->data['Category']['attr_filter'] as $k => $v){
					if($v=="0"){
						unset($this->data['Category']['attr_filter'][$k]);
					}
				}
				if(!empty($this->data['Category']['attr_filter'])){
					$this->data['CategoryFilter']['product_attribute'] = implode(";", $this->data['Category']['attr_filter']);
				}else{
					$this->data['CategoryFilter']['product_attribute']="";
				}

				foreach($this->data['Category']['start_price'] as $k => $v){
					$this->data['Category']['price'][$k]['start']=$v;
					$this->data['Category']['price'][$k]['end']=$this->data['Category']['end_price'][$k];
				}
				
				foreach($this->data['Category']['price'] as $k => $v){
					if($v['start']=="" ||$v['end']==""){
						unset($this->data['Category']['price'][$k]);
					}else{
						$this->data['Category']['price'][$k]=$v['start']."-".$v['end'];
					}
				}	
					
				if(!empty($this->data['Category']['price'])){
					$this->data['CategoryFilter']['filter_price'] = implode(";", $this->data['Category']['price']);
				}else{
					$this->data['CategoryFilter']['filter_price']="";
				}
				$this->data['CategoryFilter']['status']=!empty($this->data['CategoryFilter']['status']) ? $this->data['CategoryFilter']['status']: "0";				
			//	$this->CategoryI18n->deleteall("category_id = '".$this->data['Category']['id']."'",false); //删除原有多语言

				$this->data['Category']['orderby'] = !empty($this->data['Category']['orderby'])?$this->data['Category']['orderby']:50;
				$this->data['Category']['img01'] = str_replace("temp", $new_id, $this->data['Category']['img01']);
				$this->data['Category']['img02'] = str_replace("temp", $new_id, $this->data['Category']['img02']);
					
				
				$this->Category->saveall($this->data['Category']); //关联保存
				$id=$this->Category->id;
				$new_id = $id;
				$this->data['CategoryFilter']['category_id']=$new_id;
				$this->CategoryFilter->saveall($this->data['CategoryFilter']);
				if(is_array($this->data['CategoryI18n']))
				foreach($this->data['CategoryI18n'] as $k => $v){
					$v['category_id']=$id;
					$this->CategoryI18n->id='';
					$img01 = $v['img01'];
					if(!strpos($img01, "temp")){
				 	
				 		$pos = "..".substr($img01,0,strpos($img01, "new_id")-2-strlen($img01)).$new_id."/";
						@rename("../img/product_categories/temp/",$pos);
					}
					eval("\$img01 = \"$img01\";");
					$img01 = str_replace("temp", $new_id, $img01);
					$v['img01'] = $img01;
					$img02 = $v['img02'];
					if(!strpos($img02, "temp")){
				 		$pos = "..".substr($img02,0,strpos($img02, "new_id")-2-strlen($img02)).$new_id."/";
						@rename("../img/product_categories/temp/",$pos);
					}
					eval("\$img02 = \"$img02\";");
					$img02 = str_replace("temp", $new_id, $img02);
					$v['img02'] = $img02;
					
					$this->CategoryI18n->saveall($v); 
				}
				$id = $this->Category->getLastInsertId();
			  	$category = $this->Category->findById($id);
             	$category_name = $category['CategoryI18n']['name'];
				foreach( $this->data['CategoryI18n'] as $k=>$v ){
					if($v['locale'] == $this->locale){
						$userinformation_name = $v['name'];
					}
				}
				$id=$this->Category->id;
                //操作员日志
        		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'增加商品分类:'.$userinformation_name ,'operation');
        		}
				$this->flash("商品分类  ".$userinformation_name." 添加成功。点击继续编辑该商品分类。",'/categories/edit/P/'.$id,10);

			}		
			//取树形结构
			$categories_tree=$this->Category->tree('P',$this->locale);
			$this->set('categories_tree',$categories_tree);
			}
			/*新增商品分类*/
			if($type=='A'){
			    /*判断权限*/
				$this->operator_privilege('article_category_add');
				/*end*/
				$this->pageTitle = "新增文章分类 - 文章分类管理"." - ".$this->configs['shop_name'];
				$this->navigations[] = array('name'=>'文章分类管理','url'=>'/categories/index/A');
				$this->navigations[] = array('name'=>'新增文章分类','url'=>'');
				$this->set('navigations',$this->navigations);
				if($this->RequestHandler->isPost()){
					$this->data['Category']['orderby'] = !empty($this->data['Category']['orderby'])?$this->data['Category']['orderby']:50;
					$this->data['Category']['img01'] = str_replace("temp", $new_id, $this->data['Category']['img01']);
					$this->data['Category']['img02'] = str_replace("temp", $new_id, $this->data['Category']['img02']);
					
					$this->Category->saveall($this->data['Category']); //关联保存
					$id=$this->Category->id;
					$new_id = $id;
					if(is_array($this->data['CategoryI18n']))
					foreach($this->data['CategoryI18n'] as $k => $v){
						$v['category_id']=$id;
						$this->CategoryI18n->id='';
						$img01 = $v['img01'];
					
						if(!strpos($img01, "temp")){
				 			$pos = "..".substr($img01,0,strpos($img01, "new_id")-2-strlen($img01)).$new_id."/";
							@rename("../img/article_categories/temp/",$pos);
						}
						
						eval("\$img01 = \"$img01\";");
						$img01 = str_replace("temp", $new_id, $img01);
						$v['img01'] = $img01;
						$img02 = $v['img02'];
						if(!strpos($img02, "temp")){
				 			$pos = "..".substr($img02,0,strpos($img02, "new_id")-2-strlen($img02)).$new_id."/";
							@rename("../img/article_categories/temp/",$pos);
						}
						eval("\$img02 = \"$img02\";");
						$img02 = str_replace("temp", $new_id, $img02);
						$v['img02'] = $img02;

						$this->CategoryI18n->saveall($v); 
					}				
				
				$id = $this->Category->getLastInsertId();
			  	$category = $this->Category->findById($id);
             	$category_name = $category['CategoryI18n']['name'];
             	$this->params['controller'] = "categories/index/A";
				foreach( $this->data['CategoryI18n'] as $k=>$v ){
					if($v['locale'] == $this->locale){
						$userinformation_name = $v['name'];
					}
				}
				$id=$this->Category->id;
                //操作员日志
        		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'增加文章分类:'.$userinformation_name ,'operation');
        		}
				$this->flash("文章分类  ".$userinformation_name." 编辑成功。点击继续编辑该文章分类。",'/categories/edit/A/'.$id,10);

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
			/*判断权限*/
			$this->operator_privilege('goods_category_edit');
			/*end*/
			$pn = $this->CategoryI18n->find('list',array('fields' => array('CategoryI18n.category_id','CategoryI18n.name'),'conditions'=> 
                                        array('CategoryI18n.category_id'=>$id,'ProductI18n.locale'=>$this->locale)));
			$this->Category->del($id);
			//操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除商品分类:'.$pn[$id] ,'operation');
        	}
			$this->flash("删除成功",'/categories/index/P','');
		}
		if($type == 'A'){
			/*判断权限*/
			$this->operator_privilege('article_category_edit');
			/*end*/
			$pn = $this->CategoryI18n->find('list',array('fields' => array('CategoryI18n.category_id','CategoryI18n.name'),'conditions'=> 
                                        array('CategoryI18n.category_id'=>$id,'ProductI18n.locale'=>$this->locale)));
			$this->Category->del($id);
			//操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除文章分类:'.$pn[$id] ,'operation');
        	}
			$this->flash("删除成功",'/categories/index/A','');
		}
	}
	
	function add_new(){
		$this->set(compact('page', 'subpage', 'title'));
	}
	function getattr(){	//取属性		
		Configure::write('debug',0);
		$this->ProductTypeAttribute->hasOne = array();
		$this->ProductTypeAttribute->hasMany = array('ProductTypeAttributeI18n' =>
	                         array('className'     => 'ProductTypeAttributeI18n',
	                               'conditions'    => '',
	                               'order'         => '',
	                                'dependent'    =>  true,
	                               'foreignKey'    => 'product_type_attribute_id'
	                         )
	                  );			

		$attr_list=$this->ProductTypeAttribute->findall("where ProductTypeAttribute.product_type_id='".$_REQUEST['id']."'");						
		foreach($attr_list as $k => $v){
			if(!empty($v['ProductTypeAttributeI18n'])){
				 foreach($v['ProductTypeAttributeI18n']as $vv){
	                if($vv['locale']==$this->locale){
	                    $attr_list[$k]['ProductTypeAttribute']['name']=$vv['name'];
	                    $attr_list[$k]['ProductTypeAttribute']['attr_id']=$vv['product_type_attribute_id'];
	                }
	            }
			}		
		}
		$data="&nbsp;<select name='data[Category][attr_filter][]' onchange='check_filter(this)'><option value='0'>请选择筛选属性</option>";
		foreach($attr_list as $k => $v){
			$data.=	"<option value=".$v['ProductTypeAttribute']['attr_id']." >".$v['ProductTypeAttribute']['name']."</option>";
		}
		$data.="</select>";
		echo $data;
		die();	
	}

}

?>