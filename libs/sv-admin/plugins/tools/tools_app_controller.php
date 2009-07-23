<?php
/*****************************************************************************
 * SV-CART Tools app
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: tools_app_controller.php 3053 2009-07-17 11:59:14Z huangbo $
*****************************************************************************/
class ToolsAppController extends Controller{
	var $uses = null;
	var $install_err = '';
	var $host = '';
	function beforeFilter(){
		
		Configure::write('debug', 0);
		/* rewrite 模块关闭特殊处理webroot */
		$host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
		$this->server_host = "http://".$host;
    	if(Configure::read('App.baseUrl')){
        	$this->webroot = $webroot = str_replace("index.php","",$this->base);
        	$this->root_all = str_replace( WEBROOT_DIR . '/','',$this->webroot);//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/index.php/';
        	$this->user_webroot = $this->root_all . 'user/index.php/';
        	$this->cart_webroot = $this->root_all . 'index.php/';
        }
        else{
        	$this->root_all = str_replace(WEBROOT_DIR."/","",$this->webroot);//sv-cart的根
        	$this->admin_webroot = $this->root_all . 'sv-admin/';
        	$this->user_webroot = $this->root_all . 'user/';
        	$this->cart_webroot = $this->root_all;
        }
        $this->set('root_all',$this->root_all);
        $this->set('server_host',$this->server_host);
        $this->set('admin_webroot',$this->admin_webroot);
        $this->set('user_webroot',$this->user_webroot);
        $this->set('cart_webroot',$this->cart_webroot);
		
		if(!empty($_GET['lang']))
			$lang = $_GET['lang'] == 'eng' ? 'eng': 'chi';
		else {
			$lang = $this->Session->read('install_lang');
			$lang = empty($lang) ? 'chi': $lang;
		}
		$this->Session->write('install_lang',$lang);
		include(ROOT.WEBROOT_DIR . "/plugins/tools/data/install/language/".$lang.".php");
		$this->set('local_lang',$lang);
		$this->set('lang',$_LANG);
		$this->lang = $_LANG;
	}
	/* 获取系统参数 */
	function get_system_info(){

	    $system_info = array();
	    /* 检查系统基本参数 */
	    $system_info[] = array($this->lang['php_os'], PHP_OS);
	    $system_info[] = array($this->lang['php_ver'], PHP_VERSION);

	    /* 检查MYSQL支持情况 */
	    $mysql_enabled = function_exists('mysql_connect') ? $this->lang['support'] : $this->lang['not_support'] ;
	    $system_info[] = array($this->lang['mysql'], $mysql_enabled);
	    /* 检查PostgreSQL支持情况 */
	    $pg_enabled = function_exists('pg_connect') ? $this->lang['support'] : $this->lang['not_support'] ;
	    $system_info[] = array($this->lang['postgresql'], $pg_enabled);
	    /* 检查SQLite支持情况 */
	    $sl_enabled = function_exists('sqlite_open') ? $this->lang['support'] : $this->lang['not_support'] ;
	    $system_info[] = array($this->lang['sqlite'], $sl_enabled);
	    /* 检查图片处理函数库 */
	    $gd_ver = $this->get_gd_version();
	    $gd_ver = empty($gd_ver) ? $this->lang['not_support'] : $gd_ver;
	    $system_info[] = array($this->lang['gd_version'], $gd_ver);
	    
	    /* 服务器是否安全模式开启 */
	    $safe_mode = ini_get('safe_mode') == '1' ? $this->lang['safe_mode_on'] : $this->lang['safe_mode_off'];
	    $system_info[] = array($this->lang['safe_mode'], $safe_mode);
	    

	    return $system_info;
	}
	/* 检测apache的mod_rewrite功能 */
	function check_mod_rewrite(){
		$modules = apache_get_modules();
	    if (in_array('mod_rewrite', $modules)){
	    	return true;
	    }
	    else return false;
	}
	/* 创建数据库配置文件 */
	function create_database_file($db_type, $db_host, $db_user, $db_pass, $db_name, $prefix='svcart_'){
	    //$db_host = $db_host.":".$db_port;
	    /*  创建 database 文件字符窜 */
	    if ($copy_right = $this->file_get_contents(ROOT . WEBROOT_DIR . "/plugins/tools/data/install/copy_right.php")){
	        $copy_right = preg_replace("/\<\?php|\?\>/si", '', $copy_right);
	    }
		$content = "<?php\n";
		$content .= $copy_right;
	    $content .= 'class '. "DATABASE_CONFIG {\n\n";
	    $content .= "	var \$default = array(\n";
	    $content .=	"		'driver' => '$db_type',\n";
		$content .= "		'persistent' => false,\n";
		$content .= "		'host' => '$db_host',\n";
		$content .= "		'login' => '$db_user',\n";
		$content .= "		'password' => '$db_pass',\n";
		$content .= "		'database' => '$db_name',\n";
		$content .= "		'prefix' => '$prefix',\n";
		$content .= "		'encoding' => 'UTF8'\n";
		$content .= "	);\n";
		$content .= "}\n";
	    $content .= '?>';
		/*   重载 database 文件    */
	    $fp = @fopen(ROOT . '/database.php', 'wb+');
	    if (!$fp){
			$this->install_err .= $this->lang['cannt_mk']."database.php";
			return false;
	    }
	    if (!@fwrite($fp, trim($content))){
			$this->install_err .= $this->lang['cannt_mk']."database.php";
			return false;
	    }
	    @fclose($fp);

	    return true;
	}
	/* 读取文件 */
    function file_get_contents($file){
        if (($fp = @fopen($file, 'rb')) === false){
            return false;
        }
        else{
            $fsize = @filesize($file);
            if ($fsize){
                $contents = fread($fp, $fsize);
            }
            else{
                $contents = '';
            }
            fclose($fp);

            return $contents;
        }
    }
    /* 创建数据库和表结构 */ 
    function install_table($db_type,$db_host, $db_user, $db_pw,$db_name, $db_charset,$prefix,$admin,$demo_products,$authcode,$template){
    	$source_prefix = "svcart_";
    	$target_prefix = $prefix;
		$this->install_err = "";
    	//包含cakephp核心数据库连接文件
		App::import('Core', array('ClassRegistry', 'Overloadable', 'Validation', 'Behavior', 'ConnectionManager', 'Set', 'String'));
		$_this =& ConnectionManager::getInstance();//创建静态对象
		if(!class_exists('DATABASE_CONFIG'))
			include_once(ROOT."database.php.default");//包含数据库配置类
		$_this->config = new DATABASE_CONFIG();//实例化数据库配置类
		//数据库配置
		$_this->config->default = array(
									'driver' => $db_type,
									'persistent' => false,
									'host' => $db_host,
									'login' => $db_user,
									'password' => $db_pw,
									'database' => $db_name,
									'prefix' => $target_prefix,
									'encoding' => $db_charset
								);
		//创建数据库连接
		@$db =& ConnectionManager::getDataSource('default');
		if($db->connected){
				$file_path[] = ROOT . WEBROOT_DIR . "/plugins/tools/data/install/$db_type/structure.sql";//sql文件路径
				$file_path[] = ROOT . WEBROOT_DIR . "/plugins/tools/data/install/$db_type/primary.sql";//sql文件路径
				if($demo_products){
					//die('aaa');
					$file_path[] = ROOT . WEBROOT_DIR . "/plugins/tools/data/install/$db_type/demo.sql";//sql文件路径
					xCopy(ROOT . WEBROOT_DIR . "/plugins/tools/data/install/demo",ROOT . "../img",1);
				}
				$query_items = $this->parse_sql_file($file_path,$source_prefix,$target_prefix);
	            /* 如果解析失败，则跳过 */
	            if (!$query_items){
					$this->install_err .= $this->lang['data_empty'];
					return false;
	            }
	            foreach ($query_items AS $query_item){
	                /* 如果查询项为空，则跳过 */
	                if (!$query_item){
	                    continue;
	                }

	                if (!$db->_execute($query_item)){
	                	$this->install_err .= $this->lang['sql_error'].$query_item.$db->lastError();
	                    return false;
	                }
	            }
	            /* 管理员设置 */
	            $sql = "insert into $prefix"."operators (name,password,email,actions,status,created)values('$admin[name]','$admin[pass]','$admin[email]','all',1,now())";
	            if (!$db->_execute($sql)){
	            	$this->install_err .= $this->lang['sql_error'].$db->lastError();
	            	return false;
	            }
	            /* 验证码设置 */
	            if(!empty($authcode))foreach($authcode as $k=>$v){
	            	$sql = "update $prefix"."config_i18ns set value='$v' where config_id='$k'";
		            if (!$db->_execute($sql)){
		            	$this->install_err .= $this->lang['sql_error'].$db->lastError();
		            	return false;
		            }
				}
	            /* 模板设置 */
	            if(!empty($template)){
	            	$sql = "update $prefix"."templates set name='$template[name]',template_style='$template[template_style]',url='$template[url]',status='$template[status]',is_default='$template[is_default]',author='$template[author]',version='$template[version]' where id='1'";
		            if (!$db->_execute($sql)){
		            	$this->install_err .= $this->lang['sql_error'].$db->lastError();
		            	return false;
		            }
				}
	            return true;

			
		}
		else {
			$this->install_err .= $this->lang['conn_failed'].$db->lastError();
			return false;
		}
    
    }
    /* 读取指定的sql文件返回sql数组 */
	function parse_sql_file($file_path,$source_prefix,$target_prefix){
        /* 如果SQL文件不存在则返回false */
        $sql = '';
        foreach($file_path as $v){
	        if (!file_exists($v)){
	        	$this->install_err .= "$v".$this->lang['not_exists'];
	            return false;
	        }
	        /* 读取SQL文件 */
	        $sql .= implode('', file($v));	        
        }
        /* 删除SQL注释，由于执行的是replace操作，所以不需要进行检测。下同。 */
        $sql = $this->remove_comment($sql);

        /* 删除SQL串首尾的空白符 */
        $sql = trim($sql);

        /* 如果SQL文件中没有查询语句则返回false */
        if (!$sql)
        {
            return false;
        }

        /* 替换表前缀 */
        //$sql = $this->replace_prefix($sql,$source_prefix,$target_prefix);

        /* 解析查询项 */
        $sql = str_replace("\r", '', $sql);
        $query_items = explode(";\n", $sql);

        return $query_items;
    }
    /* 去除sql注释 */
    function remove_comment($sql){
        /* 删除SQL行注释，行注释不匹配换行符 */
        $sql = preg_replace('/^\s*(?:--|#).*/m', '', $sql);

        /* 删除SQL块注释，匹配换行符，且为非贪婪匹配 */
        $sql = preg_replace('/^\s*\/\*.*?\*\//ms', '', $sql);

        return $sql;
    }
    /**
     * 替换查询串中数据表的前缀。该方法只对下列查询有效：CREATE TABLE,
     * DROP TABLE, ALTER TABLE, UPDATE, REPLACE INTO, INSERT INTO
     *
     * @access  public
     * @param   string      $sql        SQL查询串 ，$source_prefix 原前缀，$target_prefix 现前缀
     * @return  string      返回已替换掉前缀的SQL查询串。
     */
    function replace_prefix($sql,$source_prefix,$target_prefix){
        $keywords = 'CREATE\s+TABLE(?:\s+IF\s+NOT\s+EXISTS)?|'
                  . 'DROP\s+TABLE(?:\s+IF\s+EXISTS)?|'
                  . 'ALTER\s+TABLE|'
                  . 'UPDATE|'
                  . 'REPLACE\s+INTO|'
                  . 'INSERT\s+INTO';

        $pattern = '/(' . $keywords . ')(\s*)`?' . $source_prefix . '(\w+)`?(\s*)/i';
        $replacement = '\1\2`' . $target_prefix . '\3`\4';
        $sql = preg_replace($pattern, $replacement, $sql);

        $pattern = '/(UPDATE.*?WHERE)(\s*)`?' . $source_prefix . '(\w+)`?(\s*\.)/i';
        $replacement = '\1\2`' . $target_prefix . '\3`\4';
        $sql = preg_replace($pattern, $replacement, $sql);

        return $sql;
    }
    /* 写入安装锁定文件 */
    function install_lock(){
	    /* 写入安装锁定文件 */
	    $fp = @fopen(ROOT . '/install.lock', 'wb+');
	    if (!$fp)
	    {
	        $this->install_err .= $this->lang['connt_lock'];
	        return false;
	    }
	    if (!@fwrite($fp, "SV-Cart INSTALLED"))
	    {
	        $this->install_err .= $this->lang['cannt_lock'];
	        return false;
	    }
	    @fclose($fp);
    }
	/**
	 * 把一个文件从一个目录复制到另一个目录
	 *
	 * @access  public
	 * @param   string      $source    源目录
	 * @param   string      $target    目标目录
	 * @return  boolean     成功返回true，失败返回false
	 */
	function copy_files($source, $target){
		/*
	    if (!file_exists($target)){
	        if (!mkdir(rtrim($target, '/'), 0777)){
	            $this->install_err .= '无法新建目录';
	            return false;
	        }
	        @chmod($target, 0777);
	    }
	    */
	    $dir = opendir($source);
	    while (($file = @readdir($dir)) !== false){
	        if (is_file($source . $file)){
	            if (!copy($source . $file, $target . $file)){
	                $this->install_err .= $this->lang['cannt_copy_files'];
	                return false;
	            }
	            chmod($target . $file, 0777);
	        }
	    }
	    closedir($dir);

	    return true;
	}

