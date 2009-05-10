<?php
/*****************************************************************************
 * SV-Cart ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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
	
	//����ṹ����
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