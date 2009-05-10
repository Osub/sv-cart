<?php
/*****************************************************************************
 * SV-Cart ��װ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: packaging.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Packaging extends AppModel{
	var $name = 'Packaging';
	var $hasOne = array('PackagingI18n' =>   
                        array('className'    => 'PackagingI18n', 
                              'conditions'    =>  '',
                              'order'        => 'Packaging.id',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'packaging_id'  
                        )
                  );
    
    function set_locale($locale){
    	$conditions = " PackagingI18n.locale = '".$locale."'";
    	$this->hasOne['PackagingI18n']['conditions'] = $conditions;
        
    }


	//����ṹ����
    function localeformat($id){
		$lists=$this->findAll("Packaging.id = '".$id."'");
	//	pr($lists);
		foreach($lists as $k => $v){
				 $lists_formated['Packaging']=$v['Packaging'];
				 $lists_formated['PackagingI18n'][]=$v['PackagingI18n'];
				 foreach($lists_formated['PackagingI18n'] as $key=>$val){
				 	  $lists_formated['PackagingI18n'][$val['locale']]=$val;
				 }
			}
	//	pr($lists_formated);
		return $lists_formated;
	}

	}
?>