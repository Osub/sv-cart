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
 * $Id: article.php 2988 2009-07-17 02:00:18Z huangbo $
 *****************************************************************************/
class Article extends AppModel
{
    var $name = 'Article';
    var $hasOne = array(
    		'ArticleI18n' => array('className' => 'ArticleI18n',
        							'conditions' => '', 
        							'order' => '', 
        							'dependent' => true, 
        							'foreignKey' =>'article_id'
    		)
    );
    function set_locale($locale)
    {
        $conditions = " ArticleI18n.locale = '".$locale."'";
        $this->hasOne['ArticleI18n']['conditions'] = $conditions;
    }
    //数组结构调整
    function localeformat($id)
    {
        $lists = $this->findAll("Article.id = '".$id."'");
        foreach($lists as $k => $v)
        {
            $lists_formated['Article'] = $v['Article'];
            $lists_formated['ArticleI18n'][] = $v['ArticleI18n'];
            foreach($lists_formated['ArticleI18n']as $key => $val)
            {
                $lists_formated['ArticleI18n'][$val['locale']] = $val;
            }
        }
        return $lists_formated;
    }
	function article_counts(){
		$this->hasOne = array();
    	$this->hasMany = array();
		$lists=$this->find("all",array('fields' => array('category_id', 'count(category_id) as count'),"group"=>"category_id"));
		
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Article']['category_id']]=$v['0']['count'];
			}
		//	pr($lists_formated);
		return $lists_formated;

	}

}
?>