<?php
/*****************************************************************************
 * SV-Cart 商品管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: trash_controller.php 2703 2009-07-08 11:54:52Z huangbo $
 *****************************************************************************/
class TrashController extends AppController
{
    var $name='Trash';
    var $components=array('Pagination','RequestHandler');
    var $helpers=array('Pagination','Html','Form','Javascript','Fck');
    var $uses=array("Product","ProductI18n","ProductGallery","OrderProduct","ProductsCategory","ProductAttribute",
                    "ProviderProduct","ProductRank","ProductShippingFee","ProductDownload","ProductService");
    
    function index()
    {
        $this->pageTitle="商品回收站"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '商品回收站','url' => '/trash/');
        $this->set('navigations',$this->navigations);
        $this->Product->set_locale($this->locale);
        $condition=" Product.status = '2' ";
        
        if($this->RequestHandler->isPost()){
        if(isset($this->params['form']['keywords']) && $this->params['form']['keywords'] != '')
        {
            $keywords=$this->params['form']['keywords'];
            $condition.=" and (Product.code like '%$keywords%' or ProductI18n.name like '%$keywords%' or ProductI18n.description like '%$keywords%' or Product.id='$keywords') ";
            $this->set('keywords',$this->params['form']['keywords']);
        }
        }
        
        $total=$this->Product->findCount($condition,0);
        $sortClass='Product';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $products_list=$this->Product->findAll($condition,'',"Product.created DESC",$rownum,$page);
        
