<?php
/*****************************************************************************
 * SV-Cart 我的推荐
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: shippings_controller.php 722 2009-04-17 07:49:36Z shenyunfeng $
*****************************************************************************/
class RecommendsController extends AppController {

	var $name = 'Recommends';
    var $components = array ('Pagination'); // Added 
    var $helpers = array('Pagination'); // Added 
	var $uses = array('User','Order','AffiliateLog','Product');

	function index(){
		if(!isset($_SESSION['User'])){
			 $this->redirect('/login/');
		}
		$this->page_init();
		$this->pageTitle = $this->languages['my_recommend']." - ".$this->configs['shop_title'];
		$this->Config->hasOne=array();
		$this->Config->hasMany=array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n',
                        	'conditions'    =>  '',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
                        )   
                  );
		$affiliate_config = $this->Config->findByCode("affiliate");//取推荐信息
		foreach( $affiliate_config["ConfigI18n"] as $k=>$v ){
			if($v['value'] != ""){
			//	pr($v);
				$affiliate_config["ConfigI18n"][$this->locale] = $v;//设置语言
				$affiliate_config["ConfigI18n"][$this->locale]['value'] =  unserialize($v["value"]);//返序列化
			}
		}
//	pr($affiliate_config);
//		foreach( $affiliate_config["ConfigI18n"] as $k=>$v ){
//			if($v['value'] != ""){
//				pr($v['value']);
//			}
//			$v["value"] = unserialize($v["value"]);//返序列化
//			$affiliate_config["ConfigI18n"][$v["locale"]] = $v;
//		}
//		exit;
		$this->set("affiliate_config",$affiliate_config);
        $all_uid = array();
		if(isset($affiliate_config['ConfigI18n'][$this->locale]['value']['item']) && sizeof($affiliate_config['ConfigI18n'][$this->locale]['value']['item'])>0){
		$this->set("affiliate_setting",$affiliate_config['ConfigI18n'][$this->locale]['value']['config']);
            //推荐注册分成
            $affiliate_list = array();
            $num = count($affiliate_config['ConfigI18n'][$this->locale]['value']['item']);
            $up_uid = array();
            $up_uid[] = $_SESSION['User']['User']['id'];
            $all_uid[] = $_SESSION['User']['User']['id'];
            for ($i = 1 ; $i <=$num ;$i++)
            {
                $count = 0;
                if (!empty($up_uid))
                {
                //	pr($up_uid);
                    $users= $this->User->find('list',array('conditions'=>array('User.parent_id'=>$up_uid),'fields' =>array('User.id')));
                    $up_uid = array();
					if(isset($users) && sizeof($users)>0){
						foreach($users as $k=>$v){
	                        $up_uid[] = $v;
	                        if($i < $num)
	                        {
	                            $all_uid[] = $v;
	                        }							
							$count++;
						}
					}
                }
                $affiliate_list[$i]['num'] = $count;
                $affiliate_list[$i]['point'] = $affiliate_config['ConfigI18n'][$this->locale]['value']['item'][$i-1]['level_point'];
                $affiliate_list[$i]['money'] = $affiliate_config['ConfigI18n'][$this->locale]['value']['item'][$i-1]['level_money'];
            }
            $this->set('affiliate_list', $affiliate_list);
		//	pr($affiliate_list);
		/*	$this->User->hasOne =array();
			$this->User->hasOne =array(
								  'Order'=>array(
								  'className'    => 'Order',
	                         	  'conditions'    =>  '',   
	                              'order'        => 'user_id',   
	                              'dependent'    =>  true,   
	                              'foreignKey'   => 'user_id'  								
								));
			$condition['AND'][0] = array('Order.user_id'=>'User.id');
			$condition['OR'][0] =array('User.parent_id'=>$all_uid,'Order.is_separate'=>0);
			$condition['OR'][1] =array('User.parent_id'=>$_SESSION['User']['User']['id'],'Order.is_separate >'=>0);
			$test = $this->User->find('all',array('conditions'=>$condition));
			$this->User->hasMany = array();*/
			
		//	$all_orders = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$all_uid,'Order.is_separate'=>0)));
						
		}
			$rownum = 10;
			$sortClass='AffiliateLog';
			$page=1;
			$parameters=Array('created',$rownum,$page);
			$options=Array();
			$total = $this->AffiliateLog->find('count',array('conditions'=>array('AffiliateLog.user_id'=>$all_uid)));
			$page = $this->Pagination->init(array('AffiliateLog.user_id'=>$all_uid),$parameters,$options,$total,$rownum,$sortClass); // Added 
			$user_affiliate = $this->AffiliateLog->find('all',array('conditions'=>array('AffiliateLog.user_id'=>$all_uid),'order'=>'AffiliateLog.created DESC','page'=>$page,'limit' => $rownum));
			$this->set('user_affiliate',$user_affiliate);
			$reg_oids = array(); //注册
			$rec_oids = array(); //订单推荐
			$order_ids = array();
			if(isset($user_affiliate) && sizeof($user_affiliate)>0){
				foreach($user_affiliate as $k=>$v){
					/*if($v['AffiliateLog']['separate_type'] == 0){
						$reg_oids = $v['AffiliateLog']['order_id'];
					}else if($v['AffiliateLog']['separate_type'] == 1){
						$rec_oids = $v['AffiliateLog']['order_id'];
					}*/
					$order_ids[] = $v['AffiliateLog']['order_id'];
				}
			}
			
			
			$order = $this->Order->find('all',array('conditions'=>array('Order.id'=>$order_ids),'recursive' => -1,'fields'=>array('Order.id','Order.order_code','Order.is_separate')));
			$order_list = array();
			if(isset($order) && sizeof($order)>0){
				foreach($order as $k=>$v){
					$order_list[$v['Order']['id']] = $v; 
					$order_list[$v['Order']['id']]['Order']['order_code'] = substr($v['Order']['order_code'], 0, strlen($v['Order']['order_code']) - 5) . "***" . substr($v['Order']['order_code'], -2, 2);
				}
			}
			$this->set('order_list',$order_list);
			
			//重关联
			$this->Config->hasMany=array();
			$this->Config->hasOne=array('ConfigI18n' =>   
	                        array('className'    => 'ConfigI18n',
	                        	'conditions'    =>  '',   
	                              'order'        => 'Config.id',   
	                              'dependent'    =>  false,   
	                              'foreignKey'   => 'config_id'  
	                        )   
	                  );
	}
	
	function product($id){
		if(!isset($_SESSION['User'])){
			 $this->redirect('/login/');
		}
		$this->page_init();
		$this->pageTitle = $this->languages['my_recommend']." - ".$this->configs['shop_title'];
		$type = array(1,2,3,4);
		$this->set('type',$type);
		$this->set('pid',$id);
		$this->set('uid',$_SESSION['User']['User']['id']);
        $js_languages = array("copied_to_clipboard" => $this->languages['copied_to_clipboard']);
        $this->set('js_languages',$js_languages);
	}
	
	function affiliate(){
		$pid = $_GET['pid'];
		$uid = $_GET['u'];
		$method = $_GET['method'];
		$type = $_GET['type'];
		$charset = $_GET['charset'];
		if ( $method == 'javascript' )
		{
		    header('content-type: application/x-javascript; charset=' . ($charset == 'UTF8' ? 'utf-8' : $charset));
		}		
		$product_info = $this->Product->findbyid($pid);
		$img_arr = explode('http://',$product_info['Product']['img_thumb']);
		if(sizeof($img_arr)>1){
			$img = $product_info['Product']['img_thumb'];
		}else{
			$img_url = substr($product_info['Product']['img_thumb'],1,strlen($product_info['Product']['img_thumb']));
			$img = $this->server_host.$this->cart_webroot.$product_info['Product']['img_thumb'];
		}
		
		if($type == 1){
			$output = "<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
			  <tr>
			    <td><table width=\"100%\">
			      <tr>
			        <td align=\"center\"><a href=".$this->server_host.$this->cart_webroot."commons/save_value_pu/".$pid."/".$uid."/ target=\"_blank\"><img src=".$img."  border=\"0\"></a></td>
			      </tr>
			      <tr>
			        <td align=\"center\"><a href=".$this->server_host.$this->cart_webroot."commons/save_value_pu/".$pid."/".$uid."/ target=\"_blank\"><big>".$product_info['ProductI18n']['name']."</big></a><br /><font color=\"#FF0000\">".sprintf($this->configs['price_format'],$product_info['Product']['shop_price'])."</font></td>
			      </tr>
			    </table></td>
			  </tr>
			</table>";
		}
		if($type == 2){
		$output = "<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		  <tr>
		    <td><table width=\"100%\">
		      <tr>
		        <td align=\"center\"><a href=".$this->server_host.$this->cart_webroot."commons/save_value_pu/".$pid."/".$uid."/ target=\"_blank\"><img src=".$img." alt=".$product_info['ProductI18n']['name']." border=\"0\"></a></td>
		      </tr>
		      <tr>
		        <td align=\"center\"><a href=".$this->server_host.$this->cart_webroot."commons/save_value_pu/".$pid."/".$uid."/ target=\"_blank\"><big>".$product_info['ProductI18n']['name']."</big></a><br /><s>".sprintf($this->configs['price_format'],$product_info['Product']['market_price'])."</s><br/><font color=\"#FF0000\">".sprintf($this->configs['price_format'],$product_info['Product']['shop_price'])."</font></td>
		      </tr>
		    </table></td>
		  </tr>
		</table>";
		}		
		
		if($type == 3){
		$output = "<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		  <tr>
		    <td><table width=\"100%\">
		      <tr>
		        <td align=\"center\"><a href=".$this->server_host.$this->cart_webroot."commons/save_value_pu/".$pid."/".$uid."/ target=\"_blank\"><big>".$product_info['ProductI18n']['name']."</big></a><br /><font color=\"#FF0000\">".sprintf($this->configs['price_format'],$product_info['Product']['shop_price'])."</font></td>
		      </tr>
		    </table></td>
		  </tr>
		</table>";
		}		
		if($type == 4){
		$output = "<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		  <tr>
		    <td><table width=\"100%\">
		      <tr>
		        <td align=\"center\"><a href=".$this->server_host.$this->cart_webroot."commons/save_value_pu/".$pid."/".$uid."/ target=\"_blank\"><img src=".$img."  border=\"0\"></a></td>
		      </tr>
		    </table></td>
		  </tr>
		</table>";
		}		
		$output = str_replace("\r", '', $output);
		$output = str_replace("\n", '', $output);		
		if ( $method == 'javascript' )
		{
		    echo "document.write('$output');";
		}
		else if ( $method == 'iframe' )
		{
		    echo $output;
		}		
		exit;
	}
	
	
	
	
}

?>