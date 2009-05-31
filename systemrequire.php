<?php
/*****************************************************************************
 * SV-Cart 根
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: index.php 1422 2009-05-18 03:17:44Z tangyu $
*****************************************************************************/
	function get_system_info(){

	    $system_info = array();
	    /* 检查系统基本参数 */
	    $system_info[] = array('操作系统', PHP_OS);
	    $system_info[] = array('PHP 版本', PHP_VERSION);

	    /* 检查MYSQL支持情况 */
	    $mysql_enabled = function_exists('mysql_connect') ? '支持' : '不支持' ;
	    $system_info[] = array('是否支持MySQL', $mysql_enabled);
	    
	    /* 检查图片处理函数库 */
	    $gd_ver = get_gd_version();
	    $gd_ver = empty($gd_ver) ? "不支持" : $gd_ver;
	    $system_info[] = array('GD 版本', $gd_ver);
	    
	    /* 服务器是否安全模式开启 */
	    $safe_mode = ini_get('safe_mode') == '1' ? '开启' : '关闭';
	    $system_info[] = array('服务器是否开启安全模式', $safe_mode);
	    

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
	        if(!file_exists($dir)){
	            $msgs['result'] = 'ERROR';
	            $msgs['detail'][] = array($dir, "不存在");
	            continue;
	        }
	        if (file_mode_info($root_dir . $dir) < 2){
	            $msgs['result'] = 'ERROR';
	            $msgs['detail'][] = array($dir, "不可写");
	        }
	        else{
	            $msgs['detail'][] = array($dir, "可写");
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
$system_info = get_system_info();
$checking_dirs = array( './libs',
						'./img',
						'./libs/sv-admin/tmp',
						'./libs/sv-cart/tmp',
						'./libs/sv-user/tmp'
						);
$dir_checking = check_dirs_priv($checking_dirs);
if(!function_exists('apache_get_modules'))
	$mod_rewrite = 2;//无法确认
else if(check_mod_rewrite())
	$mod_rewrite = 1;//开启
else $mod_rewrite = 0;//未开启
$checking_result = $dir_checking['result'];
$dir_checking = $dir_checking['detail'];
if($checking_result=="ERROR" || !$mod_rewrite){}else{header('Location: ./sv-admin/tools/tools_installs/home');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="Author" content="上海实玮网络科技有限公司" />
<meta name="description" content="最好的,免费开源的,PHP电子商务平台 SV-Cart系统" />
<meta name="keywords" content="电子商务平台,免费开源,sv-cart,上海实玮,php" />
	<style>
.content{
	width:99.85%;position:relative; border:1px solid #CDCDCD;border-top:0; padding-bottom:32px; height:100%;min-width:1022px;width:expression((documentElement.clientWidth < 1022) ? "1022px" : "99.8%" );
}
.home_main{
	border:1px solid #CCCCCC;width:95%; background:#F0F0F0; margin:0 auto; padding:15px 8px 10px; height:100%;overflow:hidden;min-width:954px;width:expression((documentElement.clientWidth < 954) ? "954px" : "95%" ); 
}
#header{
	min-width:1000px;width:expression((documentElement.clientWidth < 1000) ? "1000px" : "100%" ); margin: 0 auto;
}
#header .tools{
	height:25px; background:url(../img/tools.gif) repeat-x; position:relative;
}
.tools img.left{
	position:absolute;left:0;top:0;
}
.tools img.right{
	position:absolute;right:0;top:0;
}
.tools .logo{
	padding:2px 0 0 20px;float:left;
}
.tools .toolsbar{
	text-align:right;float:right;padding:4px 10px 0 0;font-family:tahoma;color:#fff;
}
.tools .toolsbar a{
	color:#fff;
}
.tools .toolsbar span{
	margin:0 5px;
}
#footer{
	bottom:30px;margin:5px auto 0;min-width:1000px;width:expression((documentElement.clientWidth < 1000) ? "1000px" : "100%" );
}
#footer p{
	text-align:center; font-family:Arial;color:#337E4B;padding:2px 0;
}
#footer p a{color:#337E4B;}
#footer p a:hover{ text-decoration:underline;}
#footer p.pwoered a{margin-left:5px;}
/*=========================Admin Iformations ==========================*/
.informations{
	border:1px solid #E0E0E0; background:#F9F9F9; margin:0 0 10px;
}
.informations .box{
	padding:20px 60px;
}
.informations li{margin:5px 0;line-height:20px;}
.informations p.ok{text-align:center;}
.informations p.handdle a{
	color:#20A24F; text-decoration:underline;
}
.informations p strong{
	font-size:14px;
}
.informations p.handdle span{
	margin:0 10px;
}
.agree{text-align:center;}
.agree input.p{vertical-align:middle;margin-top:-2px;*margin-top:-5px;}
.agree input.button{background:url(../img/long.gif);width:144px;height:22px;border:0;font-size:12px;*padding-top:4px;cursor:pointer;}
.agree input.setup{background:url(../img/upload.gif);width:78px;}
.setup li{height:100%;overflow:hidden;position:relative;}
.setup h3{font-size:108%}
.lang{float:left;background:#fff;position:relative;zoom:1;z-index:1;}
.status{background:url(../img/bgline.gif) left 12px repeat-x;text-align:right;_position:absolute;_width:100%;left:0;zoom:1;z-index:-1;}
.status span{background:#fff;padding-left:5px;}
	</style>
<title>首页- PHP电子商务平台 SV-Cart官网 | 上海实玮 - Powered by Seevia</title>
</head>
	<body>
	<form id="js_check" method="post" action="./sv-admin/tools/tools_installs/home"><fieldset style="display:none;"><input type="hidden" name="_method" value="POST" /></fieldset>

<br />
<!--Check-->

	
	<br />
	<h3 align="center" class="green">欢迎使用SV-Cart</h3>
	<div class="box">

	
<ul class="list setup" style="width:500px;margin:0 auto"> 
	<li><h3 class="green">SV-Cart系统检测</h3></li>
    <?foreach($system_info as $v){?>
    <li>
	<div class="lang"><?php echo $v[0]?></div><div class="status"><span><?php echo $v[1]?></span></div></li>
    <?php }?>
</ul>
<ul class="list setup" style="width:500px;margin:0 auto"> 
	<li><h3 class="green">APACHE功能</h3></li>
    
    <li>
    	<?if($mod_rewrite==1){?>
    	<div class="lang">mod_rewrite</div><div class="status"><span style="color:green;">开启</span></div>
    	<?}else if($mod_rewrite==2){?>
    	<div class="lang">mod_rewrite</div><div class="status"><span style="color:red;">无法确认</span></div>
    	<?}else {?>
    	<div class="lang">mod_rewrite</div><div class="status"><span style="color:red;">未开启</span></div>
    	<?}?>
	</li>
    
</ul>
<ul class="list setup" style="width:500px;margin:0 auto"> 
	<li><h3 class="green">目录权限检测</h3></li>
    <?foreach($dir_checking as $v){?>
    <li>
    <?php if ($v[1]=="可写") {?>
	<div class="lang"><?php echo $v[0]?></div><div class="status"><span style="color:green;"><?php echo $v[1]?></span></div>
	<?php }else {?>
	<div class="lang"><?php echo $v[0]?></div><div class="status"><span style="color:red;"><?php echo $v[1]?></span></div>
	<?php }?>
	</li>
    <?php }?>
</ul>
	    </div>

<div class="agree">
	<input type="button" class="button" value="重新检查" onclick="recheck();"/>
	<?php if($checking_result=="ERROR" || !$mod_rewrite){?><input type="submit" class="button" id="js-submit"  class="button" value="下一步：配置系统"  disabled/><?php }else{?>
	<input type="submit" class="button" id="js-submit"  class="button" value="进入安装操作"  />
	<?php }?>
</div>


<!--Check End-->

</form>
<script>
function recheck(){
	window.location.href = "./systemrequire.php";
}
</script>
</body>
</html>