<?php
/*****************************************************************************
 * SV-CART 网站联盟
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
class UnionUsersController extends AppController {
	var $name = 'UnionUsers';
	var $helpers = array('Html','Javascript');
	var $uses = array('UnionUser');
	var $components = array('RequestHandler','Cookie');
	

	function get_union_user($id){
		$union_user = $this->UnionUser->findbyname($id);
		if(isset($union_user['UnionUser'])){
			$this->Cookie->write('union_source', $union_user['UnionUser']['id']);
	//		$_COOKIE['CakeCookie']['union_source'] = $union_user['UnionUser']['id'];
		}
	}
	
	
	
}
?>