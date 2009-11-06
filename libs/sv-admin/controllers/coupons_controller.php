<?php
/*****************************************************************************
 * SV-Cart 优惠券管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: coupons_controller.php 4930 2009-10-12 10:24:42Z huangbo $
*****************************************************************************/
class CouponsController extends AppController {
	var $name = 'Coupons';
    var $components = array ('Pagination','RequestHandler','Email');
    var $helpers = array('Pagination','Html','Javascript'); 
	var $uses = array('SystemResource','MailSendQueue','CouponType','CouponTypeI18n','Coupon','Category','Brand','User','Product','MailTemplate','UserRank');

	function index(){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		/*判断权限*/
		$this->operator_privilege('coupon_view');
		/*end*/
		$this->pageTitle = '优惠券'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'促销栏目','url'=>'');
		$this->navigations[] = array('name'=>'优惠券','url'=>'/coupons/');
		$this->set('navigations',$this->navigations);
		$condition1 = '';
		$condition  = '1=1';
		if(!empty($_REQUEST["send_type"]) || @$_REQUEST["send_type"] == "0"){
			$condition1["CouponType.send_type"] = $_REQUEST["send_type"];
			$this->set('send_type',$_REQUEST["send_type"]);
		}
		if(!empty($_REQUEST["cname"])){
			$condition1["CouponTypeI18n.name like"] = "%".$_REQUEST["cname"]."%";
			$this->set('cname',$_REQUEST["cname"]);
		}
		$this->CouponType->set_locale($this->locale);
		
