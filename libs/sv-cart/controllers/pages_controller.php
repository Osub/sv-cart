<?php
/*****************************************************************************
 * SV-Cart 购物首页
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: pages_controller.php 5101 2009-10-15 11:23:51Z huangbo $
*****************************************************************************/
class PagesController extends AppController {
	var $name = 'Pages';
	var $helpers = array('Html','Flash','Cache');
	var $uses = array('Product','Flash','Article','UserRank','ProductRank','ProductLocalePrice','ProductI18n','Category','Vote','VoteOption','Comment','Advertisement','Topic','TopicI18n','TopicProduct');
	var $components = array('RequestHandler','Cookie','Session');
	var $cacheQueries = true;
	var $cacheAction = "1 hour";//array('home/'=>'60000');
	
	
	function home(){
	//	Configure::write('debug', 0);
		$this->page_init();
		$this->pageTitle = $this->configs['shop_title'];
		$this->set('meta_description',$this->configs['shop_description']);
		$this->set('meta_keywords',$this->configs['shop_keywords']);
		
		$comments = $this->Comment->cache_find('all',array('order'=>'Comment.created','conditions'=>array('Comment.type'=>'P','Comment.status'=>1),'limit'=>5),"Comment_home_prodcut_".$this->locale);
		$this->set('home_comments',$comments);		
		
		//所有专题 和下面的商品
		$this->Topic->set_locale($this->locale);
    	$topics = $this->Topic->cache_find('all',array('conditions'=>array('1=1'),'order'=>'Topic.created DESC'),'page_home_'.$this->locale);
    	if(isset($topics) && sizeof($topics)>0){
    		$this->data['topic_list'] = $topics;
    		$this->set('topics',$topics);
    		$topics_ids = array();
    		foreach($topics as $k=>$v){
    			$topics_ids[] = $v['Topic']['id'];
    		}
    		if(!empty($topics_ids)){
    			$topic_products = $this->TopicProduct->find('all',array('conditions'=>array('TopicProduct.topic_id'=>$topics_ids,'TopicProduct.status'=>1),'fields'=>array('TopicProduct.id','TopicProduct.topic_id','TopicProduct.product_id','TopicProduct.price')));
			}
		}
		
	//	$this->set('js_languages',$this->languages);
		$this->Flash->set_locale($this->locale);
		$cache_key = md5('find_page_flash'.'_'.$this->locale);
		
		$page_flash = cache::read($cache_key);	
		if(!$page_flash){
			$page_flash = $this->Flash->find("type = 'H'");
			cache::write($cache_key,$page_flash);
		}
		$this->set('flashes',$page_flash); //flash轮播
			
		//pr($this->Flash->find("type ='H'"));
		$this->Product->set_locale($this->locale);
		$this->Article->set_locale($this->locale);
		$condition = "Article.status = '1' and Article.front = '1'" ;
		$cache_key = md5('find_home_article'.'_'.$this->locale);
		$home_article = cache::read($cache_key);	
		if(!$home_article){
		    $home_article=$this->Article->find('all',array('order' => array('Article.modified DESC'),
											'fields' =>	array('Article.id','Article.file_url','Article.category_id',
																		'ArticleI18n.title','ArticleI18n.content'
																					),														    	
		    												'conditions' => array('Article.status'=>'1',
		    																	'Article.front' => '1'
		    																		),
		    												'limit' =>$this->configs['latest_article_show_number']
		    												));
			cache::write($cache_key,$home_article);
	    }
	    if(isset($home_article) && sizeof($home_article)>0){
	    	foreach($home_article as $k=>$v){
		    	if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
					$home_article[$k]['ArticleI18n']['sub_title'] = $this->Article->sub_str($v['ArticleI18n']['title'],$this->configs['article_title_length']);
				}
			}
	    }
		$this->set('home_article',$home_article);
		//全部商品的 三种状态
		$products_recommand  = $this->Product->recommand($this->configs['promotion_count'],$this->locale);
		$products_newarrival = $this->Product->newarrival($this->configs['promotion_count'],$this->locale);
		$products_promotion  = $this->Product->promotion($this->configs['promotion_count'],$this->locale);
		
		// 2kbuy  1级分类
	    $category_tree = $this->Category->tree('P',0,$this->locale,$this);
		
