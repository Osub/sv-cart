<?php
/*****************************************************************************
 * SV-Cart 数据库管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: database_controller.php 3113 2009-07-20 11:14:34Z huangbo $
 *****************************************************************************/
class DatabaseController extends AppController
{
    var $name='Database';
    var $components=array('RequestHandler');
    var $helpers=array('Html','Form','Javascript');
    var $uses=array("Config");
    
    var $max_size  = 2097152; // 2M
    var $is_short  = false;
    var $offset    = 300;
    var $dump_sql  = '';
    var $sql_num   = 0;
    
    function index()
    {
    	//Configure::write('debug',0);
        $this->pageTitle="数据库备份与恢复"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '数据库备份与恢复','url' => '/database/');
        $this->set('navigations',$this->navigations);

        $db =& ConnectionManager::getDataSource($useDbConfig='default');
        $tables = $db->listSources();
        $operatormenu = array(!empty($db->config['prefix'])?$db->config['prefix'].'operator_menus':'operator_menus',!empty($db->config['prefix'])?$db->config['prefix'].'operator_menu_i18ns':'operator_menu_i18ns');
        //pr($operatormenu);
        /*$mm = new Model(false,"orders");
        $mm->find("all");
        pr($mm->find("all"));
        $mm->tablePrefix = $db->config['prefix'];
        $mm->table="orders";
        */
        
       // $table_struct = $db->describe($mm);
       // pr($mm->find('all'));die();
        
        $allow_max_size = $this->return_bytes(@ini_get('upload_max_filesize')); // 单位为字节
        $allow_max_size = $allow_max_size / 1024; // 转换单位为 KB
        $sql_name = $this->get_random_name().'.sql';
        
        /* 权限检查 */
        $path = dirname(dirname(__FILE__)) . '\tmp\sqldata';
        
