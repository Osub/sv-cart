<?php
/*****************************************************************************
 * SV-Cart 商品属性
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: attributes_controller.php 1250 2009-05-07 13:59:20Z huangbo $
*****************************************************************************/
class AttributesController extends AppController {
	var $name = 'Attributes';
	var $uses = array("ProductTypeAttribute","ProductAttribute","ProductType");
 
	function index(){
	}
/*------------------------------------------------------ */
//-- 取得商品属性列表
/*------------------------------------------------------ */
function get_attr_list($cat_id, $product_id = 0){
	 /* if(empty($cat_id)){
	  	   $attr_cat=$this->ProductType->find();
	  	   $cat_id=$attr_cat['ProductType']['id'];
	  }*/
	  // 查询属性值及商品的属性值
	  $condition="ProductTypeAttribute.product_type_id = ".intval($cat_id)." ";
	  $this->ProductTypeAttribute->set_locale($this->locale);
	  $lists=$this->ProductTypeAttribute->findAll($condition);
	  //调整数据格式
	  //pr($lists);
	  return $lists;
}
}

?>