<?php
/*****************************************************************************
 * SV-CART Ucenter
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: pages_controller.php 678 2009-04-16 02:22:25Z tangyu $
*****************************************************************************/
class UcentersController extends UcenterAppController {
	var $name 		= 'Ucenters';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers 	= array('Pagination'); // Added "
	var $uses 		= array("Cart","Config","ConfigI18n","User","BookingProduct","Comment","Coupon","Order","OrderAction","UserAccount","UserBalanceLog","UserConfig","UserFavorite","UserFriend","UserFriendCat","UserInfoValue","UserMessage","UserPointLog","UserRank");
	
	function index(){
		$this->operator_privilege('ucenter_view');
	   	$this->pageTitle = "Ucenter管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name' => 'Ucenter管理', 'url' => './');
		
   	}
   	function setup(){
		$this->operator_privilege('ucenter_view');
	   	$this->pageTitle = "Ucenter管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name' => 'Ucenter管理', 'url' => './');
	   	$this->set('navigations',$this->navigations);
		$integrate_config = unserialize($this->configs["integrate_config"]);
		
		if($this->RequestHandler->isPost()){
			$integrate_config["uc_id"] = $_REQUEST["cfg"]["uc_id"];
			$integrate_config["uc_key"] = $_REQUEST["cfg"]["uc_key"];
			$integrate_config["uc_url"] = $_REQUEST["cfg"]["uc_url"];
			$integrate_config["uc_ip"] = $_REQUEST["cfg"]["uc_ip"];
			$integrate_config["uc_connect"] = $_REQUEST["cfg"]["uc_connect"];
			$integrate_config["db_host"] = $_REQUEST["cfg"]["db_host"];
			$integrate_config["db_user"] = $_REQUEST["cfg"]["db_user"];
			$integrate_config["db_name"] = $_REQUEST["cfg"]["db_name"];
			$integrate_config["db_pass"] = $_REQUEST["cfg"]["db_pass"];
			$integrate_config["db_pre"] = $_REQUEST["cfg"]["db_pre"];
			$integrate_config["uc_lang"]["credits"][0][0] = $_REQUEST["cfg"]["uc_lang"]["credits"][0][0];
			$integrate_config["uc_lang"]["credits"][1][0] = $_REQUEST["cfg"]["uc_lang"]["credits"][1][0];
			$integrate_config = serialize($integrate_config);
			$configs_info = $this->Config->find(array("code"=>"integrate_config"));
			$this->ConfigI18n->updateAll(
				array("value"=>"'".addslashes($integrate_config)."'"),
				array("config_id"=>$configs_info["Config"]["id"])
			);
  			$this->flash("成功将会员数据导入到 UCenter",'/ucenter/ucenters/setup/','');
			//pr($_REQUEST["cfg"]);
		}
		//pr($integrate_config);
		$this->set("integrate_config",$integrate_config);
   	}
   	function points_set(){
   		$integrate_config = unserialize($this->configs["integrate_config"]);
  		$this->flash("UCenter的积分兑换设置需要在UCenter管理后台进行",$integrate_config["uc_url"],'');
	}

