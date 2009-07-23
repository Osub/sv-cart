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
 * $Id: product_downloads_controller.php 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
class ProductDownloadsController extends AppController {
	var $name = 'ProductDownloads';
	var $helpers = array('Pagination','Html'); // Added
	var $components = array('Pagination','RequestHandler','Session');
	var $uses = array('Order',"OrderProduct","ProductDownload","Product","ProductDownloadLog","Order");
 	function index($order,$product){
 		$this->page_init();
		$this->pageTitle = $this->languages['coupon']." - ".$this->configs['shop_title'];
		$this->Order->hasMany = array();
		$this->Order->hasOne = array('OrderProduct' =>
	                         array('className'     => 'OrderProduct',
	                               'conditions'    => '',
	                               'order'         => 'OrderProduct.product_id DESC',
	                               'limit'         => '',
	                               'foreignKey'    => 'order_id',
	                               'dependent'     => true,
	                               'exclusive'     => false,
	                               'finderQuery'   => '',
	                               'joinTable'=>'svcart_order_products'
	                         )
	                  );    	
		$order_exist = $this->Order->find("Order.payment_status='2' and Order.id='".$order."'and Order.user_id='".$_SESSION['User']['User']['id']."' and OrderProduct.product_id='".$product."'" );
		if($order_exist){
			$allow = $this->ProductDownloadLog->findCount("ProductDownloadLog.order_id='".$order."'and ProductDownloadLog.product_id='".$product."'and ProductDownloadLog.user_id='".$_SESSION['User']['User']['id']."'" );
			$productinfo = $this->ProductDownload->find(" ProductDownload.product_id='".$product."'");
			$now=strtotime(date('Y-n-j'));
			$i=0;
			if($productinfo['ProductDownload']['allow_downloadtimes']>0){
				if($allow>=$productinfo['ProductDownload']['allow_downloadtimes']){
					$i+=1;
				}
			}
			if($productinfo['ProductDownload']['status']=='0'){
				$i+=1;
			}			
			if(!empty($productinfo['ProductDownload']['end_time'])){
				$end_time=strtotime($productinfo['ProductDownload']['end_time'])+86400;	
				if($now>$end_time){
					$i+=1;
				}
			} 
			if(!empty($productinfo['ProductDownload']['start_time'])){
				$start_time=strtotime($productinfo['ProductDownload']['start_time']);
				if($now<$start_time){
					$i+=1;
				}
			} 									
			if($i=='0'){
				$downlog['product_id']=$product;
				$downlog['order_id']=$order;
				$downlog['user_id']=$_SESSION['User']['User']['id'];
				$downlog['download_ip']=$_SERVER["REMOTE_ADDR"];
				$downcount['download_count']=$productinfo['ProductDownload']['download_count']+1;
				$downcount['id']=$productinfo['ProductDownload']['id'];
				ob_start();
				$filename=$productinfo['ProductDownload']['url'];
				if (file_exists($filename)) {					
					$this->ProductDownloadLog->save($downlog); //下载日志
					$this->ProductDownload->save(array("ProductDownload"=>$downcount)); 
					$pathinfo=pathinfo($filename);
					$data=@file_get_contents($filename);
					$file_type = strtolower(substr(strrchr($filename,"."),1));//取得后缀	
					$filesize=@strlen($data);
					$name=basename($filename);
					@header("Content-Type:application/octet-stream");
					@header("Content-Disposition:".(strstr($_SERVER[TTP_USER_AGENT],"MSIE")?"":"attachment;")."filename=".$name);
					@header("Content-Length:$filesize");
					echo $data;
					ob_end_flush();
					die;
				}else{
					$this->flash($this->languages['no_download_permissions'],$this->server_host . $this->cart_webroot,10);
					exit;
				}			
			}else{
				$this->flash($this->languages['no_download_permissions'],$this->server_host . $this->cart_webroot,10);
			}
		}else{
			$this->flash($this->languages['no_download_permissions'],$this->server_host . $this->cart_webroot,10);
		}		
 	}
}
?>