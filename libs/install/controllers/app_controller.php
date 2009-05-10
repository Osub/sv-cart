<?php
/*****************************************************************************
 * SV-Cart 后台控制
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: app_controller.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class AppController extends Controller {
	var $install_err = '';
	function get_system_info(){

	    $system_info = array();
	    /* 检查系统基本参数 */
	    $system_info[] = array('操作系统', PHP_OS);
	    $system_info[] = array('PHP 版本', PHP_VERSION);

	    /* 检查MYSQL支持情况 */
	    $mysql_enabled = function_exists('mysql_connect') ? '支持' : '不支持' ;
	    $system_info[] = array('是否支持MySQL', $mysql_enabled);

	    /* 服务器是否安全模式开启 */
	    $safe_mode = ini_get('safe_mode') == '1' ? '开启' : '关闭';
	    $system_info[] = array('服务器是否开启安全模式', $safe_mode);

	    return $system_info;
	}
	function check_mod_rewrite(){
		$modules = apache_get_modules();
	    if (in_array('mod_rewrite', $modules)){
	    	return true;
	    }
	    else return false;
	}
	/* 创建数据库配置文件 */
	function create_database_file($db_host, $db_user, $db_pass, $db_name, $prefix='svcart_'){
	    //$db_host = $db_host.":".$db_port;
	    /*  创建 database 文件字符窜 */
	    if ($copy_right = $this->file_get_contents(ROOT .'install/data/copy_right.php')){
	        $copy_right = preg_replace("/\<\?php|\?\>/si", '', $copy_right);
	    }
		$content = "<?php\n";
		$content .= $copy_right;
	    $content .= 'class '. "DATABASE_CONFIG {\n\n";
	    $content .= "	var \$default = array(\n";
	    $content .=	"		'driver' => 'mysql',\n";
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
			$this->install_err .= "无法创建database.php";
			return false;
	    }
	    if (!@fwrite($fp, trim($content))){
			$this->install_err .= "无法创建database.php";
			return false;
	    }
	    @fclose($fp);

	    return true;
	}
	//读取文件
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
    //创建数据库和表结构 
    function install_table($db_host, $db_user, $db_pw,$db_name, $db_charset,$prefix,$admin,$demo_products){
    	$source_prefix = "svcart_";
    	$target_prefix = $prefix;
		$this->install_err = "";
		if(!@mysql_connect($db_host, $db_user, $db_pw)) {
			
			$this->install_err .= "没能连上数据库,错误信息：\n".mysql_error();
			return false;
		} else {

			$curr_mysql_version = mysql_get_server_info();

			if(!$db_name) {
				$this->install_err .= "库名不能为空";
				return false;
			}
			if($curr_mysql_version > '4.1') {
				mysql_query("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET $db_charset");
			} else {
				mysql_query("CREATE DATABASE IF NOT EXISTS `$db_name`");
			}
			if(mysql_errno()) {
				$this->install_err .= mysql_error();
				return false;
			} else {
				mysql_select_db($db_name);
				mysql_query("set names utf8");
				$file_path[] = ROOT . "install/data/structure.sql";//sql文件路径
				$file_path[] = ROOT . "install/data/primary.sql";//sql文件路径
				if($demo_products){
					//die('aaa');
					$file_path[] = ROOT . "install/data/demo.sql";//sql文件路径
					xCopy(ROOT . "install/data/demo",ROOT . "../img",1);
				}
				$query_items = $this->parse_sql_file($file_path,$source_prefix,$target_prefix);
	            /* 如果解析失败，则跳过 */
	            if (!$query_items){
					$this->install_err .= "数据为空";
					return false;
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
	            $sql = "REPLACE into $prefix"."operators (id,name,password,email,actions,status,created)values(1,'$admin[name]','$admin[pass]','$admin[email]','all',1,now())";
	            if (!mysql_query($sql)){
	            	$this->install_err .= mysql_error();
	            	return false;
	            }
	            $this->install_lock();//安装上锁

			}
		}
    
    }
	function parse_sql_file($file_path,$source_prefix,$target_prefix){
        /* 如果SQL文件不存在则返回false */
        $sql = '';
        foreach($file_path as $v){
	        if (!file_exists($v)){
	        	$this->install_err .= "$v"."不存在";
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
    function install_lock(){
	    /* 写入安装锁定文件 */
	    $fp = @fopen(ROOT . '/install.lock', 'wb+');
	    if (!$fp)
	    {
	        $this->install_err .= "无法创建install.lock，无法进行安装上锁";
	        return false;
	    }
	    if (!@fwrite($fp, "SV-Cart INSTALLED"))
	    {
	        $this->install_err .= "无法创建install.lock，无法进行安装上锁";
	        return false;
	    }
	    @fclose($fp);
    }
    function check_install_lock(){
    	if(file_exists(ROOT . '/install.lock')){
	        $this->install_err .= "install.lock文件已存在，要想重复安装，请手动删除文件:/libs/install.lock 然后刷新本页面";
	        return true;
	    }
	    return false;
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
	                $this->install_err .= '无法拷贝文件';
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
	            $msgs['detail'][] = array($dir, "不存在");
	            continue;
	        }
	        if ($this->file_mode_info($root_dir . $dir) < 2){
	            $msgs['result'] = 'ERROR';
	            $msgs['detail'][] = array($dir, "不可写");
	        }
	        else{
	            $msgs['detail'][] = array($dir, "可写");
	        }
	    }

	    return $msgs;
	}

}
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
	 }    
   
   
	 $handle=dir($source);    
	 while($entry=$handle->read()){    
		 if(($entry!=".")&&($entry!="..")){    
		    if(is_dir($source."/".$entry)){    
		    	if($child)    
		  			xCopy($source."/".$entry,$destination."/".$entry,$child);    
		 	}    
		 	else{
		 		@copy($source."/".$entry,$destination."/".$entry);    
		 	}    
		   
		 }    
	 }    
	 return   1;    
}  
?>