	/**
	 * 文件或目录权限检查函数
	 *
	 * @access          public
	 * @param           string  $file_path   文件路径
	 * @param           bool    $rename_prv  是否在检查修改权限时检查执行rename()函数的权限
	 *
	 * @return          int     返回值的取值范围为{0 <= x <= 15}，每个值表示的含义可由四位二进制数组合推出。
	 *                          返回值在二进制计数法中，四位由高到低分别代表
	 *                          可执行rename()函数权限、可对文件追加内容权限、可写入文件权限、可读取文件权限。
	 */
	function file_mode_info($file_path){
	    /* 如果不存在，则不可读、不可写、不可改 */
	    if (!file_exists($file_path)){
	        return false;
	    }

	    $mark = 0;

	    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN'){
	        /* 测试文件 */
	        $test_file = $file_path . '/cf_test.txt';

	        /* 如果是目录 */
	        if (is_dir($file_path))
	        {
	            /* 检查目录是否可读 */
	            $dir = @opendir($file_path);
	            if ($dir === false){
	                return $mark; //如果目录打开失败，直接返回目录不可修改、不可写、不可读
	            }
	            if (@readdir($dir) !== false){
	                $mark ^= 1; //目录可读 001，目录不可读 000
	            }
	            @closedir($dir);

	            /* 检查目录是否可写 */
	            $fp = @fopen($test_file, 'wb');
	            if ($fp === false){
	                return $mark; //如果目录中的文件创建失败，返回不可写。
	            }
	            if (@fwrite($fp, 'directory access testing.') !== false){
	                $mark ^= 2; //目录可写可读011，目录可写不可读 010
	            }
	            @fclose($fp);

	            @unlink($test_file);

	            /* 检查目录是否可修改 */
	            $fp = @fopen($test_file, 'ab+');
	            if ($fp === false){
	                return $mark;
	            }
	            if (@fwrite($fp, "modify test.\r\n") !== false){
	                $mark ^= 4;
	            }
	            @fclose($fp);

	            /* 检查目录下是否有执行rename()函数的权限 */
	            if (@rename($test_file, $test_file) !== false){
	                $mark ^= 8;
	            }
	            @unlink($test_file);
	        }
	        /* 如果是文件 */
	        elseif (is_file($file_path)){
	            /* 以读方式打开 */
	            $fp = @fopen($file_path, 'rb');
	            if ($fp){
	                $mark ^= 1; //可读 001
	            }
	            @fclose($fp);

	            /* 试着修改文件 */
	            $fp = @fopen($file_path, 'ab+');
	            if ($fp && @fwrite($fp, '') !== false){
	                $mark ^= 6; //可修改可写可读 111，不可修改可写可读011...
	            }
	            @fclose($fp);

	            /* 检查目录下是否有执行rename()函数的权限 */
	            if (@rename($test_file, $test_file) !== false){
	                $mark ^= 8;
	            }
	        }
	    }
	    else
	    {
	        if (@is_readable($file_path)){
	            $mark ^= 1;
	        }

	        if (@is_writable($file_path)){
	            $mark ^= 14;
	        }
	    }

