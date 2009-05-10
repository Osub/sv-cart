<?php
/*****************************************************************************
 * SV-Cart �ҵ��ղ�
 * ===========================================================================
 * ��Ȩ����  �Ϻ�ʵ������Ƽ����޹�˾������������Ȩ����
 * ��վ��ַ: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * �ⲻ��һ�������������ֻ���ڲ�������ҵĿ�ĵ�ǰ���¶Գ����������޸ĺ�ʹ�ã�
 * ������Գ���������κ���ʽ�κ�Ŀ�ĵ��ٷ�����
 * ===========================================================================
 * $����: �Ϻ�ʵ��$
 * $Id: product.php 1140 2009-04-29 09:39:40Z huangbo $
*****************************************************************************/
class Product extends AppModel
{
	var $name = 'Product';
		var $hasOne = array('ProductI18n'     =>array
												( 
												  'className'    => 'ProductI18n',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'Product_id'
					                        	 ) ,
					   	/*	'ProductsCategory' =>array
												(
										          'className'     => 'ProductsCategory',   
					                              'order'        => '',   
					                              'dependent'    =>  true,   
					                              'foreignKey'   => 'Product_id'
					                        	)*/
                 	   );


    
	function set_locale($locale){
    	$conditions = " ProductI18n.locale = '".$locale."'";
    	$this->hasOne['ProductI18n']['conditions'] = $conditions;
        
    }
 /*
��Ʒ�б�
*$products_id=>��ƷID��
*$status=>״̬
*$groupby=>����
*$orderby=>����
*/    
    function get_list($products_id,$status='1',$groupby='',$orderby='Product.modified desc'){
		$Lists = array();
		$condition=' 1 ';
		if($products_id!=''){
			$condition .= " AND Product.id in (".$products_id.") ";
		}
		if($status!=''){
			$condition.=" AND Product.status='".$status."'";
		}
		if($groupby!=''){
		$condition.=" GROUP BY  ".$groupby;
		}
		$Lists=$this->findAll($condition,'',$orderby);
		return $Lists;
	}

    function promotion($number){
		$datetime = date("Y-m-d H:i:s");
		$products=$this->findall("status ='1' and alone = '1' and forsale ='1' and promotion_status in ('1','2') and '".$datetime."' between promotion_start and promotion_end  ",'','promotion_end asc',$number);
		return $products;
		
	}
    
    //�Ƿ�����Ч������Ʒ
    function is_promotion($product_id){
    	$datetime = date("Y-m-d H:i:s");
    	$condition = "Product.status ='1' and Product.alone = '1' and Product.forsale ='1' and Product.promotion_status in ('1','2') and '".$datetime."' between Product.promotion_start and Product.promotion_end  and Product.id= '".$product_id."'";
		$products=$this->find($condition);
		if($products)
			return true;
		else
			return false;
    }
    
	function newarrival($number){
		$products=$this->findall(" status ='1' and alone = '1' and forsale ='1'  ",""," Product.created desc",$number);
		return $products;
	}
	
	function recommand($number){
		$products=$this->findall(" status ='1'  and alone = '1' and forsale ='1' and recommand_flag = '1' ",""," Product.modified desc",$number);
		return $products;
	}
	
	function search($locale,$keyword){
		$condition=array(

		   'OR' => array(
		   	  array("Product.code like '%$keyword%' "),
		      array("ProductI18n.name like '%$keyword%' "),
		      array("ProductI18n.description like '%$keyword%' ")
		   		)
		   );
	    $Pids=$this->findall($condition,'DISTINCT Product.id');
	    if(is_array($Pids)){
	    	foreach($Pids as $v ){
	    		$pid_array[]=$v['Product']['id'];
	    	}
	    }
	    $this->set_locale($locale);
 	     $condition = array("Product.id"=>$pid_array);
	   $result=$this->findall($condition);
	   return $result;
	  }		
function pr(){
	//	pr($this->tablePrefix);
		
	}
	
	
		function findassoc($locale){
			$this->set_locale($locale);
		$condition="Product.status ='1'";
		
		$lists=$this->findAll($condition);
		$lists_formated = array();
		if(is_array($lists))
			foreach($lists as $k => $v){
				$lists_formated[$v['Product']['id']]=$v;
			}
		
		return $lists_formated;
	}

}
?>