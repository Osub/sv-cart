<?php
/*****************************************************************************
 * SV-Cart 网站导航
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: sitemaps_controller.php 2771 2009-07-10 10:46:46Z shenyunfeng $
*****************************************************************************/
class  SitemapsController extends AppController {
	var $name = 'Sitemaps';
	var $helpers = array('Time'); 
	var $uses = array('Category','Brand','Product','Article','Sitemap');
 	function view(){
		Configure::write('debug', 0);
 		//商品类目
 		$this->Category->set_locale($this->locale);
		$product_cat=$this->Category->tree('P',0,$this->locale);
		$this->set('product_cat',$product_cat['tree']);
		//品牌类目
		$this->Brand->set_locale($this->locale);
 	    $brands=$this->Brand->findassoc($this->locale);
 		//pr($brands);
 		$this->set('brands',$brands);
 		//商品 
		$this->Product->set_locale($this->locale);
 		$products = $this->Product->findall("1=1 and Product.status = '1'");
 		$this->set('products',$products);
 		//文章
		$this->Article->set_locale($this->locale);
 		$articles = $this->Article->findall('1=1');
 		$this->set('articles',$articles);
		//文章类目
		$article_cat=$this->Category->tree('A',0,$this->locale);
		//pr($article_cat);
		$this->set('article_cat',$article_cat['tree']);
		$ur_heres=array();
		$ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
		$ur_heres[]=array('name'=>$this->languages['sitemap'],'url'=>"/sitemaps");
		$this->set('languages',$this->locale);
		$this->set('locations',$ur_heres);
		$this->pageTitle = $this->languages['sitemap']." - ".$this->configs['shop_title'];
		$categories_tree = array();
		$this->page_init();
		$this->set('categories_tree',$categories_tree);

		$sitemap_list = $this->Sitemap->findall("1=1 and Sitemap.status = '1'");
		$this->set('sitemaps',$sitemap_list);
		
 		$this->layout = 'xml/default';

 	}
 	function index(){
 		//商品类目
 		$this->Category->set_locale($this->locale);
		$product_cat=$this->Category->tree('P',0,$this->locale);
		$this->set('product_cat',$product_cat['tree']);
		//品牌类目
		$this->Brand->set_locale($this->locale);
 	    $brands=$this->Brand->findassoc($this->locale);
 		//pr($brands);
 		$this->set('brands',$brands);
		//文章类目
		$article_cat=$this->Category->tree('A',0,$this->locale);
		//pr($article_cat);
		$this->set('article_cat',$article_cat['tree']);
		$ur_heres=array();
		$ur_heres[]=array('name'=>$this->languages['home'],'url'=>"/");
		$ur_heres[]=array('name'=>$this->languages['sitemap'],'url'=>"/sitemaps");
		$this->set('locations',$ur_heres);
		$this->pageTitle = $this->languages['sitemap']." - ".$this->configs['shop_title'];
		$categories_tree = array();
		$this->page_init();
		$this->set('categories_tree',$categories_tree);
 		$this->layout = 'default_full';
  	}

}
?>