	//	pr($category_tree);exit;
		//一级分类中商品的 三种状态
		if(isset($category_tree['tree']) && sizeof($category_tree['tree'])>0){
			$category_ids = array();
			$home_category_products = array();
			foreach($category_tree['tree'] as $k=>$v){
				$category_ids[] = $v['Category']['id'];
				$home_category_products[$v['Category']['id']] = $category_tree['assoc'][$v['Category']['id']];
			}
		//	pr($home_category_products);
			
			
			if(!empty($category_ids) && sizeof($category_ids)>0){
				foreach($category_ids as $k=>$v){
			//		$home_category_products[$v]['all_list'] = $this->Product->all_list($this->configs['promotion_count'],$this->locale,$v);
					$home_category_products[$v]['recommand'] = $this->Product->recommand($this->configs['promotion_count'],$this->locale,$v);
					$home_category_products[$v]['newarrival'] = $this->Product->newarrival($this->configs['promotion_count'],$this->locale,$v);
					$home_category_products[$v]['promotion'] = $this->Product->promotion($this->configs['promotion_count'],$this->locale,$v);
				}
			}
		}
		
		$home_ids = array();
		$topic_products_list = array();
			if(isset($topic_products) && count($topic_products) > 0){
				$topic_p_ids = array();
		   		foreach($topic_products as $k=>$v){
		   			$topic_p_ids[] = $v['TopicProduct']['product_id'];
		   			$home_ids[] = $v['TopicProduct']['product_id'];
		   			$topic_products_list[$v['TopicProduct']['topic_id']]['p_ids'][] = $v['TopicProduct']['product_id'];
		   		}
		   		if(!empty($topic_p_ids)){
					$topic_pro = $this->Product->cache_find('all',array('order' => array('Product.modified DESC'),
																		'recursive' => -1,
																		'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
																						,'Product.market_price'
																						,'Product.shop_price'
																						,'Product.promotion_price'
																						,'Product.promotion_start'
																						,'Product.promotion_end'
																						,'Product.promotion_status'
																						,'Product.code'
																						,'Product.product_rank_id'
																						,'Product.quantity'
																						),
																	'conditions'=>array('Product.id'=>$topic_p_ids,
																						'Product.status'=>'1',
					    																 'Product.alone' => '1',
					    																 'Product.forsale' => '1'																				
																						)),'topic_pro_'.$this->locale
																						);
					if(isset($topic_pro) && sizeof($topic_pro)>0){
						$topic_pro_list =array();
						foreach($topic_pro as $z=>$f){
							$topic_pro_list[$f['Product']['id']] = $f;
						}
				   		foreach($topic_products as $x=>$y){
				   			if(isset($topic_pro_list[$y['TopicProduct']['product_id']])){
				   			$topic_products_list[$y['TopicProduct']['topic_id']]['products'][$y['TopicProduct']['product_id']] = $topic_pro_list[$y['TopicProduct']['product_id']];
				   			}
				   		}						
					}		   		
		   		}		   		
   			}		
		
		
		
		
		if(isset($home_category_products) && sizeof($home_category_products)>0){
			foreach($home_category_products as $k=>$v){
				if(isset($v['all_list']) && sizeof($v['all_list'])>0){
					foreach($v['all_list'] as $kk=>$vv){
						if(!in_array($vv['Product']['id'],$home_ids)){
						$home_ids[] = $vv['Product']['id'];
						}
					}
				}				
				if(isset($v['recommand']) && sizeof($v['recommand'])>0){
					foreach($v['recommand'] as $kk=>$vv){
						if(!in_array($vv['Product']['id'],$home_ids)){
						$home_ids[] = $vv['Product']['id'];
						}
					}
				}
				if(isset($v['newarrival']) && sizeof($v['newarrival'])>0){
					foreach($v['newarrival'] as $kk=>$vv){
						if(!in_array($vv['Product']['id'],$home_ids)){
						$home_ids[] = $vv['Product']['id'];
						}
					}
				}				
				if(isset($v['promotion']) && sizeof($v['promotion'])>0){
					foreach($v['promotion'] as $kk=>$vv){
						if(!in_array($vv['Product']['id'],$home_ids)){
						$home_ids[] = $vv['Product']['id'];
						}
					}
				}
			}
		}
		
		
		
		if(isset($products_recommand) && sizeof($products_recommand)>0){
			foreach($products_recommand as $k=>$v){
				if(!in_array($v['Product']['id'],$home_ids)){
					$home_ids[] = $v['Product']['id'];
				}
			}
		}

		if(isset($products_newarrival) && sizeof($products_newarrival)>0){
			foreach($products_newarrival as $k=>$v){
				if(!in_array($v['Product']['id'],$home_ids)){
					$home_ids[] = $v['Product']['id'];
				}			
			}
		}
		
		if(isset($products_promotion) && sizeof($products_promotion)>0){
			foreach($products_promotion as $k=>$v){
				if(!in_array($v['Product']['id'],$home_ids)){
					$home_ids[] = $v['Product']['id'];
				}			
			}
		}
		
		// vancl 断码专区
		$this->Category->set_locale($this->locale);
	
		$cache_key = md5('find_home_category_info'.'_'.$this->locale);
		$category_info = cache::read($cache_key);	
		if(!$category_info){
			$category_info = $this->Category->find('all',array('fields'=>array('Category.id',
			                    'CategoryI18n.name'),'conditions'=>array('Category.id'=>'29')));
			cache::write($cache_key,$category_info);	
		}
		if(isset($category_info[0])){
			$category_vancl = $category_info[0];
			$this->set('category_vancl',$category_vancl);
		}
		
		$cache_key = md5('find_home_vancl_pro'.'_'.$this->locale);
		$vancl_pro = cache::read($cache_key);	
		if(!$vancl_pro){		
			$vancl_pro = $this->Product->find('all',array('order' => array('Product.modified DESC'),
																'recursive' => -1,
																'fields' =>	array('Product.id','Product.recommand_flag','Product.status','Product.img_thumb'
																				,'Product.market_price'
																				,'Product.shop_price'
																				,'Product.promotion_price'
																				,'Product.promotion_start'
																				,'Product.promotion_end'
																				,'Product.promotion_status'
																				,'Product.code'
																				,'Product.product_rank_id'
																				,'Product.quantity'
																				),
															'conditions'=>array('Product.category_id'=>'29',
																				'Product.status'=>'1',
			    																 'Product.alone' => '1',
			    																 'Product.forsale' => '1'																				
																				),'limit' => $this->configs['promotion_count'])
																				);
				cache::write($cache_key,$vancl_pro);	
		}
		if(isset($vancl_pro) && sizeof($vancl_pro)>0){
			foreach($vancl_pro as $k=>$v){
				if(!in_array($v['Product']['id'],$home_ids)){
					$home_ids[] = $v['Product']['id'];
				}			
			}
		}		
		
		
		// 商品多语言		
		$productI18ns_list =array();
		if(!empty($home_ids)){
			$cache_key = md5('home_ids_productI18ns'.'_'.$this->locale);
			$productI18ns = cache::read($cache_key);	
			if(!$productI18ns){
				$productI18ns = $this->ProductI18n->find('all',array( 
				'fields' =>	array('ProductI18n.id','ProductI18n.name','ProductI18n.product_id'),
				'conditions'=>array('ProductI18n.product_id'=>$home_ids,'ProductI18n.locale'=>$this->locale)));
				cache::write($cache_key,$productI18ns);
			}
			if(isset($productI18ns) && sizeof($productI18ns)>0){
				foreach($productI18ns as $k=>$v){
					$productI18ns_list[$v['ProductI18n']['product_id']] = $v;
				}
			}
		}
		// 商品地区价格
		if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1){
			$locale_price_list =array();
			if(!empty($home_ids)){
				$cache_key = md5('home_ids_locale_price'.'_'.$this->locale);
				$locale_price = cache::read($cache_key);	
				if(!$locale_price){
					$locale_price = $this->ProductLocalePrice->find('all',array( 
					'fields' =>	array('ProductLocalePrice.product_price','ProductLocalePrice.product_id'),
					'conditions'=>array('ProductLocalePrice.product_id'=>$home_ids,'ProductLocalePrice.locale'=>$this->locale,'ProductLocalePrice.status'=>1)));
					cache::write($cache_key,$locale_price);
				}
				if(isset($locale_price) && sizeof($locale_price)>0){
					foreach($locale_price as $k=>$v){
						$locale_price_list[$v['ProductLocalePrice']['product_id']] = $v;
					}
				}
			}
		}
		//  设置商品名的现实长度
	//	if(isset($_SESSION['User']['User'])){
			$product_ranks = $this->ProductRank->findall_ranks();
	//	}
	//	if(isset($_SESSION['User']['User'])){
			$user_rank_list=$this->UserRank->findrank();		
	//	}
	//pr($user_rank_list);
	    if(isset($product_ranks) && sizeof($product_ranks)>0){
			  foreach($product_ranks as $k=>$v){
			  	  if(isset($v) && sizeof($v)>0){
			  	  	 foreach($v as $kk=>$vv){
			  	  	 	 if($vv['ProductRank']['is_default_rank'] == 1){
			  	  	 	 	$product_ranks[$k][$kk]['ProductRank']['discount'] = ($user_rank_list[$vv['ProductRank']['rank_id']]['UserRank']['discount']/100);	
			  	  	 	 }			  	  	 
			  	  	 }
			  	  }
			  }
		}			
		
		
		
		if(isset($vancl_pro) && sizeof($vancl_pro)>0){
			foreach($vancl_pro as $k=>$v){
				if(isset($productI18ns_list[$v['Product']['id']])){
					$vancl_pro[$k]['ProductI18n'] = $productI18ns_list[$v['Product']['id']]['ProductI18n'];
				}else{
					$vancl_pro[$k]['ProductI18n']['name'] = "";
				}	
				
				if(isset($vancl_pro[$k]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
					$vancl_pro[$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($vancl_pro[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
				}else{
					$vancl_pro[$k]['ProductI18n']['sub_name'] = $vancl_pro[$k]['ProductI18n']['name'];
				}
				if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'])){
					$vancl_pro[$k]['Product']['shop_price'] = $locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'];
				}		
				if(isset($product_ranks[$v['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']])){
					if(isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
					  $vancl_pro[$k]['Product']['user_price']= $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
					}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
					  $vancl_pro[$k]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
					}
				}
				if($this->Product->is_promotion($v)){
					$vancl_pro[$k]['Product']['shop_price'] = $vancl_pro[$k]['Product']['promotion_price'];
				}
			}	
			$this->set('vancl_pro',$vancl_pro);		
		}
		if(isset($topic_products_list) && count($topic_products_list) > 0){
		   		
			foreach($topic_products_list as $k=>$v){
				if(isset($v['p_ids']) && sizeof($v['p_ids'])>0){
					foreach($v['p_ids'] as $kk=>$vv){
						if(isset($topic_products_list[$k]['products'][$vv]['Product'])){
						if(isset($productI18ns_list[$vv])){
							$topic_products_list[$k]['products'][$vv]['ProductI18n'] = $productI18ns_list[$vv]['ProductI18n'];
						}else{
							$topic_products_list[$k]['products'][$vv]['ProductI18n']['name'] = "";
						}	
						
						if(isset($topic_products_list[$k]['products'][$vv]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
							$topic_products_list[$k]['products'][$vv]['ProductI18n']['sub_name'] = $this->Product->sub_str($topic_products_list[$k]['products'][$vv]['ProductI18n']['name'], $this->configs['products_name_length']);
						}else{
							$topic_products_list[$k]['products'][$vv]['ProductI18n']['sub_name'] = $topic_products_list[$k]['products'][$vv]['ProductI18n']['name'];
						}
						if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($locale_price_list[$vv]['ProductLocalePrice']['product_price'])){
							$topic_products_list[$k]['products'][$vv]['Product']['shop_price'] = $locale_price_list[$vv]['ProductLocalePrice']['product_price'];
						}		
						if(isset($product_ranks[$vv]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$vv][$_SESSION['User']['User']['rank']])){
							if(isset($product_ranks[$vv][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$vv][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
							  $topic_products_list[$k]['products'][$vv]['Product']['user_price']= $product_ranks[$vv][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
							}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
							  $topic_products_list[$k]['products'][$vv]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
							}
						}
						if($this->Product->is_promotion($topic_products_list[$k]['products'][$vv]['Product'])){
							$topic_products_list[$k]['products'][$vv]['Product']['shop_price'] = $topic_products_list[$k]['products'][$vv]['Product']['promotion_price'];
						}
						}
					}
				}
		   	}
		   		$this->data['topic_products_list'] = $topic_products_list;
		   		$this->set('topic_products_list',$topic_products_list);
   		}		
		
		
		
		if(isset($home_category_products) && sizeof($home_category_products)>0){
			foreach($home_category_products as $key=>$value){
				if(isset($value['all_list']) && sizeof($value['all_list'])>0){
					foreach($value['all_list'] as $k=>$v){
						if(isset($productI18ns_list[$v['Product']['id']])){
							$home_category_products[$key]['all_list'][$k]['ProductI18n'] = $productI18ns_list[$v['Product']['id']]['ProductI18n'];
						}else{
							$home_category_products[$key]['all_list'][$k]['ProductI18n']['name'] = "";
						}	
						
						if(isset($home_category_products[$key]['all_list'][$k]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
							$home_category_products[$key]['all_list'][$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($home_category_products[$key]['all_list'][$k]['ProductI18n']['name'], $this->configs['products_name_length']);
						}else{
							$home_category_products[$key]['all_list'][$k]['ProductI18n']['sub_name'] = $home_category_products[$key]['all_list'][$k]['ProductI18n']['name'];
						}
						if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'])){
							$home_category_products[$key]['all_list'][$k]['Product']['shop_price'] = $locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'];
						}	
						if(isset($product_ranks[$v['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']])){
							if(isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
							  $home_category_products[$key]['all_list'][$k]['Product']['user_price']= $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
							}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
							  $home_category_products[$key]['all_list'][$k]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
							}
						}
						if($this->Product->is_promotion($v)){
							$home_category_products[$key]['all_list'][$k]['Product']['shop_price'] = $home_category_products[$key]['all_list'][$k]['Product']['promotion_price'];
						}
					}
				}				
				if(isset($value['recommand']) && sizeof($value['recommand'])>0){
					foreach($value['recommand'] as $k=>$v){
						if(isset($productI18ns_list[$v['Product']['id']])){
							$home_category_products[$key]['recommand'][$k]['ProductI18n'] = $productI18ns_list[$v['Product']['id']]['ProductI18n'];
						}else{
							$home_category_products[$key]['recommand'][$k]['ProductI18n']['name'] = "";
						}	
						
						if(isset($home_category_products[$key]['recommand'][$k]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
							$home_category_products[$key]['recommand'][$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($home_category_products[$key]['recommand'][$k]['ProductI18n']['name'], $this->configs['products_name_length']);
						}else{
							$home_category_products[$key]['recommand'][$k]['ProductI18n']['sub_name'] = $home_category_products[$key]['recommand'][$k]['ProductI18n']['name'];
						}
						if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'])){
							$home_category_products[$key]['recommand'][$k]['Product']['shop_price'] = $locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'];
						}	
						if(isset($product_ranks[$v['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']])){
							if(isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
							  $home_category_products[$key]['recommand'][$k]['Product']['user_price']= $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
							}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
							  $home_category_products[$key]['recommand'][$k]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
							}
						}
						if($this->Product->is_promotion($v)){
							$home_category_products[$key]['recommand'][$k]['Product']['shop_price'] = $home_category_products[$key]['recommand'][$k]['Product']['promotion_price'];
						}
					}
				}
				if(isset($value['newarrival']) && sizeof($value['newarrival'])>0){
					foreach($value['newarrival'] as $kk=>$vv){
							if(isset($productI18ns_list[$vv['Product']['id']])){
								$home_category_products[$key]['newarrival'][$kk]['ProductI18n'] = $productI18ns_list[$vv['Product']['id']]['ProductI18n'];
							}else{
								$home_category_products[$key]['newarrival'][$kk]['ProductI18n']['name'] = "";
							}
							if(isset($home_category_products[$key]['newarrival'][$kk]['ProductI18n']['name']) && isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
								$home_category_products[$key]['newarrival'][$kk]['ProductI18n']['sub_name'] = $this->Product->sub_str($home_category_products[$key]['newarrival'][$kk]['ProductI18n']['name'], $this->configs['products_name_length']);
							}else{
								$home_category_products[$key]['newarrival'][$kk]['ProductI18n']['sub_name'] = $home_category_products[$key]['newarrival'][$kk]['ProductI18n']['name'];
							}
							if(isset($product_ranks[$vv['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$vv['Product']['id']][$_SESSION['User']['User']['rank']])){
								if(isset($product_ranks[$vv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$vv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
								  $home_category_products[$key]['newarrival'][$kk]['Product']['user_price']= $product_ranks[$vv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
								}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
								  $home_category_products[$key]['newarrival'][$kk]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($vv['Product']['shop_price']);			  
								}
							}			
							if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($locale_price_list[$vv['Product']['id']]['ProductLocalePrice']['product_price'])){
								$home_category_products[$key]['newarrival'][$kk]['Product']['shop_price'] = $locale_price_list[$vv['Product']['id']]['ProductLocalePrice']['product_price'];
							}
							if($this->Product->is_promotion($vv)){
								$home_category_products[$key]['newarrival'][$kk]['Product']['shop_price'] = $home_category_products[$key]['newarrival'][$kk]['Product']['promotion_price'];
							}
					}
				}				
				if(isset($value['promotion']) && sizeof($value['promotion'])>0){
					foreach($value['promotion'] as $kkk=>$vvv){
						if(isset($productI18ns_list[$vvv['Product']['id']])){
							$home_category_products[$key]['promotion'][$kkk]['ProductI18n'] = $productI18ns_list[$vvv['Product']['id']]['ProductI18n'];
						}else{
							$home_category_products[$key]['promotion'][$kkk]['ProductI18n']['name'] = "";
						}					
						if(isset($home_category_products[$key]['promotion'][$kkk]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
							$home_category_products[$key]['promotion'][$kkk]['ProductI18n']['sub_name'] = $this->Product->sub_str($home_category_products[$key]['promotion'][$kkk]['ProductI18n']['name'], $this->configs['products_name_length']);
						}else{
							$home_category_products[$key]['promotion'][$kkk]['ProductI18n']['sub_name'] = $home_category_products[$key]['promotion'][$kkk]['ProductI18n']['name'];
						}
						if(isset($product_ranks[$vvv['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']])){
							if(isset($product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
							  $home_category_products[$key]['promotion'][$kkk]['Product']['user_price']= $product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
							}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
							  $home_category_products[$key]['promotion'][$kkk]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($vvv['Product']['shop_price']);			  
							}
						}				
						if($this->Product->is_promotion($vvv)){
							$home_category_products[$key]['promotion'][$kkk]['Product']['shop_price'] = $home_category_products[$key]['promotion'][$kkk]['Product']['promotion_price'];
						}
					}
				}
			}
	   	//		 $home_category_products = array_slice($home_category_products,'0','2');
	   			$this->data['home_category_products'] = $home_category_products;
				$this->set('home_category_products',$home_category_products);
		}		
		
		
	//	pr($home_category_products);
		
		
		
		
		foreach($products_recommand as $k=>$v){
			if(isset($productI18ns_list[$v['Product']['id']])){
				$products_recommand[$k]['ProductI18n'] = $productI18ns_list[$v['Product']['id']]['ProductI18n'];
			}else{
				$products_recommand[$k]['ProductI18n']['name'] = "";
			}	
			
			if(isset($products_recommand[$k]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
				$products_recommand[$k]['ProductI18n']['sub_name'] = $this->Product->sub_str($products_recommand[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
			}else{
				$products_recommand[$k]['ProductI18n']['sub_name'] = $products_recommand[$k]['ProductI18n']['name'];
			}
		//	if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($v['ProductLocalePrice']['product_price'])){
		//		$products_recommand[$k]['Product']['shop_price'] = $v['ProductLocalePrice']['product_price'];
		//	}
			if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'])){
				$products_recommand[$k]['Product']['shop_price'] = $locale_price_list[$v['Product']['id']]['ProductLocalePrice']['product_price'];
			}	
	
		//	$products_recommand[$k]['Product']['shop_price'] =$this->Product->locale_price($v['Product']['id'],$v['Product']['shop_price'],$this);
			if(isset($product_ranks[$v['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']])){
				if(isset($product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
				  $products_recommand[$k]['Product']['user_price']= $product_ranks[$v['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
				}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
				  $products_recommand[$k]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($v['Product']['shop_price']);			  
				}
			}
		//	$products_recommand[$k]['Product']['user_price'] =$this->Product->user_price($k,$v,$this);
			if($this->Product->is_promotion($v)){
				$products_recommand[$k]['Product']['shop_price'] = $products_recommand[$k]['Product']['promotion_price'];
			}
		}		
		
		foreach($products_newarrival as $kk=>$vv){
			if(isset($productI18ns_list[$vv['Product']['id']])){
				$products_newarrival[$kk]['ProductI18n'] = $productI18ns_list[$vv['Product']['id']]['ProductI18n'];
			}else{
				$products_newarrival[$kk]['ProductI18n']['name'] = "";
			}
			if(isset($products_newarrival[$kk]['ProductI18n']['name']) && isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
				$products_newarrival[$kk]['ProductI18n']['sub_name'] = $this->Product->sub_str($products_newarrival[$kk]['ProductI18n']['name'], $this->configs['products_name_length']);
			}else{
				$products_newarrival[$kk]['ProductI18n']['sub_name'] = $products_newarrival[$kk]['ProductI18n']['name'];
			}
			if(isset($product_ranks[$vv['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$vv['Product']['id']][$_SESSION['User']['User']['rank']])){
				if(isset($product_ranks[$vv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$vv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
				  $products_newarrival[$kk]['Product']['user_price']= $product_ranks[$vv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
				}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
				  $products_newarrival[$kk]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($vv['Product']['shop_price']);			  
				}
			}			
			if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($locale_price_list[$vv['Product']['id']]['ProductLocalePrice']['product_price'])){
				$products_newarrival[$kk]['Product']['shop_price'] = $locale_price_list[$vv['Product']['id']]['ProductLocalePrice']['product_price'];
			}
			
			
		//	$products_newarrival[$kk]['Product']['user_price'] =$this->Product->user_price($kk,$vv,$this);
		//	$products_newarrival[$kk]['Product']['shop_price'] =$this->Product->locale_price($vv['Product']['id'],$vv['Product']['shop_price'],$this);
			if($this->Product->is_promotion($vv)){
				$products_newarrival[$kk]['Product']['shop_price'] = $products_newarrival[$kk]['Product']['promotion_price'];
			}
		}
		foreach($products_promotion as $kkk=>$vvv){
			if(isset($productI18ns_list[$vvv['Product']['id']])){
				$products_promotion[$kkk]['ProductI18n'] = $productI18ns_list[$vvv['Product']['id']]['ProductI18n'];
			}else{
				$products_promotion[$kkk]['ProductI18n']['name'] = "";
			}					
			if(isset($products_promotion[$kkk]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
				$products_promotion[$kkk]['ProductI18n']['sub_name'] = $this->Product->sub_str($products_promotion[$kkk]['ProductI18n']['name'], $this->configs['products_name_length']);
			}else{
				$products_promotion[$kkk]['ProductI18n']['sub_name'] = $products_promotion[$kkk]['ProductI18n']['name'];
			}
			if(isset($product_ranks[$vvv['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']])){
				if(isset($product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
				  $products_promotion[$kkk]['Product']['user_price']= $product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
				}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
				  $products_promotion[$kkk]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($vvv['Product']['shop_price']);			  
				}
			}				
			if($this->Product->is_promotion($vvv)){
				$products_promotion[$kkk]['Product']['shop_price'] = $products_promotion[$kkk]['Product']['promotion_price'];
			}
			//$products_promotion[$kkk]['Product']['user_price'] =$this->Product->user_price($kkk,$vvv,$this);
			//$products_promotion[$kkk]['Product']['shop_price'] =$this->Product->locale_price($vvv['Product']['id'],$vvv['Product']['shop_price'],$this);
		}
//be_integer
		if(isset($this->configs['enable_one_step_buy']) && $this->configs['enable_one_step_buy'] == 1){
					$js_language = array("enable_one_step_buy" => "1"
										,'enter_positive_integer' => $this->languages['be_integer']);
		}else{
					$js_language = array("enable_one_step_buy" => "0"
										,'enter_positive_integer' => $this->languages['be_integer']);
		}//format
			  		$js_error = array("order_quantity_be_integer" => $this->languages['purchase'].$this->languages['quantity'].$this->languages['be_integer'],
							"order_quantity_not_empty" => $this->languages['purchase'].$this->languages['quantity'].$this->languages['can_not_empty'],
							"contact_not_empty" => $this->languages['connect_person'].$this->languages['can_not_empty'],
							"invalid_email" => $this->languages['email_letter'].$this->languages['format'].$this->languages['not_correct'],
							"tel_number_not_empty" => $this->languages['telephone'].$this->languages['can_not_empty'],
							"invalid_tel_number" => $this->languages['telephone'].$this->languages['format'].$this->languages['not_correct']
							);
		$js_languages = $js_language + $js_error;
	  	$this->set('js_languages',$js_languages);
	//	pr($products_recommand);
		$size = 0;
		$tab_arr = array();
		$sign = "";
		if(isset($products_recommand) && sizeof($products_recommand)>0){
		$size ++;
		$tab_arr['products_recommand'] = $size;
		}
		if(isset($products_newarrival) && sizeof($products_newarrival)>0){
		$size ++;
		$tab_arr['products_newarrival'] = $size;
		}		
		if(isset($products_promotion) && sizeof($products_promotion)>0){
		$size ++;
		$tab_arr['products_promotion'] = $size;
		}
		
		if(isset($products_promotion) && sizeof($products_promotion)>0){
		$sign = "products_promotion";
		}else
		if(isset($products_newarrival) && sizeof($products_newarrival)>0){
		$sign = "products_newarrival";
		}else		
		if(isset($products_recommand) && sizeof($products_recommand)>0){
		$sign = "products_recommand";
		}		
		$this->set('sign',$sign);
		$this->set('size',$size);
		$this->set('tab_arr',$tab_arr);
		
		
		// $this->data 赋值区
		$this->data['products_newarrival'] = $products_newarrival;
		$this->data['products_recommand'] = $products_recommand;
		$this->data['products_promotion'] = $products_promotion;
		
		$this->data['tab_arr'] = $tab_arr;
		$this->data['sign'] = $sign;
		$this->data['size'] = $size;
		$this->data['product_ranks'] = $product_ranks;
		
 	    $this->set('products_recommand',$products_recommand); 	//推荐商品
 	    $this->set('products_newarrival',$products_newarrival); //新品上架
 	    $this->set('products_promotion',$products_promotion); 	//促销商品
 	    
		$now = date("Y-m-d");
		$this->Vote->set_locale($this->locale);
		$this->VoteOption->set_locale($this->locale);
		
		$votes = $this->Vote->find('all',array('orderby'=>'Vote.modified desc',
			'fields' =>	array('Vote.id','Vote.can_multi','Vote.vote_count',
										'VoteI18n.name'
													),	
		'conditions'=>array("Vote.start_time <=" =>$now ," Vote.end_time  >= " =>$now,"Vote.status "=>1)));
		if(isset($votes) && sizeof($votes)>0){
		$vote_ids = array();
		$vote_lists = array();
		$vote_ids[] = 0;
		if(isset($votes) && sizeof($votes)>0){
			foreach($votes as $k=>$v){
				$vote_ids[] = $v['Vote']['id'];
			}
		}
		
		$vote_options = $this->VoteOption->find('all',array('order'=>array('VoteOption.option_count ASC','VoteOption.modified ASC'),
			'fields' =>	array('VoteOption.id','VoteOption.option_count','VoteOption.vote_id',
										'VoteOptionI18n.name'
													),	
		
		'conditions'=>array("VoteOption.status" => 1,"VoteOption.vote_id" => $vote_ids)));
		$vote_option_lists = array();
		$vote_type = array();
		if(isset($vote_options) && sizeof($vote_options)>0){
			foreach($vote_options as $k=>$v){
				$vote_option_lists[$v['VoteOption']['vote_id']][$v['VoteOption']['id']] = $v;
				if(isset($vote_type[$v['VoteOption']['vote_id']]['all'])){
					$vote_type[$v['VoteOption']['vote_id']]['all'] += $v['VoteOption']['option_count'];
				}else{
					$vote_type[$v['VoteOption']['vote_id']]['all'] = $v['VoteOption']['option_count'];
				}
				$vote_type[$v['VoteOption']['vote_id']][$v['VoteOption']['id']] = $v['VoteOption']['option_count'];
			}
		}
		if(isset($votes) && sizeof($votes)>0){
			foreach($votes as $k=>$v){
				$count = 100;
				if($v['Vote']['vote_count'] == 0){
					$count = 0;
				}
				$vote_lists[$v['Vote']['id']] = $v;
				if(isset($vote_option_lists[$v['Vote']['id']])){
					$vote_lists[$v['Vote']['id']]['options'] = $vote_option_lists[$v['Vote']['id']];
					if(sizeof($vote_option_lists[$v['Vote']['id']])>0 ){
						$all_count = 0;
						foreach($vote_lists[$v['Vote']['id']]['options'] as $a=>$b){			
							$all_count += $b['VoteOption']['option_count'];
						}		
					}
					if(sizeof($vote_option_lists[$v['Vote']['id']])>0 ){
						foreach($vote_lists[$v['Vote']['id']]['options'] as $a=>$b){
							$mun = 0;
							if($a == ($mun- 1)){
								$percent = $count;
							}else{
								$percent = ($all_count>0 && $b['VoteOption']['option_count'])?round(($b['VoteOption']['option_count']/$all_count)*100):0;
								$count -= $percent;
							}
							$vote_lists[$v['Vote']['id']]['options'][$a]['VoteOption']['dis'] = $percent;
							$mun ++;
						} 
					}
				}
			}
			shuffle($vote_lists);
			$vote_lists = array_slice($vote_lists,0,1);
		}
		//删除没用的值
		unset($vote_type);unset($vote_option_lists);unset($vote_options);unset($votes);
	//	pr($vote_lists);
		$this->set('vote_lists',$vote_lists);	
		}	
 	    
           /* 取得广告位下广告的信息 */
        $now = date("Y-m-d h:i:s",time());
        $data = $this->Advertisement->find('all',array('conditions'=>array('AdvertisementI18n.start_time <='=>$now,'AdvertisementI18n.end_time >='=>$now,'AdvertisementI18n.locale'=>$this->locale,'Advertisement.status'=>1),'order'=>'Advertisement.orderby asc'));   	
    	$this->set('advertisement_list',$data);	  
 	    $this->set('head_show',"show");	 	    
 	    
 	    //pr("内存使用:".number_format((memory_get_usage()/1048576), 3, '.', ''));
	}
	
	
	function closed(){
		$this->page_init();
		$this->set('shop_logo',$this->configs['shop_logo']);
		$this->set('closed_reason',$this->configs['closed_reason']);
		$this->pageTitle = $this->languages['shop_closed']." - ".$this->configs['shop_title'];
		$this->flash($this->languages['shop_closed']," ","/",5);
		//$this->layout = 'flash.ctp';
	}
}

?>