        if(!is_dir($path))
        {
        	mkdir($path, 0777);	
		    @chmod($path, 0777);
        }
        //$path = str_replace('\\','/',$path);
        $mask = $this->file_mode_info($path);
        $msgs = array('result' => 'OK', 'detail' => array());
        $warning = '';
        if ($mask === false)
        {
	        $this->flash("目录".$path."不存在,请手动创建" , '/database',10);
	        return false;
        }
        else if ($mask != 15)
        {
            $warning = '目录'.$path.'权限有以下问题：' . '<br/>';
            if (($mask&1) < 1)
            {
                $warning .= '不可读' . '&nbsp;&nbsp;';
            }
            if (($mask & 2) < 1)
            {
                $warning .= '不可写' . '&nbsp;&nbsp;';
            }
            if (($mask & 4) < 1)
            {
                $warning .= '追加数据' . '&nbsp;&nbsp;';
            }
            if (($mask & 8) < 1)
            {
                $warning .= '不能修改文件';
            }
            $this->flash($warning , '/database',10);
	        return false;
        }
        $this->set('vol_size', $allow_max_size);
        $this->set('sql_name',$sql_name);
        $this->set('tables',$tables);
        $this->set('operatormenu',$operatormenu);
        
    }
    
    function dumpsql()
    {
    	/* 检查目录权限 */
    	$path = dirname(dirname(__FILE__)) . '\tmp\sqldata';
    	$path = str_replace('\\','/',$path);
        $run_log = $path.'/run.log';
    	$mask = $this->file_mode_info($path);
    	$msgs = array('result' => 'OK', 'detail' => array());
        $warning = '';
        if ($mask === false)
    	{
    		$this->flash("目录".$path."不存在,请手动创建",'/database',10);
    		return false;
    	}
    	elseif ($mask != 15)
        {
    	    $warning = '目录'.$path.'权限有以下问题：' . '<br/>';
    	    if (($mask&1) < 1)
    	    {
    	        $warning .= '不可读' . '&nbsp;&nbsp;';
    	    }
    	    if (($mask & 2) < 1)
    	    {
    	        $warning .= '不可写' . '&nbsp;&nbsp;';
    	    }
    	    if (($mask & 4) < 1)
    	    {
    	        $warning .= '追加数据' . '&nbsp;&nbsp;';
    	    }
    	    if (($mask & 8) < 1)
    	    {
    	        $warning .= '不能修改文件';
    	    }
    	    $this->flash($warning ,'/database',10);
    	    return false;
    	 }
    	
    	 /* 设置最长执行时间为5分钟 */
    	 @set_time_limit(300);
    	 
    	 /* 初始化输入变量 */
    	 if($this->RequestHandler->isPost()){
    	 if (empty($this->params['form']['sql_file_name'])&&empty($name))   
    	 {   
    	     $sql_file_name = $this->get_random_name();
    	 }
    	 elseif(empty($this->params['form']['sql_file_name'])&&!empty($name)) 
    	 {
    	 	 $sql_file_name = $name;
    	 }  
    	 else 
    	 { 
    	     $sql_file_name = str_replace("0xa", '',trim($this->params['form']['sql_file_name']));//过滤0xa非法字符
    	     
    	     $pos = strpos($sql_file_name, '.sql');

    	     if ($pos !== false)   
    	     { 
    	         $sql_file_name = substr($sql_file_name, 0, $pos);   
    	     }
    	 }
    	 
    	 $max_size = empty($this->params['form']['vol_size']) ? 0 : intval($this->params['form']['vol_size']); 
    	 $vol = empty($this->params['form']['vol']) ? 1 : intval($this->params['form']['vol']); 
    	 $is_short = empty($this->params['form']['ext_insert']) ? false : true;
    	 
    	 $this->is_short = $is_short; 
    	 
    	 /* 变量验证 */   
    	 $allow_max_size = intval(@ini_get('upload_max_filesize')); //单位M
    	 if ($allow_max_size > 0 && $max_size > ($allow_max_size * 1024))   
    	 {   
    	     $max_size = $allow_max_size * 1024; //单位K   
    	 }   
    	 
    	 if ($max_size > 0) 
    	 {   
    	     $this->max_size = $max_size * 1024;
    	 }   
    	 
    	 /* 获取要备份数据列表 */
    	 $type = empty($this->params['form']['type']) ? '' : trim($this->params['form']['type']);
    	 $tables = array();   
    	 
    	 $db =& ConnectionManager::getDataSource($useDbConfig='default');
    	 
    	 switch ($type)   
    	 {   
    	     case 'full':
    	          $except = array(!empty($db->config['prefix'])?$db->config['prefix'].'sessions':'sessions');
                  $temp = $db->listSources();
                  
    	          foreach ($temp AS $table)
    	          {   
    	             if (in_array($table, $except))
    	             {   
    	                 continue;   
    	             }
    	             $table= !empty($db->config['prefix'])?trim(str_replace($db->config['prefix'],'',$table)):$table;
    	             $tables[$table] = -1;
    	             
    	          }
    	          $this->put_tables_list($run_log, $tables);
    	          $this->put_tables_list($path.'/' . $sql_file_name . '.txt', $tables);
    	          break;
    	          
    	     case 'stand':
    	     	 $temp =
  	          array('svcart_product_attributes','svcart_brands','svcart_carts','svcart_categories','svcart_category_i18ns','svcart_products','svcart_product_i18ns','svcart_product_galleries','svcart_product_gallery_i18ns','svcart_product_types','svcart_product_type_i18ns','svcart_product_relations','svcart_orders','svcart_order_actions','svcart_order_products','svcart_configs','svcart_config_i18ns','svcart_users','svcart_user_addresses','svcart_user_ranks',
'svcart_user_rank_i18ns','svcart_virtual_cards','svcart_operator_menus','svcart_operator_menu_i18ns');
    	         foreach ($temp AS $table)
    	         {  
    	             $table= !empty($db->config['prefix'])?trim(str_replace($db->config['prefix'],'',$table)):$table; 
    	             $tables[$table] = -1;   
    	         }   
    	         $this->put_tables_list($run_log, $tables);
    	         $this->put_tables_list($path.'/' . $sql_file_name . '.txt', $tables);   
    	         break;
    	     
    	     case 'min':   
    	         $temp =    
    	array('svcart_product_attributes','svcart_brands','svcart_carts','svcart_categories','svcart_category_i18ns','svcart_products','svcart_product_i18ns','svcart_product_galleries','svcart_product_gallery_i18ns','svcart_product_types','svcart_product_type_i18ns','svcart_product_relations','svcart_configs','svcart_config_i18ns','svcart_users','svcart_user_addresses','svcart_user_ranks','svcart_user_rank_i18ns','svcart_virtual_cards','svcart_operator_menus','svcart_operator_menu_i18ns');
 
    	            foreach ($temp AS $table)
    	            {
    	            	$table= !empty($db->config['prefix'])?trim(str_replace($db->config['prefix'],'',$table)):$table;
    	                $tables[$table] = -1;
    	            }
    	            $this->put_tables_list($run_log, $tables);
    	            $this->put_tables_list($path.'/' . $sql_file_name . '.txt', $tables);
    	            break;
    	        case 'custom':
    	            foreach ($this->params['form']['customtables'] AS $table)
    	            {
    	            	$table= !empty($db->config['prefix'])?trim(str_replace($db->config['prefix'],'',$table)):$table;
    	                $tables[$table] = -1;
    	            }
    	            $this->put_tables_list($run_log, $tables);
    	            $this->put_tables_list($path.'/' . $sql_file_name . '.txt', $tables);
    	            break;
    	    }
    	
    	    /* 开始备份 */
    	    $tables = $this->dump_table($run_log, $vol);
    	   
    	    if ($tables === false)
    	    {
    	        //die($dump->errorMsg());
    	    }
    	    
    	    if (empty($tables))
    	    {
    	        /* 备份结束 */
    	        if ($vol > 1)
    	        {
    	            /* 有多个文件 */
    	            if (!@$this->file_put_contents($path.'/' . $sql_file_name . '_' . $vol . '.sql', $this->dump_sql))
    	            {
    	                $this->flash("数据库导出失败",'/database',10);
    	            }
    	            else
    	            {
    	            	$this->flash("数据库导出成功",'/database',10);
    	            }
    	           
    	        }
    	        else
    	        {
    	            /* 只有一个文件 */
    	            if (!@$this->file_put_contents($path.'/' . $sql_file_name . '.sql', $this->dump_sql))
    	            {
    	            	$this->flash("数据库导出失败",'/database',10);
    	            }
    	            else
    	            {
    	            	$this->flash("数据库导出成功",'/database',10);
    	            }
    	            
    	        }
    	    }
    	    else
    	    {
    	        /* 下一个页面处理 */
    	        if (!@$this->file_put_contents($path.'/' . $sql_file_name . '_' . $vol . '.sql', $this->dump_sql))
    	        {
    	        	$this->flash("数据库导出失败",'/database',10);
    	        }
    	        else
    	        {
    	        	$this->flash("数据库导出失败",'/database',10);
    	        }
    	    }
    }
    }
    
    /*恢复备份*/
    function restore()
    {
    	$this->pageTitle="恢复备份"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '恢复备份','url' => '/restore/');
        $this->set('navigations',$this->navigations);
    	
    	
    	$list = array();
    	$path = dirname(dirname(__FILE__)) . '\tmp\sqldata';
    	$path = str_replace('\\','/',$path);
    	$path.='/';
    	
    	// 检查目录 
    	$mask = $this->file_mode_info($path);
    	if ($mask === false)
    	{
	        $this->flash("目录".$path."不存在,请手动创建" ,'/database',10);
    	    return false;
    	}
    	elseif (($mask & 1) < 1)
    	{
    	    $warning .= '不可读' . '&nbsp;&nbsp;';
    	    $this->flash($warning ,'/database',10);
    	    return false;
    	}
    	else
    	{
    	    // 获取文件列表 
    	    $real_list = array();
    	    $folder = opendir($path);
    	    while ($file = readdir($folder))
    	    {
    	        if (strpos($file,'.sql') !== false)
    	        {
    	            $real_list[] = $file;
    	        }
    	    }
    	    natsort($real_list);
    	
    	    $match = array();
    	    foreach ($real_list AS $file)
    	    {
    	        if (preg_match('/_([0-9])+\.sql$/', $file, $match))
    	        {
    	            if ($match[1] == 1)
    	            {
    	                $mark = 1;
    	            }
    	            else
    	            {
    	                $mark = 2;
    	            }
    	        }
    	        else
    	        {
    	            $mark = 0;
    	        }
    	
    	        $file_size = filesize($path . $file);
    	        $file_time = date("Y-m-d H:i:s",filectime($path . $file));
    	        $info = $this->get_head($path . $file);
    	        $list[] = array('name' => $file, 'ver' => $info['svcart_ver'], 'add_time' => $file_time, 'vol' =>
    	         "1", 'file_size' => $this->num_bitunit($file_size), 'mark' => $mark);
    	    }
    	}
    	
    	$this->set('list',$list);
    }

    /*导入备份*/
    function import($name='')
    {
    	//$is_confirm = empty($_GET['confirm']) ? false : true;
    	$file_name = empty($name) ? '': trim($name);
    	$path = dirname(dirname(__FILE__)) . '\tmp\sqldata';
    	$path = str_replace('\\','/',$path);
    	$path.='/';
    	
    	/* 设置最长执行时间为5分钟 */
    	@set_time_limit(300);

    	/* 单卷 */
    	//$info = $this->get_head($path . $file_name);
    	if ($this->sql_import($path . $file_name))    
    	{    
    	    $this->flash("数据库导入成功",'/database/restore',10); 
    	}    
    	else    
    	{    
    	     $this->flash("数据库导入失败",'/database/restore',10); 
    	}    
    }
    
    /*单个删除备份文件*/
    function remove($name)
    {
    	if (isset($name)&&!empty($name))
        {
        	$table_name = str_replace('.sql','.txt',$name);
            $path = dirname(dirname(__FILE__)) . '\tmp\sqldata';
    	    $path = str_replace('\\','/',$path);
    	    $path.='/';
    	    
            @unlink($path . $name);
            @unlink($path . $table_name);
        }
        
        $this->flash("删除成功",'/database/restore/',10);
    }
    
    /*批量删除备份文件*/
    function batch()
    {
    	$pro_names=!empty($this->params['form']['file']) ? $this->params['form']['file']: array();
    	
    	if (isset($pro_names)&&!empty($pro_names))
    	{
    	    $path = dirname(dirname(__FILE__)) . '\tmp\sqldata';
    	    $path = str_replace('\\','/',$path);
    	    $path.='/';
    	    
    	    foreach ($pro_names AS $file)
    	    {
    	        @unlink($path . $file);
    	    }
    	    $this->flash("删除成功",'/database/restore/',10);
    	}
    }
    
    /*本地上传sql文件并执行*/
    function upload_sql()
    {
    	$sql_file = dirname(dirname(__FILE__)) . '\tmp\sqldata\\';
    	$sql_file = str_replace('\\','/',$sql_file);
    	
    	$file = $this->params['form']['sqlfile'];
    	
    	// 检查上传是否成功     
    	if ((isset($file['error']) && $file['error'] > 0) || (!isset($file['error']) && $file['tmp_name']=='none'))
    	{    
    	    $this->flash("文件上传失败",'/database/restore/',10); 
    	    return false;  
    	}    
    	
    	//检查文件格式     
    	if ($file['type'] == 'application/x-zip-compressed')    
    	{    
    	    $this->flash("不支持此格式",'/database/restore/',10);
    	    return false; 
    	}    
    	
    	if (!preg_match("/\.sql$/i" , $file['name']))    
    	{    
    	    $this->flash("不是sql文件",'/database/restore/',10); 
    	    return false;
    	}    
    	
    	// 设置最长执行时间为5分钟 
    	@set_time_limit(300);
    	
    	if ($this->sql_import($sql_file.$file['name']))
    	{
    	    $this->flash("导入成功",'/database/restore/',10);
    	}
    	else
    	{
    	    $this->flash("导入失败",'/database/restore/',10);
    	}
    	
    }
    
    /*数据表优化列表*/
    function optimize()
    {
    	$this->pageTitle="数据表优化"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '数据表优化','url' => '/optimize/');
        $this->set('navigations',$this->navigations);
        
        /* 初始化数据 */
        $db =& ConnectionManager::getDataSource($useDbConfig='default');
    	
        $db_ver_arr = $this->version();
        $db_ver = $db_ver_arr;
    	
        $ret = mysql_query("SHOW TABLE STATUS");
        
        if ($ret !== false)
        {
            $row = array();
            $num = 0;
            $list= array();
            
            while ($row = mysql_fetch_assoc($ret))
            {
            	$res['Msg_text'] = '';
            	if(strpos($row['Name'], '_sessions') !== false)
            	{
            		
            		$res['Msg_text'] = 'Ignore';
                    $row['Data_free'] = 'Ignore';
            	}
            	else
                {
                    $res = $this->GetRow('CHECK TABLE ' . $row['Name']);
                    $num += $row['Data_free'];
                }
            	//pr($arr);
            	$type = $db_ver >= '4.1' ? $row['Engine'] : $row['Type'];
                $charset = $db_ver >= '4.1' ? $row['Collation'] : 'N/A';
            	$list[] = array('table' => $row['Name'], 'type' => $type, 'rec_num' => $row['Rows'], 'rec_size' =>
                sprintf("%.2f KB", $row['Data_length'] / 1024), 'rec_index' => $row['Index_length'],  
            	'rec_chip' =>$row['Data_free'], 'status' => $res['Msg_text'], 'charset' => $charset);
            }
            unset($ret);
        }
        else
        {
            return false;
        }
        
        $this->set('list',    $list);
        $this->set('num',     $num);
    }
    
    /*数据表优化*/
    function run_optimize()
    {
    	//pr($this->params);
    	
    	$tables = $this->getCol("SHOW TABLES");
    	
    	foreach ($tables AS $table)
    	{
    	    if ($row = $this->getRow('OPTIMIZE TABLE ' . $table))
    	    {
    	        // 优化出错，尝试修复 
    	        if ($row['Msg_type'] =='error' && strpos($row['Msg_text'], 'repair') !== false)
    	        {
    	        	$db =& ConnectionManager::getDataSource($useDbConfig='default');
    	            mysql_query('REPAIR TABLE ' . $table);
    	        }
    	    }
    	}
    	$this->flash("优化成功，共清理碎片".$this->params['form']['num'],'/database/optimize/',10);
    }
    
    
    /**
      *******数据库导出备份有关函数*******
    **/
    
    /*将含有单位的数字转成字节*/
    function return_bytes($val)
    {
        $val = trim($val);
        $last = strtolower($val{strlen($val)-1});
        switch($last)
        {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
    
        return $val;
    }
    
    /*返回一个随机的名字*/
    function get_random_name()
    {
        $str = '';
    
        for ($i = 0; $i < 6; $i++)
        {
            $str .= chr(mt_rand(97, 122));
        }
    
        $str .= date('Ymd');
    
        return $str;
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
    function file_mode_info($file_path)
    {
        /* 如果不存在，则不可读、不可写、不可改 */
        if (!file_exists($file_path))
        {
            return false;
        }
    
        $mark = 0;
    
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
        {
            /* 测试文件 */
            $test_file = $file_path . '/cf_test.txt';
            /* 如果是目录 */
            if (is_dir($file_path))
            {
                /* 检查目录是否可读 */
                $dir = @opendir($file_path);
                if ($dir === false)
                {
                    return $mark; //如果目录打开失败，直接返回目录不可修改、不可写、不可读
                }
                if (@readdir($dir) !== false)
                {
                    $mark ^= 1; //目录可读 001，目录不可读 000
                }
                @closedir($dir);
    
                /* 检查目录是否可写 */
                $fp = @fopen($test_file, 'wb');
                if ($fp === false)
                {
                    return $mark; //如果目录中的文件创建失败，返回不可写。
                }
                if (@fwrite($fp, 'directory access testing.') !== false)
                {
                    $mark ^= 2; //目录可写可读011，目录可写不可读 010
                }
                @fclose($fp);
    
                @unlink($test_file);
    
                /* 检查目录是否可修改 */
                $fp = @fopen($test_file, 'ab+');
                if ($fp === false)
                {
                    return $mark;
                }
                if (@fwrite($fp, "modify test.\r\n") !== false)
                {
                    $mark ^= 4;
                }
                @fclose($fp);
    
                /* 检查目录下是否有执行rename()函数的权限 */
                if (@rename($test_file, $test_file) !== false)
                {
                    $mark ^= 8;
                }
                @unlink($test_file);
            }
            /* 如果是文件 */
            elseif (is_file($file_path))
            {
                /* 以读方式打开 */
                $fp = @fopen($file_path, 'rb');
                if ($fp)
                {
                    $mark ^= 1; //可读 001
                }
                @fclose($fp);
    
                /* 试着修改文件 */
                $fp = @fopen($file_path, 'ab+');
                if ($fp && @fwrite($fp, '') !== false)
                {
                    $mark ^= 6; //可修改可写可读 111，不可修改可写可读011...
                }
                @fclose($fp);
    
                /* 检查目录下是否有执行rename()函数的权限 */
                if (@rename($test_file, $test_file) !== false)
                {
                    $mark ^= 8;
                }
            }
        }
        else
        {
            if (@is_readable($file_path))
            {
                $mark ^= 1;
            }
    
            if (@is_writable($file_path))
            {
                $mark ^= 14;
            }
        }
    
        return $mark;
    }
    
    
    /**
     *  获取指定表的定义
     *
     * @access  public
     * @param   string      $table      数据表名
     * @param   boolen      $add_drop   是否加入drop table
     *
     * @return  string      $sql
     */
     
    function get_table_df($table, $add_drop = false)
    {
        if ($add_drop)
        {
            $table_df = "DROP TABLE IF EXISTS `$table`;\r\n";
        }
        else
        {
            $table_df = '';
        }
        $db =& ConnectionManager::getDataSource('default');
        $model->tablePrefix = $db->config['prefix'];
        $model->table = $table;
        $table_struct = $db->describe($model);
        //pr($model->tablePrefix);exit();
        
        $tmp_arr = $this->getRow("SHOW CREATE TABLE `$model->tablePrefix$model->table`");
        $tmp_sql = $tmp_arr['Create Table'];
        $tmp_sql = substr($tmp_sql, 0, strrpos($tmp_sql, ")") + 1); //去除行尾定义。
    
        if ($this->version() >= '4.1')
        {
            $table_df .= $tmp_sql . " ENGINE=MyISAM DEFAULT CHARSET=utf8;\r\n";
        }
        else
        {
            $table_df .= $tmp_sql . " TYPE=MyISAM;\r\n";
        }
    
        return $table_df;
    }
    
    /**
     *  获取指定表的数据定义
     *
     * @access  public
     * @param   string      $table      表名
     * @param   int         $pos        备份开始位置
     *
     * @return  int         $post_pos   记录位置
     */
    function get_table_data($table, $pos)
    {
    	$db =& ConnectionManager::getDataSource($useDbConfig='default');
    	$taprex = $db->config['prefix'];
        $post_pos = $pos;
        
        /* 获取数据表记录总数 */
        $mm = new Model(false,$table);
        $total = $mm->find("count");

        if ($total == 0 || $pos >= $total)
        {
            /* 无须处理 */
            return -1;
        }
    
        /* 确定循环次数 */
        $cycle_time = ceil(($total-$pos) / $this->offset); //每次取offset条数。需要取的次数

        /* 循环查数据表 */
        
            /* 获取数据库数据 */
            $data = $mm->find("all");

            $data_count = count($data);
    
            $fields = array_keys($data[0]['Model']);
            //$start_sql = "INSERT INTO ".$taprex.$table." VALUES ";
            $start_sql = "INSERT INTO ".$taprex.$table." ( " . implode(", ", $fields) . " ) VALUES ";
            /* 循环将数据写入 */
            for($j=0; $j< $data_count; $j++)
            {
                $record = $data[$j]["Model"];
                $record = str_replace("'","''",$record);
    
                /* 检查是否能写入，能则写入 */
               
                    $tmp_dump_sql = $start_sql . " ('" . preg_replace("~(?:\r)?\n~s","\\n",implode("', '" , $record)) . "' );\r\n";
                  
                if (strlen($this->dump_sql) + strlen($tmp_dump_sql) > $this->max_size - 32)
                {
                    if ($this->sql_num == 0)
                    {
                        $this->dump_sql .= $tmp_dump_sql; //当是第一条记录时强制写入
                        $this->sql_num++;
                        $post_pos++;
                        if ($post_pos == $total)
                        {
                            /* 所有数据已经写完 */
                            return -1;
                        }
                    }
                    return $post_pos;
                }
                else
                {
                    $this->dump_sql .= $tmp_dump_sql;
                    $this->sql_num++; //记录sql条数
                    $post_pos++;
                }
            }
        
        /* 所有数据已经写完 */
        return -1;    
     }
    
    /**
     *  备份一个数据表
     *
     * @access  public
     * @param   string      $path       保存路径表名的文件
     * @param   int         $vol        卷标
     *
     * @return  array       $tables     未备份完的表列表
     */
    function dump_table($path, $vol)
    {
        $tables = $this->get_tables_list($path);
    
        if ($tables === false)
        {
            return false;
        }
    
        if (empty($tables))
        {
            return $tables;
        }
    
        foreach($tables as $table => $pos)
        {
          
            if ($pos == -1)
            {
                $this->sql_num +=2;
                $pos = 0;
              
            }
   
            /* 尽可能多获取数据表数据 */
            $post_pos = $this->get_table_data($table, $pos);
    
            if ($post_pos == -1)
            {
                /* 该表已经完成，清除该表 */
                unset($tables[$table]);
            }
            else
            {
                /* 该表未完成。说明将要到达上限,记录备份数据位置 */
                $tables[$table] = $post_pos;
                
                break;
            }
        }
        $this->put_tables_list($path, $tables);
    
        return $tables;
    }
    
    /**
     *  生成备份文件头部
     *
     * @access  public
     * @param   int     文件卷数
     *
     * @return  string  $str    备份文件头部
     */
    function make_head($vol)
    {
        // 系统信息
        $sys_info['os']         = PHP_OS;
        $sys_info['web_server'] = $this->get_domain();
        $sys_info['php_ver']    = PHP_VERSION;
        $sys_info['mysql_ver']  = $this->version();
        $sys_info['date']       = date('Y-m-d H:i:s');
    
        $head = "-- sv-cart SQL Dump Program\r\n".
                 "-- " . $sys_info['web_server'] . "\r\n".
                 "-- \r\n".
                 "-- DATE : ".$sys_info["date"]."\r\n".
                 "-- MYSQL SERVER VERSION : ".$sys_info['mysql_ver']."\r\n".
                 "-- PHP VERSION : ".$sys_info['php_ver']."\r\n".
                 //"-- SV-Cart VERSION : ".VERSION."\r\n".
                 "-- Vol : " . $vol . "\r\n";
    
        return $head;
    }
    /**
     *  获取备份文件信息
     *
     * @access  public
     * @param   string      $path       备份文件路径
     *
     * @return  array       $arr        信息数组
     */
    function get_head($path)
    {
        // 获取sql文件头部信息 
        $sql_info = array('date'=>'', 'mysql_ver'=> '', 'php_ver'=>0, 'svcart_ver'=>'', 'vol'=>0);
        $fp = fopen($path,'rb');
        $str = fread($fp, 250);
        fclose($fp);
        $arr = explode("\n", $str);
    
        foreach ($arr AS $val)
        {
            $pos = strpos($val, ':');
            if ($pos > 0)
            {
                $type = trim(substr($val, 0, $pos), "-\n\r\t ");
                $value = trim(substr($val, $pos+1), "/\n\r\t ");
                if ($type == 'DATE')
                {
                    $sql_info['date'] = $value;
                }
                elseif ($type == 'MYSQL SERVER VERSION')
                {
                    $sql_info['mysql_ver'] = $value;
                }
                elseif ($type == 'PHP VERSION')
                {
                    $sql_info['php_ver'] = $value;
                }
                elseif ($type == 'SV-CART VERSION')
                {
                    $sql_info['svcart_ver'] = $value;
                }
                elseif ($type == 'Vol')
                {
                    $sql_info['vol'] = $value;
                }
            }
        }
    
        return $sql_info;
    }
    /**
     *  将文件中数据表列表取出
     *
     * @access  public
     * @param   string      $path    文件路径
     *
     * @return  array       $arr    数据表列表
     */
    function get_tables_list($path)
    {
        if (!file_exists($path))
        {
            $this->flash($path .'不存在' ,'/database',10);
            return false;
        }
    	
        $arr = array();
        $str = @$this->file_get_contents($path);
    
        if (!empty($str))
        {
            $tmp_arr = explode("\n", $str);
            foreach ($tmp_arr as $val)
            {
                $val = trim ($val, "\r;");
                if (!empty($val))
                {
                    list($table, $count) = explode(':',$val);
                    $arr[$table] = $count;
                }
            }
        }
        return $arr;
        
    }
    
    /**
     *  将数据表数组写入指定文件
     *
     * @access  public
     * @param   string      $path    文件路径
     * @param   array       $arr    要写入的数据
     *
     * @return  boolen
     */
    function put_tables_list($path, $arr)
    {
        if (is_array($arr))
        {
            $str = '';
            foreach($arr as $key => $val)
            {
                $str .= $key . ':' . $val . ";\r\n";
            }
            
            if (@$this->file_put_contents($path, $str))
            {
                return true;
            }
        }
        else
        {
            $this->flash($path .'需要创建一个数组' ,'/database',10);
            return false;
        }
    }
    
    /**
     * 如果系统不存在file_get_contents函数则声明该函数
     *
     * @access  public
     * @param   string  $file
     * @return  mix
     */
    function file_get_contents($file)
    {
        if (($fp = @fopen($file, 'rb')) === false)
        {
            return false;
        }
        else
        {
            $fsize = @filesize($file);
            if ($fsize)
            {
                $contents = fread($fp, $fsize);
            }
            else
            {
                $contents = '';
            }
            fclose($fp);
    
            return $contents;
        }
    }
    
    /**
     * 如果系统不存在file_put_contents函数则声明该函数
     *
     * @access  public
     * @param   string  $file
     * @param   mix     $data
     * @return  int
     */
    function file_put_contents($file, $data, $flags = '')
    {
        $contents = (is_array($data)) ? implode('', $data) : $data;
    
        if ($flags == 'FILE_APPEND')
        {
            $mode = 'ab+';
        }
        else
        {
            $mode = 'wb';
        }
    
        if (($fp = @fopen($file, $mode)) === false)
        {
            return false;
        }
        else
        {
            $bytes = fwrite($fp, $contents);
            fclose($fp);
    
            return $bytes;
        }
    }
    
    function version()
    {
    	$config = new DATABASE_CONFIG();//实例化数据库配置类
    	$config_database = $config->default;
    	$conn = @mysql_connect($config_database['host'],$config_database['login'],$config_database['password']);
    	$is_db_selected = mysql_select_db($config_database['database'],$conn);
    	
        return mysql_get_server_info($conn);
    }
    
    /**
     * 取得当前的域名
     *
     * @access  public
     *
     * @return  string      当前的域名
     */
     /*
    function get_domain()
    {
        // 协议 
        $protocol = $this->http();
    
        // 域名或IP地址 
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
        {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        }
        elseif (isset($_SERVER['HTTP_HOST']))
        {
            $host = $_SERVER['HTTP_HOST'];
        }
        else
        {
            // 端口 
            if (isset($_SERVER['SERVER_PORT']))
            {
                $port = ':' . $_SERVER['SERVER_PORT'];
    
                if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
                {
                    $port = '';
                }
            }
            else
            {
                $port = '';
            }
    
            if (isset($_SERVER['SERVER_NAME']))
            {
                $host = $_SERVER['SERVER_NAME'] . $port;
            }
            elseif (isset($_SERVER['SERVER_ADDR']))
            {
                $host = $_SERVER['SERVER_ADDR'] . $port;
            }
        }
    
        return $protocol . $host;
    }
    */
    /**
     * 获得 SV-CART 当前环境的 URL 地址
     *
     * @access  public
     *
     * @return  void
     */
    function url()
    {
        $curr = strpos(PHP_SELF, 'admin/') !== false ?
                preg_replace('/(.*)(admin)(\/?)(.)*/i', '\1', dirname(PHP_SELF)) :
                dirname(PHP_SELF);
    
        $root = str_replace('\\', '/', $curr);
    
        if (substr($root, -1) != '/')
        {
            $root .= '/';
        }
    
        return $this->get_domain() . $root;
    }
    
    /**
     * 获得 SV-CART 当前环境的 HTTP 协议方式
     *
     * @access  public
     *
     * @return  void
     */
    function http()
    {
        return (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
    }
    
    function getRow($sql, $limited = false)
    {
    	$config = new DATABASE_CONFIG();//实例化数据库配置类
    	$config_database = $config->default;
    	$conn = @mysql_connect($config_database['host'],$config_database['login'],$config_database['password']);
    	$is_db_selected = mysql_select_db($config_database['database'],$conn);

        if ($limited == true)
        {
            $sql = trim($sql . ' LIMIT 1');
        }
        $res = mysql_query($sql,$conn) or die("error:".mysql_error());
        if ($res !== false)
        {
            return mysql_fetch_assoc($res);
        }
        else
        {
            return false;
        }
    }
    
    function getCol($sql)
    {
    	$config = new DATABASE_CONFIG();//实例化数据库配置类
    	$config_database = $config->default;
    	$conn = @mysql_connect($config_database['host'],$config_database['login'],$config_database['password']);
    	$is_db_selected = mysql_select_db($config_database['database'],$conn);
    	
        $res = mysql_query($sql,$conn) or die("error:".mysql_error());
        if ($res !== false)
        {
            $arr = array();
            while ($row = mysql_fetch_row($res))
            {
                $arr[] = $row[0];
            }
    
            return $arr;
        }
        else
        {
            return false;
        }
    }
    
    function getOne($sql, $limited = false)
    {
        $db =& ConnectionManager::getDataSource($useDbConfig='default');
    		
        $res = mysql_query($sql);
        
    	if ($res !== false) 
    	{	
    	    while ($row = mysql_fetch_row($res))	
    	    {	
    	    	if ($row !== false)	
    	        {	
                     return $row[0];    
                }    
                else    
                {    
                     return '';    
                }    
            }    
    	}	
    	else	
    	{	
    	    return false;	
    	}	
    }
    
    function getAll($sql)
    {
        $db =& ConnectionManager::getDataSource($useDbConfig='default');
    		
        $res = mysql_query($sql);
        if ($res !== false)
        {
            $arr = array();
            while ($row = mysql_fetch_assoc($res))
            {
                $arr[] = $row;
            }
    
            return $arr;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * 将字节转成可阅读格式
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function num_bitunit($num)
    {
        $bitunit = array(' B',' KB',' MB',' GB');
        for ($key = 0, $count = count($bitunit); $key < $count; $key++)
        {
           if ($num >= pow(2, 10 * $key) - 1) // 1024B 会显示为 1KB
           {
               $num_bitunit_str = (ceil($num / pow(2, 10 * $key) * 100) / 100) . " $bitunit[$key]";
           }
        }
    
        return $num_bitunit_str;
    }
    
    /*数据库导入函数*/
    function sql_import($sql_file)
    {
    	$db =& ConnectionManager::getDataSource($useDbConfig='default');
    	$table = array();
    	$tables = $this->get_tables_list(str_replace('.sql','.txt',$sql_file));

    	foreach($tables as $k => $v){
    		$table[]=$k;
    	}
    	
    	foreach($table as $vv){
    		$mm = new Model(false,$vv);
            $mm->deleteAll("1=1");
        }
        
        //$db_ver  = $this->version();
    
        $sql_str = array_filter(file($sql_file), 'remove_comment');
        $sql_str = str_replace("\r", '', implode('', $sql_str));
    
        $ret = explode(";\n", $sql_str);
        $ret_count = count($ret);
    
        /* 执行sql语句 */
        for($i = 0; $i < $ret_count; $i++)
        {
            $ret[$i] = trim($ret[$i], " \r\n;"); //剔除多余信息
            if (!empty($ret[$i]))
            {
                $db->query($ret[$i]);
            }
        }
        return true;
    }
}
function remove_comment($var)
{
    return (substr($var, 0, 2) != '--');
}
?>