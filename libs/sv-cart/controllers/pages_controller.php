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
 * $Id: pages_controller.php 3225 2009-07-22 10:59:01Z huangbo $
*****************************************************************************/
class PagesController extends AppController {
	var $name = 'Pages';
	var $helpers = array('Html','Flash');
	var $uses = array('Product','Flash','Article','UserRank','ProductRank','ProductLocalePrice','ProductI18n');
	var $components = array('RequestHandler','Cookie','Session');
//	var $cacheQueries = true;
//	var $cacheAction = "1 day";
	
	
	function home(){
		
	//	Configure::write('debug', 0);
		$this->page_init();
		$this->pageTitle = $this->languages['home']."- ".$this->configs['shop_title'];
		$this->set('meta_description',$this->configs['shop_description']);
		$this->set('meta_keywords',$this->configs['shop_keywords']);
		
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
																		'ArticleI18n.title'
																					),														    	
		    												'conditions' => array('Article.status'=>'1',
		    																	'Article.front' => '1'
		    																		),
		    												'limit' => 10
		    												));
			cache::write($cache_key,$home_article);
	    }
	    if(isset($home_article) && sizeof($home_article)>0){
	    	foreach($home_article as $k=>$v){
		    	if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
					$home_article[$k]['ArticleI18n']['title'] = $this->Article->sub_str($v['ArticleI18n']['title'],$this->configs['article_title_length']);
				}
			}
	    }
		$this->set('home_article',$home_article);
		
		$products_recommand  = $this->Product->recommand($this->configs['promotion_count'],$this->locale);
		$products_newarrival = $this->Product->newarrival($this->configs['promotion_count'],$this->locale);
		$products_promotion  = $this->Product->promotion($this->configs['promotion_count'],$this->locale);
		$home_ids = array();
		
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
		if(isset($_SESSION['User']['User'])){
		$product_ranks = $this->ProductRank->findall_ranks();
		}
		if(isset($_SESSION['User']['User'])){
			$user_rank_list=$this->UserRank->findrank();		
		}
		foreach($products_recommand as $k=>$v){
			if(isset($productI18ns_list[$v['Product']['id']])){
				$products_recommand[$k]['ProductI18n'] = $productI18ns_list[$v['Product']['id']]['ProductI18n'];
			}else{
				$products_recommand[$k]['ProductI18n']['name'] = "";
			}	
			
			if(isset($products_recommand[$k]['ProductI18n']['name']) &&isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
				$products_recommand[$k]['ProductI18n']['name'] = $this->Product->sub_str($products_recommand[$k]['ProductI18n']['name'], $this->configs['products_name_length']);
			}
			if(isset($this->configs['mlti_currency_module']) && $this->configs['mlti_currency_module'] == 1 && isset($v['ProductLocalePrice']['product_price'])){
				$products_recommand[$k]['Product']['shop_price'] = $v['ProductLocalePrice']['product_price'];
			}
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
				$products_newarrival[$kk]['ProductI18n']['name'] = $this->Product->sub_str($products_newarrival[$kk]['ProductI18n']['name'], $this->configs['products_name_length']);
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
				$products_promotion[$kkk]['ProductI18n']['name'] = $this->Product->sub_str($products_promotion[$kkk]['ProductI18n']['name'], $this->configs['products_name_length']);
			}
			if(isset($product_ranks[$vvv['Product']['id']]) && isset($_SESSION['User']['User']['rank']) && isset($product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']])){
				if(isset($product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank']) && $product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['is_default_rank'] == 0){
				  $products_promotion[$kkk]['Product']['user_price']= $product_ranks[$vvv['Product']['id']][$_SESSION['User']['User']['rank']]['ProductRank']['product_price'];			  
				}else if(isset($user_rank_list[$_SESSION['User']['User']['rank']])){
				  $products_promotion[$kkk]['Product']['user_price']=($user_rank_list[$_SESSION['User']['User']['rank']]['UserRank']['discount']/100)*($vvv['Product']['shop_price']);			  
				}
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
		
		$vote_options = $this->VoteOption->find('all',array('order'=>array('VoteOption.option_count ASC'),
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
		$count = 100;
		if(isset($votes) && sizeof($votes)>0){
			foreach($votes as $k=>$v){
				$vote_lists[$v['Vote']['id']] = $v;
				if(isset($vote_option_lists[$v['Vote']['id']])){
					$vote_lists[$v['Vote']['id']]['options'] = $vote_option_lists[$v['Vote']['id']];
					if(sizeof($vote_option_lists[$v['Vote']['id']])>0 ){
						foreach($vote_lists[$v['Vote']['id']]['options'] as $a=>$b){
							if($a == (sizeof($vote_lists[$v['Vote']['id']]['options']) - 1)){
							$percent = $count;
							}else{
							$percent = ($v['Vote']['vote_count'] >0 && $b['VoteOption']['option_count'])?round(($b['VoteOption']['option_count']/$v['Vote']['vote_count'])*100):0;
							$count -= $percent;
							}
							$vote_lists[$v['Vote']['id']]['options'][$a]['VoteOption']['dis'] = $percent;
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