<?php
/*****************************************************************************
 * SV-CART PluginTestsController
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: pages_controller.php 678 2009-04-16 02:22:25Z tangyu $
*****************************************************************************/
class PluginTestsController extends AppController {
	var $name 		= 'PluginTests';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers 	= array('Pagination'); // Added "
	var $uses 		= array();
	
	function index(){
		echo "He only examples";
		die();
   	}
}

?>