		$page = 1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);		
		$options = array();
   	    $total = count($this->CouponType->find("all",array("conditions"=>$condition1,"fields"=>"DISTINCT CouponType.id")));

		$sortClass = 'CouponType';
		$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		//取得优惠券列表
		$data = $this->CouponType->find("all",array("conditions"=>$condition1,"order"=>"CouponType.send_start_date,CouponType.use_start_date","page"=>$page,"limlt"=>$rownum));
     
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
		foreach($data as $k=>$v){
			$v['CouponType']['send_type_name'] = $systemresource_info["coupontype"][$v['CouponType']['send_type']];

			if($v['CouponType']['send_type'] == 5){
				$v['CouponType']['count_coupon'] = 0;
				$v['CouponType']['max_use'] = 0;
				$count_coupons =  $this->Coupon->findall('Coupon.coupon_type_id ='.$v['CouponType']['id']);
				if(is_array($count_coupons) && sizeof($count_coupons)>0){
					foreach($count_coupons as $kk=>$vv){
						$v['CouponType']['count_coupon'] += $vv['Coupon']['max_use_quantity'];
						$v['CouponType']['max_use'] += $vv['Coupon']['max_buy_quantity'];
					}
				}
			}
			
			
			$data[$k] = $v;
		}
		//$sent_coupons = $this->Coupon->find('list', array('fields'=>array('Coupon.coupon_type_id', 'count(Coupon.id)'),'group' => array('Coupon.coupon_type_id')));
		//查找已发放的优惠券数量
		$data2 = $this->Coupon->find('all',array(
												'conditions' => $condition, 
												'fields' => array('Coupon.coupon_type_id'), 
												'group' => array('Coupon.coupon_type_id')
											));
		
		$count_coupon = $this->Coupon->find("all",array("conditions"=>$condition,"fields"=>array("Coupon.id","Coupon.coupon_type_id")));
		$count_coupon_list = array();
		if(isset($count_coupon) && sizeof($count_coupon)>0){
			foreach($count_coupon as $k=>$v){
				$count_coupon_list[$v['Coupon']['coupon_type_id']][] = $v;
			}
		}
		
		
		$sent_coupons = array();
		foreach($data2 as $v){
			if(!empty($v['Coupon'])){
				$sent_coupons[$v['Coupon']['coupon_type_id']]['count_coupon'] = isset($count_coupon_list[$v['Coupon']['coupon_type_id']])?count($count_coupon_list[$v['Coupon']['coupon_type_id']]):0;
			}
		}
		//查找已使用的优惠券数量
		$condition2 = $condition." and Coupon.used_time > '2008-02-02'";
		$count_coupon = $this->Coupon->find("all",array("conditions"=>$condition,"fields"=>array("Coupon.id","Coupon.coupon_type_id")));
		$count_coupon_list = array();
		if(isset($count_coupon) && sizeof($count_coupon)>0){
			foreach($count_coupon as $k=>$v){
				$count_coupon_list[$v['Coupon']['coupon_type_id']][] = $v;
			}
		}
		
		$data3 = $this->Coupon->find('all',array(
												'conditions' => $condition2, 
												'fields' => array('Coupon.coupon_type_id'), 
												'group' => array('Coupon.coupon_type_id')
											));
		foreach($data3 as $v){
			if(!empty($v['Coupon']))$sent_coupons[$v['Coupon']['coupon_type_id']]['count_coupon_used'] = isset($count_coupon_list[$v['Coupon']['coupon_type_id']])?count($count_coupon_list[$v['Coupon']['coupon_type_id']]):0;
		}
		$this->set('coupons',$data);
		$this->set('sent_coupons',$sent_coupons);		
		$this->set('systemresource_info',$systemresource_info);		

	}
	
	function view($id){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		/*判断权限*/
		$this->operator_privilege('coupon_operation');
		/*end*/
		$this->pageTitle = '查看电子优惠券'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'促销栏目','url'=>'');
		$this->navigations[] = array('name'=>'优惠券','url'=>'/coupons/');
		$this->navigations[] = array('name'=>'查看电子优惠券','url'=>'');
		$this->set('navigations',$this->navigations);
		$condition["Coupon.coupon_type_id"] = $id;
		$page = 1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);		
		$options = array();
		$total = $this->Coupon->findCount($condition,0);
		$sortClass = 'Coupon';
		$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);	
		$this->CouponType->set_locale($this->locale);
		$coupon_type = $this->CouponType->findbyid($id);
		$coupons = $this->Coupon->findall("Coupon.coupon_type_id =".$id);
		if(is_array($coupons) && sizeof($coupons) > 0){
			foreach($coupons as $k=>$v){
				$user= $this->User->findbyid($v['Coupon']['user_id']);
				$coupons[$k]['Coupon']['user_name'] = $user['User']['name'];
			}
		}
		$this->set('coupons',$coupons);
		$this->set('coupon_type',$coupon_type['CouponType']['send_type']);			
	}
	
	
	function remove($id){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		$pn = $this->CouponTypeI18n->find('list',array('fields' => array('CouponTypeI18n.coupon_type_id','CouponTypeI18n.name'),'conditions'=> 
                                        array('CouponTypeI18n.coupon_type_id'=>$id,'CouponTypeI18n.locale'=>$this->locale)));
        
		$this->CouponType->deleteAll("CouponType.id='$id'");
		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'移除电子优惠券:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/coupons/',10);
	
	}
	function remove_coupon($id){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		$this->Coupon->deleteAll("Coupon.id='$id'");
		$this->flash("删除成功",'/coupons/',10);
	
	}
	
	function edit($id){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		$this->pageTitle = "优惠券 - 优惠券"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'促销栏目','url'=>'');
		$this->navigations[] = array('name'=>'优惠券','url'=>'/coupons/');
		$this->navigations[] = array('name'=>'编辑电子优惠券','url'=>'');
	
		
		if($this->RequestHandler->isPost()){
			$this->data['CouponType']['max_amount'] = !empty($this->data['CouponType']['max_amount'])?$this->data['CouponType']['max_amount']:0;
			$this->data['CouponType']['send_end_date'] = date("Y-m-d",strtotime($this->data['CouponType']['send_end_date']))." 23:59:59";
			$this->data['CouponType']['use_end_date'] = date("Y-m-d",strtotime($this->data['CouponType']['use_end_date']))." 23:59:59";
			//pr($this->data);
			//$this->CouponType->deleteall("id = '".$this->data['CouponType']['id']."'",false);
			//$this->CouponTypeI18n->deleteall("coupon_type_id = '".$this->data['CouponType']['id']."'",false);
			if(empty($this->data['CouponType']['money'])){
				$this->flash("电子优惠券金额 不能为空  编辑失败。点击这里继续编辑电子优惠券。",'/coupons/add/',10,false);
				return false;
			}
			if(empty($this->data['CouponType']['min_amount'])){
				$this->flash("电子优惠券最小订单金额 不能为空  编辑失败。点击这里继续编辑电子优惠券。",'/coupons/add/',10,false);
				return false;
			}			
			foreach($this->data['CouponTypeI18n'] as $v){
              	     	    $couponTypeI18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'coupon_type_id'=> isset($v['coupon_type_id'])?$v['coupon_type_id']:$id,
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                           'description'=>	$v['description']
		                     );
		                     $this->CouponTypeI18n->saveall(array('CouponTypeI18n'=>$couponTypeI18n_info));//更新多语言
            }
			$this->CouponType->save($this->data); //保存
			foreach( $this->data['CouponTypeI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑电子优惠券:'.$userinformation_name ,'operation');
    	    }
			$this->flash("电子优惠券  ".$userinformation_name." 编辑成功。点击这里继续编辑该电子优惠券。",'/coupons/edit/'.$id,10);
		}
		
		$coupontype = $this->CouponType->localeformat( $id );
		$this->set('coupontype',$coupontype);
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$coupontype["CouponTypeI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	
	function add(){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		$this->pageTitle = "优惠券 - 优惠券"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'促销栏目','url'=>'');
		$this->navigations[] = array('name'=>'优惠券','url'=>'/coupons/');
		$this->navigations[] = array('name'=>'编辑电子优惠券','url'=>'');
		$this->set('navigations',$this->navigations);
		
		if($this->RequestHandler->isPost()){
			if(empty($this->data['CouponType']['money'])){
				$this->flash("电子优惠券金额 不能为空  添加失败。点击这里继续添加电子优惠券。",'/coupons/add/',10,false);
				return false;
			}
			if(empty($this->data['CouponType']['min_amount'])){
				$this->flash("电子优惠券最小订单金额 不能为空  添加失败。点击这里继续添加电子优惠券。",'/coupons/add/',10,false);
				return false;
			}

			
			
			if($this->data['CouponType']['min_products_amount'] == ""){
				$this->data['CouponType']['min_products_amount'] = 0;
			}
			$this->data['CouponType']['max_amount'] = !empty($this->data['CouponType']['max_amount'])?$this->data['CouponType']['max_amount']:0;
			$this->data['CouponType']['send_end_date'] = date("Y-m-d",strtotime($this->data['CouponType']['send_end_date']))." 23:59:59";
			$this->data['CouponType']['use_end_date'] = date("Y-m-d",strtotime($this->data['CouponType']['use_end_date']))." 23:59:59";
			$this->CouponType->save($this->data); //保存
			$id=$this->CouponType->id;
			//新增多语言
			   
			   	if(is_array($this->data['CouponTypeI18n']))
			          foreach($this->data['CouponTypeI18n'] as $k => $v){
				            $v['coupon_type_id']=$id;
				            $this->CouponTypeI18n->id='';
				            $this->CouponTypeI18n->save($v); 
			           }
			foreach( $this->data['CouponTypeI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加电子优惠券:'.$userinformation_name ,'operation');
    	    }
			$this->flash("电子优惠券  ".$userinformation_name." 添加成功。点击这里继续编辑该电子优惠券。",'/coupons/edit/'.$id,10);
		}
	}
	
	
	function send($id){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		$this->pageTitle = "优惠券 - 电子优惠券发放"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'促销栏目','url'=>'');
		$this->navigations[] = array('name'=>'优惠券','url'=>'/coupons/');
		$this->navigations[] = array('name'=>'电子优惠券发放','url'=>'');
		$this->set('navigations',$this->navigations);
        		
		$this->CouponType->set_locale($this->locale);
		$coupontype = $this->CouponType->findbyid($id);
		if($coupontype['CouponType']['send_type'] == 0){
			$this->UserRank->set_locale($this->locale);
			$user_ranks = $this->UserRank->findall();
			$this->set('user_ranks',$user_ranks);
		}
		
		if($coupontype['CouponType']['send_type'] == 1){
			$this->Category->set_locale($this->locale);
	        $categories_tree=$this->Category->tree('P',$this->locale);
	   		$this->Brand->set_locale($this->locale);
	        $brands_tree=$this->Brand->getbrandformat();
			$this->Product->set_locale($this->locale);
	     // $product_arr = $this->Product->findall("'Product.coupon_type_id ='".$id."'");
	       	$product_arr = $this->Product->find('all',array('conditions'=>array('Product.coupon_type_id'=>$id)));
	       // pr($product_arr);
			$this->set('product_relations',$product_arr);
			$this->set('categories_tree',$categories_tree);
			$this->set('brands_tree',$brands_tree);			
		}

		if($coupontype['CouponType']['send_type'] == 2){
			
		}
	
		if($coupontype['CouponType']['send_type'] == 5){
			
		}

		$this->set('coupontype',$coupontype);
	}
	
	function searchusers($keywords="0"){
		$condition="";
		if($keywords != "0"){
			$condition["User.name like"]="%".$keywords."%";
		}
		$Pids=$this->User->findall($condition,'DISTINCT User.id');
		$pid_array=array();
		if(is_array($Pids)){
			foreach($Pids as $v ){
				$pid_array[]=$v['User']['id'];
			}
		}
		$condition = array("User.id"=>$pid_array);
		$users=$this->User->findall($condition);
		$this->set('users',$users);
		
		//显示的页面
		Configure::write('debug',0);
		$result['type'] = "0";
		$result['message']=$users;
		die(json_encode($result));
	
	}
	
	function insert_link_users($link_id,$id){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		$this->CouponType->set_locale($this->locale);
		$coupon_info = $this->CouponType->findbyid($id);
		$coupon_arr = $this->Coupon->findall("",'DISTINCT Coupon.sn_code');
		$coupon_count = count($coupon_arr);
		$num = 0;
		if($coupon_count > 0){
			$num = $coupon_arr[$coupon_count - 1]['Coupon']['sn_code'];
		}
		
		if(isset($coupon_sn)){
			$num = $coupon_sn;
		}
		
		$num = substr($num,2, 10);
		$num = $num ? floor($num / 10000) : 100000;
		$coupon_sn = $coupon_info['CouponType']['prefix'].$num.str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
		$coupon = array(
					    'id'=>'',
					    'coupon_type_id' => $coupon_info['CouponType']['id'],
				    	'sn_code' => $coupon_sn,
					    'user_id' => $link_id,
					    );
		$user_info = $this->User->findbyid($link_id);
		$this->Coupon->save($coupon);
		$coupon_id  = $this->Coupon->id;
	//	$this->send_coupon_email($coupon_id);

	
		//页面显示
		Configure::write('debug',0);
        $result['type'] = "0";
        $result['msg'] = $user_info['User'];
        $result['action'] = "drop_link_users";
        $result['coupon_id'] = 	$this->Coupon->id;
        die(json_encode($result));		
		
		
	}
	
	function drop_link_users($id,$user_id){
		$coupon = $this->Coupon->find('Coupon.id = '.$id.' and Coupon.user_id = '.$user_id);
		$this->Coupon->del($coupon);
		Configure::write('debug',0);
        $result['type'] = "0";
        $result['msg'] = $user_id;
        $result['coupon_id'] = $id;
        die(json_encode($result));
	}
	
	function insert_link_products($link_id,$id){
		$this->Product->set_locale($this->locale);
		$product_info['Product']['id'] = $link_id;
		$product_info['Product']['coupon_type_id'] = $id;
		$this->Product->save($product_info);
		$product_info = $this->Product->findbyid($link_id);
		//页面显示
		Configure::write('debug',0);
        $result['type'] = "0";
        $result['msg']['id'] = $link_id;
        $result['msg']['name'] = $product_info['ProductI18n']['name'];
        $result['action'] = "drop_link_products";
        $result['coupon_id'] = $id	;
        die(json_encode($result));
	}
	
	function drop_link_products($id,$product_id){
		$product = array(
						'id' => $product_id,
						'coupon_type_id' => 0
						);
		$this->Product->save($product);
		Configure::write('debug',0);
        $result['type'] = "0";
        $result['msg'] = $product_id;
        $result['coupon_id'] = $id;
        die(json_encode($result));
	}
		
		
	function send_print(){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		$times = $_POST['num'];
		$this->CouponType->set_locale($this->locale);
		$coupon_info = $this->CouponType->findbyid($_POST['coupon_type_id']);
		$coupon_arr = $this->Coupon->findall("",'DISTINCT Coupon.sn_code');
		$coupon_count = count($coupon_arr);
		$num = 0;
		if($coupon_count > 0){
			$num = $coupon_arr[$coupon_count - 1]['Coupon']['sn_code'];
		}
		for($i = 0; $i < $times ; $i++){
			if(isset($coupon_sn)){
				$num = $coupon_sn;
			}
			$num = substr($num,2, 10);
			$num = $num ? floor($num / 10000) : 100000;
		    $coupon_sn = $coupon_info['CouponType']['prefix'].$num . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
		    $coupon = array(
						        'id'=>'',
						        'coupon_type_id' => $coupon_info['CouponType']['id'],
								'sn_code' => $coupon_sn,
						        'user_id' => 0,
						        );
			$this->Coupon->save($coupon);
			}
		$this->flash("发放成功",'/coupons/'.$_POST['coupon_type_id'],10);
	}
	
	function send_coupon(){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		$this->CouponType->set_locale($this->locale);
		$coupon_info = $this->CouponType->findbyid($_POST['coupon_type_id']);
		$coupon_arr = $this->Coupon->findall("",'DISTINCT Coupon.sn_code');
		$coupon_count = count($coupon_arr);
		$num = 0;
		if($coupon_count > 0){
			$num = $coupon_arr[$coupon_count - 1]['Coupon']['sn_code'];
		}
			if(isset($coupon_sn)){
				$num = $coupon_sn;
			}
			$num = substr($num,2, 10);
			$num = $num ? floor($num / 10000) : 100000;
		    $coupon_sn = $coupon_info['CouponType']['prefix'].$num . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
		    $coupon = array(
						        'id'=>'',
						        'coupon_type_id' => $coupon_info['CouponType']['id'],
								'sn_code' => $coupon_sn,
								'max_buy_quantity'=> $_POST['max_buy_quantity'],
								'order_amount_discount'=> $_POST['order_amount_discount'],
						        'user_id' => 0,
						        );
			$this->Coupon->save($coupon);
			if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'发放电子优惠券' ,'operation');
    	    }
		$this->flash("发放成功",'/coupons/'.$_POST['coupon_type_id'],10);		
	}
	
	function send_coupon_email($id){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

			$coupon = $this->Coupon->findbyid($id);
			$user = $this->User->findbyid($coupon['Coupon']['user_id']);
			$user_name = $user['User']['name'];//template
			
			$this->CouponType->set_locale($this->locale);
			$coupon_type = $this->CouponType->findbyid($coupon['Coupon']['coupon_type_id']);
			$money = $coupon_type['CouponType']['money'];//template
			$shop_name=$this->configs['shop_name'];//template
			$shop_url=$this->server_host.$this->cart_webroot;//template
			$send_date=date('Y-m-d H:m:s');//template
			//读模板
			$template='send_coupon';
			$this->MailTemplate->set_locale($this->locale);
			$template=$this->MailTemplate->find("code = '$template' and status = '1'");
			//模板赋值
			$html_body=$template['MailTemplateI18n']['html_body'];
			eval("\$html_body = \"$html_body\";");
            $text_body=$template['MailTemplateI18n']['text_body'];
            eval("\$text_body = \"$text_body\";");
            //主题赋值
            $title = $template['MailTemplateI18n']['title'];
            eval("\$title = \"$title\";");
            
		        $mailsendqueue = array(
		       		"sender_name"=>$shop_name,//发送从姓名
		       		"receiver_email"=>$user_name.";".$user['User']['email'],//接收人姓名;接收人地址
		         	"cc_email"=>";",//抄送人
		         	"bcc_email"=>";",//暗送人
		          	"title"=>$title,//主题 
		           	"html_body"=>$html_body,//内容
		          	"text_body"=>$text_body,//内容
		         	"sendas"=>"html"
		     	);
         	$this->MailSendQueue->saveAll(array("MailSendQueue"=>$mailsendqueue));//保存邮件队列
          	if(isset($this->configs['email_the_way'])&&$this->configs['email_the_way'] == 1){
           		$this->requestAction('/mail_sends/?status=1'); 
          	}
    	return true;
	}
	
	function user_coupon_email($id){
		Configure::write('debug', 0);
		if($this->send_coupon_email($id)){
			$result['type'] = 0;
			$result['msg'] = "发送成功";
		}else{
			$result['type'] = 1;
			$result['msg'] = "发送失败";
		}
        $this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function send_by_user_rank(){
		$this->CouponType->hasOne = array('CouponTypeI18n' =>   
                        array('className'    => 'CouponTypeI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'coupon_type_id'  
                        )
                  );

		$users = $this->User->findall('User.rank ='.$_POST['user_rank']);
	//	pr($users);
		$this->CouponType->set_locale($this->locale);
		$coupon_info = $this->CouponType->findbyid($_POST['coupon_type_id']);
		$coupon_arr = $this->Coupon->findall("",'DISTINCT Coupon.sn_code');
		$coupon_count = count($coupon_arr);
		$num = 0;
		if($coupon_count > 0){
			$num = $coupon_arr[$coupon_count - 1]['Coupon']['sn_code'];
		}
		if(is_array($users) && sizeof($users)>0){
		foreach($users as $k=>$v){
			if(isset($coupon_sn)){
				$num = $coupon_sn;
			}
			$num = substr($num,2, 10);
			$num = $num ? floor($num / 10000) : 100000;
		    $coupon_sn = $coupon_info['CouponType']['prefix'].$num . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
		    $coupon = array(
						        'id'=>'',
						        'coupon_type_id' => $coupon_info['CouponType']['id'],
								'sn_code' => $coupon_sn,
						        'user_id' => $v['User']['id'],
						        );
			$this->Coupon->save($coupon);
			$coupon_id  = $this->Coupon->id;
			$this->send_coupon_email($coupon_id);
			}
		}
		$this->flash("发放成功",'/coupons/'.$_POST['coupon_type_id'],10);		
	}
	
}

?>