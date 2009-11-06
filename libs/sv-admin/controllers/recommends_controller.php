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
class RecommendsController extends AppController {

	var $name = 'Recommends';
    var $components = array ('Pagination','RequestHandler');
    var $helpers = array('Pagination');
	var $uses = array("Config","ConfigI18n");
	
	function index(){
		$this->pageTitle = "推荐设置" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'分成管理','url'=>'/royalties/');
		$this->navigations[] = array('name'=>'推荐设置','url'=>'/recommends/');
		$this->set('navigations',$this->navigations);
		//重关联
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
			$affiliate_config["ConfigI18n"][$v["locale"]] = $v;//设置语言
		}

		if($this->RequestHandler->isPost()){
		//	pr($this->data);
			foreach($this->languages as $k=>$v){
				if($v["Language"]["locale"] !="chi"){ continue;}
				$affiliate_config["ConfigI18n"][$v["Language"]["locale"]]["value"] = serialize($this->data[$v["Language"]["locale"]]);
				$affiliate_configi18n=$affiliate_config["ConfigI18n"][$v["Language"]["locale"]];
				$this->ConfigI18n->save($affiliate_configi18n);//保存修改
			}
			$this->flash("管理设置编辑成功！",'/recommends/index/',10);
		}
		foreach( $affiliate_config["ConfigI18n"] as $k=>$v ){
			$v["value"] = unserialize($v["value"]);//返序列化
			$affiliate_config["ConfigI18n"][$v["locale"]] = $v;
		}
	//	pr($affiliate_config);
		$this->set("affiliate_config",$affiliate_config);
		//重关联
		$this->Config->hasMany=array();
		$this->Config->hasOne=array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n',
                        	'conditions'    =>  '',   
                              'order'        => 'Config.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
                        )   
                  );
	}
	function ajax_index(){
		//重关联
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
			$affiliate_config["ConfigI18n"][$v["locale"]] = $v;//设置语言
			$v["value"] = unserialize($v["value"]);//返序列化
			$affiliate_config["ConfigI18n"][$v["locale"]] = $v;
		}
		$this->set("affiliate_config",$affiliate_config);
		
		
		//重关联
		$this->Config->hasMany=array();
		$this->Config->hasOne=array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n',
                        	'conditions'    =>  '',   
                              'order'        => 'Config.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
                        )   
                  );
		Configure::write('debug',0);

	}
	function add_recomment_config($addid,$locale,$mypoint=0,$mymoney=0){
		$this->Config->set_locale($locale);
		$config_info = $this->Config->findByCode("affiliate");
		$config_info_value = unserialize($config_info["ConfigI18n"]["value"]);//返序列化
		$config_info_value_item = $config_info_value["item"];
		$config_info_value_item_count = count($config_info_value_item);
		//$config_info_value_item[$config_info_value_item];
		
	
	    /* 取得参数 */
	    $key = trim($addid);
	    $maxpoint = 100;
	    $maxmoney = 100;
	    foreach ($config_info_value_item as $k => $v)
	    {
	        if ($k != $key)
	        {
	            $maxpoint -= $v['level_point'];
	        }
	        if ($k != $key)
	        {
	            $maxmoney -= $v['level_money'];
	        }
	    }
	    $mypoint > $maxpoint && $mypoint = $maxpoint;
	    $mymoney > $maxmoney && $mymoney = $maxmoney;
	    if (!empty($mypoint) && strpos($mypoint,'%') === false)
	    {
	        $mypoint .= '%';
	    }
	    if (!empty($mymoney) && strpos($mymoney,'%') === false)
	    {
	        $mymoney .= '%';
	    }
    	$config_info_value['item'][$key]['level_point'] = $mypoint;
    	$config_info_value['item'][$key]['level_money'] = $mymoney;
    	//pr($config_info_value);
    	$config_info["ConfigI18n"]["value"] = serialize($config_info_value);//返序列化
		$this->ConfigI18n->save($config_info["ConfigI18n"]);
		Configure::write('debug',0);
		die();
	}
	function remove($delid,$locale){
		$this->Config->set_locale($locale);
		$config_info = $this->Config->findByCode("affiliate");
		$config_info_value = unserialize($config_info["ConfigI18n"]["value"]);//返序列化

	    $key = $delid;
	    unset($config_info_value['item'][$key]);
	    $temp = array();
	    foreach ($config_info_value['item'] as $key => $val)
	    {
	        $temp[] = $val;
	    }
	    $config_info_value['item'] = $temp;
	    $config_info["ConfigI18n"]["value"] = serialize($config_info_value);
		$this->ConfigI18n->save($config_info["ConfigI18n"]);
		Configure::write('debug',0);
		die();
	}
	function get_affiliate_ck(){
	    $affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
	    empty($affiliate) && $affiliate = array();
	    $separate_by = $affiliate['config']['separate_by'];

	    $sqladd = '';
	    if (isset($_REQUEST['status']))
	    {
	        $sqladd = ' AND o.is_separate = ' . (int)$_REQUEST['status'];
	        $filter['status'] = (int)$_REQUEST['status'];
	    }
	    if (isset($_REQUEST['order_sn']))
	    {
	        $sqladd = ' AND o.order_sn LIKE \'%' . trim($_REQUEST['order_sn']) . '%\'';
	        $filter['order_sn'] = $_REQUEST['order_sn'];
	    }

	    if(!empty($affiliate['on']))
	    {
	        if(empty($separate_by))
	        {
	            //推荐注册分成
	            $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " o".
	                    " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".
	                    " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .
	                    " WHERE o.user_id > 0 AND (u.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd";
	        }
	        else
	        {
	            //推荐订单分成
	            $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " o".
	                    " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".
	                    " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .
	                    " WHERE o.user_id > 0 AND (o.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd";
	        }
	    }
	    else
	    {
	        $sql = "SELECT COUNT(*) FROM " . $GLOBALS['ecs']->table('order_info') . " o".
	                " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".
	                " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .
	                " WHERE o.user_id > 0 AND o.is_separate > 0 $sqladd";
	    }


	    $filter['record_count'] = $GLOBALS['db']->getOne($sql);
	    $logdb = array();
	    /* 分页大小 */
	    $filter = page_and_size($filter);

	    if(!empty($affiliate['on']))
	    {
	        if(empty($separate_by))
	        {
	            //推荐注册分成
	            $sql = "SELECT o.*, a.log_id, a.user_id as suid,  a.user_name as auser, a.money, a.point, a.separate_type,u.parent_id as up FROM " . $GLOBALS['ecs']->table('order_info') . " o".
	                    " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".
	                    " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .
	                    " WHERE o.user_id > 0 AND (u.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd".
	                    " ORDER BY order_id DESC" .
	                    " LIMIT " . $filter['start'] . ",$filter[page_size]";

	            /*
	                SQL解释：

	                列出同时满足以下条件的订单分成情况：
	                1、有效订单o.user_id > 0
	                2、满足以下情况之一：
	                    a.有用户注册上线的未分成订单 u.parent_id > 0 AND o.is_separate = 0
	                    b.已分成订单 o.is_separate > 0

	            */
	        }
	        else
	        {
	            //推荐订单分成
	            $sql = "SELECT o.*, a.log_id,a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type,u.parent_id as up FROM " . $GLOBALS['ecs']->table('order_info') . " o".
	                    " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".
	                    " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .
	                    " WHERE o.user_id > 0 AND (o.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd" .
	                    " ORDER BY order_id DESC" .
	                    " LIMIT " . $filter['start'] . ",$filter[page_size]";

	            /*
	                SQL解释：

	                列出同时满足以下条件的订单分成情况：
	                1、有效订单o.user_id > 0
	                2、满足以下情况之一：
	                    a.有订单推荐上线的未分成订单 o.parent_id > 0 AND o.is_separate = 0
	                    b.已分成订单 o.is_separate > 0

	            */
	        }
	    }
	    else
	    {
	        //关闭
	        $sql = "SELECT o.*, a.log_id,a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type,u.parent_id as up FROM " . $GLOBALS['ecs']->table('order_info') . " o".
	                " LEFT JOIN".$GLOBALS['ecs']->table('users')." u ON o.user_id = u.user_id".
	                " LEFT JOIN " . $GLOBALS['ecs']->table('affiliate_log') . " a ON o.order_id = a.order_id" .
	                " WHERE o.user_id > 0 AND o.is_separate > 0 $sqladd" .
	                " ORDER BY order_id DESC" .
	                " LIMIT " . $filter['start'] . ",$filter[page_size]";
	    }


	    $query = $GLOBALS['db']->query($sql);
	    while ($rt = $GLOBALS['db']->fetch_array($query))
	    {
	        if(empty($separate_by) && $rt['up'] > 0)
	        {
	            //按推荐注册分成
	            $rt['separate_able'] = 1;
	        }
	        elseif(!empty($separate_by) && $rt['parent_id'] > 0)
	        {
	            //按推荐订单分成
	            $rt['separate_able'] = 1;
	        }
	        if(!empty($rt['suid']))
	        {
	            //在affiliate_log有记录
	            $rt['info'] = sprintf($GLOBALS['_LANG']['separate_info2'], $rt['suid'], $rt['auser'], $rt['money'], $rt['point']);
	            if($rt['separate_type'] == -1 || $rt['separate_type'] == -2)
	            {
	                //已被撤销
	                $rt['is_separate'] = 3;
	                $rt['info'] = "<s>" . $rt['info'] . "</s>";
	            }
	        }
	        $logdb[] = $rt;
	    }
	    $arr = array('logdb' => $logdb, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

	    return $arr;
	}
	function write_affiliate_log($oid, $uid, $username, $money, $point, $separate_by)
	{
	    $time = gmtime();
	    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('affiliate_log') . "( order_id, user_id, user_name, time, money, point, separate_type)".
	                                                              " VALUES ( '$oid', '$uid', '$username', '$time', '$money', '$point', $separate_by)";
	    if ($oid)
	    {
	        $GLOBALS['db']->query($sql);
	    }
	}

}

?>