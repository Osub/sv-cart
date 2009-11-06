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
 * $Id: category_articles_controller.php 4078 2009-09-04 11:42:15Z huangbo $
*****************************************************************************/
class  CategoryArticlesController extends AppController {
    var $name = 'CategoryArticles';
    var $components = array ('Pagination'); // Added
    var $helpers = array('Pagination'); // Added
	var $uses = array('ArticleCategory','Article','Category','Tag');
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
	       	$this->pageTitle = $this->languages['hot'].$this->languages['article']." - ".$this->configs['shop_title'];
            $hot_list=$this->Article->hot_list('','');
            $total = count($hot_list);
            $sortClass='Articles';
        }else{
        	
          //  $condition = " ArticleCategory.category_id =".$cat_id ;
         //   $total = $this->ArticleCategory->findCount($condition,0);
	        $this->Category->tree('A',$cat_id,$this->locale);
    	  	$category_ids =$this->Category->allinfo['subids'][$cat_id];
         	$condition = array('Article.category_id'=>$category_ids);
    	  	$total = $this->Article->findCount($condition,0);    	  	         	 
            $sortClass='Articles';
        }
		$now = date("Y-m-d H:i:s");
       	$yestoday = date("Y-m-d H:i:s",strtotime ("-1 day"));
       	$filter = "1=1";
        $filter .= " and  Article.status = '1' and Article.created <= '".$now."' and  Article.created >='".$yestoday."' ";
        if($cat_id != 'hot'){
      	 	$filter .= "and Article.category_id = ".$cat_id;
        }     	
        $this->Article->set_locale($this->locale);
       	$today = $this->Article->find('all',array('conditions'=>array($filter),'fields'=>array('Article.id'),'recursive'=>-1));
		$this->set("today",count($today));        
        
         //修改end
        $page=1;
        $parameters=Array($orderby,$rownum,$page);
        $options=Array();
        list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass); // Added
        //ArticleCategory信息
 //       $list_by_cat=$this->ArticleCategory->findAll($condition,''," ArticleCategory.$orderby asc ","$rownum",$page);
 		 $list_by_cat=$this->Article->find('all',array('conditions'=>$condition,'fields'=>array('Article.id'),'order'=>array("Article.$orderby asc"),'limit'=>$rownum,'page'=>$page));
         $article_id='';
	         foreach($list_by_cat as $key=>$v){
	            $article_id.=$v['Article']['id'].',';           
	         }
            if($article_id!=''){
                $article_id=substr($article_id,0,-1);
                $article_list=$this->Article->get_list($article_id,'');
                foreach($article_list as $key=>$val){
                $article_list[$key]['Article']['created']=substr($val['Article']['created'],0,10);
                $article_list[$key]['Article']['modified']=substr($val['Article']['modified'],0,10);
	                if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
						$article_list[$key]['ArticleI18n']['sub_title'] = $this->Article->sub_str($val['ArticleI18n']['title'],$this->configs['article_title_length']);
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
      	$ur_heres[]=array('name'=>$this->languages['hot'].$this->languages['article'],'url'=>"/articles/index/hot");
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
		      $this->pageTitle = $category_arr['CategoryI18n']['name']." - ".$this->configs['shop_title'];
      }
      
      $this->set('categories_tree',$navigate['tree']);
      $this->set('category_type','A'); //判断是文章
      $this->set('locations',$ur_heres);
      //排序方式,显示方式,分页数量限制
      $this->set('orderby',$orderby);
      $this->set('rownum',$rownum);
      $this->set('total',$total);
      
   	 }//flag end
      //set js 语言
      $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
      $this->set('js_languages',$js_languages);
      $this->set('meta_description',isset($cat_detail['CategoryI18n']['meta_description'])?$cat_detail['CategoryI18n']['meta_description']:$this->languages['hot'].$this->languages['article']);
 	  $this->set('meta_keywords',isset($cat_detail['CategoryI18n']['meta_keywords'])?$cat_detail['CategoryI18n']['meta_keywords']:$this->languages['hot'].$this->languages['article']);
    }
    
    function tag($tag,$orderby="orderby",$rownum=''){
    	   $tag = UrlDecode($tag);
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
               	
		$now = date("Y-m-d H:i:s");
       	$yestoday = date("Y-m-d H:i:s",strtotime ("-1 day"));
       	
       	$filter = "1=1";
        $filter .= " and  Article.status = '1' and Article.created <= '".$now."' and  Article.created >='".$yestoday."'";     	
        $this->Article->set_locale($this->locale);
       	$today = $this->Article->findall($filter);
		$this->set("today",count($today)); 
        $article_id=array();
        if(isset($this->configs['use_tag']) && $this->configs['use_tag'] == 1){
        	$tags = $this->Tag->findall(" TagI18n.name = '".$tag."' and TagI18n.locale = '".$this->locale."' and Tag.status ='1'");
        	if(is_array($tags) && sizeof($tags)>0){
        		foreach($tags as $k=>$v){
        			$article_id[] = $v['Tag']['type_id'];
        		}
        	}
        }
        
		$conditions = array("Article.id"=>$article_id,'Article.status'=>'1');

		$total = $this->Article->findCount($conditions,0);
        $sortClass = "Article";
        $page=1;
        $parameters=Array($orderby,$rownum,$page);
        $options=Array();
        $page = $this->Pagination->init($conditions,$parameters,$options,$total,$rownum,$sortClass); // Added
        if($article_id!=''){
				$article_list = $this->Article->findall($conditions,'',"Article.$orderby","$rownum",$page);
                foreach($article_list as $key=>$val){
                $article_list[$key]['Article']['created']=substr($val['Article']['created'],0,10);
                $article_list[$key]['Article']['modified']=substr($val['Article']['modified'],0,10);
	                if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
						$article_list[$key]['ArticleI18n']['sub_title'] = $this->Article->sub_str($val['ArticleI18n']['title'],$this->configs['article_title_length']);
	                }
                }
                $this->set('article_list',$article_list);
            }
            
		      $ur_heres=array();
		      $ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
		      $ur_heres[]=array('name'=>$tag,'url'=>"/articles/index/hot");
		      $this->set('locations',$ur_heres);
		      //排序方式,显示方式,分页数量限制
		      $this->set('orderby',$orderby);
		      $this->set('rownum',$rownum);
		      $this->set('total',$total);
		      
		      $this->pageTitle = $tag." - ".$this->configs['shop_title'];
		      //set js 语言
		      $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
		      $this->set('js_languages',$js_languages);
		      $this->set('meta_description',$tag);
		 	  $this->set('meta_keywords',$tag);
    	
    }

}

?>