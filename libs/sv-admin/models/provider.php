<?php
/*****************************************************************************
 * SV-Cart 供应商
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: provider.php 781 2009-04-18 12:48:57Z huangbo $
*****************************************************************************/
class Provider extends AppModel{
	var $name = 'Provider';
	var $hasMany = array('providerProduct' =>   
                        array('className'    => 'providerProduct', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'provider_id'  
                        )
                  );
    	function get_provider_list(){
    		$condition['status'] = 1;
			$provider_list = $this->findAll($condition);
			return $provider_list;
		}
	}
	

?>