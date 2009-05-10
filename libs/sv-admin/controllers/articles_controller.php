<?php
/*****************************************************************************
 * SV-Cart 文章管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: articles_controller.php 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
class ArticlesController extends AppController {

	var $name = 'Articles';
	var $components = array ('Pagination','RequestHandler'); // Added 
	var $helpers = array('Pagination','Html', 'Form', 'Javascript', 'Fck','Time'); // Added   
	var $uses = array('Article','ArticleI18n','Brand','ProductType','Category','ArticleCategorie','Product','StoreProduct');
	
	function index(){
		$this->pageTitle = "文章管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'文章管理','url'=>'/articles/');
		$this->set('navigations',$this->navigations);
		$this->set("article_cats",0);
		//echo $this->today;
	//	pr();
		$condition="";
		if(isset($this->params['url']['article_cat']) && $this->params['url']['article_cat'] != 0){
			$wh_article_categories['ArticleCategorie.category_id'] = $this->params['url']['article_cat'];
			$this->set("article_cats",$this->params['url']['article_cat']);
	   	   	$ArticleCategorie = $this->ArticleCategorie->findAll($wh_article_categories);
	   	   	foreach($ArticleCategorie as $k=>$v){
	   	   		$ArticleCategorie_arr[] = $v['ArticleCategorie']['article_id'];
	   	   		$condition['or'][]["Article.id"] = $v['ArticleCategorie']['article_id'];
	   	   	}
	   	   	if(empty($ArticleCategorie)){
	   	   		$condition['or'][]["Article.id"] = "none";
	   	   	}
	   	}
		if(isset($this->params['url']['title']) && $this->params['url']['title'] != ''){
	   	   $condition["ArticleI18n.title LIKE"] = "%".$this->params['url']['title']."%";
	   	   $this->set('titles',$this->params['url']['title']);
	   	}
	   	if(isset($this->params['url']['start_time']) && $this->params['url']['start_time'] != ''){
	   	   	$condition["Article.created >"] = $this->params['url']['start_time'];
	   		$this->set('start_time',$this->params['url']['start_time']);
	   	}
	   	if(isset($this->params['url']['end_time']) && $this->params['url']['end_time'] != ''){
	   	   $condition["Article.created <"] = $this->params['url']['end_time'];
	   	   $this->set('end_time',$this->params['url']['end_time']);
	   	}
	   	$this->Category->set_locale($this->locale);
		$article_cat=$this->Category->getbrandformat();

   	    //echo  $condition."ssssssss";
   	    $this->Article->set_locale($this->locale);
   	    $total = $this->Article->findCount($condition,0);
	    $sortClass='Article';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);

	    $parameters=Array($rownum,$page);
	    $options=Array();
	    list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		$article = $this->Article->findAll($condition,'',"ArticleCategory.category_id desc",$rownum,$page);
		
		if( @isset( $article ) ){
			foreach( $article as $k=>$v ){
				$article[$k]['Article']['category'] = !empty($article_cat[$v['ArticleCategory']['category_id']]['CategoryI18n']['name'])?$article_cat[$v['ArticleCategory']['category_id']]['CategoryI18n']['name']:"所有分类";
				
			}
		}
		$categories_tree=$this->Category->tree('A',$this->locale);
		//pr($article);
		$this->set('categories_tree',$categories_tree);
		$this->set('article_cat',$article_cat);
		$this->set('article',$article);
	} 
	
	function edit( $id ){
		$this->pageTitle = "编辑文章 - 文章管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'文章管理','url'=>'/articles/');
		$this->navigations[] = array('name'=>'编辑文章','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			//pr( $_REQUEST['article_categories_id'] );
			//$this->Article->deleteall("id = '".$this->data['Article']['id']."'",false); 
			//$this->ArticleI18n->deleteall("article_id = '".$this->data['Article']['id']."'",false); //删除原有多语言
			foreach($this->data['ArticleI18n'] as $v){
              	     $articleI18n_info=array(
		                           'id'				=>	isset($v['id'])?$v['id']:'',
		                           'locale'			=>	$v['locale'],
		                           'article_id'		=> 	isset($v['article_id'])?$v['article_id']:$id,
		                           'title'			=>	isset($v['title'])?$v['title']:'',
		                           'meta_keywords'	=> 	$v['meta_keywords'],
		                 			'meta_description'	=> 	$v['meta_description'],
		                 			'img01'		=> 	$v['img01'],
		                           'content'		=> 	$v['content']
		              );
		        $this->ArticleI18n->saveall(array('ArticleI18n'=>$articleI18n_info));//更新多语言
            }
            $this->ArticleCategorie->deleteall("article_id = '".$id."'",false); 
            $ArticleCategorie = array(
            			'article_id'		=>		$id,
            			'category_id'		=>		$_REQUEST['article_categories_id']
            	);
            $this->ArticleCategorie->save(array('ArticleCategorie'=>$ArticleCategorie)); 
			$this->Article->save($this->data); //保存
			$this->flash("编辑成功",'/articles/edit/'.$id,10);
		}
		$categories_tree_A		=			$this->Category->tree('A',$this->locale);
		$categories_tree_P		=			$this->Category->tree('P',$this->locale);
		$article 				= 			$this->Article->localeformat( $id );
		$articles_products 		=			$this->requestAction("/commons/get_articles_products/".$id);
		$category_arr			=			$this->ArticleCategorie->find(array("article_id"=>$id));
		$this->set('categories_tree_A',$categories_tree_A);
		$this->set('categories_tree_P',$categories_tree_P);
		$this->set('articles_products',$articles_products);
		$this->set('category_id',$category_arr['ArticleCategorie']['category_id']);
		$this->set('article',$article);
	
	}
	
	
	function add(){
		
		$this->pageTitle = "添加文章 - 文章管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'文章管理','url'=>'/articles/');
		$this->navigations[] = array('name'=>'添加文章','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->data['Article']['orderby'] = !empty($this->data['Article']['orderby'])?$this->data['Article']['orderby']:50;

			
			
			$this->Article->save($this->data); //保存
			$id=$this->Article->id;
			   //新增多语言
			if(is_array($this->data['ArticleI18n']))
				foreach($this->data['ArticleI18n'] as $k => $v){
					$v['article_id']=$id;
				    $this->ArticleI18n->id='';
				    $this->ArticleI18n->save($v); 
			    }
			$article_id = $this->Article->getLastInsertID();
			$ArticleCategorie = array(
            			'article_id'		=>		$article_id,
            			'category_id'		=>		$_REQUEST['article_categories_id']
            	);
            $this->ArticleCategorie->save(array('ArticleCategorie'=>$ArticleCategorie)); 
			$this->flash("添加成功",'/articles/',10);
		}
		$categories_tree_A		=			$this->Category->tree('A',$this->locale);
		$this->set('categories_tree_A',$categories_tree_A);
	}
	
	function remove( $id ){
		
		$this->Article->deleteall("Article.id = '".$id."'",false);
		$this->ArticleI18n->deleteall("ArticleI18n.article_id = '".$id."'",false);
		$this->ArticleCategorie->deleteall("ArticleCategorie.article_id = '".$id."'",false);
		$this->flash("删除成功",'/articles/',10);
	}
	//批量处理
	function batch(){
   	   if( isset($this->params['url']['act_type']) && $this->params['url']['act_type'] != "0" ){
       		if ($this->params['url']['act_type'] == 'delete'){
                $id_arr = $this->params['url']['checkbox'];
                for( $i=0;$i<=count( $id_arr )-1;$i++ ){
                	$article_id = $id_arr[$i];
                	$condition['Article.id'] = $article_id;
                	$this->Article->deleteAll( $condition );
                }
                $this->flash("删除成功",'/articles/','');
            }else{
            	$this->flash("请选择文章",'/articles/','');
            }
	   }else{
	   		$this->flash("请选择处理",'/articles/','');
	   }
   }
/*------------------------------------------------------ */
//-- 文章搜索
/*------------------------------------------------------ */
   function searcharticles($keywords=0,$cat=0){
   	   	   $this->Article->set_locale($this->locale);
   	       $condition="1=1 ";
		   if($keywords != 0){
		         $condition .=" and ArticleI18n.title like '%$keywords%' or ArticleI18n.article_id='$keywords' ";
		   }
		   $Ai18ns_id=array();
		   $Ai18ns=$this->ArticleI18n->findall($condition,'DISTINCT ArticleI18n.article_id');
		   foreach($Ai18ns as $k=>$v){
		   	    $Ai18ns_id[]=$v['ArticleI18n']['article_id'];
		   }
		   $condition=array("Article.id"=>$Ai18ns_id);
		   if($cat != 0){
		   	    $condition = array("Article.id"=>$Ai18ns_id," Article.type  like '%$cat%'");
		   }
	       $Aids=$this->Article->findall($condition,'DISTINCT Article.id');
	       $aid_array=array();
	      if(is_array($Aids)){
	    	   foreach($Aids as $v ){
	    		   $aid_array[]=$v['Article']['id'];
	    	   }
	       }
 	      $condition = array("Article.id"=>$aid_array);
	      $articles_tree=$this->Article->findall($condition);
	     //调整数组格式
	      	foreach($articles_tree as $k => $v){
				 $articles_tree[$k]['Article']=$v['Article'];
				 $articles_tree[$k]['ArticleI18n']=$v['ArticleI18n'];
				 $articles_tree[$k]['Article']['title']='';
				
				 //foreach($articles_tree[$k]['ArticleI18n'] as $key=>$val){
				 	  $articles_tree[$k]['Article']['title'] =$v['ArticleI18n']['title'] ;
				 //}
			}
	      
	      $this->set('articles_tree',$articles_tree);
	    // pr($articles_tree);
	      //显示的页面
	      Configure::write('debug',0);
          $result['type'] = "0";
          $result['message']=$articles_tree;
          die(json_encode($result));
   }
	function rss($category_id=0){
		$this->layout = '/rss/articles';
		$this->Article->set_locale($this->locale);
        $article_list = $this->Article->find('all',array('conditions'=>array('ArticleCategory.category_id'=>$category_id),'limit'=>4));
       	//pr($article_list);
       	$this->set('this_config',$this->configs); 
        $this->set('articles',$article_list); 
        Configure::write('debug',0);
	}
}

?>