<?php
/*****************************************************************************
 * SV-Cart ���
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: advertisement.php 5527 2009-11-05 02:07:24Z huangbo $
*****************************************************************************/
class Advertisement extends AppModel{
	var $name = 'Advertisement';
	var $hasOne = array('AdvertisementI18n'=>
						array('className'  => 'AdvertisementI18n',
							  'conditions' => '',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => 'advertisement_id'							
						),
		               'AdvertisementPosition'=>
						array('className'  => 'AdvertisementPosition',
							  'conditions' => 'Advertisement.advertisement_position_id=AdvertisementPosition.id',
							  'order'      => '',
							  'dependent'  => true,
							  'foreignKey' => ''							
						)
					);


	function set_locale($locale){
    	$conditions = " AdvertisementI18n.locale = '".$locale."'";
    	$this->hasOne['AdvertisementI18n']['conditions'] = $conditions;
        
    }
    
    function get_all($db){
	    $url = $db->server_host.substr($db->cart_webroot,0,-1);
        $str = "";
        $now = date("Y-m-d h:i:s",time());
        /* ȡ���ض����λ�¹�����Ϣ */
        $data = $this->cache_find('all',array('conditions'=>
                array(//'Advertisement.advertisement_position_id'=>$id,
        'AdvertisementI18n.start_time <='=>$now,'AdvertisementI18n.end_time >='=>$now,'Advertisement.status'=>1),'order'=>'Advertisement.orderby asc'),'advertisement_all_'.$db->locale);
        $adv_list = array();
       // pr($data);exit;
		if (!empty($data))
		{
			foreach($data as $k=>$v)
			{
                $str = '';
                $adv_url = (strpos($v['AdvertisementI18n']['url'], 'http://') === false && strpos($v['AdvertisementI18n']['url'], 'https://') === false) 
                	? $db->server_host.substr($db->cart_webroot,0,strlen($db->cart_webroot)-1). urlencode($v['AdvertisementI18n']['url'])
                	: $v['AdvertisementI18n']['url'];
                switch ($v['Advertisement']['media_type'])        
                {        
                    case '0':        
                        /* ͼƬ��� */        
                        $src = (strpos($v['AdvertisementI18n']['code'], 'http://') === false && strpos($v['AdvertisementI18n']['code'], 'https://') === false) ? $url . "{$v['AdvertisementI18n']['code']}" : $v['AdvertisementI18n']['code'];        
                       if($v['AdvertisementI18n']['url_type'] == 0){
                        $str= '<a href="'.$adv_url. '"target="_blank" title="'.$v['AdvertisementI18n']['name'].'">'.
                               '<img src="'.$src.'" border="0" alt="' .$v['AdvertisementI18n']['name'] .'" /></a>'; 
                       
                       }else{
                        $str= '<a href="'.$url.'/advertisements/url/'.$v['Advertisement']['id']. '" target="_blank" title="'.$v['AdvertisementI18n']['name'].'">'.
                               '<img src="'.$src.'" border="0" alt="' .$v['AdvertisementI18n']['name'] .'" /></a>'; 
                       }
                        break;
                
                    case '1':        
                        /* Falsh��� */        
                        $src = (strpos($v['AdvertisementI18n']['code'], 'http://') === false && strpos($v['AdvertisementI18n']['code'], 'https://')         
				        === false) ? $url.$v['AdvertisementI18n']['code'] : $v['AdvertisementI18n']['code'];
				                        $str = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"         
				        codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <param name="movie"         
				        value="'.$src.'"><param name="quality" value="high"><embed src="'.$src.'" quality="high"         
				        pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed></object>';        
                        break;        
                
                    case '2':        
                        /* ������ */        
                        $str = $v['AdvertisementI18n']['code'];        
                        break;        
                
                    case '3':        
                        /* ���ֹ�� */        
                        $str = nl2br(htmlspecialchars(addslashes($v['AdvertisementI18n']['code'])));
                    
                       if($v['AdvertisementI18n']['url_type'] == 0){
                        $str = '<a href="'.$adv_url. '" target="_blank">' .
                          nl2br(htmlspecialchars(addslashes($v['AdvertisementI18n']['code']))). '</a>';                       	   
                       }else{
                        $str = '<a href="'.$url.'/advertisements/url/'.$v['Advertisement']['id'].'" target="_blank">' .
                          nl2br(htmlspecialchars(addslashes($v['AdvertisementI18n']['code']))). '</a>';
                       }
                        
                        break;        
                }
				$adv_list[$v['Advertisement']['advertisement_position_id']][] = $str;
            } 
		}   
		
		 return $adv_list;
    }    
    
}
?>