<?php
/*****************************************************************************
 * SV-Cart �ⲿ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: link.php 2699 2009-07-08 11:07:31Z huangbo $
*****************************************************************************/
class Link extends AppModel{
	var $name = 'Link';
	var $cacheQueries = true;
	var $cacheAction = "1 day";	
	
	var $hasOne = array('LinkI18n' =>   
                        array('className'    => 'LinkI18n', 
                              'conditions'    =>  '',
                              'order'        => 'Link.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'link_id'  
                        )
                  );
    
    function set_locale($locale){
    	$conditions = " LinkI18n.locale = '".$locale."'";
    	$this->hasOne['LinkI18n']['conditions'] = $conditions;
        
    }
    
    //����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Link.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Link']=$v['Link'];
				 $lists_formated['LinkI18n'][]=$v['LinkI18n'];
				 foreach($lists_formated['LinkI18n'] as $key=>$val){
				 	  $lists_formated['LinkI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}
	function find_link($locale){
	    	$conditions = " Link.status = '1'";
			$cache_key = md5($this->name.'_'.$locale);
			$link = cache::read($cache_key);	
			if($link){
				return $link;
			}else{
	    		$link = $this->findAll($conditions);
				cache::write($cache_key,$link);
	    		return $link;
	    	}
	}

}
?>