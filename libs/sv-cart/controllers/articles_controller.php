<?php
/*****************************************************************************
 * SV-Cart 文章
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: articles_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/

class   ArticlesController extends AppController {
	var $name = 'Articles';
	var $uses = array('Article','Comment','Category','ArticleCategory','Product','ProductArticle','Tag','ProductLocalePrice');
 	function index($cat_id=''){
 		
 		$cat_id=intval($cat_id);
		//文章首页 分类
		$this->Article->set_locale($this->locale);
		$this->Category->set_locale($this->locale);
		$all_subcat=$this->Category->tree('A',$cat_id,$this->locale);
		$article_index = $all_subcat['assoc'];
		$this->set('categories_tree',$all_subcat['tree']);
	//	pr($all_subcat['tree']);
		$category_id='';
		$flag=3;
		foreach($article_index as $key=>$v){
			//时间格式化
			$article_index[$key]['Category']['created']=substr($v['Category']['created'],0,10);
			$article_index[$key]['Category']['modified']=substr($v['Category']['modified'],0,10);
			//最新咨询
			if($v['Category']['id']=='1') {
			$news=array();
			$news=$article_index[$key];	
			$category_id.=$v['Category']['id'].',';
			$flag--;
			}
			//活动看板
			if($v['Category']['id']=='2') {
			$actives_news=array();
			$actives_news=$article_index[$key];	
			$category_id.=$v['Category']['id'].',';
			$flag--;
			}
			//精彩专题
			if($v['Category']['id']=='3') {
			$wondeful_news=array();
			$wondeful_news=$article_index[$key];
			$category_id.=$v['Category']['id'].',';	
			$flag--;
			}
		}
		//有列表为取得则跳转
		if($flag){
				$this->redirect('/');
	        exit;
		}
		
		if($category_id!=''){
		//	print($category_id); //14,15,16
			$category_id=substr($category_id,0,-1);
		//  文章列表
			
			$article_list = $this->ArticleCategory->find_indx_all($category_id,$this->locale);
			
			$article_id='';
			$article_list_temp=array();
			foreach($article_list as $key=>$v){
			$article_id.=$v['ArticleCategory']['article_id'].",";
			$article_list_temp[$v['ArticleCategory']['category_id']][]=$v;
		}
		//	pr($article_list_temp); 以14,15,16,为序的 文章数组
			if($article_id!=''){
			//	print($article_id); //Article id
				$article_id=substr($article_id,0,-1);
			//  文章详细
			//	print($article_id);
				$article_list = $this->Article->get_list($article_id);
			//	pr($article_list);// 全部文章
				$article_list_insert=array();
				foreach($article_list as $key=>$v){
			//  时间格式化
					$v['Article']['created']=substr($v['Article']['created'],0,10);
					$v['Article']['modified']=substr($v['Article']['modified'],0,10);
					$article_list_insert[$v['Article']['id']]=$v;
				}
				$article_detail=array();
				foreach($article_list_temp as $key=>$v){
					foreach($v as $k=>$val){
						if(isset($article_list_insert[$val['ArticleCategory']['article_id']])){
							$article_list_temp[$key][$k]=$article_list_insert[$val['ArticleCategory']['article_id']];
						}
						unset($article_list_temp[$key][$k]['ArticleCategory']);
					}
				}
				$article_list_temp[] = array();
				$news['Article_list'] = $article_list_temp[$news['Category']['id']];
				if(isset($actives_news['Category']['id']) &&  isset($article_list_temp[$actives_news['Category']['id']])){
					$actives_news['Article_list']=$article_list_temp[$actives_news['Category']['id']];
				}
				if(isset($wondeful_news['Category']['id']) && isset($article_list_temp[$wondeful_news['Category']['id']])){
					$wondeful_news['Article_list']=$article_list_temp[$wondeful_news['Category']['id']];
				}
				$brands = array();
			    $this->set('categories_tree',$all_subcat['tree']);
			    $this->set('category_type','A'); //判断是文章
				$this->set('news',$news);
				$this->set('actives_news',$actives_news);
				$this->set('wondeful_news',$wondeful_news);
			}
		}
		//本周最热门文章
		$hot_list=$this->Article->hot_list(5,'');
		/*时间格式化	*/
		foreach($hot_list as $key=>$val){
			$hot_list[$key]['Article']['created']=substr($val['Article']['created'],0,10);
			$hot_list[$key]['Article']['modified']=substr($val['Article']['modified'],0,10);
		}
		//pr($hot_list);
		$this->set('hot_list',$hot_list);
		
		//本周最新评论
		$comment_list = $this->Comment->get_list('A','');
		//pr($comment_list);
		$this->set('comment_list',$comment_list);
		//文章列表
		//pr($article_list);
		//ur_here
		$ur_heres=array();
		//article_home_page 
		$this->pageTitle = $this->languages['article'].$this->languages['home']." - ".$this->configs['shop_title'];
		$ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
		$ur_heres[]=array('name'=>$this->languages['article'].$this->languages['home'],'url'=>"/articles/{$cat_id}");
		$this->page_init();
		$this->set('locations',$ur_heres);
 	
 	}//end index()

	function view($id=""){
		$this->page_init();
		//文章详细Category
		$this->Category->set_locale($this->locale);
		$this->Article->set_locale($this->locale);
		$flag = 1;
		$article_detail = $this->Article->findbyid($id);
	    if(empty($article_detail)){
	       $this->pageTitle = $this->languages['article'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
		   $this->flash($this->languages['article'].$this->languages['not_exist'],"/","","");
		   $flag = 0;
	    }else if($article_detail['Article']['status']!=1){
	    	$this->pageTitle = $this->languages['article'].$this->languages['not_exist']." - ".$this->configs['shop_title'];
	    	$this->flash($this->languages['article'].$this->languages['not_exist'],"/","","");
	    	$flag = 0;
	    }		
		
	    if($flag == 1){
			//更新点击次数
			$article_detail['Article']['clicked'] += 1; 
			$this->Article->save($article_detail);
			/*时间格式化*/
			$article_detail['Article']['created']=substr($article_detail['Article']['created'],0,10);
			$article_detail['Article']['modified']=substr($article_detail['Article']['modified'],0,10);
			//pr($article_detail);
			$this->set('article_detail',$article_detail);
			//相关商品
		//	$product_article = $this->ProductArticle->findAll(" ProductArticle.article_id=$id");
			$product_article = $this->ProductArticle->find_product_article($id,$this->locale);
			//pr($product_article);
			$product_id='';
			foreach($product_article as $key=>$v){
				$product_id.=$v['ProductArticle']['product_id'].",";
			}
			if($product_id!=''){
				$product_id=substr($product_id,0,-1);
				//商品详细
				$this->Product->set_locale($this->locale);
				$product_list = $this->Product->get_list($product_id,$this->locale);
				if(is_array($product_list) && sizeof($product_list)>0){
				foreach($product_list as $k=>$v){
					//$product_list[$k]['Product']['shop_price'] = $this->Product->locale_price($v['Product']['id'],$v['Product']['shop_price'],$this);
					if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($v['ProductLocalePrice']['product_price'])){
						$product_list[$k]['Product']['shop_price'] = $v['ProductLocalePrice']['product_price'];
					}					
				}
				//pr($product_list);
				$this->set('product_list',$product_list);
				}
			}
			
			//用户评论
			$comment_list = $this->Comment->get_list('A',$id);
			$reply_info=array();
			//获取评论回复信息
			$my_comments_id =array();
			if(isset($comment_list) && sizeof($comment_list)>0){
				foreach($comment_list as $key=>$v){
					$my_comments_id[] = $v['Comment']['id'];
				}
			}
		  $my_comments_replies = $this->Comment->find('all',array('conditions'=>array('Comment.parent_id'=>$my_comments_id)));
		  $replies_list =array();
		  if(is_array($my_comments_replies) && sizeof($my_comments_replies)>0){
		  		foreach($my_comments_replies as $kk=>$vv){
		  			$replies_list[$vv['Comment']['parent_id']][] = $vv;
		  		}
		  }			
			
			if(isset($comment_list) && sizeof($comment_list)>0){
				foreach($comment_list as $key=>$v){
			//		$comment_list[$key]['reply']=@$reply_info[$v['Comment']['id']];
					$comment_list[$key]['reply'] = @$replies_list[$v['Comment']['id']];
				}
			}

			$this->set('comment_list',$comment_list);	
			
			//文章分类
			$article_category_detail=$this->ArticleCategory->findbyarticle_id($article_detail['Article']['id']);
			$ur_heres=array();

			$ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
		//	$ur_heres[]=array('name'=>$this->languages['article_home_page'],'url'=>"/articles/index/1");
			//pr($article_category_detail['ArticleCategory']['category_id']);
			$cat_navigate = $this->Category->tree('A',$article_category_detail['ArticleCategory']['category_id'],$this->locale);
		//	krsort($cat_navigate);
		//	pr($cat_navigate);

			//导航分级处理
			$article_category_find = $this->ArticleCategory->findbyarticle_id($id);
			$category_id = $article_category_find['ArticleCategory']['category_id'];
			$this->Category->set_locale($this->locale);
			$category_arr = $this->Category->findbyid($category_id);
			
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
			
			if(isset($this->configs['use_tag']) && $this->configs['use_tag'] == 1){
				$conditions = " Tag.status = '1' and Tag.type ='A' and Tag.type_id =".$id;
				$this->Tag->set_locale($this->locale);
				
				$tags = $this->Tag->find("all",array('fields' =>array('Tag.id','Tag.type_id','TagI18n.name'),"conditions" => array($conditions)));
				$this->set('tags',$tags);
			}
						
	    	$ur_heres[]=array('name'=>$article_detail['ArticleI18n']['title'],'url'=>"");
			$this->set('locations',$ur_heres);
			$this->set('neighbours',$this->Article->findNeighbours('',array('id','ArticleI18n.title'),$id));
		    $this->set('id',$id);		
			$this->set('type','A');
			$this->set('categories_tree',$cat_navigate['tree']);
			$this->set('category_type','A'); //判断是文章
		    $this->set('meta_description',$article_detail['ArticleI18n']['meta_description']);
		 	$this->set('meta_keywords',$article_detail['ArticleI18n']['meta_keywords']);
		 	$this->pageTitle = $article_detail['ArticleI18n']['title']."- ".$category_arr['CategoryI18n']['name']." - ".$this->configs['shop_title'];
	    }
	    

		//pr($article_category_find);
		$this->layout = 'default';	
		//set js 语言
	    $js_languages = array("waitting_for_check" => $this->languages['waitting_for_check'],
							"comments_not_empty" => $this->languages['comments'].$this->languages['can_not_empty'],
							"invalid_email" => $this->languages['email_letter'].$this->languages['format'].$this->languages['not_correct'],
							"page_submit" => $this->languages['submit'],
							"page_reset" => $this->languages['reset'],		
							"tag_can_not_empty"=>$this->languages['tags'].$this->languages['apellation'].$this->languages['can_not_empty'],
							"select_level_comments" => $this->languages['please_choose'].$this->languages['comment_rank'],
	    					  "comment" => $this->languages['comments']);
	    $this->set('js_languages',$js_languages);	

	}
	
	function rss($category_id=0){
		$this->layout = '/rss/articles';
		
		$this->Article->set_locale($this->locale);
        $article_list = $this->Article->find('all',array('conditions'=>array('ArticleCategory.category_id'=>$category_id,'Article.status'=>1),'limit'=>10,'order'=>'Article.created desc'));
       	
       	$this->set('dynamic',"文章动态"); 
       	$this->set('this_config',$this->configs); 
        $this->set('articles',$article_list); 
        Configure::write('debug',0);
	}
}//end class

?>