        $keywords=isset($this->params['form']['keywords']) ? $this->params['form']['keywords']: '';
        if(!empty($products_list))
        {
        	foreach($products_list as $k=>$v)
        	{
        		$products_list[$k]['Product']['format_shop_price'] = '';
        		$products_list[$k]['Product']['format_shop_price'] = sprintf($this->configs['price_format'],sprintf("%01.2f",$v['Product']['shop_price']));
        	}
        }
        $this->set('products_list',$products_list);
        $this->set('keywords',$keywords);
    }
    
    //单独处理回收站商品---还原商品
    function revert($id)
    {
    	$this->Product->updateAll(array('Product.status' => '1'),array('Product.id' => $id));
    	$pn = $this->ProductI18n->find('list',array('fields' => array('ProductI18n.product_id','ProductI18n.name'),'conditions'=> 
                                        array('ProductI18n.product_id'=>$id,'ProductI18n.locale'=>$this->locale)));
    	//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'还原商品:'.$pn[$id] ,'operation');
    	}
        $this->flash("该商品已还原",'/trash/',10);
    }
    
    //单独处理回收站商品---彻底删除商品
    function com_delete($id)
    {
    	//取得商品信息
    	$pn = $this->ProductI18n->find('list',array('fields' => array('ProductI18n.product_id','ProductI18n.name'),'conditions'=> 
                                        array('ProductI18n.product_id'=>$id,'ProductI18n.locale'=>$this->locale)));
    	$product_info = array();
    	$product_info = $this->Product->findById($id);
    	
    	if (empty($product_info))
        {
        	$this->flash("该商品不存在",'/trash/',10);
        }
        else
        {
        	if ($product_info['Product']['status']!= 2)
        	{
        		$this->flash("该商品尚未放入回收站，不能删除",'/trash/',10);
        	}
        	else
        	{
        		/* 删除商品图片 */
        		if (!empty($product_info['Product']['img_thumb']))
        		{
        		    @unlink('..' . $product_info['Product']['img_thumb']);
        		}
        		if (!empty($product_info['Product']['img_detail']))
        		{
        		    @unlink('..' . $product_info['Product']['img_detail']);
        		}
        		if (!empty($product_info['Product']['img_original']))
        		{
        		    @unlink('..' . $product_info['Product']['img_original']);
        		}
        		if ($product_info['Product']['extension_code']=="download_product")
        		{
        		   $this->ProductDownload->deleteAll(array('ProductDownload.product_id'=>$id));
        		}
        		if ($product_info['Product']['extension_code']=="services_product")
        		{
        		   $this->ProductService->deleteAll(array('ProductService.product_id'=>$id));
        		}        		
        		/* 删除商品 */
        		$this->Product->del($id);
        		
        		/* 删除相关表记录 */
        		$this->ProductsCategory->deleteAll(array('ProductsCategory.product_id'=>$id));
        		$this->ProductAttribute->deleteAll(array('ProductAttribute.product_id'=>$id));
        		$this->ProviderProduct->deleteAll(array('ProviderProduct.product_id'=>$id));
        		$this->ProductRank->deleteAll(array('ProductRank.product_id'=>$id));
        		$this->ProductShippingFee->deleteAll(array('ProductShippingFee.product_id'=>$id));
        		
        		/* 删除商品相册文件夹中的图片 */
        		$product_gallery_info = array();
        		$product_gallery_info = $this->ProductGallery->find('all',array('conditions'=>
        		    	                                  array('ProductGallery.product_id'=>$id)));
        		
        		if (!empty($product_gallery_info))
        		{
        			foreach($product_gallery_info as $vv){
        				if (!empty($vv['ProductGallery']['img_thumb']))
        		        {
        		        	@unlink('..' . $vv['ProductGallery']['img_thumb']);
        		        }
        		        if (!empty($vv['ProductGallery']['img_detail']))
        		        {
        		            @unlink('..' . $vv['ProductGallery']['img_detail']);
        		        }
        		        if (!empty($vv['ProductGallery']['img_original']))
        		        {
        		            @unlink('..' . $vv['ProductGallery']['img_original']);
        		        }
        		        $this->ProductGallery->deleteAll(array('ProductGallery.product_id'=>$id));
        			}
        		}
        		//操作员日志
        		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除商品:'.$pn[$id] ,'operation');
        		}
        	}
        }
    }
    
    //批量处理回收站的商品
    function batch()
    {
        $pro_ids=!empty($this->params['form']['checkboxes']) ? $this->params['form']['checkboxes']: array();
        if($this->params['form']['act_type'] == 'rev')
        {
            $this->Product->updateAll(array('Product.status' => '1'),array('Product.id' => $pro_ids));
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量还原商品' ,'operation');
    		}
            $this->flash("商品已还原",'/trash/','');
        }
		
        if($this->params['form']['act_type'] == 'del')
        { 
        	 foreach($pro_ids as $v){
        	     $product_info = array();
        	     $product_info = $this->Product->findById($v);
        	     
        	     if (empty($product_info))
        	     {
        	     	$this->flash("该商品不存在",'/trash/',10);
        	     }
        	     else
        	     {
        	     	 if ($product_info['Product']['status']!= 2)
        	     	 {
        	     	 	$this->flash("该商品尚未放入回收站，不能删除",'/trash/',10);
        	     	 }
        	     	 else
        	     	 {
        	     	 	 /* 删除商品图片 */
        	     	     if (!empty($product_info['Product']['img_thumb']))
        	     	     {
        	     	         @unlink('..' . $product_info['Product']['img_thumb']);
        	     	     }
        	     	     if (!empty($product_info['Product']['img_detail']))
        	     	     {
        	     	         @unlink('..' . $product_info['Product']['img_detail']);
        	     	     }
        	     	     if (!empty($product_info['Product']['img_original']))
        	     	     {
        	     	         @unlink('..' . $product_info['Product']['img_original']);
        	     	     }
        	     	     if ($product_info['Product']['extension_code']=="download_product")
        	     	     {
        	     	     	$this->ProductDownload->deleteAll(array('ProductDownload.product_id'=>$v));
        	     	     }
         	     	     if ($product_info['Product']['extension_code']=="services_product")
        	     	     {
        	     	     	$this->ProductService->deleteAll(array('ProductService.product_id'=>$v));
        	     	     }       	     	     
        	     	     /* 删除商品 */
        	     	     $this->Product->del($v,false);
        	     	     /* 删除相关表记录 */
        	     	     $this->ProductI18n->deleteAll(array('ProductI18n.product_id'=>$v));
        	     	     $this->ProductsCategory->deleteAll(array('ProductsCategory.product_id'=>$v));
        	     	     $this->ProductAttribute->deleteAll(array('ProductAttribute.product_id'=>$v));
        	     	     $this->ProviderProduct->deleteAll(array('ProviderProduct.product_id'=>$v));
        	     	     $this->ProductRank->deleteAll(array('ProductRank.product_id'=>$v));
        	     	     $this->ProductShippingFee->deleteAll(array('ProductShippingFee.product_id'=>$v));
        	     	     
        	     	     /* 删除商品相册 */
        	     	     $product_gallery_info = array();
        	     	     $product_gallery_info = $this->ProductGallery->find('all',array('conditions'=>
        	     	         	                                  array('ProductGallery.product_id'=>$v)));
        	     	     
        	     	     if (!empty($product_gallery_info))
        	     	     {
        	     	     	 foreach($product_gallery_info as $vv){
        	     	     	 	 if(!empty($vv['ProductGallery']['img_thumb']))
        	     	     	     {
        	     	     	     	 @unlink('..' . $vv['ProductGallery']['img_thumb']);
        	     	     	     }
        	     	     	     if (!empty($vv['ProductGallery']['img_detail']))
        	     	     	     {
        	     	     	     	 @unlink('..' . $vv['ProductGallery']['img_detail']);
        	     	     	     }
        	     	     	     if (!empty($vv['ProductGallery']['img_original']))
        	     	     	     {
        	     	     	         @unlink('..' . $vv['ProductGallery']['img_original']);
        	     	     	     }
        	     	     	     $this->ProductGallery->deleteAll(array('ProductGallery.product_id'=>$v));
        	     	     	 }
        	     	     }
        	     	 }
        	     }
        	 }
        	 //操作员日志
        	 if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	     $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量删除商品' ,'operation');
    	     }
        	 $this->flash("商品已删除",'/trash/','');
        }
    }
}
?>