	    return $mark;
	}
	/**
	 * 检查目录的读写权限
	 *
	 * @access  public
	 * @param   array     $checking_dirs     目录列表
	 * @return  array     检查后的消息数组，
	 *    成功格式形如array('result' => 'OK', 'detail' => array(array($dir, $_LANG['can_write']), array(), ...))
	 *    失败格式形如array('result' => 'ERROR', 'd etail' => array(array($dir, $_LANG['cannt_write']), array(), ...))
	 */
	function check_dirs_priv($checking_dirs){
		
	    $msgs = array('result' => 'OK', 'detail' => array());

	    foreach ($checking_dirs AS $dir){
	    	$root_dir = substr(ROOT,0,-5);
	        if(!file_exists($root_dir . $dir)){
	            $msgs['result'] = 'ERROR';
	            $msgs['detail'][] = array($dir, $this->lang['not_exists']);
	            continue;
	        }
	        if ($this->file_mode_info($root_dir . $dir) < 2){
	            $msgs['result'] = 'ERROR';
	            $msgs['detail'][] = array($dir, $this->lang['cannt_write']);
	        }
	        else{
	            $msgs['detail'][] = array($dir, $this->lang['can_write']);
	        }
	    }

	    return $msgs;
	}
    /**
     * 获得服务器上的 GD 版本
     *
     * @access      public
     * @return      int         可能的值为0，1，2
     */
    function get_gd_version()
    {
        $version = -1;

        if ($version >= 0)
        {
            return $version;
        }

        if (!extension_loaded('gd'))
        {
            $version = 0;
        }
        else
        {
            // 尝试使用gd_info函数
            if (PHP_VERSION >= '4.3')
            {
                if (function_exists('gd_info'))
                {
                    $ver_info = gd_info();
                    preg_match('/\d/', $ver_info['GD Version'], $match);
                    $version = $match[0];
                }
                else
                {
                    if (function_exists('imagecreatetruecolor'))
                    {
                        $version = 2;
                    }
                    elseif (function_exists('imagecreate'))
                    {
                        $version = 1;
                    }
                }
            }
            else
            {
                if (preg_match('/phpinfo/', ini_get('disable_functions')))
                {
                    /* 如果phpinfo被禁用，无法确定gd版本 */
                    $version = 1;
                }
                else
                {
                  // 使用phpinfo函数
                   ob_start();
                   phpinfo(8);
                   $info = ob_get_contents();
                   ob_end_clean();
                   $info = stristr($info, 'gd version');
                   preg_match('/\d/', $info, $match);
                   $version = $match[0];
                }
             }
        }

        return $version;
     }
    /* 数据库备份 */
	function dump_tables($db_host,$db_user,$db_pw,$db_name,$tables,$path){
		if($link = @mysql_connect($db_host, $db_user, $db_pw)){
			mysql_select_db($db_name, $link);
			mysql_query("set names utf8");
			$str = '';
			foreach($tables as $table){
				$str .= "DROP TABLE IF EXISTS `$table`;\r\n";
				$sql = "SHOW CREATE TABLE `$table`";
				$res = mysql_query($sql);
				$row = mysql_fetch_row($res);
				$str .= $row[1].";\r\n";
				$str .= "INSERT INTO `$table` VALUES ";
				$res = mysql_query("select * from $table");
				$num = mysql_num_rows($res);
				$i = 1;
				while($row = mysql_fetch_row($res)){
					if($i>=$num){
						$str .= " ( '" . implode("', '" , $row) . "' );\r\n";
					}
					else {
						$str .= " ( '" . implode("', '" , $row) . "' ),\r\n";
					}
					$i++;
				}
			}
			file_put_contents($path, $str);
			
		}
	}
	/* 数据库升级 */
	function upgrade_tables($db_host,$db_user,$db_pw,$db_name,$file_path){
		if($link = @mysql_connect($db_host, $db_user, $db_pw)){
				mysql_select_db($db_name,$link);
				mysql_query("set names utf8");
				$source_prefix = "svcart_";
				$target_prefix = "svcart_";
				$query_items = $this->parse_sql_file($file_path,$source_prefix,$target_prefix);
	            /* 如果解析失败，则跳过 */
	            if (!$query_items){
					return ;
	            }
	            foreach ($query_items AS $query_item){
	                /* 如果查询项为空，则跳过 */
	                if (!$query_item){
	                    continue;
	                }

	                if (!mysql_query($query_item)){
	                	$this->install_err .= $query_item.mysql_error();
	                    return false;
	                }
	            }
			
		}
	}
	/* 数据库还原 */
	function rollback_tables($db_host,$db_user,$db_pw,$db_name,$file_path){
		$this->upgrade_tables($db_host,$db_user,$db_pw,$db_name,$file_path);
	}
	/* 文件字符串行模糊替换 */
	function file_row_replace($file_path,$str,$new_str){
		if($file_arr = file($file_path)){
			$file_new_str = '';
			foreach($file_arr as $k=>$v){
				if(strripos($v,$str)){
					//$file_arr[$k] = $new_str;
					$v = $new_str;
				}
				$file_new_str .= $v;
			}
			/*   重载文件    */
		    $fp = @fopen($file_path, 'wb+');
		    if (!$fp){
				return false;
		    }
		    if (!@fwrite($fp, trim($file_new_str))){
				return false;
		    }
		    @fclose($fp);
		    return true;
		}
		return false;
	}

}
/* 文件夹拷贝 */
function   xCopy($source,   $destination,   $child){    
	  //用法：    
	  //   xCopy("feiy","feiy2",1):拷贝feiy下的文件到   feiy2,包括子目录    
	  //   xCopy("feiy","feiy2",0):拷贝feiy下的文件到   feiy2,不包括子目录    
	  //参数说明：    
	  //   $source:源目录名    
	  //   $destination:目的目录名    
	  //   $child:复制时，是不是包含的子目录    
	 if(!is_dir($source)){    
		 echo("Error:the   $source   is   not   a   direction!");    
		 return   0;    
	 }    
	 if(!is_dir($destination)){    
	     mkdir($destination,0777);    
	     @chmod($destination, 0777);
	 }    
   
   
	 $handle=dir($source);    
	 while($entry=$handle->read()){    
		 if(($entry!=".")&&($entry!="..")&&($entry!=".svn")){    
		    if(is_dir($source."/".$entry)){    
		    	if($child)    
		  			xCopy($source."/".$entry,$destination."/".$entry,$child);    
		 	}    
		 	else{
		 		@copy($source."/".$entry,$destination."/".$entry);   
		 		@chmod($destination."/".$entry, 0777); 
		 	}    
		   
		 }    
	 }    
	 return   1;
}  
?>