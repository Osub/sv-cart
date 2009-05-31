<?php
/*****************************************************************************
 * SV-Cart 文章详细
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: category_articles_controller.php 1841 2009-05-27 06:51:37Z huangbo $
*****************************************************************************/
class  CategoryArticlesController extends AppController {
    var $name = 'CategoryArticles';
    var $components = array ('Pagination'); // Added
    var $helpers = array('Pagination'); // Added
	var $uses = array('ArticleCategory','Article','Category');
	function view($cat_id,$orderby="orderby",$rownum='') {
 	 	   $this->page_init();
           if(isset($this->configs['article_category_page_list_number'])){
                 $rownum=$this->configs['article_category_page_list_number'];
           }
           elseif(!empty($rownum)){
                 $rownum=$rownum;
           }else{
                 $rownum=5;
           }
          
           if(isset($this->configs['articles_list_orderby'])){
                 $orderby=$this->configs['articles_list_orderby'];
           }
           elseif(!empty($orderby)){
                 $orderby=$orderby;
           }
           else{
                 $orderby='created';
           }
      	$flag = 1;
        //文章分类信息列表
        if($cat_id != 'hot'){
	        $this->Category->set_locale($this->locale);
	        $cat_detail=$this->Category->findbyid($cat_id);
        	if(empty($cat_detail)){
	       	 $this->pageTitle = $this->languages['classificatory'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
			 $this->flash($this->languages['classificatory'].$this->languages['not_exist'],"/",5);
			 $flag = 0;
        	}
        }
        if($flag == 1){
        //文章列表
/*        $condition = " ArticleCategory.category_id ='$cat_id' ";
        $total = $this->ArticleCategory->findCount($condition,0);
        $sortClass='Product'; */
         //pr($parameters);
         //修改
        if($cat_id == 'hot'){
            $condition = '1=1';
            $hot_list=$this->Article->hot_list('','');
            $total = count($hot_list);
            $sortClass='Product';
        }else{
            $condition = " ArticleCategory.category_id =".$cat_id ;
            $total = $this->ArticleCategory->findCount($condition,0);
            $sortClass='Product';
        }
		$now = date("Y-m-d H:i:s");
       	$yestoday = date("Y-m-d H:i:s",strtotime ("-1 day"));
       	$filter = "1=1";
        $filter .= " and  Article.status = '1' and Article.created <= '".$now."' and  Article.created >='".$yestoday."'";     	
        $this->Article->set_locale($this->locale);
       	$today = $this->Article->findall($filter);
		$this->set("today",count($today));        
        
         //修改end
        $page=1;
        $parameters=Array($orderby,$rownum,$page);
        $options=Array();
        list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass); // Added
        //ArticleCategory信息
        $list_by_cat=$this->ArticleCategory->findAll($condition,''," ArticleCategory.$orderby asc ","$rownum",$page);
        $article_id='';
        
            foreach($list_by_cat as $key=>$v){
                $article_id.=$v['ArticleCategory']['article_id'].',';           
            }
            if($article_id!=''){
                $article_id=substr($article_id,0,-1);
                $article_list=$this->Article->get_list($article_id,'');
                foreach($article_list as $key=>$val){
                $article_list[$key]['Article']['created']=substr($val['Article']['created'],0,10);
                $article_list[$key]['Article']['modified']=substr($val['Article']['modified'],0,10);
	                if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
						$article_list[$key]['ArticleI18n']['title'] = $this->Article->sub_str($val['ArticleI18n']['title'],$this->configs['article_title_length']);
	                }
                }
                $this->set('article_list',$article_list);
            }
    //    }

      $ur_heres=array();
      $ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
      
      //$ur_heres[]=array('name'=>$this->languages['article_home_page'],'url'=>"/articles/index/1");
      
      $navigate=$this->Category->tree('A',$cat_id);
      $cat_navigate = $navigate['assoc'];
      krsort($cat_navigate);
      $this->Category->set_locale($this->locale);
      $category_arr = $this->Category->findbyid($cat_id);
      if($cat_id == 'hot'){  
      	$ur_heres[]=array('name'=>$this->languages['hot_article'],'url'=>"/articles/index/hot");
      }else{
	  	if($category_arr['Category']['parent_id'] == 0){
	  		if(!empty($category_arr['Category']['link'])){
	  			$ur_heres[]	= array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/{$category_arr['Category']['link']}");
	  		}else{
				$ur_heres[] = array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/category_articles/".$category_arr['Category']['id']);
			}
		}
		if($category_arr['Category']['parent_id'] > 0){
			$main_arr = $this->Category->findbyid($category_arr['Category']['parent_id']);
			if(!empty($main_arr['Category']['link'])){
				$ur_heres[]	= array('name'=>$main_arr['CategoryI18n']['name'],'url'=>"/{$main_arr['Category']['link']}");
			}else{
				$ur_heres[] = array('name'=>$main_arr['CategoryI18n']['name'],'url'=>"/category_articles/".$main_arr['Category']['id']);
			}
			if(!empty($category_arr['Category']['link'])){
	  			$ur_heres[]	= array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/{$category_arr['Category']['link']}");
	  		}else{
				$ur_heres[] = array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/category_articles/".$category_arr['Category']['id']);
			}
		}
		
      }
      
      $this->set('categories_tree',$navigate['tree']);
      $this->set('category_type','A'); //判断是文章
      $this->set('locations',$ur_heres);
      //排序方式,显示方式,分页数量限制
      $this->set('orderby',$orderby);
      $this->set('rownum',$rownum);
      $this->set('total',$total);
      
      $this->pageTitle = $category_arr['CategoryI18n']['name']." - ".$this->configs['shop_title'];
   	 }//flag end
      //set js 语言
      $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
      $this->set('js_languages',$js_languages);
      $this->set('meta_description',$cat_detail['CategoryI18n']['meta_description']);
 	  $this->set('meta_keywords',$cat_detail['CategoryI18n']['meta_keywords']);
    }

}

?>