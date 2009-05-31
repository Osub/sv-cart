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
 * $Id: pages_controller.php 1902 2009-05-31 13:56:19Z huangbo $
*****************************************************************************/
class PagesController extends AppController {
	var $name = 'Pages';
	var $helpers = array('Html','Flash');
	var $uses = array('Product','Flash','Article','UserRank','ProductRank');
	var $components = array('RequestHandler','Cookie','Session');
	function home(){
	//	Configure::write('debug', 0);
		$this->page_init();
		$this->pageTitle = $this->languages['home']."- ".$this->configs['shop_title'];
		$this->set('meta_description',$this->configs['shop_description']);
		$this->set('meta_keywords',$this->configs['shop_keywords']);
		
	//	$this->set('js_languages',$this->languages);
		$this->Flash->set_locale($this->locale);
		$this->set('flashes',$this->Flash->find("type ='H'")); //flash轮播
		//pr($this->Flash->find("type ='H'"));
		$this->Product->set_locale($this->locale);
	
		$this->Article->set_locale($this->locale);
		$condition = "Article.status = '1' and Article.front = '1'" ;
	    $home_article=$this->Article->find('all',array('order' => array('Article.modified DESC'),
	    												'conditions' => array('Article.status'=>'1',
	    																	'Article.front' => '1'
	    																		),
	    												'LIMIT' => 10
	    												));
		$this->set('home_article',$home_article);
		$products_recommand = $this->Product->recommand($this->configs['promotion_count']);
		$products_newarrival = $this->Product->newarrival($this->configs['promotion_count']);
		$products_promotion = $this->Product->promotion($this->configs['promotion_count']);
		
		//  设置商品名的现实长度
		
			foreach($products_recommand as $k=>$v){
				if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
					$products_recommand[$k]['ProductI18n']['name'] = $this->Product->sub_str($v['ProductI18n']['name'], $this->configs['products_name_length']);
				}
				$products_recommand[$k]['Product']['shop_price'] =$this->Product->locale_price($v['Product']['id'],$v['Product']['shop_price'],$this);
				$products_recommand[$k]['Product']['user_price'] =$this->Product->user_price($k,$v,$this);
				if($this->Product->is_promotion($v['Product']['id'])){
					$products_recommand[$k]['Product']['shop_price'] = $products_recommand[$k]['Product']['promotion_price'];
				}
			}
			foreach($products_newarrival as $kk=>$vv){
				if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
					$products_newarrival[$kk]['ProductI18n']['name'] = $this->Product->sub_str($vv['ProductI18n']['name'], $this->configs['products_name_length']);
				}
				$products_newarrival[$kk]['Product']['user_price'] =$this->Product->user_price($kk,$vv,$this);
				$products_newarrival[$kk]['Product']['shop_price'] =$this->Product->locale_price($vv['Product']['id'],$vv['Product']['shop_price'],$this);
				if($this->Product->is_promotion($vv['Product']['id'])){
					$products_newarrival[$kk]['Product']['shop_price'] = $products_newarrival[$kk]['Product']['promotion_price'];
				}
			}
			foreach($products_promotion as $kkk=>$vvv){
				if(isset($this->configs['products_name_length']) && $this->configs['products_name_length'] >0){
					$products_promotion[$kkk]['ProductI18n']['name'] = $this->Product->sub_str($vvv['ProductI18n']['name'], $this->configs['products_name_length']);
				}
				$products_promotion[$kkk]['Product']['user_price'] =$this->Product->user_price($kkk,$vvv,$this);
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