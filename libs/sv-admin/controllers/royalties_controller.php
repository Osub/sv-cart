<?php
/*****************************************************************************
 * SV-Cart 用户管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: votes_controller.php 3179 2009-07-22 05:09:18Z zhengli $
*****************************************************************************/
class RoyaltiesController extends AppController {

	var $name = 'Royalties';
    var $components = array ('Pagination','RequestHandler');
    var $helpers = array('Pagination');
	var $uses = array("Config","ConfigI18n","AffiliateLog","Order","User","SystemResource","Product","OrderProduct","UserPointLog","UserBalanceLog");
	
	function index(){
		$this->pageTitle = "分成管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'客户管理','url'=>'');
		$this->navigations[] = array('name'=>'推荐提成','url'=>'/royalties/');
		$this->set('navigations',$this->navigations);
		
        if(isset($this->params['url']['date']) && $this->params['url']['date']!=''){
        	$condition["and"]["Order.created >="] = $this->params['url']['date']." 00:00:00";
            
            $this->set('date',$this->params['url']['date']);
        }
        if(isset($this->params['url']['date2']) && $this->params['url']['date2']!=''){
        	$condition["and"]["Order.created <="] = $this->params['url']['date2']." 23:59:59";
            
            $this->set('date2',$this->params['url']['date2']);
        }
        if(isset($this->params['url']['order_code']) && $this->params['url']['order_code']!=''){
        	$condition["and"]["Order.order_code like"] = "%".$this->params['url']['order_code']."%";
            $this->set('order_code',$this->params['url']['order_code']);
        }
        if(isset($this->params['url']['order_domain']) && $this->params['url']['order_domain']!=''){
        	$condition["and"]["Order.order_domain like"] = "%".$this->params['url']['order_domain']."%";
            $this->set('order_domain',$this->params['url']['order_domain']);
        }

		$this->Config->set_locale("chi");
		$affiliate_config = $this->Config->findByCode("affiliate");//取推荐信息
	    $affiliate = unserialize($affiliate_config['ConfigI18n']['value']);
	    empty($affiliate) && $affiliate = array();
	    $separate_by = $affiliate['config']['separate_by'];
	    $this->Order->hasOne=array();
	    $this->Order->hasMany=array();
	    $sqladd = '';
	    if(!empty($affiliate['on'])){
	    	if(!empty($separate_by)){
	            //推荐注册分成
		    	$condition["and"]["Order.is_separate >="] = "0";
		    	$condition["and"]["Order.user_id >"] = "0";
		    	$condition["and"]["User.parent_id >"] = "0";
	        }
	        else{
	            //推荐订单分成
		    	$condition["and"]["Order.is_separate >="] = "0";
		    	$condition["and"]["Order.user_id >"] = "0";
		    	$condition["and"]["Order.parent_id >"] = "0";
	        }
	    }
	    else{
		    $condition["and"]["Order.is_separate >"] = "0";
		    $condition["and"]["Order.user_id >"] = "0";
	    }
		$order_info = $this->Order->find("all",array("conditions"=>$condition));
		$order_id = array();
		foreach( $order_info as $k=>$v ){
			$order_id[]=$v["Order"]["id"];
			if(!empty($separate_by) && $v['User']['parent_id'] > 0){
	            //按推荐注册分成
	            $order_info[$k]["Order"]['separate_able'] = 1;
        	}
        	elseif(!empty($separate_by) && $v["Order"]['parent_id'] > 0){
            	//按推荐订单分成
            	$order_info[$k]["Order"]['separate_able'] = 1;
        	}
		}
		
		$affiliatelog_info = $this->AffiliateLog->find("all",array("conditions"=>array("order_id"=>$order_id)));
		$affiliatelog_data = array();
		foreach($affiliatelog_info as $k=>$v){
			$affiliatelog_data[$v["AffiliateLog"]["order_id"]] = $v;
		}
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info = $this->SystemResource->resource_formated(false);//find("first",array("conditions"=>array("code"=>"order_status")));
       	//
       	
		$this->set("order_info",$order_info);
		$this->set("affiliatelog_data",$affiliatelog_data);
		$this->set("systemresource_info",$systemresource_info);

		$this->set("affiliate",$affiliate);
	}
	
