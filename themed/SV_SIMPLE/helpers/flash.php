<?php 
/*****************************************************************************
 * SV-Cart flash
 *===========================================================================
 * ��Ȩ�����Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 *---------------------------------------------------------------------------
 *�ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 *������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 *===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: flash.php 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/

class FlashHelper extends AppHelper {    
    var $helpers = array('Javascript');
    var $options = array(
        'width' => 100,
        'height' => 100
    );
    var $defaultVersionRequirement = '9.0.0';
    var $initialized = false;
    function init($options = array()) {
        if (!empty($options)) {
            $this->options = am($this->options, $options);
        }
        $this->initialized = true;
        $view =& ClassRegistry::getObject('view'); 
        if (is_object($view)) { 
            $view->addScript($this->Javascript->link('swfobject')); 
            return true;
        } else {
            return $this->Javascript->link('swfobject');
        }
    }
    
    function renderSwf($swfFile, $width = null, $height = null, $divDomId = false, $options = array()) {
        $options = am ($this->options, $options);        
        if (is_null($width)) {
            $width = $options['width'];
        }
        if (is_null($height)) {
            $height = $options['height'];
        }
        $ret = '';
        if (!$this->initialized) {
            $init = $this->init($options);
            if (is_string($init)) {
                $ret = $init;
            }
            $this->initialized = TRUE;
        }        
        $flashvars = '{}';
        $params =  '{wmode : "opaque"}';
        $attributes = '{}';
        if (isset($options['flashvars'])) {
            $flashvars = $this->Javascript->object($options['flashvars']);
        }
        if (isset($options['params'])) {
            $params = $this->Javascript->object($options['params']);
        }
        if (isset($options['attributes'])) {
            $attributes = $this->Javascript->object($options['attributes']);
        }
    
        if ($divDomId === false) {
            $divDomId = uniqid('c_');
            $ret .= '<div id="'.$divDomId.'"></div>';
        }
        if (isset($options['version'])) {
            $version = $options['version'];
        } else {
            $version = $this->defaultVersionRequirement;            
        }
        if (isset($options['install'])) {
            $install = $options['install'];
        } else {
            $install =  '';            
        }
        
        $swfLocation = $this->webroot.$swfFile;
        $ret .= $this->Javascript->codeBlock(
            'swfobject.embedSWF("'.$swfLocation.'", "'.$divDomId.'", "'.$width.'", "'.$height.'", "'.$version.'","'.$install.'", '.$flashvars.', '.$params.', '.$attributes.');');
    
        return $ret;
    }
}?>