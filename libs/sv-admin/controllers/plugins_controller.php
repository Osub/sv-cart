<?php
/*****************************************************************************
 * SV-Cart 插件管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: plugins_controller.php 4366 2009-09-18 09:49:37Z huangbo $
*****************************************************************************/
class PluginsController extends AppController {

	var $name = 'Plugins';
    var $components = array ('Pagination','RequestHandler'); 
    var $helpers = array('Pagination'); 
	var $uses = array("Plugin");
	
	function index(){
		$this->pageTitle = "插件管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'功能管理','url'=>'');
		$this->navigations[] = array('name'=>'插件管理','url'=>'/plugins/');
		$this->set('navigations',$this->navigations);
		
		$plugin_list = $this->Plugin->find("all");
		$plugin_code = array();
		foreach( $plugin_list as $k=>$v ){
			$plugin_code[] = $v["Plugin"]["code"];
			$plugin_data[$v["Plugin"]["code"]] = $v;
		}
		
		$plugin_randme_dir = "../libs/sv-admin/tmp/plugin_readme/";
		$plugin_randme_arr = $this->myreaddir($plugin_randme_dir);//取目录下的文件名
		foreach( $plugin_randme_arr as $k=>$v ){
			$str_arr = $this->txt_read($plugin_randme_dir.$v,true);
			if( in_array($str_arr["code"],$plugin_code) ){
				$str_arr["status"] = 1;
				$str_arr["plugin_randme"] = $plugin_data[$str_arr["code"]]["Plugin"]["id"];
			}
			else{
				$str_arr["status"] = 0;
				$str_arr["plugin_randme"] = $v;
			}
			
			$plugin_all[] = $str_arr;
		}
	//	pr($plugin_all);
		$this->set("plugin_list",$plugin_all);
	}
	
