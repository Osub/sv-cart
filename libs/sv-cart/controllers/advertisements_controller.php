<?php
/*****************************************************************************
 * SV-Cart 前台广告管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: advertisements_controller.php 5433 2009-10-26 09:49:14Z huangbo $
*****************************************************************************/

class AdvertisementsController extends AppController {
	var $name = 'Advertisements';
	var $helpers = array('Html');
	var $components = array('RequestHandler');
	var $uses = array('Config','Advertisement','AdvertisementI18n','AdvertisementPosition');
	
	function index(){
		$this->pageTitle = "广告代码 - ".$this->configs['shop_title'];
		$ur_heres=array();
		$ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
		$ur_heres[]=array('name'=>'广告代码','url'=>"/advertisements");
		$this->set('locations',$ur_heres);
		$this->layout = 'default_full';
	}
	
	function show($id='',$type=2){
	  //  Configure::write('debug', 0);
	    $url = $this->server_host.substr($this->cart_webroot,0,-1);

        $str = "";
        $now = date("Y-m-d h:i:s",time());

        /* 取得特定广告位下广告的信息 */
        $data = $this->Advertisement->find('all',array('conditions'=>
                array('Advertisement.advertisement_position_id'=>$id,
        'AdvertisementI18n.start_time <='=>$now,'AdvertisementI18n.end_time >='=>$now,'Advertisement.status'=>1)));
        
        
		if (!empty($data))
		{
			foreach($data as $k=>$v)
			{
                $str = '';
                switch ($v['Advertisement']['media_type'])        
                {        
                    case '0':        
                        /* 图片广告 */        
                        $src = (strpos($v['AdvertisementI18n']['code'], 'http://') === false && strpos($v['AdvertisementI18n']['code'], 'https://') === false) ? $url . "{$v['AdvertisementI18n']['code']}" : $v['AdvertisementI18n']['code'];        
                        $str= '<a href="'.$url.'/advertisements/url/'.$v['Advertisement']['id']. '" target="_blank" title="'.$v['AdvertisementI18n']['name'].'">'.
                               '<img src="'.$src.'" border="0" alt="' .$v['AdvertisementI18n']['name'] .'" /></a>'; 
                        break;
                
                    case '1':        
                        /* Falsh广告 */        
                        $src = (strpos($v['AdvertisementI18n']['code'], 'http://') === false && strpos($v['AdvertisementI18n']['code'], 'https://')         
        === false) ? $url.$v['AdvertisementI18n']['code'] : $v['AdvertisementI18n']['code'];
                        $str = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"         
        codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <param name="movie"         
        value="'.$src.'"><param name="quality" value="high"><embed src="'.$src.'" quality="high"         
        pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed></object>';        
                        break;        
                
                    case '2':        
                        /* 代码广告 */        
                        $str = $v['AdvertisementI18n']['code'];        
                        break;        
                
                    case '3':        
                        /* 文字广告 */        
                        $str = nl2br(htmlspecialchars(addslashes($v['AdvertisementI18n']['code'])));
                        $str = '<a href="'.$url.'/advertisements/url/'.$v['Advertisement']['id']. '" target="_blank">' .
                          nl2br(htmlspecialchars(addslashes($v['AdvertisementI18n']['code']))). '</a>';
                        break;        
                }
                if($type == "2"){
                	echo "document.writeln('$str');";
                }
            } 
                if($type == "1"){
                	return $str;
                }
            die();
		}
	}
	
	function url($id=0){
		
		/*更新点击次数*/
		//$ad_id = $_GET['ad_id'];
		$ad_click = $this->Advertisement->find('first',array('fields'=>array('Advertisement.id',
			                    'Advertisement.click_count','AdvertisementI18n.url'),'conditions'=>array('Advertisement.id'=>$id)));
		
		$click_num = $ad_click['Advertisement']['click_count']+1;
		$data1 = array();
		$data1 = array('Advertisement.click_count'=>$click_num);
		$this->Advertisement->updateAll($data1,array('Advertisement.id'=>$id)); //更新
        
		/* 跳转到广告的链接页面 */
		if (!empty($id))
		{
		    $uri = (strpos($ad_click['AdvertisementI18n']['url'], 'http://') === false && strpos($ad_click['AdvertisementI18n']['url'], 'https://') === false) ? 
		    $this->server_host.substr($this->cart_webroot,0,strlen($this->cart_webroot)-1).urldecode($ad_click['AdvertisementI18n']['url']) : urldecode($ad_click['AdvertisementI18n']['url']);
		}
		else
		{
	        $uri = $this->server_host.$this->cart_webroot;
		}
		
		header("Location: $uri\n");
		exit;
	}	
	/**
	 * 获得当前环境的 HTTP 协议方式
	 *
	 * @access  public
	 *
	 * @return  void
	 */
	function http()
	{
	    return (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
	}
}
?>