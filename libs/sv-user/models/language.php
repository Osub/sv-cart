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
 * $Id: language.php 2304 2009-06-26 07:00:53Z zhengli $
*****************************************************************************/
class Language extends AppModel
{
	var $name = 'Language';
	
	function findalllang(){
		 if($this->cacheFind($this->name,'findalllang',array('front'=>'1'))){
		 	$language = $this->cacheFind($this->name,'findalllang',array('front'=>'1'));
		 }else{
		 	$language = $this->findAll("Language.front = '1' ");
			$this->cacheSave($this->name,'findalllang',array('front'=>'1'),$language);
		 }
		 return $language;
	}
	
	
}
?>