   	function ucenter_install(){
   		$this->operator_privilege('ucenter_view');
	   	$this->pageTitle = "Ucenter管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name' => 'Ucenter管理', 'url' => './');
		
   	}
   	function setup_ucenter(){
   		include_once(ROOT.APP_DIR."/plugins/ucenter/controllers/commons.php");
		include_once(ROOT.APP_DIR."/plugins/ucenter/controllers/cls_transport.php");
		
    	$result 	= array('error' => 0, 'message' => '');
		$app_type   = 'SVCART';
    	$app_name   = $this->configs["shop_name"];
    	$app_url    = url();
    	$app_charset = "utf-8";
    	$app_dbcharset = strtolower((str_replace('-', '', "utf-8")));
    	$ucapi = !empty($_REQUEST['ucapi']) ? trim($_REQUEST['ucapi']) : '';
    	$ucip = !empty($_REQUEST['ucip']) ? trim($_REQUEST['ucip']) : '';
    	$dns_error = false;
    	if(!$ucip)
    	{   
        	$temp = @parse_url($ucapi);
        	$ucip = gethostbyname($temp['host']);
        	if(ip2long($ucip) == -1 || ip2long($ucip) === FALSE)
        	{
            	$ucip = '';
            	$dns_error = true;
        	}
        	
    	}
    	if($dns_error){
        	$result['error'] = 2;
        	$result['message'] = '';
        	die(json_encode($result));
    	}

    	$ucfounderpw = trim($_REQUEST['ucfounderpw']);
    	$app_tagtemplates = 'apptagtemplates[template]='.urlencode('<a href="{url}" target="_blank">{goods_name}</a>').'&'.
        	'apptagtemplates[fields][goods_name]='.urlencode("商品名称").'&'.
        	'apptagtemplates[fields][uid]='.urlencode("用户 ID").'&'.
        	'apptagtemplates[fields][username]='.urlencode("添加标签者").'&'.
        	'apptagtemplates[fields][dateline]='.urlencode("日期").'&'.
        	'apptagtemplates[fields][url]='.urlencode("商品地址").'&'.
        	'apptagtemplates[fields][image]='.urlencode("商品图片").'&'.
        	'apptagtemplates[fields][goods_price]='.urlencode("商品价格");
    	$postdata ="m=app&a=add&ucfounder=&ucfounderpw=".urlencode($ucfounderpw)."&apptype=".urlencode($app_type).
        	"&appname=".urlencode($app_name)."&appurl=".urlencode($app_url)."&appip=&appcharset=".$app_charset.
        	'&appdbcharset='.$app_dbcharset.'&apptagtemplates='.$app_tagtemplates;
	    $t = new transport;
	    $ucconfig = $t->request($ucapi.'/index.php', $postdata);
		$ucconfig = $ucconfig['body'];
    	if(empty($ucconfig))
    	{
        	//ucenter 验证失败
        	$result['error'] = 1;
        	$result['message'] = "验证失败";
    	}
    	elseif($ucconfig == '-1')
    	{
        	//管理员密码无效
        	$result['error'] = 1;
        	$result['message'] = "创始人密码错误";
    	}
   	 	else
    	{
        	list($appauthkey, $appid) = explode('|', $ucconfig);
        	//pr($appauthkey);
        	if(empty($appauthkey) || empty($appid))
        	{
            	//ucenter 安装数据错误
            	$result['error'] = 1;
            	$result['message'] = "安装数据错误";
        	}
        	else
        	{
            	$result['error'] = 0;
            	$result['message'] = $ucconfig;
        	}
    	}
		Configure::write('debug', 0);
    	die(json_encode($result));

  	}
  	
	/*------------------------------------------------------ */
	//-- 第一次保存UCenter安装的资料
	/*------------------------------------------------------ */
  	function save_uc_config_first(){
  		$code = $_POST['code'];
  		$_POST['cfg']['quiet'] = 1;
  	    list($appauthkey, $appid, $ucdbhost, $ucdbname, $ucdbuser, $ucdbpw, $ucdbcharset, $uctablepre, $uccharset) = explode('|', $_POST['ucconfig']);
    	$uc_ip 	= !empty($ucip)? $ucip : trim($_POST['uc_ip']);
    	$uc_url = !empty($ucapi)? $ucapi : trim($_POST['uc_url']);
    	$cfg = array(
                    'uc_id' => $appid,
                    'uc_key' => $appauthkey,
                    'uc_url' => $uc_url,
                    'uc_ip' => $uc_ip,
                    'uc_connect' => 'mysql',
                    'uc_charset' => $uccharset,
                    'db_host' => $ucdbhost,
                    'db_user' => $ucdbuser,
                    'db_name' => $ucdbname,
                    'db_pass' => $ucdbpw,
                    'db_pre' => $uctablepre,
                    'db_charset' => $ucdbcharset,
                );
  		$cfg['uc_lang']['credits'][0][0] = '等级积分';
		$cfg['uc_lang']['credits'][0][1] = '';
		$cfg['uc_lang']['credits'][1][0] = '消费积分';
		$cfg['uc_lang']['credits'][1][1] = '';
		$cfg['uc_lang']['exchange'] = 'UCenter积分兑换';
		$cfg['integrate_url'] = isset($cfg['integrate_url'])?$cfg['integrate_url']:"http://";
		//pr($cfg);
  	    /* 检测成功临时保存论坛配置参数 */
	    $_SESSION['cfg'] = $cfg;
	    $_SESSION['code'] = $code;
	    /* 直接保存修改 */
	    if (!empty($_POST['save']))
	    {
	        /*if ($this->save_integrate_config($code, $cfg))
	        {
	            sys_msg($_LANG['save_ok'],0, array(array('text'=>$_LANG['06_list_integrate'],'href'=>'integrate.php?act=list')));
	        }
	        else
	        {
	            sys_msg($_LANG['save_error'],0, array(array('text'=>$_LANG['06_list_integrate'],'href'=>'integrate.php?act=list')));
	        }*/
	    }
	    /* 保存完成整合 */
	    $this->save_integrate_config($code, $cfg);
  	}
  	
