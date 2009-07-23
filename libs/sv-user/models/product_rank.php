<?php
/*****************************************************************************
 * SV-Cart 商品等级
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: product_rank.php 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
class ProductRank extends AppModel
{ 
	var $name = 'ProductRank';
	var $cacheQueries = true;
	var $cacheAction = "1 day";	

	function findall_ranks(){
		$cache_key = md5('ProductRank_findall');
		$rank_price = cache::read($cache_key);	
		if(!$rank_price){
			$p_r = $this->findall();
			$rank_price = array();
			if(is_array($p_r) && sizeof($p_r)>0){
				foreach($p_r as $k=>$v){
					$rank_price[$v['ProductRank']['product_id']][$v['ProductRank']['rank_id']] = $v;
				}
			}
			cache::write($cache_key,$rank_price);	
			return $rank_price;
		}else{
			return $rank_price;
		}		
	}
	
}
?>