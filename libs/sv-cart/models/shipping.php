<?php
/*****************************************************************************
 * SV-Cart 配送方式
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
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