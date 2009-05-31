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
 * $Id: svcart.php 837 2009-04-21 01:33:05Z shenyunfeng $
*****************************************************************************/

class SVshowHelper extends HTMLHelper {

	function productimagethumb($img,$link, $options = array()) {
		if($img == ""){
			$img = "/img/product_default.jpg";
		}
		
		$options["width"] =108;
		$options["height"] =108;
		return $this->link($this->image($img,$options),$link,"",false,false);
	}
	
	function price_format($price,$config){
		return sprintf($config,$price);
	}
	
	function sku_product_link($id,$name,$code,$config){
		if($config == 1){
			return "/../products/sku/".$name."/".$code;
		}else{
			return "/../products/".$id;
		}
	}

}
?>