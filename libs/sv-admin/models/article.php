<?php
/*****************************************************************************
 * SV-Cart 文章
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: article.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class  Article extends AppModel{
	var $name = 'Article'; 
	var $hasOne = array('ArticleI18n' =>   
                      array('className'    => 'ArticleI18n', 
        					 'conditions' => '',   
                             'order'        => '',   
                             'dependent'    =>  true,   
                           'foreignKey'   => 'article_id'  
                      )   ,
        				'ArticleCategory' =>array
												(
										          'className'     => 'ArticleCategory',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'article_id'
					                        	),
                 ); 
    
    function set_locale($locale){
    	$conditions = " ArticleI18n.locale = '".$locale."'";
    	$this->hasOne['ArticleI18n']['conditions'] = $conditions;
        
    }

    /*function localeformat($id){
		$info=$this->findbyid($id);
		if(is_array($info['ArticleI18n']))
			foreach($info['ArticleI18n'] as $k => $v){
				$info['ArticleI18n'][$v['locale']]=$v;
			}
		return $info;
	} */
	
	//数组结构调整
    function localeformat($id){
		$lists=$this->findAll("Article.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Article']=$v['Article'];
				 $lists_formated['ArticleI18n'][]=$v['ArticleI18n'];
				 foreach($lists_formated['ArticleI18n'] as $key=>$val){
				 	  $lists_formated['ArticleI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
 
}
?>