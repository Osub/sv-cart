<?php
/*****************************************************************************
 * SV-Cart ��Ӧ��
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: provider.php 5195 2009-10-20 05:29:32Z huangbo $
*****************************************************************************/
class Provider extends AppModel{
	var $name = 'Provider';
	var $hasMany = array('providerProduct' =>   
                        array('className'    => 'providerProduct', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'provider_id'  
                        )
                  );
	function get_provider_list(){
		$condition['status'] = 1;
		$provider_list = $this->find("all",array("conditions"=>$condition,"fields"=>array("Provider.id,Provider.name")));
		return $provider_list;

	}
}
	

?>