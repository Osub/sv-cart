<?php
/*****************************************************************************
 * SV-Cart 商品分类
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: product_category.php 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
class ProductCategory extends AppModel
{
	var $name = 'ProductCategory';

	//hobby 20081120 取得id=>count
	function findcountassoc(){
		$lists=$this->find("all",array('fields' => array('category_id', 'count(*) as count'),"group"=>"category_id"));
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['ProductCategory']['category_id']]=$v['0']['count'];
			}
		return $lists_formated;
	}

}
?>