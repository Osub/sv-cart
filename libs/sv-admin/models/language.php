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
 * $Id: language.php 3196 2009-07-22 07:17:12Z huangbo $
*****************************************************************************/
class Language extends AppModel{
	var $name = 'Language';
		function findalllang(){
		 if($this->cacheFind($this->name,'findalllang',array('backend'=>'1'))){
		 	$language = $this->cacheFind($this->name,'findalllang',array('backend'=>'1'));
		 }else{
		 	$language = $this->findAll("Language.backend = '1' ");
			$this->cacheSave($this->name,'findalllang',array('backend'=>'1'),$language);
		 }
		 return $language;
	}
}
?>