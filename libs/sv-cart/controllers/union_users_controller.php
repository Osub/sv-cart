<?php
/*****************************************************************************
 * SV-CART ��վ����
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
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