	//、、分成
	function separate($oid){
		$this->Config->set_locale("chi");
		$affiliate_config = $this->Config->findByCode("affiliate");//取推荐信息
	    $affiliate = unserialize($affiliate_config['ConfigI18n']['value']);
    	empty($affiliate) && $affiliate = array();
		$separate_by = $affiliate['config']['separate_by'];
	    $this->Order->hasOne=array();
	    $this->Order->hasMany=array();
	    $order_info = $this->Order->findById($oid);
	    $order_info["Order"]["subtotal"] = $order_info["Order"]["subtotal"]-$order_info["Order"]["discount"];

    	if (empty($order_info["Order"]['is_separate'])){
        	$affiliate['config']['level_point_all'] = (float)$affiliate['config']['level_point_all'];
        	$affiliate['config']['level_money_all'] = (float)$affiliate['config']['level_money_all'];
        	if ($affiliate['config']['level_point_all']){
            	$affiliate['config']['level_point_all'] /= 100;
        	}
        	if ($affiliate['config']['level_money_all']){
            	$affiliate['config']['level_money_all'] /= 100;
        	}
        	$money = round($affiliate['config']['level_money_all'] * $order_info["Order"]['subtotal'],2);
        	$point = $this->integral_to_give($oid);
        	$point = round($affiliate['config']['level_point_all'] * intval($point), 0);
			
			if(!empty($separate_by)){
            	//推荐注册分成
            	$num = count($affiliate['item']);
            	for ($i=0; $i < $num; $i++){
                	$affiliate['item'][$i]['level_point'] = (float)$affiliate['item'][$i]['level_point'];
                	$affiliate['item'][$i]['level_money'] = (float)$affiliate['item'][$i]['level_money'];
                	if ($affiliate['item'][$i]['level_point']){
                    	$affiliate['item'][$i]['level_point'] /= 100;
                	}
                	if ($affiliate['item'][$i]['level_money']){
                    	$affiliate['item'][$i]['level_money'] /= 100;
                	}
                	$setmoney = round($money * $affiliate['item'][$i]['level_money'], 2);
                	$setpoint = round($point * $affiliate['item'][$i]['level_point'], 0);
                	$user_info = $this->User->findById($order_info["Order"]["parent_id"]);
                	$up_uid = $user_info["User"]['id'];
                	if (empty($up_uid) || empty($user_info["User"]['name'])){
                    	break;
                	}
                	else{
                		$info = "订单号 ".$order_info["Order"]["order_code"]." ,用户ID ".$up_uid."(".$user_info["User"]['name'].") 分成:金钱:".$setmoney." 积分 ".$setpoint;
		                $point_log=array("id" => "","user_id" => $up_uid,"point" => $setpoint,"log_type" => "A","system_note"=>$info);
		                $balance_log=array("id" => "","user_id" => $up_uid,"amount" => $setmoney,"log_type" => "A","system_note"=>$info);
						
						$user_info["User"]["point"] = $user_info["User"]["point"]+$setpoint;
		                $user_info["User"]["user_point"] = $user_info["User"]["user_point"]+$setpoint;
		                $user_info["User"]["balance"] = $user_info["User"]["balance"]+$setmoney;
		                $this->User->save(array("User"=>$user_info["User"]));
		                $this->UserPointLog->save($point_log);
		                $this->UserBalanceLog->save($balance_log);
                    	$this->write_affiliate_log($oid, $up_uid, $user_info["User"]['name'], $setmoney, $setpoint, $separate_by);
                }
            }
        }
        else{
            $user_info = $this->User->findById($order_info["Order"]["parent_id"]);
            $up_uid = $order_info["Order"]["parent_id"];
            if(!empty($up_uid) && $up_uid > 0){
                $info = "订单号 ".$order_info["Order"]["order_code"]." ,用户ID ".$up_uid."(".$user_info["User"]['name'].") 分成:金钱:".$money." 积分 ".$point;
		        $point_log=array("id" => "","user_id" => $up_uid,"point" => $point,"log_type" => "A","system_note"=>$info);
		        $balance_log=array("id" => "","user_id" => $up_uid,"amount" => $money,"log_type" => "A","system_note"=>$info);
                $user_info["User"]["point"] = $user_info["User"]["point"]+$point;
                $user_info["User"]["user_point"] = $user_info["User"]["user_point"]+$point;
                $user_info["User"]["balance"] = $user_info["User"]["balance"]+$money;
                $this->User->save(array("User"=>$user_info["User"]));
                $this->UserPointLog->save($point_log);
		        $this->UserBalanceLog->save($balance_log);
                $this->write_affiliate_log($oid, $up_uid, $user_info["User"]['name'], $money, $point, $separate_by);
            }
            else{
       			$this->flash("操作失败！",'/royalties/',10);
            }
        }
        $order_info["Order"]["is_separate"]=1;
       	$this->Order->save(array("Order"=>$order_info["Order"]));
       	}
       	
    	$this->flash("操作成功！",'/royalties/',10);
	}
	/*
	    撤销某次分成，将已分成的收回来
	*/
	function rollback($logid){
	    $stat = $this->AffiliateLog->findById($logid);
	    if (!empty($stat)){
	    	if($stat["AffiliateLog"]["separate_type"] == 1){
	            //推荐订单分成
	            $flag = "-2";
	        }
	        else{
	            //推荐注册分成
	            $flag = "-1";
	        }
		    $point_log=array("id" => "","user_id" => $stat["AffiliateLog"]["user_id"],"point" =>"-".$stat["AffiliateLog"]["point"],"log_type" => "A","system_note"=>"分成被管理员取消！");
            $this->UserPointLog->save($point_log);
		    $balance_log=array("id" => "","user_id" => $stat["AffiliateLog"]["user_id"],"amount" => "-".$stat["AffiliateLog"]["money"],"log_type" => "A","system_note"=>"分成被管理员取消！");
		    $this->UserBalanceLog->save($balance_log);
			$user_info = $this->User->findById($stat["AffiliateLog"]["user_id"]);
			$user_info["User"]["point"] = $user_info["User"]["point"]-$stat["AffiliateLog"]["point"];
			$user_info["User"]["balance"] = $user_info["User"]["balance"]-$stat["AffiliateLog"]["money"];
			$this->User->save(array("User"=>$user_info["User"]));
			$this->AffiliateLog->updateAll(
				array("separate_type"=>$flag),
				array("id"=>$logid)
			);
		}
    	$this->flash("操作成功！",'/royalties/',10);
	}
	function write_affiliate_log($oid, $uid, $username, $money, $point, $separate_by){	
		$write_affiliate_log_arr = array(
			"order_id" => $oid,
			"user_id" => $uid,
			"user_name"=>$username,
			"money"=>$money,
			"point"=>$point,
			"separate_type"=>$separate_by
			
		);
		$this->AffiliateLog->saveAll($write_affiliate_log_arr);
	}
	
	function concendel($oid){
		$this->Order->updateAll(
			array("Order.is_separate"=>"2"),
			array("Order.id"=>$oid)
		);
		$this->flash("操作成功！",'/royalties/',10);
	}
	//取得某订单应该赠送的积分数
	function integral_to_give($order_id){

		$OrderProduct_info = $this->OrderProduct->find("all",array("conditions"=>array("order_id"=>$order_id)));
	
		$point = 0;
		foreach( $OrderProduct_info as $k=>$v ){
			if( $v["Product"]["point"] > 0){
				$point+= $v["Product"]["point"];
			}
			else{
				$point+= $v["Product"]["shop_price"];
			}
		}
	//	pr($OrderProduct_info);
		return $point;
    }

}

?>