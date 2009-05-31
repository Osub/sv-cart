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
 * $Id: attribute.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class Attribute extends AppModel
{
	var $name = 'Attribute';
	var $hasOne = array('AttributeI18n' =>   
                        array('className'    => 'AttributeI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'attribute_id'  
                        )
                  );
    
   	function set_locale($locale){
    	$conditions = " AttributeI18n.locale = '".$locale."'";
    	$this->hasOne['AttributeI18n']['conditions'] = $conditions;
        
    }
//����ҳ��ȡ�¼�������Ϣ�Լ�id���Ͻ���
/*###############--ShoGun add--######################*/
//������ϸ	
 function get_list($category_id){
		$Lists = array();
		$condition="Attribute.status ='1'";
		if($category_id!=''){
			$condition.= " AND Attribute.id in (".$category_id.")";
		}

		$Lists=$this->findAll($condition,'','orderby asc');
		return $Lists;
	}

//class_end
}
?>