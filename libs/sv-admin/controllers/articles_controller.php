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
 * $Id: articles_controller.php 5425 2009-10-26 05:25:54Z huangbo $
 *****************************************************************************/
class ArticlesController extends AppController{
    var $name='Articles';
    var $components=array('Pagination','RequestHandler');
    var $helpers=array('Pagination','Html','Form','Javascript','Tinymce','Time','fck');
    var $uses=array('Article','ArticleI18n','Brand','ProductType','Category','ArticleCategorie','Product','StoreProduct','SystemResource','SeoKeyword');
    function index(){
        /*判断权限*/
        $this->operator_privilege('article_view');
        /*end*/
        $this->pageTitle="文章管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'文章管理','url'=>'');
        $this->navigations[]=array('name' => '文章管理','url' => '/articles/');
        $this->set('navigations',$this->navigations);
        $this->set("article_cats",0);
        $this->set("article_cat_type",0);
        $condition="";
        if(isset($this->params['url']['article_cat']) && $this->params['url']['article_cat']!=0){
        	$category_id = $this->params['url']['article_cat'];
    	    
		  	$this->Category->tree_p('A',$category_id,$this->locale);
    	  	$category_ids = isset($this->Category->allinfo['subids'][$category_id])?$this->Category->allinfo['subids'][$category_id]:$category_id;
            $condition["Article.category_id"]=$category_ids;
            $this->set("article_cats",$this->params['url']['article_cat']);
        }
        if(isset($this->params['url']['article_cat_type']) && $this->params['url']['article_cat_type']!=''){
            $condition["Article.type"]=$this->params['url']['article_cat_type'];
            $this->set('article_cat_type',$this->params['url']['article_cat_type']);
        }
        if(isset($this->params['url']['title']) && $this->params['url']['title']!=''){
            $condition["ArticleI18n.title LIKE"]="%".$this->params['url']['title']."%";
            $this->set('titles',$this->params['url']['title']);
        }
        if(isset($this->params['url']['start_time']) && $this->params['url']['start_time']!=''){
            $condition["Article.created >"]=$this->params['url']['start_time'];
            $this->set('start_time',$this->params['url']['start_time']);
        }
        if(isset($this->params['url']['end_time']) && $this->params['url']['end_time']!=''){
            $condition["Article.created <"]=$this->params['url']['end_time'];
            $this->set('end_time',$this->params['url']['end_time']);
        }
        $this->Category->set_locale($this->locale);
        $article_cat=$this->Category->findall();
        $article_cat_new=array();
        foreach($article_cat as $k => $v){
            $article_cat_new[$v["Category"]["id"]]=$v;
        }
        $article_cat=$article_cat_new;
        $this->Article->set_locale($this->locale);
        $total=$this->Article->findCount($condition,0);
        $sortClass='Article';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        list($page)=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        //$article=$this->Article->findAll($condition,'',"Article.id desc",$rownum,$page);
        $article=$this->Article->find("all",array("conditions"=>$condition,"order"=>"Article.orderby asc,Article.modified desc","limit"=>$rownum,"page"=>$page));
        if(@isset($article)){
            foreach($article as $k => $v){
                $article[$k]['Article']['category']=!empty($article_cat[$v['Article']['category_id']]['CategoryI18n']['name']) ? $article_cat[$v['Article']['category_id']]['CategoryI18n']['name']: "所有分类";
            }
        }
        $categories_tree=$this->Category->tree('A',$this->locale);
		//资源库信息
	    $this->SystemResource->set_locale($this->locale);
	    $systemresource_info = $this->SystemResource->resource_formated(false);
		$this->set("systemresource_info",$systemresource_info);

        $this->set('categories_tree',$categories_tree);
        $this->set('article_cat',$article_cat);
        $this->set('article',$article);
    }
    function edit($id){
        /*判断权限*/
        $this->operator_privilege('article_edit');
        /*end*/
        $this->pageTitle="编辑文章 - 文章管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'文章管理','url'=>'');
        $this->navigations[]=array('name' => '文章管理','url' => '/articles/');
        $this->navigations[]=array('name' => '编辑文章','url' => '');
        if($this->RequestHandler->isPost()){
        
            foreach($this->data['ArticleI18n']as $v){
                $articleI18n_info=array('id' => isset($v['id']) ? $v['id']: '','locale' => $v['locale'],'article_id' => isset($v['article_id']) ? $v['article_id']: $id,'title' => isset($v['title']) ? $v['title']: '','meta_keywords' => $v['meta_keywords'],'meta_description' => $v['meta_description'],'img01' => $v['img01'],'author' => $v['author'],'content' => $v['content']);
                $this->ArticleI18n->saveall(array('ArticleI18n' => $articleI18n_info));
            }
            $this->ArticleCategorie->deleteall("article_id = '".$id."'",false);
            $article_categories_id_arr=!empty($_REQUEST['article_categories_id']) ? $_REQUEST['article_categories_id']: array();
            foreach($article_categories_id_arr as $k => $v){
            	if(!empty($v)){
                	$ArticleCategorie=array('article_id' => $id,'category_id' => $v);
                	$this->ArticleCategorie->saveall(array('ArticleCategorie' => $ArticleCategorie));
            	}
            }

            $this->Article->save($this->data); //保存
            foreach($this->data['ArticleI18n']as $k => $v){
                if($v['locale']==$this->locale){
                    $userinformation_name=$v['title'];
                }
            }
            $id=$this->Article->id;
            $this->flash("文章  ".$userinformation_name." 编辑成功。点击这里继续编辑该商品类型。",'/articles/edit/'.$id,10);
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑文章:'.$userinformation_name,'operation');
            }
        }
        $categories_tree_A=$this->Category->tree('A',$this->locale);
        $categories_tree_P=$this->Category->tree('P',$this->locale);
        $article=$this->Article->localeformat($id);
        $articles_products=$this->requestAction("/commons/get_articles_products/".$id);

