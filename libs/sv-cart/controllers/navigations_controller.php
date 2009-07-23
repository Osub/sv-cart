<?php
/*****************************************************************************
 * SV-Cart 导航设置
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: navigations_controller.php 725 2009-04-17 08:00:21Z huangbo $
*****************************************************************************/
class NavigationsController extends AppController {
	var $name = 'Navigations';
	var $uses = array('Navigation');
 	function index(){
		$n=	$this->Navigation->findall();
		//	pr($n);
			if (!class_exists('I18n')) {
				App::import('Core', 'i18n');
			}
			$I18n =& I18n::getInstance();
			echo $I18n->l10n->locale;
			exit();
 	}
 	
 	function getbytype($type=''){
 		$this->Navigation->get();
 	}

}
?>