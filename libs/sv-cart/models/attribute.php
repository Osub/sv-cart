<?php
/*****************************************************************************
 * SV-Cart 属性
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: attribute.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class Attribute extends AppModel
{
	var $name = 'Attribute';
	var $hasOne = array('AttributeI18n' =>   
                        array('className'    => 'AttributeI18n',   
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'attribute_id'  
                        )
                  );
    
   	function set_locale($locale){
    	$conditions = " AttributeI18n.locale = '".$locale."'";
    	$this->hasOne['AttributeI18n']['conditions'] = $conditions;
        
    }
//分类页获取下级分类信息以及id集合结束
/*###############--ShoGun add--######################*/
//分类详细	
 function get_list($category_id){
		$Lists = array();
		$condition="Attribute.status ='1'";
		if($category_id!=''){
			$condition.= " AND Attribute.id in (".$category_id.")";
		}

		$Lists=$this->findAll($condition,'','orderby asc');
		return $Lists;
	}

//class_end
}
?>