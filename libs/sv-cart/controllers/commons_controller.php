<?php
/*****************************************************************************
 * SV-Cart 评论
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: commons_controller.php 5527 2009-11-05 02:07:24Z huangbo $
*****************************************************************************/

class CommonsController extends AppController {
    var $name = 'Commons';
    var $components = array ('Pagination','RequestHandler','Session','Cookie','Email'); // Added
    var $helpers = array('Pagination'); // Added
    var $uses = array('User','Language','SystemResource','Plugin','Navigation','MailTemplate','Category','UserMessage','Brand','Article','Comment','Config','Product','Card','Packaging','ProductsCategory','Tag','TagI18n','LanguageDictionary','Order','UserProductGallerie','OrderProduct','Payment');
    //$languages = $this->requestAction('commons/get_languages_front/');
     function get_languages_front(){
         $languages = $this->Language->findall("Language.front <> '0' ");
        return $languages;
     }
     function get_web_url(){
         $url_arr['server_host']  =  $this->server_host;
         $url_arr['user_webroot'] =  $this->user_webroot;
         $url_arr['cart_webroot'] =  $this->cart_webroot;
         return $url_arr;
     }     
    
     function is_error(){
	    	$this->page_init();
	       $this->pageTitle = $this->languages['page_not_exist']." - ".$this->configs['shop_title'];
		   $this->flash($this->languages['page_not_exist'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/",3);
     	 
     }
    
     //$categories = $this->requestAction('commons/get_categories_tree/');
     function get_categories_tree($type='P',$category_id = 0){//Shogun:增加参数 $type,'P'->列出商品分类树；'A'->列出文章分类树
         $this->Category->set_locale($this->locale);
         $categories = $this->Category->tree($type,$category_id,$this->locale);
         return $categories;
     }
     
     function get_order(){
		$result =array();
		$result['type'] = 2;
		$result['msg'] = "";
		Configure::write('debug', 0);
		if($this->RequestHandler->isPost()){
     		$order_info = $this->Order->findbyorder_code($_POST['order_code']);
     		if(isset($order_info['Order'])){
				$result['type'] = 0;
		        $this->SystemResource->set_locale($this->locale);
		        $systemresource_info = $this->SystemResource->resource_formated(true,$this->locale);
		        $result['order_code'] = $_POST['order_code'];
		        $result['order_code_i18n'] = $this->languages['order_code'];
		        $result['status_i18n'] = $this->languages['order'].$this->languages['status'];
		        $result['status'] = $systemresource_info['order_status'][$order_info['Order']['status']]." ".$systemresource_info['payment_status'][$order_info['Order']['payment_status']]." ".$systemresource_info['shipping_status'][$order_info['Order']['shipping_status']];
     		}else{
				$result['type'] = 1;
				$result['msg'] = $this->languages['void'].$this->languages['order_code'];
     		}
				die(json_encode($result));				
     	}
     }

//高级搜索带有缩进级别的分类列表结束
     function get_articls(){
         $this->Article->set_locale($this->locale);
         $articls = $this->Article->getlist();
         return $articls;
     }
     
     function change_theme(){
		$result =array();
		$result['type'] = 2;
		$result['msg'] = "";
		//Configure::write('debug', 0);
		if($this->RequestHandler->isPost()){
			if(isset($_POST['no_ajax'])){
				$arr = explode('_|_',$_POST['select_theme']);
		        $_SESSION['template_style'] = $arr['1'];
		        $_SESSION['template_use'] = $arr['0'];
		       	$this->Cookie->write('template_style',$arr['1']);
				$this->Cookie->write('template',$arr['0']);
				$url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:$this->server_host.$this->cart_webroot;
				header('Location:'.$url);exit;
			}else{
				$result['type'] = 1;
		        $_SESSION['template_style'] = $_POST['style'];
		        $_SESSION['template_use'] = $_POST['theme'];
		       	$this->Cookie->write('template_style',$_POST['style']);
				$this->Cookie->write('template',$_POST['theme']);
				die(json_encode($result));
			}
     	}elseif(isset($_GET['themes']) || isset($_GET['theme_style'])){
     		if(isset($_GET['themes'])){
     			$_SESSION['template_use'] = $_GET['themes'];
				$this->Cookie->write('template',$_GET['themes']);
     		}
     		if(isset($_GET['theme_style'])){
     			$_SESSION['template_style'] = $_GET['theme_style'];
				$this->Cookie->write('template_style',$_GET['theme_style']);
     		}
			header('Location:'.$this->server_host.$this->cart_webroot);exit;
     	}
			header('Location:'.$this->server_host.$this->cart_webroot);exit;
     }
     
     function currencie(){
		$result =array();
		$result['type'] = 2;
		$result['msg'] = "";
		Configure::write('debug', 0);
		if($this->RequestHandler->isPost()){
			$result['type'] = 1;
	        $_SESSION['currencies'] = $_POST['code'];
			$this->currencie = $_POST['code'];
	       	$this->Cookie->write('currencies',$_POST['code']);
			$this->Cookie->write('currencies',$_POST['code']);    
			
			if(isset($_SESSION['svcart']['payment']['payment_id']) && $_SESSION['svcart']['payment']['code'] == "account_pay"){
					$this->Payment->set_locale($this->locale);
					$pay = $this->Payment->findbyid($_SESSION['svcart']['payment']['payment_id']);
						eval($pay['Payment']['config']);
						if(@isset($payment_arr['currency_code']['value']) && $payment_arr['currency_code']['value'] == $this->currencie){
							$pay_can_use = 1;
						}else{
							unset($_SESSION['svcart']['payment']);
						}					
			}			
			
			die(json_encode($result));				
     	}     
     }
     
     
     
    function locale($locale="chi",$is_ajax = 0) {
        $result = NULL;
        $default_locale="chi";
       if(isset($_POST['select_locale'])){
     	  $locale = $_POST['select_locale'];
       }
        $languages=$this->Language->findall("Language.front <> '0' ");
        
        if(is_array($languages) && sizeof($languages)>0 ){
            $has=false;
            foreach($languages as $language){
                if($language['Language']['front'] == '2'){
                    $default_locale=$language['Language']['locale'];
                }
                if($language['Language']['locale'] == $locale){
                    $has = true;
                }
                
            }
            
            if(!$has) {
                $locale=$default_locale;
                $result->error = 1;
                $result->message = __("No Language!",true);
            }else{
                $result->error = 0;
            }
            
			$this->Config->set_locale($locale);
			$this->configs = $this->Config->getformatcode($locale); 
			$this->languages = $this->LanguageDictionary->getformatcode($locale);
		    $this->set('SVConfigs',$this->configs);$this->set('SCLanguages',$this->languages);
			$this->Cookie->write('locale',$locale);
			$_SESSION['Config']['locale'] = $locale;
			$_SESSION['Config']['language'] = $locale;			
			$this->Session->write('Config.locale',$locale);
			$this->Session->write('Config.language',$locale);				    
		    $this->locale = $locale;
    //      pr($_COOKIE);
        /* 切换语言后更改SESSION中 商品的属性 */
				$this->Product->set_locale($locale);
	        	if(isset($_SESSION['cookie_product']) && sizeof($_SESSION['cookie_product']) > 0){
	        		foreach($_SESSION['cookie_product'] as $k=>$v){
					$product_i18n = $this->Product->findbyid($v['Product']['id']);
	        			
		     		 $_SESSION['cookie_product'][$k] = array('Product'=>array(
		     		 											 'id'=>$product_i18n['Product']['id'],
		     		 											'img_thumb'=>$product_i18n['Product']['img_thumb'],
		     		 											'code'=>$product_i18n['Product']['code'],
		     		 											'shop_price'=>$product_i18n['Product']['shop_price']
		     		 											),'ProductI18n'=>array('sub_name'=>$this->Product->sub_str($product_i18n['ProductI18n']['name'],6),
		     		 																	'name' => $product_i18n['ProductI18n']['name']
		     		 																	));
	        		}
	        	}
				if(isset($_SESSION['svcart']['products'])){
					foreach($_SESSION['svcart']['products'] as $product){
						$attributes = isset($product['attributes'])?$product['attributes']:'';
						$quantity = $product['quantity'];
	                    $is_promotion = isset($product['is_promotion'])?$product['is_promotion']:'';
	                    $market_subtotal = $product['market_subtotal'];
	                    $subtotal = $product['subtotal'];
	                    $discount_price = $product['discount_price'];
	                    $discount_rate = $product['discount_rate'];	                    
						$product_i18n = $this->Product->findbyid($product['Product']['id']);
						if(isset($product['Product']['attributes'])  && sizeof($product['Product']['attributes'])>0){
							$p_id = $product['Product']['id'];
						//	$product_i18n['ProductI18n']['name'] .=" (";
							foreach($product['Product']['attributes'] as $k=>$v){
								$p_id .= ".".$k;
						//		$product_i18n['ProductI18n']['name'] .= $v." ";
							}
						//	$product_i18n['ProductI18n']['name'] .=" )";
							$_SESSION['svcart']['products'][$p_id] = $product_i18n;
	                    	$_SESSION['svcart']['products'][$p_id]['Product']['attributes'] = $product['Product']['attributes'];
						}else{
							$p_id = $product['Product']['id'];
							$_SESSION['svcart']['products'][$p_id] = $product_i18n;
						}
						$_SESSION['svcart']['products'][$p_id]['attributes'] = $attributes;
						$_SESSION['svcart']['products'][$p_id]['quantity'] = $quantity;
	                    $_SESSION['svcart']['products'][$p_id]['is_promotion'] = $is_promotion;
	                    $_SESSION['svcart']['products'][$p_id]['market_subtotal'] = $market_subtotal;
	                    $_SESSION['svcart']['products'][$p_id]['subtotal'] = $subtotal;
	                    $_SESSION['svcart']['products'][$p_id]['discount_price'] = $discount_price;
	                    $_SESSION['svcart']['products'][$p_id]['discount_rate'] = $discount_rate;
					}
				}
				if(isset($_SESSION['svcart']['packagings'])){
					$this->Packaging->set_locale($locale);
					foreach($_SESSION['svcart']['packagings'] as $packaging){
						$quantity = $packaging['quantity'];
	                    $subtotal = $packaging['subtotal'];
	                    $is_promotion = $packaging['is_promotion'];
						$packaging_i18n = $this->Packaging->findbyid($packaging['Packaging']['id']);
						$_SESSION['svcart']['packagings'][$packaging['Packaging']['id']] = $packaging_i18n;
						$_SESSION['svcart']['packagings'][$packaging['Packaging']['id']]['subtotal'] = $subtotal;
	                    $_SESSION['svcart']['packagings'][$packaging['Packaging']['id']]['quantity'] = $quantity;
	                    $_SESSION['svcart']['packagings'][$packaging['Packaging']['id']]['is_promotion'] = $is_promotion;
					}
				}
				if(isset($_SESSION['svcart']['cards'])){
					$this->Card->set_locale($locale);
					foreach($_SESSION['svcart']['cards'] as $card){
						$quantity = $card['quantity'];
	                    $subtotal = $card['subtotal'];
	                    $is_promotion = $card['is_promotion'];
						$card_i18n = $this->Card->findbyid($card['Card']['id']);
						$_SESSION['svcart']['cards'][$card['Card']['id']] = $card_i18n;
						$_SESSION['svcart']['cards'][$card['Card']['id']]['subtotal'] = $subtotal;
	                    $_SESSION['svcart']['cards'][$card['Card']['id']]['quantity'] = $quantity;
	                    $_SESSION['svcart']['cards'][$card['Card']['id']]['is_promotion'] = $is_promotion;
					}
        		}
        
        }
        else{
            
            $result->error = 1;
            $result->message = __("No Data!",true);
        }
        if($is_ajax == 0){
      		$this->page_init();
			$this->pageTitle = $this->languages['operation'].$this->languages['successfully']." - ".$this->configs['shop_title'];
			$this->flash($this->languages['operation'].$this->languages['successfully'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'','');					
        }else{
        	$this->set('Result',json_encode($result));
        	$this->layout = 'ajax';
        }
    }

//添加评论
    function add_comment(){
     //$cmt=$_REQUEST['cmt'];
    $coments=array(
        'type'=>    isset($_POST['type'])   ? trim($_POST['type'])  : '',
        'type_id'=>    isset($_POST['id'])   ? intval($_POST['id'])  : 0,
        'email'=>    isset($_POST['email'])   ? trim($_POST['email'])  : '',
        'status'=>  isset($this->configs['comment_check'])?$this->configs['comment_check']:0,//评论是否要审核
        'content'=> isset($_POST['content'])   ? trim($_POST['content'])  : '',
        'user_id'=> isset($_POST['user_id'])   ? intval($_POST['user_id'])  : 0,
        'name'=> isset($_POST['username'])   ? trim($_POST['username'])  : '',
        'rank'=> isset($_POST['rank'])   ? intval($_POST['rank'])  : 0,        
        'ipaddr'=>$this->real_ip()
        );
    if($this->Comment->save(array('Comment'=>$coments))){
        $message=array(
        'msg'=>'评论添加成功',
        'url'=>''
        );
        }else{
        $message=array(
        'msg'=>'评论添加失败',
        'url'=>''
        );
        }
    $this->set('result',$message);
       $this->layout="ajax";
}

    /**
 * 获得用户的真实IP地址
 *
 * @access  public
 * @return  string
 */
function real_ip()
{
    static $realip = NULL;

    if ($realip !== NULL)
    {
        return $realip;
    }

    if (isset($_SERVER))
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

            /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
            foreach ($arr AS $ip)
            {
                $ip = trim($ip);

                if ($ip != 'unknown')
                {
                    $realip = $ip;

                    break;
                }
            }
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']))
        {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else
        {
            if (isset($_SERVER['REMOTE_ADDR']))
            {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
            else
            {
                $realip = '0.0.0.0';
            }
        }
    }
    else
    {
        if (getenv('HTTP_X_FORWARDED_FOR'))
        {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_CLIENT_IP'))
        {
            $realip = getenv('HTTP_CLIENT_IP');
        }
        else
        {
            $realip = getenv('REMOTE_ADDR');
        }
    }

    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

    return $realip;
}    
//搜索函数
 function search($type,$keywords='',$category_id='',$brand_id='',$min_price='',$max_price=''){
 	 
 	// pr($keywords);
     // $condition=" 1=1 and Product.status = 1";
	  $condition['AND'][]= "Product.status = '1'";
    if($category_id !=''&& $category_id != 0){
      //$condition .=" and ProductsCategory.category_id =$category_id";
     // 	$condition['AND'][]= "ProductsCategory.category_id =$category_id";
     $arr = $this->ProductsCategory->findall('ProductsCategory.category_id ='.$category_id ,'DISTINCT ProductsCategory.product_id');
     if(is_array($arr) && sizeof($arr)>0){
     	foreach($arr as $v ){
     		$con = " Product.id = ".$v['ProductsCategory']['product_id'];
     		if($min_price != '' && $min_price >0 ){
     			$con .= " and Product.shop_price >= ".$min_price;
     		}
     	    if($max_price !=''&& $max_price < 99999999){
      	 	  	$con .= " and Product.shop_price <= ".$max_price;
   		    }
		    if($brand_id !='' && $brand_id != 0){
		       	$con .=" and Product.brand_id =$brand_id";
		    }   		    
     		$p = $this->Product->find($con);
     		if(isset($p['Product'])){
     			$category_product_ids[] = $v['ProductsCategory']['product_id'];
     		}
     	}
     }
    // pr($arr);exit;
    }//ProductsCategory
    if($brand_id !='' && $brand_id != 0){
      //$condition .=" and Product.brand_id =$brand_id";
      	  $condition['AND'][]= "Product.brand_id =$brand_id";
    }
    if($category_id !=''&& $category_id != 0){
      	  $condition['AND'][]= "Product.category_id =$category_id";
    }
   if($min_price !=''&& $min_price > 0){
     // $condition .=" and Product.shop_price >= ".$min_price;
      	  $condition['AND'][]= "Product.shop_price >= ".$min_price;
    }
   if($max_price !=''&& $max_price < 99999999){
      //$condition .=" and Product.shop_price <= ".$max_price;
      	  $condition['AND'][]= "Product.shop_price <= ".$max_price;
    }
    if($keywords == $this->languages['all'].$this->languages['products']){
     }else{
        if($keywords != '0' && $keywords != 'all_products'){
      		//$condition .=" and Product.code like '%$keywords%' or ProductI18n.name like '%$keywords%' or ProductI18n.description like '%$keywords%' ";
				$condition['OR'][0] = "Product.code like '%$keywords%' ";
				$condition['OR'][1] = "ProductI18n.name like '%$keywords%' ";
				$condition['OR'][2] = "ProductI18n.description like '%$keywords%' ";
    	}
     }
     //pr($condition);exit;            	
     $pid_arrays = array();;
	
	if(isset($this->configs['use_tag']) && $this->configs['use_tag'] == 1){
		$tag_filter = " TagI18n.locale = '".$this->locale."' and TagI18n.name = '".$keywords."' and Tag.type = 'P'";
		$tags = $this->Tag->findall($tag_filter);
		if(is_array($tags) && sizeof($tags)>0){
			foreach($tags  as $k=>$v){
				$category_product_ids[] = $v['Tag']['type_id'];
			}
		}
	}
    $Pids=$this->Product->findall($condition,'DISTINCT Product.id');
        if(is_array($Pids) && count($Pids)>0){
            foreach($Pids as $v ){
                $pid_array[]=$v['Product']['id'];
            }
            if(isset($category_product_ids) && sizeof($category_product_ids)>0){
	            foreach($category_product_ids as $k){
	            	if(!in_array($k,$pid_array)){
	            		$pid_array[] = $k;
	            	}
	            }
					$pid_arrays = $pid_array;
            }else{
            	if(isset($category_id) && $category_id > 0){
            		//$pid_arrays = 'null';
					$pid_arrays = $pid_array;
            	}else{
            		$pid_arrays = $pid_array;
            	}
            }
        }else{
        	if(is_array($category_product_ids) && sizeof($category_product_ids)>0){
        	foreach($category_product_ids as $k=>$v){
        		$ids_arr[] =array();
        		if(!in_array($v,$ids_arr)){
        			$ids_arr[] = $v;
        		}
        	}
        	$pid_arrays = $ids_arr;
        	
        	}else{
            $pid_arrays = 'null';
            }
        }
   
  return $pid_arrays;
 }
 
 	function select_template(){
		$a=$_REQUEST['template'];
		die($a);
	}
 
     function index($orderby="orderby",$rownum=''){
         //取商店设置文章列表数量
           if(isset($this->configs['products_list_num'])){
                 $rownum=$this->configs['products_list_num'];
           }
           elseif(!empty($rownum)){
                 $rownum=$rownum;
           }
           else{
                 $rownum=1;
           }
           //取商店设置文章排序
           if(isset($this->configs['products_list_orderby'])){
                 $orderby=$this->configs['products_list_orderby'];
           }
           elseif(!empty($orderby)){
                 $orderby=$orderby;
           }
           else{
                 $orderby='created';
           }
           
         //用户评论
        $comment_list = $this->Comment->get_list('A','');
        //pr($comment_list);
        $reply_info=array();
        //获取评论回复信息
        $sortClass='Product';
        $total = count($comment_list);
        $page=1;
        $parameters=Array($orderby,$rownum,$page);
        $options=Array();
        $conditions="status ='1'";
        $conditions.= " AND type = 'A'";
        list($page) = $this->Pagination->init($conditions,$parameters,$options,$total,$rownum,$sortClass); // Added
        $comment_list=$this->Comment->findAll($conditions,''," Comment.modified asc ","$rownum",$page);
        foreach($comment_list as $key=>$v){
            if($v['Comment']['parent_id']!=0){
                $reply_info[$v['Comment']['parent_id']][]=$v;
                unset($comment_list[$key]);
            }
        }
        foreach($comment_list as $key=>$v){
            $comment_list[$key]['reply']=@$reply_info[$v['Comment']['id']];
        }

        $ur_heres=array();
        $ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
        $ur_heres[]=array('name'=>$this->languages['article_home_page'],'url'=>"/articles/1");
        $ur_heres[]=array('name'=>$this->languages['latest_comments'],'url'=>"/commons/");
        $brands = array();
        $this->set('comment_list',$comment_list);
        $this->set('brands',$brands);  //空;
        $this->set('languages',$this->locale);
        $this->Category->set_locale($this->locale);
        $navigate=$this->Category->tree('A',0,$this->locale);
        $cat_navigate = $navigate['assoc'];
        krsort($cat_navigate);     
        $this->set('categories_tree',$navigate['tree']);
        $this->set('category_type','A'); //判断是文章
        $this->set('locations',$ur_heres);
      //排序方式,显示方式,分页数量限制
         $this->set('orderby',$orderby);
        $this->set('rownum',$rownum);
        $this->set('total',$total);
     
    }
    
    function add_tag(){
		if($this->RequestHandler->isPost()){
			$result['type'] = 2;
			$result['msg'] = "";
			if(isset($_SESSION['User']['User'])){
				if(trim($_POST['tag'] == "")){
					$result['type'] = 1;
					$result['msg']= $this->languages['tags'].$this->languages['apellation'].$this->languages['can_not_empty'];					
				}else{
					$tag = array(
								'id' =>'',
								'type_id'=>$_POST['type_id'],
								'type' => $_POST['type'],
								'user_id' => $_SESSION['User']['User']['id'],
								'status'=> 1
								);
					$this->Tag->save($tag);
					$id=$this->Tag->id;
					$tag_i18n = array(
									'id' => '',
									'locale'=>$this->locale,
									'tag_id'=>$id,
									'name' => $_POST['tag']
					);
					$this->TagI18n->save($tag_i18n);
					$result['type'] = 0;
					$result['msg'] = $this->languages['add'].$this->languages['tags'].$this->languages['successfully'];
					$result['tag_type'] = $_POST['type'];
					
					$this->Tag->set_locale($this->locale);
			    	$tags = $this->Tag->findall("Tag.status ='1' and Tag.type_id =".$_POST['type_id']." and Tag.type = '".$_POST['type']."'");					
					$this->set('tags',$tags);
					
				}
			}else{
				$result['type'] = 1;
				$result['msg']=$this->languages['time_out_relogin'];
			}
			
			if(!isset($_POST['is_ajax'])){
				$this->page_init();
				$this->pageTitle = isset($result['msg'])?$result['msg']:''." - ".$this->configs['shop_title'];
				$this->flash(isset($result['msg'])?$result['msg']:'',isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'','');					
			}
			
			$this->set('result',$result);
		}
    }
	
	function get_cat_products(){
		$this->Category->set_locale($this->locale);
		$this->Product->set_locale($this->locale);
		$home_category = $this->Category->home_category($this->locale);
	//	$home_category = array_slice($home_category,'0','2');
	//  pr($home_category);
		$home_category_ids = array();
		$home_category_names = array();
		if(isset($home_category) && sizeof($home_category) > 0){
			foreach($home_category as $k=>$v){
				$home_category_ids[] = $v['Category']['id'];
				$home_category_names[$v['Category']['id']]['category_id'] = $v['Category']['id'];
				$home_category_names[$v['Category']['id']]['category_name'] = $v['CategoryI18n']['name'];
			}
		}
		$products = $this->Product->home_category_products($home_category_ids,$this->locale,$this->configs['promotion_count']);
		foreach($home_category_names as $k=>$v){
			if(isset($products[$k])){
				$home_category_names[$k]['products'] =array_slice($products[$k],'0',$this->configs['promotion_count']);;
			}
		}
		return $home_category_names;
		//$this->set('home_category_products',$products);
		//$this->set('home_category_names',$home_category_names);
	}
	function header_cart(){
		if(isset($_SESSION['svcart']['products']) && sizeof($_SESSION['svcart']['products'])>0){
			$cart['quantity'] =0;
			$cart['total']=0;
			foreach($_SESSION['svcart']['products'] as $k=>$v){
				$cart['quantity'] += $v['quantity'];
				$cart['total'] += $v['subtotal'];
			}
			return $cart;
		}	
	}
	
		function add_message(){
			Configure::write('debug', 0);
			if($this->RequestHandler->isPost()){
				$message = array(
								'id'=>'',
								'user_id'=> isset($_SESSION['User']['User']['id'])?$_SESSION['User']['User']['id']:'',
								'user_name'=>isset($_SESSION['User']['User']['name'])?$_SESSION['User']['User']['name']:'',
								'msg_title'=>$_POST['title'],
								'msg_type'=>2,
								'value_id'=>$_POST['value_id'],
								'type'=>'P',
								'msg_content'=>$_POST['content'],
								'status'=> 0
								);
				$result['msg'] = $this->languages['message'].$this->languages['successfully']." ".$this->languages['waiting_reply'];
				$this->UserMessage->save($message); 
				die(json_encode($result));
			}
		}
		
	function commend_friend(){
		$result = array();
		if($this->RequestHandler->isPost()){				
				$this->Product->set_locale($this->locale);
				$product_info = $this->Product->findbyid($_POST['product_id']);
				$product_desc ="";
                $product_desc.= $this->languages['products'].$this->languages['names']."：".$product_info['ProductI18n']['name']."<br />";
                $product_desc.= $this->languages['sku']."：".$product_info['Product']['code']."<br />";
                $product_desc.= $this->languages['our_price']."：".$product_info['Product']['shop_price']." <br />";
				
				$url = $this->server_host.$this->cart_webroot."/products/".$_POST['product_id'];
				$user_name = $_POST['username'];
				$shop_url = $this->server_host.$this->cart_webroot;
				$shop_name=$this->configs['shop_name'];
				$send_date=date('Y-m-d');
		 		$this->MailTemplate->set_locale($this->locale);
  	            $template=$this->MailTemplate->find("code = 'commend_friend' ");
  	            $template_str=$template['MailTemplateI18n']['html_body'];
  	            eval("\$template_str = \"$template_str\";");
		        $text_body = $template['MailTemplateI18n']['text_body'];
		     	eval("\$text_body = \"$text_body\";");
				$subject = $template['MailTemplateI18n']['title'];
				eval("\$subject = \"$subject\";");
				$mailsendqueue = array(
					"sender_name"=>$shop_name,//发送从姓名
					"receiver_email"=>";".$to_email,//接收人姓名;接收人地址
				 	"cc_email"=>";",//抄送人
				 	"bcc_email"=>";",//暗送人
				  	"title"=>$subject,//主题 
				   	"html_body"=>$template_str,//内容
				  	"text_body"=>$text_body,//内容
				 	"sendas"=>"html"
				);
				$this->Email->send_mail($this->locale,$this->configs['email_the_way'], $mailsendqueue);
				if(@$this->Email->send_mail($this->locale,$this->configs['email_the_way'], $mailsendqueue)){
			      $result['type'] = 0;
			      $result['msg'] = $this->languages['send_mail'].$this->languages['successfully'];
			    }else{
			      $result['type'] = 1;
			      $result['msg'] = $this->languages['send_mail'].$this->languages['failed'];
			    }
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function upfile(){
		$this->page_init();
		$this->pageTitle = $this->languages['upload'].$this->languages['my_photos']." - ".$this->configs['shop_title'];
			if($this->RequestHandler->isPost()){	
					$orders = $this->Order->findallbyuser_id($_SESSION['User']['User']['id']);
					$is_upfile = 0;
					foreach($orders as $k=>$v){
						foreach($v['order_products'] as $kk=>$vv){
							if($vv['product_id'] == $_POST['product_id']){
								$is_upfile = 1;
							}
						}
					}			
			
			
				if($is_upfile == 0){
					$this->flash($this->languages['users_purchased_upload_photos'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'','');
				}else{
					$img_dir =  dirname(dirname(dirname(dirname(__FILE__))));
					$img_dir .= "\\img\\products\\".$_POST['product_code']."\\";
					$type = explode('/',$_FILES['photo']['type']);
					if(isset($type[0]) && $type[0] == "image"){
						$name_s = explode('.',$_FILES['photo']['name']);
						$exe = isset($name_s[1])?$name_s[1]:'';
						$target_path = time(); 
						copy($_FILES['photo']['tmp_name'], $img_dir.$target_path.".".$exe); 
						if(file_exists($img_dir.$target_path.".".$exe)) { 
							$img_arr = array('id'=>'','user_id'=>$_SESSION['User']['User']['id'],'product_id'=>$_POST['product_id'],'status'=>0,'img'=>"/img/products/".$_POST['product_code']."/".$target_path.".".$exe);
							$this->UserProductGallerie->save($img_arr);
							$this->flash($this->languages['upload'].$this->languages['successfully'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'','');
						} else { 
							$this->flash($this->languages['upload'].$this->languages['failed'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'','');
						}  		
					}else{
						$this->flash($this->languages['upload_pictures_only'],isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'','');
					}
				}
		}
	}
	
	function can_updata_photo(){
		Configure::write('debug', 0);
		$result = array();
		$result['type'] = 1;
		$result['msg'] = $this->languages['not_buy_product_not_upload'];
		if($this->RequestHandler->isPost()){
			if(isset($_SESSION['User']['User']['id'])){
				$order_p = $this->OrderProduct->find('list',array('conditions'=>array('OrderProduct.product_id'=>$_POST['id']),'fields'=>array('OrderProduct.order_id')));
				if(isset($order_p) && sizeof($order_p)>0){
					$order_i = $this->Order->find('all',array('conditions'=>array('Order.id'=>$order_p,'Order.user_id'=>$_SESSION['User']['User']['id'])));
					if(isset($order_i) && sizeof($order_i)>0){
						$result['type'] = 0;
					}					
				}
			}
		}
		die(json_encode($result));
	}
	
	function save_value_pu($pid,$id){
			$is_user = $this->User->findbyid($id);
			if(isset($is_user['User'])){
				if( $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "hour"){
					$save_time = $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60;
				}
				if( $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "day"){
					$save_time = $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60*24;
				}
				if( $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "week"){
					$save_time = $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60*24*7;
				}				
				$this->Cookie->write('affiliate_user_id',$id,false,time()+$save_time);
				$this->Cookie->write('affiliate_product_id',$pid,false,time()+$save_time);			
			}
			header("Location:".$this->server_host.$this->cart_webroot."products/".$pid);exit;		
	}
	
	function save_value_u($id){
		$is_user = $this->User->findbyid($id);
		if(isset($is_user['User'])){
			if( $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "hour"){
				$save_time = $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60;
			}
			if( $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "day"){
				$save_time = $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60*24;
			}
			if( $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire_unit'] == "week"){
				$save_time = $this->affiliate_config['ConfigI18n'][$this->locale]['value']['config']['expire']*60*60*24*7;
			}				
			$this->Cookie->write('affiliate_uid',$id,false,time()+$save_time);
		}
		header("Location:".$this->server_host.$this->cart_webroot);	exit;
	}
	
	function save_get_source($id){
		$plugin_union = $this->Plugin->find_union();
		if(isset($plugin_union['Plugin'])){ 
			$this->requestAction($plugin_union['Plugin']['function'].$id);
		}
		header("Location:".$this->server_host.$this->cart_webroot);exit;		
	}
	
	/*
	function save_get_value($id = 0){
		if(isset($_GET['pu'])){
		}elseif(isset($_GET['u'])){
		}elseif(isset($_GET['source'])){
		}
		header("Location:".$this->server_host.$this->cart_webroot);exit;
	}*/	

}
?>