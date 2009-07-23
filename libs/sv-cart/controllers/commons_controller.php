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
 * $Id: commons_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/

class CommonsController extends AppController {
    var $name = 'Commons';
    var $components = array ('Pagination','RequestHandler','Session','Cookie'); // Added
    var $helpers = array('Pagination'); // Added
    var $uses = array('Language','SystemResource','Navigation','Category','UserMessage','Brand','Article','Comment','Config','Product','Card','Packaging','ProductsCategory','Tag','TagI18n','LanguageDictionary','Order');
    //$languages = $this->requestAction('commons/get_languages_front/');
     function get_languages_front(){
         $languages = $this->Language->findall("Language.front <> '0' ");
        return $languages;
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
				if(isset($_SESSION['svcart']['products'])){
					$this->Product->set_locale($locale);
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
		//pr($home_category);
		$home_category_ids = array();
		$home_category_names = array();
		if(isset($home_category) && sizeof($home_category) > 0){
			foreach($home_category as $k=>$v){
				$home_category_ids[] = $v['Category']['id'];
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
				$result['msg'] = $this->languages['add'].$this->languages['successfully']." ".$this->languages['waitting_for_check'];
				$this->UserMessage->save($message); 
				die(json_encode($result));
			}
		}
	
}
?>