	function add(){
		$this->pageTitle = "新增插件 - 插件管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'功能管理','url'=>'');
		$this->navigations[] = array('name'=>'插件管理','url'=>'/plugins/');
		$this->navigations[] = array('name'=>'新增插件','url'=>'');
		$this->set('navigations',$this->navigations);
		$plugin_dir = "../libs/sv-admin/tmp/pluginzip/";
		$install_dir = "../libs/sv-admin/tmp/pluginsql/";
		if(!is_dir($plugin_dir)){
			mkdir($plugin_dir, 0777);
			@chmod($plugin_dir, 0777);
		}
		if(!is_dir($install_dir)){
			mkdir($install_dir, 0777);
			@chmod($install_dir, 0777);
		}
		$fdir = opendir($plugin_dir);
		if($this->RequestHandler->isPost())
		{	
			$status = 0;
			if(!empty($_REQUEST['zipfile']))
			{	//echo $_REQUEST["zipfile"];
				$this->start_unzip($plugin_dir.$_REQUEST["zipfile"],$plugin_dir.$_REQUEST["zipfile"],0,$plugin_dir);
				$status =1;
			}
			if(!empty($_FILES['upfile']['name']))
			{	//echo $_FILES["upfile"]["tmp_name"];
				$this->start_unzip($_FILES["upfile"]["tmp_name"],$_FILES["upfile"]["name"],1,$plugin_dir);
				$upfile=$plugin_dir.$_FILES['upfile']['name'];
				//删除ZIP
    			@unlink($upfile);
				$status =1;
			}
			if($status==0){
				$this->flash("请选择插件或上传插件",'/plugins/add/',10);
			}else{
				//读取config安装信息文件
				$readme_info = $this->txt_read($plugin_dir."config.txt",true);
				foreach( $readme_info["contents"] as $k=>$v ){
					$this->move_file($plugin_dir.$k,$v);
				}
				$check_exits = $this->Plugin->find(array("code"=>$readme_info["code"],"status"=>"1"));
				if( $check_exits["Plugin"]["code"] == $readme_info["code"] ){
					$this->flash("对不起该插件已经安装请先卸载或移除后再进行解压!",'/plugins/add/',10,false);
				}else{
					$this->flash("插件  ".$readme_info["name"]." 解压成功。",'/plugins/',10);
				}
			}
		}
		while($file=readdir($fdir))
		{
			if(preg_match('/\.zip$/mis',$file))
			{
				$zip_arr[] = $file;
			}
		}
		$this->set("zip_arr",@$zip_arr);
	}
	//安装
	function install($txt){
		$plugin_randme_dir = "../libs/sv-admin/tmp/plugin_readme/";
		$install_dir = "../libs/sv-admin/tmp/pluginsql/";
		$readme_info = $this->txt_read($plugin_randme_dir.$txt,true);
		$this->Plugin->deleteAll(array("name"=>$readme_info["name"]));
		$Plugin = array(
			"name" => trim($readme_info["name"]),
			"author" => trim($readme_info["author"]),
			"directory"=>trim($readme_info["directory"]),
			"copyright"=>trim($readme_info["copyright"]),
			"version"=>trim($readme_info["version"]),
			"code"=>trim($readme_info["code"]),
			"contents"=>json_encode($readme_info["contents"]),
			"app_contents"=>json_encode(isset($readme_info["app_contents"])?$readme_info["app_contents"]:""),
			"install"=>$install_dir.trim($readme_info["install"]),
			"uninstall"=>$install_dir.trim($readme_info["uninstall"]),
			"function"=>json_encode(isset($readme_info["function"])?$readme_info["function"]:""),
			"status"=>"1"
		);
		$this->Plugin->save(array("Plugin"=>$Plugin));
		$id = $this->Plugin->getlastinsertid();
		$source_prefix = "svcart_";
		$plugin_info = $this->Plugin->findById($id);
		$target_prefix = "svcart_";
		$file_path[] = $plugin_info["Plugin"]["install"];//sql文件路径
		$install = $this->parse_sql_file($file_path,$source_prefix,$target_prefix);
		
		foreach($install as $v){
			$this->Plugin->query($v);		
		}
		//更新状态
		$this->flash("插件  ".$plugin_info["Plugin"]["name"]." 安装成功。",'/plugins/',10);
	}
	//卸载
	function uninstall($id){
		$source_prefix = "svcart_";
		$plugin_info = $this->Plugin->findById($id);
		$target_prefix = "svcart_";
		$file_path[] = $plugin_info["Plugin"]["uninstall"];//sql文件路径
	
		$uninstall = $this->parse_sql_file($file_path,$source_prefix,$target_prefix);
		foreach($uninstall as $v){
			$this->Plugin->query($v);
		}
		$this->Plugin->del($id);
		$this->flash("插件  ".$plugin_info["Plugin"]["name"]." 卸载成功。",'/plugins/',10);
	}
	//移除
	function delete_plugin($txt){
		$plugin_randme_dir = "../libs/sv-admin/tmp/plugin_readme/";
		$install_dir = "../libs/sv-admin/tmp/pluginsql/";
		$readme_info = $this->txt_read($plugin_randme_dir.$txt,true);
		foreach($readme_info["contents"] as $k=>$v){
			$this->del_dir($v);
		}
		$this->flash("插件  ".$readme_info["name"]." 移除成功。",'/plugins/',10);
	}
	//开始解压
	function start_unzip($tmp_name,$new_name,$checked,$plugin_dir)
	{
	    $upfile=array("tmp_name" => $tmp_name,"name" => $new_name);
	    if(is_file($upfile["tmp_name"]))
	    {
	        if(preg_match('/\.zip$/mis',$upfile["name"]))
	        {
	            $result=$this->unzip($upfile["tmp_name"],$plugin_dir);
	            if($result== - 1)
	            {
	                echo"<br>文件 $upfile[name] 错误.<br>";
	            }
	        }
	        else
	        {
	            echo"<br>$upfile[name] 不是 zip 文件.<br><br>";
	        }
	        if(realpath($upfile["name"])!=realpath($upfile["tmp_name"]))
	        {
	            @unlink($upfile["name"]);
	            rename($upfile["tmp_name"],$upfile["name"]);
	        }
	    }
	}
	function unzip($zn,$to,$index=Array(-1))
	{
	    $zip=@fopen($zn,'rb');
	    if(!$zip)
	    {
	        return ( - 1);
	    }
	    $cdir=$this->ReadCentralDir($zip,$zn);
	    $pos_entry=$cdir['offset'];
	    if(!is_array($index))
	    {
	        $index=array($index);
	    }

	    for($i=0; $i < $cdir['entries']; $i++)
	    {
	        @fseek($zip,$pos_entry);
	        $header=$this->ReadCentralFileHeaders($zip);
	        $header['index']=$i;
	        $pos_entry=ftell($zip);
	        @rewind($zip);
	        fseek($zip,$header['offset']);
	        if(in_array("-1",$index) || in_array($i,$index))
	        {
	            $stat[$header['filename']]=$this->ExtractFile($header,$to,$zip);
	        }
	    }
	    fclose($zip);
	    return $stat;
	}
	function ReadFileHeader($zip)
	{
	    $binary_data=fread($zip,30);
	    $data=unpack('vchk/vid/vversion/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len',$binary_data);
	    $header['filename']=fread($zip,$data['filename_len']);

	    $header['compression']=$data['compression'];
	    $header['size']=$data['size'];
	    $header['compressed_size']=$data['compressed_size'];
	    $header['crc']=$data['crc'];
	    $header['flag']=$data['flag'];
	    $header['mdate']=$data['mdate'];
	    $header['mtime']=$data['mtime'];
	    if($header['mdate'] && $header['mtime'])
	    {
	        $hour=($header['mtime'] & 0xF800) >> 11;
	        $minute=($header['mtime'] & 0x07E0) >> 5;
	        $seconde=($header['mtime'] & 0x001F) * 2;
	        $year=(($header['mdate'] & 0xFE00) >> 9) + 1980;
	        $month=($header['mdate'] & 0x01E0) >> 5;
	        $day=$header['mdate'] & 0x001F;
	        $header['mtime']=mktime($hour,$minute,$seconde,$month,$day,$year);
	    }
	    else
	    {
	        $header['mtime']=time();
	    }
	    $header['stored_filename']=$header['filename'];
	    return $header;
	}
	function ReadCentralFileHeaders($zip)
	{
	    $binary_data=fread($zip,46);
	    $header=unpack('vchkid/vid/vversion/vversion_extracted/vflag/vcompression/vmtime/vmdate/Vcrc/Vcompressed_size/Vsize/vfilename_len/vextra_len/vcomment_len/vdisk/vinternal/Vexternal/Voffset',$binary_data);
	    $header['filename']=$header['filename_len']!=0 ? fread($zip,$header['filename_len']): '';
	    return $header;
	}
	function ReadCentralDir($zip,$zip_name)
	{
	    $size=filesize($zip_name);
	    if($size < 277)
	    {
	        $maximum_size=$size;
	    }
	    else
	    {
	        $maximum_size=277;
	    }
	    @fseek($zip,$size - $maximum_size);
	    $pos=ftell($zip);
	    $bytes=0x00000000;
	    while($pos < $size)
	    {
	        $byte=@fread($zip,1);
	        $bytes=($bytes << 8) | ord($byte);
	        if($bytes==0x504b0506 or $bytes==0x2e706870504b0506)
	        {
	            $pos++;
	            break;
	        }
	        $pos++;
	    }
	    $fdata=fread($zip,18);
	    $data=@unpack('vdisk/vdisk_start/vdisk_entries/ventries/Vsize/Voffset/vcomment_size',$fdata);
	    $centd['entries']=$data['entries'];
	    $centd['offset']=$data['offset'];
	    $centd['size']=$data['size'];
	    return $centd;
	}
	function ExtractFile($header,$to,$zip)
	{
	    $header=$this->readfileheader($zip);
	    if(substr($to, - 1)!="/")
	    {
	        $to.="/";
	    }
	    if($to=='./')
	    {
	        $to='';
	    }
	    $pth=explode("/",$to.$header['filename']);
	    $mydir='';
	    for($i=0; $i < count($pth) - 1; $i++)
	    {
	        if(!$pth[$i])
	        {
	            continue;
	        }
	        $mydir .= $pth[$i]."/";
	        if((!is_dir($mydir) && @mkdir($mydir,0777)) || (($mydir==$to.$header['filename'] || $mydir==$to) && is_dir($mydir)))
	        {
	            @chmod($mydir,0777);
	        }
	    }
	    if(strrchr($header['filename'],'/')=='/')
	    {
	        return ;
	    }
	    if($header['compression']==0)
	    {
	        $fp=@fopen($to.$header['filename'],'wb');
	        if(!$fp)
	        {
	            return ( - 1);
	        }
	        $size=$header['compressed_size'];
	        while($size!=0)
	        {
	            $read_size=($size < 2048 ? $size : 2048);
	            $buffer=fread($zip,$read_size);
	            $binary_data=pack('a'.$read_size,$buffer);
	            @fwrite($fp,$binary_data,$read_size);
	            $size-=$read_size;
	        }
	        fclose($fp);
	        touch($to.$header['filename'],$header['mtime']);
	    }
	    else
	    {
	        $fp=@fopen($to.$header['filename'].'.gz','wb');
	        if(!$fp)
	        {
	            return ( - 1);
	        }
	        $binary_data=pack('va1a1Va1a1',0x8b1f,Chr($header['compression']),Chr(0x00),time(),Chr(0x00),Chr(3));
	        fwrite($fp,$binary_data,10);
	        $size=$header['compressed_size'];
	        while($size!=0)
	        {
	            $read_size=($size < 1024 ? $size : 1024);
	            $buffer=fread($zip,$read_size);
	            $binary_data=pack('a'.$read_size,$buffer);
	            @fwrite($fp,$binary_data,$read_size);
	            $size-=$read_size;
	        }
	        $binary_data=pack('VV',$header['crc'],$header['size']);
	        fwrite($fp,$binary_data,8);
	        fclose($fp);
	        $gzp=@gzopen($to.$header['filename'].'.gz','rb')or die("Cette archive est compress閑");
	        if(!$gzp)
	        {
	            return ( - 2);
	        }
	        $fp=@fopen($to.$header['filename'],'wb');
	        if(!$fp)
	        {
	            return ( - 1);
	        }
	        $size=$header['size'];
	        while($size!=0)
	        {
	            $read_size=($size < 2048 ? $size : 2048);
	            $buffer=gzread($gzp,$read_size);
	            $binary_data=pack('a'.$read_size,$buffer);
	            @fwrite($fp,$binary_data,$read_size);
	            $size-=$read_size;
	        }
	        fclose($fp);
	        gzclose($gzp);
	        touch($to.$header['filename'],$header['mtime']);
	        @unlink($to.$header['filename'].'.gz');
	    }
	    return true;
	}
	//读文件
	function txt_read($file,$mode=false){
		$fp = fopen ($file, "r");
		$buffer = "";         
		while (!feof($fp)) {          
	    	$buffer.= fgets($fp, 40960); 
		}
		fclose($fp);
		if($mode){
			$buffer = json_decode($buffer, true);
		}
		return $buffer;
	}	
	//移动文件或文件夹。如存在文件或文件夹先删除 
	//把name文件从spath移动到dpath路径
	function move_file($spath,$dpath){
		if(file_exists($spath)){
			$this->del_dir($dpath);
			$result=rename($spath,$dpath);
			if( $result == false or !file_exists($dpath) ){
				echo "文件移动失败或目的目录不存在";
			}else{
				echo "";
			}
		}else{
			echo "文件不存在，无法移动";
		}
	}
	//删除文件或文件夹
	function del_dir($pathname){
		if(file_exists($pathname)){
			if(!is_dir($pathname)){
				
				@unlink("$pathname");
				return true;
			}
			$handle = opendir($pathname);
			while(($fileordir=readdir($handle))!==false){
				if($fileordir!="."&&$fileordir!=".."){
					is_dir("$pathname/$fileordir")?$this->del_dir("$pathname/$fileordir"):unlink("$pathname/$fileordir");
				}
			}
			if(readdir($handle)==false){
				closedir($handle);
				rmdir($pathname);
			}
		}
	}
	/* 读取指定的sql文件返回sql数组 */
	function parse_sql_file($file_path,$source_prefix,$target_prefix){
    /* 如果SQL文件不存在则返回false */
        $sql = '';
        foreach($file_path as $v){
	        if (!file_exists($v)){
	            return array();
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
            return array();
        }
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
	//*****************************************************************//  
  	//函数名:myreaddir($dir)  
  	//作用:读取目录所有的文件名  
  	//参数:$dir   目录地址  
  	//返回值:文件名数组  
  	//*****************************************************************//  
  	function myreaddir($dir){  
  		$handle=opendir($dir);  
  		$i=0;  
  		while($file=readdir($handle)){  
  			if(($file!=".")and($file!="..")and($file!=".svn")){  
  				$list[$i]=$file;  
  				$i=$i+1;  
  			}  
  		}  
  		closedir($handle);    
  		return   $list;  
  	} 
}

?>