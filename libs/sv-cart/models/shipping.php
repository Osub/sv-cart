<?php
/*****************************************************************************
 * SV-Cart ���ͷ�ʽ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: shipping.php 3134 2009-07-21 06:45:45Z huangbo $
*****************************************************************************/
class Shipping extends AppModel
{
	var $name = 'Shipping';
	var $hasOne = array('ShippingI18n'     =>array(
												  'className'    => 'ShippingI18n', 
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'shipping_id'
					                        	 ) 
                 	   );
    
    function set_locale($locale){
    	$conditions = " ShippingI18n.locale = '".$locale."'";
    	$this->hasOne['ShippingI18n']['conditions'] = $conditions;
    }
    
    function availables(){
    	$lists=$this->findall("Shipping.status = '1' ",'','Shipping.orderby asc');
    	foreach($lists as $k => $v){
    		$lists[$k]['Shipping']['fee']=0;
    		
    	}
	    return $lists;
 	}
 	
   function USPSParcelRate($weight,$dest_zip,$userName,$orig_zip) {  
	   $url = "http://Production.ShippingAPIs.com/ShippingAPI.dll";  
	   $ch = curl_init();  
	   curl_setopt($ch, CURLOPT_URL,$url);  
	   curl_setopt($ch, CURLOPT_HEADER, 1);  
	   curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	   curl_setopt($ch, CURLOPT_POST, 1);  
	   $data = "API=RateV3&XML=<RateV3Request USERID=\"$userName\"><Package ID=\"1ST\"><Service>PRIORITY</Service><ZipOrigination>$orig_zip</ZipOrigination><ZipDestination>$dest_zip</ZipDestination><Pounds>$weight</Pounds><Ounces>0</Ounces><Size>REGULAR</Size><Machinable>TRUE</Machinable></Package></RateV3Request>";  
	   curl_setopt($ch, CURLOPT_POSTFIELDS,$data);  
	   $result=curl_exec ($ch);  
	   $data = strstr($result, '<?');  
	   $xml_parser = xml_parser_create();  
	   xml_parse_into_struct($xml_parser, $data, $vals, $index);  
	   xml_parser_free($xml_parser);  
	   $params = array();  
	   $level = array();  
	   foreach ($vals as $xml_elem) {  
	       if ($xml_elem['type'] == 'open') {  
	           if (array_key_exists('attributes',$xml_elem)) {  
	               list($level[$xml_elem['level']],$extra) = array_values($xml_elem['attributes']);  
	           } else {  
	           $level[$xml_elem['level']] = $xml_elem['tag'];  
	           }  
	       }  
	       if ($xml_elem['type'] == 'complete') {  
	       $start_level = 1;  
	       $php_stmt = '$params';  
	       while($start_level < $xml_elem['level']) {  
	           $php_stmt .= '[$level['.$start_level.']]';  
	           $start_level++;  
	       }  
	       $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';  
	   	   eval($php_stmt);  
	   }  
	 }  
	 	curl_close($ch);  
	 	return $params['RATEV3RESPONSE']['1ST']['1']['RATE'];  
	}  
 	
}
?>