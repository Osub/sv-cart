<?php
/*****************************************************************************
 * SV-Cart ���·���
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: article_category.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class ArticleCategory extends AppModel
{
	var $name = 'ArticleCategory';

	//hobby 20081120 ȡ��id=>count
	function findcountassoc(){
		$lists=$this->find("all",array('fields' => array('id', 'count(*) as count'),"group"=>"id"));
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['ArticleCategory']['id']]=$v['0']['count'];
			}
		return $lists_formated;
	}
	//��չ����
    function handle_other_cat($article_id, $cat_list){
    	   //��ѯ���е���չ����
    	   $res=$this->findAll("ArticleCategory.article_id = ".$article_id."");
    	   $exist_list=array();
    	   foreach($res as $k=>$v){
    	   	    $exist_list[$k]=$v['ArticleCategory']['category_id'];
    	   }
    	   //ɾ�������еķ���
    	   $delete_list = array_diff($exist_list, $cat_list);
    	   if($delete_list){
    	   	      $condition=array("ArticleCategory.category_id"=>$delete_list,"ArticleCategory.article_id = ".$article_id."");
    	   	      $this->deleteAll($condition);
    	   }
    	   //����¼ӵķ���
    	   $add_list = array_diff($cat_list, $exist_list, array(0));
    	   foreach ($add_list AS $k=>$cat_id){
    	   	          $other_cat_info=array(
		                   'product_id'=>$product_id,
		                   'category_id'=>$add_list[$k]
		              );
		             $this->saveAll(array('ArticleCategory'=>$other_cat_info));
    	   }
       return true;
    }

}
?>