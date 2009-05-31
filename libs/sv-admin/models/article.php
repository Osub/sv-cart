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
 * $Id: article.php 1841 2009-05-27 06:51:37Z huangbo $
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
    //����ṹ����
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
}
?>