<?php
/*****************************************************************************
 * SV-Cart 操作员
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: operator.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Operator extends AppModel{
	var $name = "Operator";
    var $hasOne = array('Department'     =>array( 
												  'className'    => 'Department',
		                                          'conditions'    => 'Department.id = Operator.department_id',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => ''
					                        	 )
                 	   );
	//检查用户名是否重用
	function check_unique_name($name,$id=0){
		if($id==0)
			$condition = " Operator.name='$name'";
		else
			$condition = " Operator.id <> $id and Operator.name='$name'";
		$data=$this->findCount($condition);

		return $data;

	}
}	
?>