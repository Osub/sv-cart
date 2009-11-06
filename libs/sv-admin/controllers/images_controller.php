<?php
/*****************************************************************************
 * SV-Cart 图片管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: images_controller.php 5493 2009-11-03 10:47:49Z huangbo $
*****************************************************************************/
class ImagesController extends AppController {

	var $name = 'Images';
	var $helpers = array('Html','Javascript');
	var $uses = array("Config");
	
	function test(){
		if(!is_dir("../img/article_categories/")){
			mkdir("../img/article_categories/", 0777);
			@chmod("../img/article_categories/", 0777);
		}
		if(!is_dir("../img/articles/")){
			mkdir("../img/articles/", 0777);
			@chmod("../img/articles/", 0777);
		}
		if(!is_dir("../img/brands/")){
			mkdir("../img/brands/", 0777);
			@chmod("../img/brands/", 0777);
		}
		if(!is_dir("../img/cards/")){
			mkdir("../img/cards/", 0777);
			@chmod("../img/cards/", 0777);
		}
		if(!is_dir("../img/home/")){
			mkdir("../img/home/", 0777);
			@chmod("../img/home/", 0777);
		}
		if(!is_dir("../img/others/")){
			mkdir("../img/others/", 0777);
			@chmod("../img/others/", 0777);
		}
		if(!is_dir("../img/packs/")){
			mkdir("../img/packs/", 0777);
			@chmod("../img/packs/", 0777);
		}
		if(!is_dir("../img/product_categories/")){
			mkdir("../img/product_categories/", 0777);
			@chmod("../img/product_categories/", 0777);
		}
		if(!is_dir("../img/products/")){
			mkdir("../img/products/", 0777);
			@chmod("../img/products/", 0777);
		}
		if(!is_dir("../img/topics/")){
			mkdir("../img/topics/", 0777);
			@chmod("../img/topics/", 0777);
		}
		if(!is_dir("../img/links/")){
			mkdir("../img/links/", 0777);
			@chmod("../img/links/", 0777);
		}
		if(!empty($_REQUEST['path'])){
			$dir = "../img".$_REQUEST['path'];
			@chmod("../img".$_REQUEST['path'], 0777);
		}else{
			$dir = "../img/";
			@chmod("../img/", 0777);
		}
		if(!empty($_REQUEST['product_categories_id'])){
			$categories = "../img".$_REQUEST['path'].$_REQUEST['product_categories_id']."/";
			@mkdir("../img".$_REQUEST['path'].$_REQUEST['product_categories_id']."/", 0777);
			@chmod("../img".$_REQUEST['path'].$_REQUEST['product_categories_id']."/".$_REQUEST['path'], 0777);
		}
		if(!empty($_REQUEST['article_categories_id'])){
			$categories = "../img".$_REQUEST['path'].$_REQUEST['article_categories_id']."/";
			@mkdir("../img".$_REQUEST['path'].$_REQUEST['article_categories_id']."/", 0777);
			@chmod("../img".$_REQUEST['path'].$_REQUEST['article_categories_id']."/".$_REQUEST['path'], 0777);
		}
		if(!empty($_REQUEST['dirname'])&&!empty($_REQUEST['path'])){
			
			$crdir = "../img".$_REQUEST['path'].$_REQUEST['dirname'];
			if(!is_dir($crdir)){
				mkdir($crdir, 0777);
				@chmod($crdir, 0777);
			}
			if($_REQUEST['path']=='/products/'){
				$crdir_detail 	= "../img".$_REQUEST['path'].$_REQUEST['dirname']."/detail";
				if(!is_dir($crdir_detail)){
					mkdir($crdir_detail, 0777);
					@chmod($crdir_detail, 0777);
				}
				$crdir_original = "../img".$_REQUEST['path'].$_REQUEST['dirname']."/original";
				if(!is_dir($crdir_original)){
					mkdir($crdir_original, 0777);
					@chmod($crdir_original, 0777);
				}
			}
		}else{
			$crdir = "../img";
		}

		//echo $dir;
		$handle=opendir($dir);   
		$i=0;
		$j=0;   
		while($file=readdir($handle)){   
			if(($file!=".")&&($file!="..")){
				if(is_dir($dir."/".$file)){  
					$list[$i]=$file;   
					$i=$i+1;   
				}else{
					$list_img[$j]=substr($dir."/".$file,2);
					$list_img_name[$j]=$file;
					$j=$j+1;
				}
			}
		}   
		closedir($handle); 
		Configure::write('debug',0);
		$results['message'] = $list;
		$results['list_img'] = $list_img;
		$results['list_img_name'] = $list_img_name;
		foreach($results as $k=>$v){
			foreach($v as $kk=>$vv){    
				if(substr($vv, -3) ==".db"||$vv ==".svn"||substr($vv, -4) ==".swf"||$vv =="downloads"||$vv =="temp"){
					$results[$k][$kk]="";
				}
				//echo $vv;
			}
		}
		array_filter($results['message']);
		for( $i=0;$i<count($results['message']);$i++ ){
			if( $results['message'][$i] != ""){
				$arr_message[] = $results['message'][$i];
			}
		}
		$results['message'] = $arr_message;
		for( $i=0;$i<count($results['list_img']);$i++ ){
			if( $results['list_img'][$i] != ""){
				$arr_list_img[] = $results['list_img'][$i];
			}
		}
		$results['list_img'] = $arr_list_img;
		
		for( $i=0;$i<count($results['list_img_name']);$i++ ){
			if( $results['list_img_name'][$i] != ""){
				$list_img_names[] = $results['list_img_name'][$i];
			}
		}
		$results['list_img_name'] = $list_img_names;
		if(count($results['list_img'])>0){
			$show_img_str = "";
			$ij = 1;
		
			$results['show_img_str'] = $show_img_str;
		}
		if(!empty($_REQUEST['article_categories_id'])||!empty($_REQUEST['product_categories_id'])){
			if(!empty($_REQUEST['article_categories_id'])){
				$categories_id = $_REQUEST['article_categories_id'];
			}
			if(!empty($_REQUEST['product_categories_id'])){
				$categories_id = $_REQUEST['product_categories_id'];
				
			}
			$results_message = $results['message'];
			for($i=0;$i<=count($results_message)-1;$i++){
				
				if($categories_id == $results_message[$i]){
					$results['message'] = "";
					$results['message'][] = $results_message[$i];
				}
			
			}
		
		}
		$this->set("results",$results);
	
	//	die(json_encode($results));
		$this->set("hosts",$this->server_host.substr($this->root_all,0,-1));
	
	}
	function index(){
		/*判断权限*/
		$this->operator_privilege('image_view');
		/*end*/
		$this->pageTitle = '图片管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'界面管理','url'=>'');
		$this->navigations[] = array('name'=>'图片管理','url'=>'/images/');
		$this->set('navigations',$this->navigations);
		
		if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
			$session_config_str = serialize($this->Session->read('Config'));
			
			$session_operator_str = serialize($this->Session->read('Operator_Info'));
			
			$session_admin_config_str = serialize($this->Session->read('Admin_Config'));
			
			$session_action_list_str = serialize($this->Session->read('Action_List'));
			$session_admin_locale_str = serialize($this->Session->read('Admin_Locale'));
			$cart_back_url = serialize($this->Session->read('cart_back_url'));
			$this->set('session_config_str',$session_config_str);
			$this->set('session_operator_str',$session_operator_str);
			$this->set('session_admin_config_str',$session_admin_config_str);
			$this->set('session_action_list_str',$session_action_list_str);
			$this->set('session_admin_locale_str',$session_admin_locale_str);
			$this->set('cart_back_url',$cart_back_url);
		} else {
		}
		if(@$_REQUEST['status']){
			$this->set('status',$_REQUEST['status']);
		
		}else{
			$this->set('status',0);
		
		}
		
	}
	//取目录名并分好文件。。。文件夹
	function treeview(){
		if(!is_dir("../img/article_categories/")){
			mkdir("../img/article_categories/", 0777);
			@chmod("../img/article_categories/", 0777);
		}
		if(!is_dir("../img/articles/")){
			mkdir("../img/articles/", 0777);
			@chmod("../img/articles/", 0777);
		}
		if(!is_dir("../img/brands/")){
			mkdir("../img/brands/", 0777);
			@chmod("../img/brands/", 0777);
		}
		if(!is_dir("../img/cards/")){
			mkdir("../img/cards/", 0777);
			@chmod("../img/cards/", 0777);
		}
		if(!is_dir("../img/home/")){
			mkdir("../img/home/", 0777);
			@chmod("../img/home/", 0777);
		}
		if(!is_dir("../img/others/")){
			mkdir("../img/others/", 0777);
			@chmod("../img/others/", 0777);
		}
		if(!is_dir("../img/packs/")){
			mkdir("../img/packs/", 0777);
			@chmod("../img/packs/", 0777);
		}
		if(!is_dir("../img/product_categories/")){
			mkdir("../img/product_categories/", 0777);
			@chmod("../img/product_categories/", 0777);
		}
		if(!is_dir("../img/products/")){
			mkdir("../img/products/", 0777);
			@chmod("../img/products/", 0777);
		}
		if(!is_dir("../img/topics/")){
			mkdir("../img/topics/", 0777);
			@chmod("../img/topics/", 0777);
		}
		if(!is_dir("../img/links/")){
			mkdir("../img/links/", 0777);
			@chmod("../img/links/", 0777);
		}
		if(!empty($_REQUEST['path'])){
			$dir = "../img".$_REQUEST['path'];
			@chmod("../img".$_REQUEST['path'], 0777);
		}else{
			$dir = "../img/";
			@chmod("../img/", 0777);
		}
		if(!empty($_REQUEST['product_categories_id'])){
			$categories = "../img".$_REQUEST['path'].$_REQUEST['product_categories_id']."/";
			@mkdir("../img".$_REQUEST['path'].$_REQUEST['product_categories_id']."/", 0777);
			@chmod("../img".$_REQUEST['path'].$_REQUEST['product_categories_id']."/".$_REQUEST['path'], 0777);
		}
		if(!empty($_REQUEST['article_categories_id'])){
			$categories = "../img".$_REQUEST['path'].$_REQUEST['article_categories_id']."/";
			@mkdir("../img".$_REQUEST['path'].$_REQUEST['article_categories_id']."/", 0777);
			@chmod("../img".$_REQUEST['path'].$_REQUEST['article_categories_id']."/".$_REQUEST['path'], 0777);
		}
		if(!empty($_REQUEST['dirname'])&&!empty($_REQUEST['path'])){
			
			$crdir = "../img".$_REQUEST['path'].$_REQUEST['dirname'];
			if(!is_dir($crdir)){
				mkdir($crdir, 0777);
				@chmod($crdir, 0777);
			}
			if($_REQUEST['path']=='/products/'){
				$crdir_detail 	= "../img".$_REQUEST['path'].$_REQUEST['dirname']."/detail";
				if(!is_dir($crdir_detail)){
					mkdir($crdir_detail, 0777);
					@chmod($crdir_detail, 0777);
				}
				$crdir_original = "../img".$_REQUEST['path'].$_REQUEST['dirname']."/original";
				if(!is_dir($crdir_original)){
					mkdir($crdir_original, 0777);
					@chmod($crdir_original, 0777);
				}
			}
		}else{
			$crdir = "../img";
		}

		//echo $dir;
		$handle=opendir($dir);   
		$i=0;
		$j=0;   
		while($file=readdir($handle)){   
			if(($file!=".")&&($file!="..")){
				if(is_dir($dir."/".$file)){  
					$list[$i]=$file;   
					$i=$i+1;   
				}else{
					$list_img[$j]=substr($dir."/".$file,2);
					$list_img_name[$j]=$file;
					$j=$j+1;
				}
			}
		}   
		closedir($handle); 
		Configure::write('debug',0);
		if(!empty($_REQUEST['dirname'])&&!empty($_REQUEST['path'])){
			$results['message'] = $_REQUEST['dirname'];
		}
		else{
			$results['message'] = $list;
		}
		$results['list_img'] = $list_img;
		$results['list_img_name'] = $list_img_name;
		foreach($results as $k=>$v){
			foreach($v as $kk=>$vv){    
				if(substr($vv, -3) ==".db"||$vv ==".svn"||substr($vv, -4) ==".swf"||$vv =="downloads"){
					$results[$k][$kk]="";
				}
				//echo $vv;
			}
		}
		array_filter($results['message']);
		for( $i=0;$i<count($results['message']);$i++ ){
			if( $results['message'][$i] != ""){
				$arr_message[] = $results['message'][$i];
			}
		}
		$results['message'] = $arr_message;
		for( $i=0;$i<count($results['list_img']);$i++ ){
			if( $results['list_img'][$i] != ""){
				$arr_list_img[] = $results['list_img'][$i];
			}
		}
		$results['list_img'] = $arr_list_img;
		
		for( $i=0;$i<count($results['list_img_name']);$i++ ){
			if( $results['list_img_name'][$i] != ""){
				$list_img_names[] = $results['list_img_name'][$i];
			}
		}
		$results['list_img_name'] = $list_img_names;
		if(count($results['list_img'])>0){
			$show_img_str = "";
			$ij = 1;
			foreach( $results['list_img'] as $k=>$v ){
				$show_img_str.='<li>';
				$show_img_str.='<a href="'.$this->server_host.substr($this->root_all,0,-1).$v.'" rel="lightbox" name="img_hide_show[]">';
				$show_img_str.='<img src="'.$this->server_host.substr($this->root_all,0,-1).$v.'" onclick="img_src_return(this)" name="'.$v.'" /></a>';
				$show_img_str.='<p><span onclick=\'javascript:listTable.edit(this,"images/pic_rename/","'.$results['list_img_name'][$k].'","'.$dir.'/")\'>'.$results['list_img_name'][$k].'</span>&nbsp&nbsp<a href="javascript:;" onclick="remove_img(\''.$v.'\')"><font color=\'\'>删除</font></a></p><div class="bg"></div></li>';
				/*
				if($ij==1){$show_img_str.='<tr>';}
				$show_img_str.='<td>';
				$show_img_str.='<table style="border: medium none ; padding-left: 30px; border-collapse: collapse; font-family: 宋体" border="1" bordercolor="#C4F9A4">';
				$show_img_str.='<tr><td colspan="2">'.'<a href="'.$this->server_host.substr($this->root_all,0,-1).$v.'" rel="lightbox" name="img_hide_show[]"><div class="box"  ><img src="'.$this->server_host.substr($this->root_all,0,-1).$v.'" onclick="img_src_return(this)" name="'.$v.'" /></div></a>'.'</td></tr>';
				$show_img_str.='<tr><td valign="top"  width="70%">'.'<a href="javascript:" ondblclick="mkname(this)" name="'.$v.'" >'.$results['list_img_name'][$k].'</a>'.'</td><td  width="30%"><input type="image"  src="'.$this->server_host.substr($this->root_all,0,-1).'/sv-admin/img/no.gif" onclick="remove_img(this)" value="'.$v.'"  />'.'</td></tr>';
				$show_img_str.='</table>';
				$show_img_str.='</td>';
				$ij++;
				if($ij==7){$show_img_str.='</tr>';$ij=1;}*/
			}
		
			$results['show_img_str'] = $show_img_str;
		}
		if(!empty($_REQUEST['article_categories_id'])||!empty($_REQUEST['product_categories_id'])){
			if(!empty($_REQUEST['article_categories_id'])){
				$categories_id = $_REQUEST['article_categories_id'];
			}
			if(!empty($_REQUEST['product_categories_id'])){
				$categories_id = $_REQUEST['product_categories_id'];
				
			}
			$results_message = $results['message'];
			for($i=0;$i<=count($results_message)-1;$i++){
				
				if($categories_id == $results_message[$i]){
					$results['message'] = "";
					$results['message'][] = $results_message[$i];
				}
			
			}
		
		}
		die(json_encode($results));
	}
	//创建目录
	function create_dir(){
		$dir = "../img".$_REQUEST['path'];
		mkdir($dir, 0777);
		@chmod($dir, 0777);
		Configure::write('debug',0);
		die();
	}
	//重命名目录
	function rename(){
		$old_name = "../".$_REQUEST['old_name'];
		$new_name = "../".$_REQUEST['new_name'];
		rename($old_name,$new_name);
		Configure::write('debug',0);
		die();
	}
	//重命名图片名
	function pic_rename(){
		$old_name = $_REQUEST['old_name'];
		$new_name = $_REQUEST['new_name'];
		rename($old_name,$new_name);
		Configure::write('debug',0);
		die();
	}

	function del_dir(){
		$dir = "../img".$_REQUEST['dir_src'];
		$dh=opendir($dir);
  		while ($file=readdir($dh)) {
	    	if($file!="." && $file!="..") {
	      		$fullpath=$dir."/".$file;
	      		if(!is_dir($fullpath)) {
	          	unlink($fullpath);
	      	} else {
	         	deldir($fullpath);
	      	}
	    	}
  		}
		closedir($dh);
 		Configure::write('debug',0);
		if(rmdir($dir)) {
  			die(true);
    	}else{
  			die(false);
    	}
	}
	//删除图片
	function remove_img(){
		if( isset($this->params['url']['img_src']) && $this->params['url']['img_src'] != '' ){
			$img_src = $this->params['url']['img_src'];
		}
		@unlink('..' . $img_src);
		Configure::write('debug',0);
		die();
	}
	function upload(){
		if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
			$session_operator_str = serialize($_SESSION['Operator_Info']);
			$Operator = serialize($_SESSION['Operator']);
			$Admin_Config = serialize($_SESSION['Admin_Config']);
			$Action_List = serialize($_SESSION['Action_List']);
			$Admin_Locale = serialize($_SESSION['Admin_Locale']);
			$this->set('Operator',$Operator);
			$this->set('Admin_Config',$Admin_Config);
			$this->set('Action_List',$Action_List);
			$this->set('Admin_Locale',$Admin_Locale);
			$this->set('session_operator_str',$session_operator_str);
		} else {
			//echo $_REQUEST['img_addr'];
			//取水印文件
			$watermark_file = $this->configs['watermark_file'];
			//取水印位置$this->configs
			$watermark_location = $this->configs['watermark_location'];
			//取水印透明度
			$watermark_transparency = $this->configs['watermark_transparency'];
			//是否加水印
			$is_watermark = $this->configs['is_watermark'];
			//上传商品图片是否保留原图	 	  	
			$retain_original_image_when_upload_products = $this->configs['retain_original_image_when_upload_products'];
			//列表缩略图宽度
			$thumbl_image_width = $this->configs['thumbl_image_width'];
			//列表缩略图高度
			$thumb_image_height = $this->configs['thumb_image_height'];
			//中图宽度
			$image_width = $this->configs['image_width'];
			//中图高度
			$image_height = $this->configs['image_height'];
			
			//处理文件目录start
			$imgname_arr 				= explode(".",$_FILES["Filedata"]["name"]);
			if(preg_match("/[\x80-\xff]./",$imgname_arr[0])){
				$img_thumb_watermark_name 	= substr(md5($_SESSION['Operator_Info']['Operator']['id']),-3).substr(md5(time()),-5);//名称
			}
			else{
				$img_thumb_watermark_name	= $imgname_arr[0];
				
			}
			
			
			$image_name 				= $img_thumb_watermark_name.".".$imgname_arr[1];//要改成的文件名
			$dir_root					= "../img".$_REQUEST['img_addr'];
			//end 
			
			//创建目录上传图片	
			if(substr($_REQUEST['img_addr'],0,9) == "/products"){
				//echo $dir_root;
				if(!is_dir($dir_root."/original/")){
					mkdir($dir_root."/original/", 0777);
					@chmod($dir_root."/original/", 0777);
				}
				if(!is_dir($dir_root."/detail/")){
					mkdir($dir_root."/detail/", 0777);
					@chmod($dir_root."/detail/", 0777);
				}
				
				move_uploaded_file($_FILES["Filedata"]["tmp_name"], iconv("UTF-8","gb2312","../img".$_REQUEST['img_addr']."/original/".$_FILES["Filedata"]["name"]));
				$upload_img_src =  "".$_REQUEST['img_addr']."/original/".$_FILES["Filedata"]["name"];
			}else{
				move_uploaded_file($_FILES["Filedata"]["tmp_name"], iconv("UTF-8","gb2312","../img".$_REQUEST['img_addr']."/".$_FILES["Filedata"]["name"]));
				$upload_img_src =  "".$_REQUEST['img_addr']."/".$_FILES["Filedata"]["name"];
			}	
			
			if(substr($_REQUEST['img_addr'],0,9) == "/products"){
				rename(iconv("UTF-8","gb2312","../img".$upload_img_src),"../img".$_REQUEST['img_addr']."/original/".$image_name);
			}else{
				rename(iconv("UTF-8","gb2312","../img".$upload_img_src),"../img".$_REQUEST['img_addr']."/".$image_name);
			}
			$upload_img_src 			= $_REQUEST['img_addr']."/".$image_name;
			$img_original 				= $dir_root."/original/".$image_name ;//原图地址
			$img_detail 				= $dir_root."/detail/";//详细图 中图地址
			$thumb 						= $dir_root."/";//缩略图地址
			
			$WaterMark_img_address 		= substr($_SERVER["DOCUMENT_ROOT"],0, -1).trim($watermark_file);//水印文件
			//商品缩略图
			if(substr($_REQUEST['img_addr'],0,9) == "/products"){
 				$image_name	= $this->make_thumb($img_original,$thumbl_image_width,$thumb_image_height,"#FFFFFF",$img_thumb_watermark_name,$thumb,$imgname_arr[1]);
	 			$image_name	= $this->make_thumb($img_original,$image_width,$image_height,"#FFFFFF",$img_thumb_watermark_name,$img_detail,$imgname_arr[1]);
	
			}
			//水印
			if( $is_watermark == 1 && substr($_REQUEST['img_addr'],0,9) == "/products"){
				$this->imageWaterMark($img_detail.$image_name,$watermark_location,$WaterMark_img_address,$watermark_transparency);
				$this->imageWaterMark($img_original,$watermark_location,$WaterMark_img_address,$watermark_transparency);
				$this->imageWaterMark($thumb.$image_name,$watermark_location,$WaterMark_img_address,$watermark_transparency);
			}
			if( $retain_original_image_when_upload_products==1){
				$show_img_str='<li>';
				$show_img_str.='<a href="'.$this->server_host.$this->root_all.'img'.$_REQUEST['img_addr']."/".$image_name.'" rel="lightbox" name="img_hide_show[]">';
				$show_img_str.='<img src="'.$this->server_host.$this->root_all.'img'.$_REQUEST['img_addr']."/".$image_name.'" name="/img'.$_REQUEST['img_addr']."/".$image_name.'" onclick="img_src_return(this)" /></a>';
				$show_img_str.='<p><span onclick=\'javascript:listTable.edit(this,"images/pic_rename/","'.$image_name.'","'.$dir_root.'/")\'>'.$image_name.'</span>&nbsp&nbsp<a href="javascript:;" onclick="remove_img(\'/img'.$upload_img_src.'\')"><font color=\'\'>删除</font></a></p><div class="bg"></div></li>';
				echo $show_img_str;
				//echo '<li><a href="'.$this->server_host.$this->root_all.'img'.$_REQUEST['img_addr']."/".$image_name.'" rel="lightbox" name="img_hide_show[]"><div class="box"  ><img src="'.$this->server_host.$this->root_all.'img'.$_REQUEST['img_addr']."/".$image_name.'" name="/img'.$_REQUEST['img_addr']."/".$image_name.'" onclick="img_src_return(this)" /></div></a><div  style=" margin:-20px   0   0   100px"><input type="image"  src="'.$this->server_host.substr($this->root_all,0,-1).'/sv-admin/img/no.gif" onclick="remove_img(this)" value="/img'.$upload_img_src.'""  /></div><span ><a href="javascript:" ondblclick="mkname(this)" name="/img'.$upload_img_src.'" >'.$image_name.'</a></span></li>';
			}elseif($retain_original_image_when_upload_products==0){
				@unlink($img_address);
			}
		
			$this->layout="ajax";
			Configure::write('debug',0);
			die();
			exit();

		}
	}

	/**
	* 创建图片的缩略图
	*
	* @param   string      $img    原始图片的路径
	* @param   int         $thumb_width  缩略图宽度
	* @param   int         $thumb_height 缩略图高度
	* @param   int         $filename 	 图片名..
	* @param   strint      $dir         指定生成图片的目录名
	* @return  mix         如果成功返回缩略图的路径，失败则返回false
	*/
	function make_thumb($img, $thumb_width = 0, $thumb_height = 0, $bgcolor='#FFFFFF',$filename,$dir,$imgname){
		//echo $filename;
		/* 检查缩略图宽度和高度是否合法 */
		if ($thumb_width == 0 && $thumb_height == 0){
			return false;
		}
		/* 检查原始文件是否存在及获得原始文件的信息 */
		$org_info = @getimagesize($img);
		if (!$org_info){
			return false;
		}
		
		$img_org = $this->img_resource($img, $org_info[2]);
		/* 原始图片以及缩略图的尺寸比例 */
		$scale_org = $org_info[0] / $org_info[1];
		/* 处理只有缩略图宽和高有一个为0的情况，这时背景和缩略图一样大 */
		if ($thumb_width == 0){
			$thumb_width = $thumb_height * $scale_org;
		}
		if ($thumb_height == 0){
			$thumb_height = $thumb_width / $scale_org;
		}

		/* 创建缩略图的标志符 */
		$img_thumb  = @imagecreatetruecolor($thumb_width, $thumb_height);//真彩

		/* 背景颜色 */
		if (empty($bgcolor)){
			$bgcolor = $bgcolor;
		}
		$bgcolor = trim($bgcolor,"#");
		sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
		$clr = imagecolorallocate($img_thumb, $red, $green, $blue);
		imagefilledrectangle($img_thumb, 0, 0, $thumb_width, $thumb_height, $clr);
		if ($org_info[0] / $thumb_width > $org_info[1] / $thumb_height){
			$lessen_width  = $thumb_width;
			$lessen_height  = $thumb_width / $scale_org;
		}else{
			/* 原始图片比较高，则以高度为准 */
			$lessen_width  = $thumb_height * $scale_org;
			$lessen_height = $thumb_height;
		}
		$dst_x = ($thumb_width  - $lessen_width)  / 2;
		$dst_y = ($thumb_height - $lessen_height) / 2;
		
		/* 将原始图片进行缩放处理 */
		imagecopyresampled($img_thumb, $img_org, $dst_x, $dst_y, 0, 0, $lessen_width, $lessen_height, $org_info[0], $org_info[1]);

		
		/* 生成文件 */
		if (function_exists('imagejpeg')){
			$filename .= ".".$imgname;
			imagejpeg($img_thumb, $dir . $filename,90);
		}elseif (function_exists('imagegif')){
			$filename .= ".".imgname;
			imagegif($img_thumb, $dir . $filename,90);
		}elseif (function_exists('imagepng')){
			$filename .= ".".$imgname;
			imagepng($img_thumb, $dir . $filename,90);
		}else{
			return false;
		}
		imagedestroy($img_thumb);
		imagedestroy($img_org);

		//确认文件是否生成
		if (file_exists($dir . $filename)){
			return  $filename;
		}else{
			return false;
		}
	}
	/*
	* 参数：
	*       $groundImage     	要加水印的图片
	*       $waterPos        	水印位置		0为随机位置；
	*                       	1为顶端居左，	2为顶端居中，	3为顶端居右；
	*                       	4为中部居左，	5为中部居中，	6为中部居右；
	*                       	7为底端居左，	8为底端居中，	9为底端居右；
	*       $waterImage      	图片水印
	*		$watermark_alpha	图片水印透明度
	*       $waterText       	文字水印
	*       $fontSize        	文字大小
	*       $textColor       	文字颜色
	*       $fontfile        	windows字体文件
	*       $xOffset         	水平偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果给水印留
	*                       	出水平方向上的边距，可以设置这个值,如：2 则表示在默认的基础上向右移2个单位,-2 表示向左移两单位
	*       $yOffset         	垂直偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果给水印留
	*                       	出垂直方向上的边距，可以设置这个值,如：2 则表示在默认的基础上向下移2个单位,-2 表示向上移两单位
	* 返回值：
	*        0   水印成功
	*        1   水印图片格式不支持
	*        2   要水印的背景图片不存在
	*        3   需要加水印的图片的长度或宽度比水印图片或文字区域还小，无法生成水印
	*        4   字体文件不存在
	*        5   水印文字颜色格式不正确
	*        6   水印背景图片格式目前不支持
	*/
	function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$watermark_alpha=50,$fontSize=44,$textColor="#6AD267",$waterText="", $fontfile='../vendors/securimage/elephant.ttf',$xOffset=0,$yOffset=0){
	
		$isWaterImage = FALSE;
		//读取水印文件
		if(!empty($waterImage) && file_exists($waterImage)){
			$isWaterImage = TRUE;
			$water_info = getimagesize($waterImage);
			$water_w     = $water_info[0];//取得水印图片的宽
			$water_h     = $water_info[1];//取得水印图片的高
			
			switch($water_info[2]){    //取得水印图片的格式  
	            case 1:$water_im = imagecreatefromgif($waterImage);break;
	            case 2:$water_im = imagecreatefromjpeg($waterImage);break;
	            case 3:$water_im = imagecreatefrompng($waterImage);break;
	            default:return 1;
	        }
	    }

	     //读取背景图片
		if(!empty($groundImage) && file_exists($groundImage)){
	        $ground_info  = getimagesize($groundImage);
	        $ground_w     = $ground_info[0];//取得背景图片的宽
	        $ground_h     = $ground_info[1];//取得背景图片的高

	        switch($ground_info[2]){    //取得背景图片的格式  
	             case 1:$ground_im = imagecreatefromgif($groundImage);break;
	             case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
	             case 3:$ground_im = imagecreatefrompng($groundImage);break;
	             default:return 1;
	         }
	     }else{
			return 2;
	     }

	     //水印位置
		if($isWaterImage){ //图片水印  
	         $w = $water_w;
	         $h = $water_h;
	         $label = "图片的";
		}else{  
	     	//文字水印
	     	
			if(!file_exists($fontfile))return 4;
				$temp 	= imagettfbbox($fontSize,0,$fontfile,$waterText);//取得使用 TrueType 字体的文本的范围
				$w 		= $temp[2] - $temp[6];
				$h 		= $temp[3] - $temp[7];
				unset($temp);
	     }
	     if( ($ground_w < $w) || ($ground_h < $h) ){
	         return 3;
	     }
	     switch($waterPos) {
	         case 0://随机
	             $posX = rand(0,($ground_w - $w));
	             $posY = rand(0,($ground_h - $h));
	             break;
	         case 1://1为顶端居左
	             $posX = 0;
	             $posY = 0;
	             break;
	         case 2://2为顶端居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = 0;
	             break;
	         case 3://3为顶端居右
	             $posX = $ground_w - $w;
	             $posY = 0;
	             break;
	         case 4://4为中部居左
	             $posX = 0;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 5://5为中部居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 6://6为中部居右
	             $posX = $ground_w - $w;
	             $posY = ($ground_h - $h) / 2;
	             break;
	         case 7://7为底端居左
	             $posX = 0;
	             $posY = $ground_h - $h;
	             break;
	         case 8://8为底端居中
	             $posX = ($ground_w - $w) / 2;
	             $posY = $ground_h - $h;
	             break;
	         case 9://9为底端居右
	             $posX = $ground_w - $w;
	             $posY = $ground_h - $h;
	             break;
	         default://随机
	             $posX = rand(0,($ground_w - $w));
	             $posY = rand(0,($ground_h - $h));
	             break;     
	     }

	     //设定图像的混色模式
	     imagealphablending($ground_im, true);
	     if($isWaterImage) { //图片水印
	         imagecopymerge($ground_im, $water_im, $posX + $xOffset, $posY + $yOffset, 0, 0, $water_w,$water_h, $watermark_alpha);//拷贝水印到目标文件         
	     }else{//文字水印
			if( !empty($textColor) && (strlen($textColor)==7) ) {
				$R = hexdec(substr($textColor,1,2));
				$G = hexdec(substr($textColor,3,2));
				$B = hexdec(substr($textColor,5));
	         }else{
				return 5;
	         }
	         imagettftext ( $ground_im, $fontSize, 0, $posX + $xOffset, $posY + $h + $yOffset, imagecolorallocate($ground_im, $R, $G, $B), $fontfile, $waterText);
	     }

	     //生成水印后的图片
	     
	     @unlink($groundImage);
	     switch($ground_info[2]) {//取得背景图片的格式
			case 1:imagegif($ground_im,$groundImage);break;
			case 2:imagejpeg($ground_im,$groundImage);break;
			case 3:imagepng($ground_im,$groundImage);break;
			default: return 6;
	     }

	     //释放内存
	     if(isset($water_info)) unset($water_info);
	     if(isset($water_im)) imagedestroy($water_im);
	     unset($ground_info);
	     imagedestroy($ground_im);
	     return 0;
	}
	/**
	* 根据来源文件的文件类型创建一个图像操作的标识符
	*
	* @param   string      $img_file   图片文件的路径
	* @param   string      $mime_type  图片文件的文件类型
	* @return  resource    如果成功则返回图像操作标志符，反之则返回错误代码
	*/
	function img_resource($img_file, $mime_type){
		switch ($mime_type){
			
			case 1:
			case 'image/gif':
			$res = imagecreatefromgif($img_file);
			break;
			
			case 2:
			case 'image/pjpeg':
			case 'image/jpeg':
			$res = imagecreatefromjpeg($img_file);
			break;

			case 3:
			case 'image/x-png':
			case 'image/png':
			$res = imagecreatefrompng($img_file);
			break;

			default:
			return false;
		}
		return $res;
	}

}

?>