  	//会员导入Ucenter
  	function import_user(){
	    $cfg = $_SESSION['cfg'];
		include_once(ROOT.APP_DIR."/plugins/ucenter/controllers/cls_mysql.php");
	    $ucdb = new cls_mysql($cfg['db_host'], $cfg['db_user'], $cfg['db_pass'], $cfg['db_name'], $cfg['db_charset']);
	    $result = array('error' => 0, 'message' => '');
	    $query = $ucdb->query("SHOW TABLE STATUS LIKE '".$cfg['db_pre']."members" . "'");
	    $data = $ucdb->fetch_array($query);
	    if($data["Auto_increment"]) {
	        $maxuid = $data["Auto_increment"]-1;
	    } else {
	        $maxuid = 0;
	    }
	    $merge_method = intval($_POST['merge']);
	    $merge_uid = array();
	    $uc_uid = array();
	    $repeat_user = array();
		$user_list = $this->User->find("all");
		$up_uc_uid[] = 0;
    	foreach( $user_list as $k=>$v )
    	{
	        $salt = rand(100000, 999999);
        	$password = md5($v['User']['password'].$salt);
        	$v['User']['name'] = addslashes($v['User']['name']);
        	$lastuid = $v['User']['id'] + $maxuid;
        	
	        $uc_userinfo = $ucdb->getRow("SELECT `uid`, `password`, `salt` FROM ".$cfg['db_pre']."members WHERE `username`='".$v['User']['name']."'");
	        if(!$uc_userinfo)
	        {
	            $ucdb->query("INSERT LOW_PRIORITY INTO ".$cfg['db_pre']."members SET uid='$lastuid', username='".$v["User"]["name"]."', password='$password', email='".$v["User"]["email"]."', regip='".$v["User"]["login_ipaddr"]."', regdate='".$v["User"]["created"]."', salt='$salt'", 'SILENT');
	            $ucdb->query("INSERT LOW_PRIORITY INTO ".$cfg['db_pre']."memberfields SET uid='$lastuid'",'SILENT');
	        	$up_uc_uid[] = $v['User']['id'];
	        }
	        else
	        {
            	if ($merge_method == 1)
            	{
                	if (md5($v['User']['password'].$uc_userinfo['salt']) == $uc_userinfo['password'])
                	{
                    	$merge_uid[] = $v['User']['id'];
                    	$uc_uid[] = $v['User']['id'];
                    	continue;
                	}
            	}
            	$uc_appid = isset($cfg['uc_id'])?$cfg['uc_id']:'';
	            $ucdb->query("REPLACE INTO ".$cfg['db_pre']."mergemembers SET appid='".$uc_appid."', username='".$v["User"]["name"]."'", 'SILENT');
	            $repeat_user[] = $v;
	        }
	    }
	    //$ucdb->query("ALTER TABLE ".$cfg['db_pre']."members AUTO_INCREMENT=".($lastuid + 1), 'SILENT');
		//更新User_id
		$this->BookingProduct->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
			
		);
		$this->Comment->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
		);
		$this->Coupon->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
		);
		$this->BookingProduct->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
		);
		$this->Order->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
		);
		$this->OrderAction->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
		);
		$this->UserAccount->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
			
		);
		$this->UserBalanceLog->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
			
		);
		$this->UserConfig->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
			
		);
		$this->UserFavorite->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
			
		);
		$this->UserFriend->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
			
		);
		$this->UserFriendCat->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
			
		);
		$this->UserInfoValue->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
			
		);
		$this->UserMessage->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
			
		);
		$this->UserPointLog->updateAll(
			array("user_id"=>"user_id+".$maxuid),
			array("user_id"=>$up_uc_uid)
			
		);		
		$this->User->updateAll(
			array("id"=>"id+".$maxuid),
			array("id"=>$up_uc_uid)
		);

		// 清空的表
		$this->Cart->deleteall("1=1");
	    // 保存重复的用户信息
	    /*if (!empty($repeat_user))
	    {
	        @file_put_contents(ROOT_PATH . 'data/repeat_user.php', json_encode($repeat_user));
	    }*/
    	$result['error'] = 0;
	    $result['message'] = "成功将会员数据导入到 UCenter";
	    Configure::write('debug', 0);
	    die(json_encode($result));
  	}
  	
  	function complete(){
  		$this->flash("成功将会员数据导入到 UCenter",'../../plugins','');
  	}



	function save_integrate_config($code, $cfg)
	{	//重新关联去除locale设定
		$this->Config->hasOne = array('ConfigI18n' =>   
                        array('className'    => 'ConfigI18n',
                        	'conditions'    =>  '',   
                              'order'        => 'Config.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'config_id'  
                        )   
                  );
        //检测商店设置是否存在integrate_code
	    if (empty($this->configs["integrate_code"]))
	    { 	
	    	$configs = array(
	    			"group_code"=>"basic_setting",
	    			"code"=>"integrate_code",
	    			"type"=>"hidden",
	    			"orderby"=>"50"
	    		);
	    
	    	$this->Config->saveAll(array("Config"=>$configs));
	    	$id = $this->Config->getLastInsertId();
	    	foreach($this->languages as $lk => $lv)
		    {
	    		$configI18n = array(
	    			"locale" => $lv['Language']['locale'],
	    			"config_id"=>$id,
	    			"name"=>"integrate_code",
	    			"value"=>$code,
	    			"options"=>"",
	    			"description"=>""
	    		);
	    		$this->ConfigI18n->saveAll(array("ConfigI18n"=>$configI18n));
	    	}
	    }
	    else
	    {

	    	$config_info = $this->Config->findAll(array("code"=>"integrate_code"));
			foreach( $config_info as $k=>$v ){
				$v["ConfigI18n"]["value"] = $code;
				$this->ConfigI18n->save($v);
			}
	    }

	    /* 当前的域名 */
	    if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
	    {
	        $cur_domain = $_SERVER['HTTP_X_FORWARDED_HOST'];
	    }
	    elseif (isset($_SERVER['HTTP_HOST']))
	    {
	        $cur_domain = $_SERVER['HTTP_HOST'];
	    }
	    else
	    {
	        if (isset($_SERVER['SERVER_NAME']))
	        {
	            $cur_domain = $_SERVER['SERVER_NAME'];
	        }
	        elseif (isset($_SERVER['SERVER_ADDR']))
	        {
	            $cur_domain = $_SERVER['SERVER_ADDR'];
	        }
	    }

	    /* 整合对象的域名 */
	    $int_domain = str_replace(array('http://', 'https://'), array('', ''), $cfg['integrate_url']);
	    if (strrpos($int_domain, '/'))
	    {
	        $int_domain = substr($int_domain, 0, strrpos($int_domain, '/'));
	    }

	    if ($cur_domain != $int_domain)
	    {
	        $same_domain    = true;
	        $domain         = '';

	        /* 域名不一样，检查是否在同一域下 */
	        $cur_domain_arr = explode(".", $cur_domain);
	        $int_domain_arr = explode(".", $int_domain);

	        if (count($cur_domain_arr) != count($int_domain_arr) || $cur_domain_arr[0] == '' || $int_domain_arr[0] == '')
	        {
	            /* 域名结构不相同 */
	            $same_domain = false;
	        }
	        else
	        {
	            /* 域名结构一致，检查除第一节以外的其他部分是否相同 */
	            $count = count($cur_domain_arr);

	            for ($i = 1; $i < $count; $i++)
	            {
	                if ($cur_domain_arr[$i] != $int_domain_arr[$i])
	                {
	                    $domain         = '';
	                    $same_domain    = false;
	                    break;
	                }
	                else
	                {
	                    $domain .= ".$cur_domain_arr[$i]";
	                }
	            }
	        }

	        if ($same_domain == false)
	        {
	            /* 不在同一域，设置提示信息 */
	            $cfg['cookie_domain']   = '';
	            $cfg['cookie_path']     = '/';
	        }
	        else
	        {
	            $cfg['cookie_domain']   = $domain;
	            $cfg['cookie_path']     = '/';
	        }
	    }
	    else
	    {
	        $cfg['cookie_domain']   = '';
	        $cfg['cookie_path']     = '/';
	    }
        //检测商店设置是否存在integrate_config
	    if (empty($this->configs["integrate_config"]))
	    {
	    	$configs = array(
	    			"group_code"=>"basic_setting",
	    			"code"=>"integrate_config",
	    			"type"=>"hidden",
	    			"orderby"=>"50"
	    		);
	    	$this->Config->saveAll(array("Config"=>$configs));
	    	$id = $this->Config->getLastInsertId();
	    	foreach($this->languages as $lk => $lv)
		    {
	    		$configI18n = array(
	    			"locale" => $lv['Language']['locale'],
	    			"config_id"=>$id,
	    			"name"=>"integrate_config",
	    			"value"=>serialize($cfg),
	    			"options"=>"",
	    			"description"=>""
	    		);
	    		$this->ConfigI18n->saveAll(array("ConfigI18n"=>$configI18n));
	    	}
	    }
	    else
	    {	

	    	$config_info = $this->Config->findAll(array("code"=>"integrate_config"));
			foreach( $config_info as $k=>$v ){
				$v["ConfigI18n"]["value"] = $code;
				$this->Config->save($v);
			}
	    }

	    return true;
	}
}

?>
