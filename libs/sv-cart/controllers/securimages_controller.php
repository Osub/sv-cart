<?php
/*****************************************************************************
 * SV-Cart ��֤ͼƬ��ʾ
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ��������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * �������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: securimages_controller.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class SecurimagesController extends AppController {
	var $name = 'Securimages';
	var $uses = array();
    var $components = array ('Captcha');
    
 	function index(){
 	    $this->layout = 'blank'; //a blank layout 
        $this->set('captcha_data', $this->captcha->show()); //dynamically creates an image 
 	}
}
?>