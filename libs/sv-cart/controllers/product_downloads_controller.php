<?php
/*****************************************************************************
 * SV-Cart 下载页
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: product_downloads_controller.php 2699 2009-07-08 11:07:31Z huangbo $
*****************************************************************************/
class ProductDownloadsController extends AppController {
	var $name = 'ProductDownloads';
	var $helpers = array('Pagination','Html'); // Added
	var $components = array('Pagination','RequestHandler','Session');
	var $uses = array('Order',"OrderProduct","ProductDownload","Product","ProductDownloadLog","Order");
 
 	function download_product(){
		ob_start();
		$filename="../download/test.rar";
		if (file_exists($filename)) {
			$pathinfo=pathinfo($filename);
			$data=@file_get_contents($filename);
			$file_type = strtolower(substr(strrchr($filename,"."),1));//取得后缀	
			$filesize=@strlen($data);
			$name=basename($filename);
			@header("Content-Type:application/x-msdownload");
			@header("Content-Disposition:".(strstr($_SERVER[TTP_USER_AGENT],"MSIE")?"":"attachment;")."filename=".$name);
			@header("Content-Length:$filesize");
			echo $data;
			ob_end_flush();
			die;
		}else{
			echo "文件不存在！";
			exit;
		}
	}	
	
}

?>