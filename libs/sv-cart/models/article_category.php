<?php
/*****************************************************************************
 * SV-Cart 文章分类
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: article_category.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class ArticleCategory extends AppModel
{
	var $name = 'ArticleCategory';

	//hobby 20081120 取得id=>count
	function findcountassoc(){
		$lists=$this->find("all",array('fields' => array('id', 'count(*) as count'),"group"=>"id"));
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['ArticleCategory']['id']]=$v['0']['count'];
			}
		return $lists_formated;
	}
	//扩展分类
    function handle_other_cat($article_id, $cat_list){
    	   //查询现有的扩展分类
    	   $res=$this->findAll("ArticleCategory.article_id = ".$article_id."");
    	   $exist_list=array();
    	   foreach($res as $k=>$v){
    	   	    $exist_list[$k]=$v['ArticleCategory']['category_id'];
    	   }
    	   //删除不再有的分类
    	   $delete_list = array_diff($exist_list, $cat_list);
    	   if($delete_list){
    	   	      $condition=array("ArticleCategory.category_id"=>$delete_list,"ArticleCategory.article_id = ".$article_id."");
    	   	      $this->deleteAll($condition);
    	   }
    	   //添加新加的分类
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