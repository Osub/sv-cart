<?php
/*****************************************************************************
 * SV-Cart ��Ʒ�ȼ�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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