        $category_arr=$this->ArticleCategorie->findall(array("article_id" => $id));
        $this->set('categories_tree_A',$categories_tree_A);
        $this->set('categories_tree_P',$categories_tree_P);
        $this->set('articles_products',$articles_products);
        $this->set('category_arr',$category_arr);
        $this->set('category_id',@$this->data['Article']['category_id']);
        $this->set('article',$article);
        //leo20090722导航显示
        foreach($article["ArticleI18n"]as $k => $v){
            if($v["locale"]==$this->locale){
                $title=$v["title"];
            }
        }
        $this->navigations[]=array('name' => $v["title"],'url' => '');
        $this->set('navigations',$this->navigations);
		//资源库信息
	    $this->SystemResource->set_locale($this->locale);
	    $systemresource_info = $this->SystemResource->resource_formated(false);
		$this->set("systemresource_info",$systemresource_info);
		//关键字
		$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>array("status"=>1)));
		$this->set("seokeyword_data",$seokeyword_data);
    }
    function add(){
        /*判断权限*/
        $this->operator_privilege('article_add');
        /*end*/
        $this->pageTitle="添加文章 - 文章管理"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'文章管理','url'=>'');
        $this->navigations[]=array('name' => '文章管理','url' => '/articles/');
        $this->navigations[]=array('name' => '添加文章','url' => '');
        $this->set('navigations',$this->navigations);
        if($this->RequestHandler->isPost()){
            $this->data['Article']['orderby']=!empty($this->data['Article']['orderby']) ? $this->data['Article']['orderby']: 50;
            $this->Article->saveAll(array("Article" => $this->data['Article']));
            $id=$this->Article->id;
            if(is_array($this->data['ArticleI18n']))
            foreach($this->data['ArticleI18n']as $k => $v){
                $v['article_id']=$id;
                $this->ArticleI18n->saveall(array("ArticleI18n" => $v));
            }
            $article_id=$this->Article->getLastInsertID();
            $article_categories_id_arr=!empty($_REQUEST['article_categories_id']) ? $_REQUEST['article_categories_id']: array();
            foreach($article_categories_id_arr as $k => $v){
            	if(!empty($v)){
	                $ArticleCategorie=array('article_id' => $article_id,'category_id' => $v);
	                $this->ArticleCategorie->saveall(array('ArticleCategorie' => $ArticleCategorie));
                }
            }
            foreach($this->data['ArticleI18n']as $k => $v){
                if($v['locale']==$this->locale){
                    $userinformation_name=$v['title'];
                }
            }
            $id=$this->Article->id;
            $this->flash("文章  ".$userinformation_name." 添加成功。点击这里继续编辑该商品类型。",'/articles/edit/'.$id,10);
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'增加文章:'.$userinformation_name,'operation');
            }
        }
        $categories_tree_A=$this->Category->tree('A',$this->locale);
        $this->set('categories_tree_A',$categories_tree_A);
		//资源库信息
	    $this->SystemResource->set_locale($this->locale);
	    $systemresource_info = $this->SystemResource->resource_formated(false);
		$this->set("systemresource_info",$systemresource_info);
		//关键字
		$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>array("status"=>1)));
		$this->set("seokeyword_data",$seokeyword_data);

    }
    function remove($id){
        /*判断权限*/
        $this->operator_privilege('article_edit');
        /*end*/
        $pn=$this->ArticleI18n->find('list',array('fields' => array('ArticleI18n.article_id','ArticleI18n.title'),'conditions' => array('ArticleI18n.article_id' => $id,'ArticleI18n.locale' => $this->locale)));
        $this->Article->deleteall("Article.id = '".$id."'",false);
        $this->ArticleI18n->deleteall("ArticleI18n.article_id = '".$id."'",false);
        $this->ArticleCategorie->deleteall("ArticleCategorie.article_id = '".$id."'",false);

        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除文章:'.$pn[$id],'operation');
        }
        $this->flash("删除成功",'/articles/',10);
    }
    //批量处理
    function batch(){
    	$art_ids=!empty($_REQUEST["checkbox"]) ? $_REQUEST["checkbox"]: 0;
        if(isset($this->params['url']['act_type']) && $this->params['url']['act_type']!="0"){
            if($this->params['url']['act_type']=='delete'){
				$condition['Article.id']=$art_ids;
                $this->Article->deleteAll($condition);
                //操作员日志
                if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量删除文章','operation');
                }
                $this->flash("删除成功",'/articles/','');
            }
            if($this->params['url']['act_type']=='sub_type'){
				$condition['Article.id']=$art_ids;
                $this->Article->updateAll(array('Article.type' =>"'".$_REQUEST["sub_type"]."'"),array('Article.id' => $art_ids));
            	$this->flash("系统类型批量转移成功",'/articles/','');
            }
            if($this->params['url']['act_type']=='a_category'){
				$condition['Article.id']=$art_ids;
                $this->Article->updateAll(array('Article.category_id' =>$_REQUEST["article_cat_o"]),array('Article.id' => $art_ids));
            	$this->flash("文章分类批量转移成功",'/articles/','');
            }
            
            if($this->params['url']['act_type']=='a_status'){
				$condition['Article.id']=$art_ids;
                $this->Article->updateAll(array('Article.status' =>$_REQUEST["is_yes_no"]),array('Article.id' => $art_ids));
            	$this->flash("文章是否显示状态修改成功",'/articles/','');
            }
            if($this->params['url']['act_type']=='a_f_status'){
				$condition['Article.id']=$art_ids;
                $this->Article->updateAll(array('Article.front' =>$_REQUEST["is_yes_no"]),array('Article.id' => $art_ids));
            	$this->flash("文章分类首页显示修改成功",'/articles/','');
            }
            if($this->params['url']['act_type']=='a_c_status'){
				$condition['Article.id']=$art_ids;
                $this->Article->updateAll(array('Article.recommand' =>$_REQUEST["is_yes_no"]),array('Article.id' => $art_ids));
            	$this->flash("文章是否推荐修改成功",'/articles/','');
            }
            
            
        }
        else{
            $this->flash("请选择处理",'/articles/','');
        }
    }
    /*------------------------------------------------------ */
    //-- 文章搜索
    /*------------------------------------------------------ */
    function searcharticles($cat="all"){
        $this->Article->set_locale($this->locale);
        $keywords = $_REQUEST['Article_keywords'];
        $keywords=urldecode($keywords);
        $condition="";
        if(!empty($keywords)){
            $condition['or']["ArticleI18n.title like"]="%".$keywords."%";
            $condition['or']["ArticleI18n.article_id ="]=$keywords;
        }
        if($cat!="all"){
            $condition['and']["Article.category_id"]=$cat;
        }
        $articles_tree=$this->Article->findall($condition);
        //调整数组格式
        foreach($articles_tree as $k => $v){
            $articles_tree[$k]['Article']=$v['Article'];
            $articles_tree[$k]['ArticleI18n']=$v['ArticleI18n'];
            $articles_tree[$k]['Article']['title']='';
            $articles_tree[$k]['Article']['title']=$v['ArticleI18n']['title'];
        }
        //显示的页面
        Configure::write('debug',0);
        $result['type']="0";
        $result['message']=$articles_tree;
        die(json_encode($result));
    }
}

?>