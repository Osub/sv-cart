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
 * $Id: articles_controller.php 5527 2009-11-05 02:07:24Z huangbo $
*****************************************************************************/

class   ArticlesController extends AppController {
	var $name = 'Articles';
	 var $components = array ('Pagination'); // Added
	var $uses = array('Article','Comment','Category','ArticleCategory','Product','Sitemap','ProductArticle','Tag','ProductLocalePrice','UserRank','ProductRank','ArticleI18n');
	var $helpers = array('Pagination','Time','Xml','Rss','Text','Flash','HtmlCache'); //
	var $cacheQueries = true;
	var $cacheAction = "1 hour";	
 	function index($locale='',$cat_id=''){
 		if(empty($locale)){
			$this->redirect('/articles/index/'.$this->locale."/".$cat_id);
		}
 		
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
			//	if(isset($actives_news['Category']['id']) &&  isset($article_list_temp[$actives_news['Category']['id']])){
					$actives_news['Article_list']= $this->Article->cache_find('all',array('conditions'=>array('Article.status'=>'1','Article.category_id'=>'2'),'order'=>'Article.created DESC','limit'=>5),'actives_news_'.$locale);//$article_list_temp[$actives_news['Category']['id']];
			//	}
			//	if(isset($wondeful_news['Category']['id']) && isset($article_list_temp[$wondeful_news['Category']['id']])){
					$wondeful_news['Article_list']=$this->Article->cache_find('all',array('conditions'=>array('Article.status'=>'1','Article.category_id'=>'3'),'order'=>'Article.created DESC','limit'=>5),'wondeful_news_'.$locale);//$article_list_temp[$wondeful_news['Category']['id']];
			//	}
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
		if(isset($comment_list) && sizeof($comment_list)>0){
			$article_ids = array();
			foreach($comment_list as $k=>$v){
				$comment_list[$k]['Comment']['sub_content'] = $this->Article->sub_str($v['Comment']['content'],16);
				if(!in_array($v['Comment']['type_id'],$article_ids)){
					$article_ids[] = $v['Comment']['type_id'];
				}
			}
			if(!empty($article_ids)){
				$comment_articles = $this->Article->cache_find('all',array('conditions'=>array('Article.id'=>$article_ids,'Article.status'=>'1')),'comment_articles_'.$this->locale);
				if(isset($comment_articles) && sizeof($comment_articles)>0){
					$comment_articles_list = array();
					foreach($comment_articles as $k=>$v){
						$comment_articles_list[$v['Article']['id']] = $v;
					}
					$this->set('comment_articles_list',$comment_articles_list);
				}
			}
			
			
		}
		
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

	function view($id="",$local='',$name=''){
	//	pr($_SESSION);
		if(empty($local)){
			$this->redirect('/articles/'.$id."/".$this->locale);
		}
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
	//		$article_detail['Article']['clicked'] += 1; 
			$update_article = array('id'=>$article_detail['Article']['id'],'clicked'=>$article_detail['Article']['clicked'] += 1);
			$this->Article->save($update_article);
			/*时间格式化*/
			$article_detail['Article']['created']=substr($article_detail['Article']['created'],0,10);
			$article_detail['Article']['modified']=substr($article_detail['Article']['modified'],0,10);
			//pr($article_detail);
			$this->set('article_detail',$article_detail);
			$key_arr = explode(',',$article_detail['ArticleI18n']['meta_keywords']);
			
			//该文章分类下的所有文章
			$category_articles_list = $this->Article->cache_find('all',array('conditions'=>array('Article.category_id'=>$article_detail['Article']['category_id'],'Article.status'=>1),'fields'=>array('ArticleI18n.title','Article.id')),'category_articles_list_article_view_'.$this->locale."_".$article_detail['Article']['category_id']);
			$this->set('category_articles_list',$category_articles_list);
			
			
			//根据关键字找相关文章
			if(isset($key_arr) && sizeof($key_arr)>0 && $article_detail['ArticleI18n']['meta_keywords'] != ""){
				$key_condition = array();
				
				foreach($key_arr as $k=>$v){
					$key_condition['OR'][] = "ArticleI18n.meta_keywords like '%$v%' ";
				}
				
				$related_articles_id = $this->ArticleI18n->find('list',array('conditions'=>$key_condition,'fields'=>'ArticleI18n.article_id'));
				if(!empty($related_articles_id)){
					$related_articles = $this->Article->find('all',array('conditions'=>array('Article.status'=>1,'Article.id'=>$related_articles_id,'Article.id <>'=>$id)));
					if(isset($this->configs['related_articles_number']) && $this->configs['related_articles_number'] >0){
						$related_articles = array_slice($related_articles,'0',$this->configs['related_articles_number']);
					}
					$this->set('related_articles',$related_articles);
				}
				
			//	$relation_article = $this->Article->cache_find('all',$param,'relation_article_view_'.$this->locale);
			}
			
			//推荐文章
			$param = array(
					'conditions'=>array('Article.recommand'=>1,
					'Article.status'=>1,
					'Article.id <>'=>$article_detail['Article']['id']),
					'limit'=>5,
					'order' => 'Article.orderby ASC'
					);
			
			if($article_detail['Article']['category_id'] > 0){
				$param['conditions']['Article.category_id']=$article_detail['Article']['category_id'];
			}
			
			$recommand_article = $this->Article->cache_find('all',$param,'recommand_article_index_'.$this->locale);
			$this->set('recommand_article',$recommand_article);
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
				
				//地区价格
				if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1){
					$locale_price_list =array();
					if(!empty($product_id)){
						$cache_key = md5('article_product_id_locale_price'.'_'.$this->locale);
						$locale_price = cache::read($cache_key);	
						if(!$locale_price){
							$locale_price = $this->ProductLocalePrice->find('all',array( 
							'fields' =>	array('ProductLocalePrice.product_price','ProductLocalePrice.product_id'),
							'conditions'=>array('ProductLocalePrice.product_id'=>$product_id,'ProductLocalePrice.locale'=>$this->locale,'ProductLocalePrice.status'=>1)));
							cache::write($cache_key,$locale_price);
						}
						if(isset($locale_price) && sizeof($locale_price)>0){
							foreach($locale_price as $k=>$v){
								$locale_price_list[$v['ProductLocalePrice']['product_id']] = $v;
							}
						}
					}
				}			
				
				if(isset($_SESSION['User']['User'])){
					$product_ranks = $this->ProductRank->findall_ranks();
				}
				if(isset($_SESSION['User']['User'])){
					$user_rank_list=$this->UserRank->findrank();		
				}				
				
				
				//商品详细
				$this->Product->set_locale($this->locale);
				$product_list = $this->Product->get_list($product_id,$this->locale);
				if(is_array($product_list) && sizeof($product_list)>0){
				foreach($product_list as $k=>$v){
					//$product_list[$k]['Product']['shop_price'] = $this->Product->locale_price($v['Product']['id'],$v['Product']['shop_price'],$this);
					if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1  && isset($locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'])){
						$product_list[$k]['Product']['shop_price'] = $locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'];
					}
					if(isset($product_ranks[$v['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']])){
						if(isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
						  $product_list[$k]['Product']['shop_price']= $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
						}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
						  $product_list[$k]['Product']['shop_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
						}
					}					
					if($this->Product->is_promotion($v)){
						$product_list[$k]['Product']['shop_price'] = $product_list[$k]['Product']['promotion_price'];
					}					
					
				}
				//pr($product_list);
				$this->data['cache_products'] = $product_list;
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
			$cat_navigate = $this->Category->tree('A',$article_category_detail['ArticleCategory']['category_id'],$this->locale);
			//导航分级处理
			$article_category_find = $this->ArticleCategory->findbyarticle_id($id);
			$category_id = $article_detail['Article']['category_id'];
			$this->Category->set_locale($this->locale);
			$category_arr = $this->Category->findbyid($category_id);
			$this->set('category_name',$category_arr['CategoryI18n']['name']);
		  	if($category_arr['Category']['parent_id'] == 0){
		  		if(!empty($category_arr['Category']['link'])){
		  			$ur_heres[]	= array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/{$category_arr['Category']['link']}");
		  		}else{
					$ur_heres[] = array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/articles/category/".$category_arr['Category']['id']);
				}
			}
			if($category_arr['Category']['parent_id'] > 0){
				$main_arr = $this->Category->findbyid($category_arr['Category']['parent_id']);
				if(!empty($main_arr['Category']['link'])){
					$ur_heres[]	= array('name'=>$main_arr['CategoryI18n']['name'],'url'=>"/{$main_arr['Category']['link']}");
				}else{
					$ur_heres[] = array('name'=>$main_arr['CategoryI18n']['name'],'url'=>"/articles/category/".$main_arr['Category']['id']);
				}
				if(!empty($category_arr['Category']['link'])){
		  			$ur_heres[]	= array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/{$category_arr['Category']['link']}");
		  		}else{
					$ur_heres[] = array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/articles/category/".$category_arr['Category']['id']);
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
			$this->data['article_detail'] = $article_detail;
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
		if($category_id > 0){
			$condition["and"]["or"]["Article.category_id"] = $category_id;
		}
		$condition["and"]["and"]["Article.status"] = 1;
        $article_list = $this->Article->find('all',array('conditions'=>$condition,'order'=>'Article.created desc',"limit"=>"7"));
       	$this->set('this_locale',$this->locale); 
       	$this->set('this_url',$this->server_host.$this->cart_webroot); 
       	$this->set('dynamic',"文章动态"); 
       	$this->set('this_config',$this->configs); 
        $this->set('articles',$article_list); 
        Configure::write('debug',0);
	}		
	function recommend_rss($limit=7){
		$this->layout = '/rss/articles';
		$this->Article->set_locale($this->locale);

		$condition["Article.recommand"] = 1;
        $article_list = $this->Article->find('all',array('conditions'=>$condition,'order'=>'Article.orderby asc,Article.created desc',"limit"=>$limit));
       	$this->set('this_locale',$this->locale); 
       	$this->set('this_url',$this->server_host.$this->cart_webroot); 
       	$this->set('dynamic',"文章推荐"); 
       	$this->set('this_config',$this->configs); 
        $this->set('articles',$article_list); 
        Configure::write('debug',0);
	}		
	function category($cat_id,$locale='',$page=1,$orderby="orderby",$rownum=''){
		$this->page_init();
		 if(empty($locale)){
			$this->redirect('/articles/category/'.$cat_id."/".$this->locale);
	  	}
           if(isset($this->configs['article_category_page_list_number'])){
                 $rownum=$this->configs['article_category_page_list_number'];
           }
           elseif(!empty($rownum)){
                 $rownum=$rownum;
           }else{
                 $rownum=5;
           }
           
          	if(!isset($_GET['page'])){
				$_GET['page'] = $page;
			}else{
				$page = $_GET['page'];
			}
			$this->data['get_page'] = $_GET['page'];           
            
		    $this->data['to_page_id'] = $cat_id;

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
         //修改
	        if($cat_id == 'hot'){
	            $condition = '1=1';
		       	$this->pageTitle = $this->languages['hot'].$this->languages['article']." - ".$this->configs['shop_title'];
	            $hot_list=$this->Article->hot_list('','');
	            $total = count($hot_list);
	            $sortClass='Articles';
	        }else{
		        $this->Category->tree('A',$cat_id,$this->locale);
		        if(isset($this->Category->allinfo['subids'][$cat_id])){
	    	  		$category_ids =$this->Category->allinfo['subids'][$cat_id];
	    	  	}else{
	    	  		$category_ids = $cat_id;
	    	  	}	    	  	
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

	      $ur_heres=array();
	      $ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
      
       	  $this->data['article_search'] = $this->server_host.$this->cart_webroot.$this->params['controller']."/category/".$cat_id."/".$locale."/";
      
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
					$ur_heres[] = array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/articles/category/".$category_arr['Category']['id']);
				}
			}
			if($category_arr['Category']['parent_id'] > 0){
				$main_arr = $this->Category->findbyid($category_arr['Category']['parent_id']);
				if(!empty($main_arr['Category']['link'])){
					$ur_heres[]	= array('name'=>$main_arr['CategoryI18n']['name'],'url'=>"/{$main_arr['Category']['link']}");
				}else{
					$ur_heres[] = array('name'=>$main_arr['CategoryI18n']['name'],'url'=>"/articles/category/".$main_arr['Category']['id']);
				}
				if(!empty($category_arr['Category']['link'])){
		  			$ur_heres[]	= array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/{$category_arr['Category']['link']}");
		  		}else{
					$ur_heres[] = array('name'=>$category_arr['CategoryI18n']['name'],'url'=>"/articles/category/".$category_arr['Category']['id']);
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
	      $this->data['cat_id'] = $cat_id;
      
   	 }//flag end
      //set js 语言
      $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
      $this->set('js_languages',$js_languages);
      $this->set('meta_description',isset($cat_detail['CategoryI18n']['meta_description'])?$cat_detail['CategoryI18n']['meta_description']:$this->languages['hot'].$this->languages['article']);
 	  $this->set('meta_keywords',isset($cat_detail['CategoryI18n']['meta_keywords'])?$cat_detail['CategoryI18n']['meta_keywords']:$this->languages['hot'].$this->languages['article']);
    }
	

    
    function tag($tag,$page = 1,$orderby="orderby",$rownum=''){
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
          	if(!isset($_GET['page'])){
				$_GET['page'] = $page;
			}else{
				$page = $_GET['page'];
			}
			$this->data['get_page'] = $_GET['page'];           
            
		    $this->data['to_page_id'] = $tag;
            $this->data['article_search'] = $this->server_host.$this->cart_webroot."category_articles/tag/".$tag."/";
                 
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
    
    function search($tag='',$page = 1,$orderby="orderby",$rownum=''){
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
      //     $rownum = 1;
          	if(!isset($_GET['page'])){
				$_GET['page'] = $page;
			}else{
				$page = $_GET['page'];
			}
			$this->data['get_page'] = $_GET['page'];           
            
            if($tag == ""){
		    	$this->data['to_page_id'] = "";
            }else{
		    	$this->data['to_page_id'] = $tag;
		    }
           
           if($tag == 'is_new'){
           		 $orderby = 'created';
           }elseif(isset($this->configs['articles_list_orderby'])){
                 $orderby=$this->configs['articles_list_orderby'];
           }
           elseif(!empty($orderby)){
                 $orderby=$orderby;
           }
           else{
                 $orderby='created';
           }
               	
               	
        $this->data['article_search'] = $this->server_host.$this->cart_webroot.$this->params['controller']."/search/".$tag."/";
        
		$now = date("Y-m-d H:i:s");
       	$yestoday = date("Y-m-d H:i:s",strtotime ("-1 day"));
       	
       	$filter = "1=1";
        $filter .= " and  Article.status = '1' and Article.created <= '".$now."' and  Article.created >='".$yestoday."'";
        $this->Article->set_locale($this->locale);
       	$today = $this->Article->findall($filter);
		$this->set("today",count($today)); 
        $article_id=array();
        if($tag == "is_recommand"){
			$conditions = array('Article.status'=>'1','Article.front'=>'1');
			$tag_show = $this->languages['recommend'];
        }elseif($tag != ""){
	        if(isset($this->configs['use_tag']) && $this->configs['use_tag'] == 1){
	        	$tags = $this->Tag->findall(" TagI18n.name = '".$tag."' and TagI18n.locale = '".$this->locale."' and Tag.status ='1'");
	        	if(is_array($tags) && sizeof($tags)>0){
	        		foreach($tags as $k=>$v){
	        			$article_id[] = $v['Tag']['type_id'];
	        		}
	        	}
	        }
	        $key_article_id = $this->ArticleI18n->find('list',array('conditions'=>array('AND'=>array('ArticleI18n.locale'=>$this->locale),'OR'=>array("ArticleI18n.title like '%$tag%' ","ArticleI18n.content like '%$tag%' ")),'fields'=>'ArticleI18n.article_id'));
	        $article_id += $key_article_id;
			
	       // pr($article_id);
			$conditions = array("Article.id"=>$article_id,'Article.status'=>'1');
			if($tag == "is_new"){
				$tag_show = $this->languages['latest'].$this->languages['news'];
			}else{
				$tag_show = $tag;
			}
		}else{
			$conditions = array('Article.status'=>'1');
			$tag_show = $this->languages['all'].$this->languages['article'];
		}

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
					//	$article_list[$key]['ArticleI18n']['sub_title'] = $this->Article->sub_str($val['ArticleI18n']['title'],$this->configs['article_title_length']);
						$article_list[$key]['ArticleI18n']['sub_title'] = $val['ArticleI18n']['title'];
	                }else{
						$article_list[$key]['ArticleI18n']['sub_title'] = $val['ArticleI18n']['title'];
	                }
					$article_list[$key]['ArticleI18n']['content'] = $this->Article->sub_str($val['ArticleI18n']['content'],180);
                }
                $this->set('article_list',$article_list);
            }
       	//     pr($article_list);
		      $ur_heres=array();
		      $ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
		      $ur_heres[]=array('name'=>$tag_show,'url'=>"");
		      $this->set('locations',$ur_heres);
		      //排序方式,显示方式,分页数量限制
		      $this->set('orderby',$orderby);
		      $this->set('rownum',$rownum);
		      $this->set('total',$total);
		      
		      $this->pageTitle = $tag_show." - ".$this->configs['shop_title'];
		      //set js 语言
		      $js_languages = array("page_number_expand_max" => $this->languages['page_number'].$this->languages['not_exist']);
		      $this->set('js_languages',$js_languages);
		      $this->set('meta_description',$tag);
		 	  $this->set('meta_keywords',$tag);
		 	  
    }
    
    function sitemap(){
		Configure::write('debug', 0);
 		//文章
		$this->Article->set_locale($this->locale);
 		$articles = $this->Article->find('all',array('conditions'=>array('Article.status'=>1),'order'=>'Article.created DESC'));
 		$this->set('articles',$articles);
		//文章类目
		$article_cat=$this->Category->tree('A',0,$this->locale);
		//pr($article_cat);
		$this->set('article_cat',$article_cat['tree']);
		$ur_heres=array();
		$ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
		$ur_heres[]=array('name'=>$this->languages['sitemap'],'url'=>"/sitemaps");
	//	$this->set('languages',$this->locale);
		$this->set('locations',$ur_heres);
		$this->pageTitle = $this->languages['sitemap']." - ".$this->configs['shop_title'];
		$categories_tree = array();
		$this->page_init();
		$this->set('categories_tree',$categories_tree);

		$sitemap_list = $this->Sitemap->findall("1=1 and Sitemap.status = '1'");
		$this->set('sitemaps',$sitemap_list);
		
 		$this->layout = 'xml/default';
		
    }
}//end class

?>