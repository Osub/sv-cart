<?php
/*****************************************************************************
 * SV-Cart ��Ʒ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: product_category.php 2989 2009-07-17 02:03:04Z huangbo $
*****************************************************************************/
class ProductCategory extends AppModel
{
	var $name = 'ProductCategory';

	//hobby 20081120 ȡ��id=>count
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