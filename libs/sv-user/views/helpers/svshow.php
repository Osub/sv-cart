<?php
/*****************************************************************************
 * SV-Cart svshow
 *===========================================================================
 * 版权所有上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 *不允许对程序代码以任何形式任何目的的再发布。
 *===========================================================================
 * $开发: 上海实玮$
 * $Id: svshow.php 4333 2009-09-17 10:46:57Z huangbo $
*****************************************************************************/

class SVshowHelper extends HTMLHelper {

	function productimagethumb($img,$link, $options = array(),$default_img = '',$web_url) {
		if($img == ""){
			if($default_img == ""){
				$img = "/img/product_default.jpg";
			}else{
				$img = $default_img;
			}
		}
		
	//	$options["width"] =108;
	//	$options["height"] =108;
		return $this->link($this->image($web_url.$img,$options),$link,"",false,false);
	}
	
	function price_format($price,$config){
		$price = round($price,2);
		return sprintf($config,$price);
	}
	
	function sku_product_link($id,$name,$code,$config,$server_host='',$cart_webroot=''){
		$name = str_replace(" ","-",$name);
		$name = str_replace("/","-",$name);
		if($config == 1){
			return $server_host . $cart_webroot."products/sku/".$name."/".$code;
		}else{
			return $server_host . $cart_webroot."products/".$id;
		}
	}

}
?>