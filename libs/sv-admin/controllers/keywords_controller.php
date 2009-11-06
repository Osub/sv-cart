<?php
/*****************************************************************************
 * SV-Cart 关键字管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: votes_controller.php 3636 2009-08-14 09:26:56Z huangbo $
*****************************************************************************/
class KeywordsController extends AppController {

	var $name = 'Keywords';
    var $components = array ('Pagination','RequestHandler');
    var $helpers = array('Pagination');
	var $uses = array("SeoKeyword");
	
	function index(){
		$this->pageTitle = "关键字管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'功能管理','url'=>'');
		$this->navigations[] = array('name'=>'关键字管理','url'=>'/keywords/');
		$this->set('navigations',$this->navigations);
		$condition	= 	"";
   	    $total 		= 	$this->SeoKeyword->findCount($condition,0);
	    $sortClass	=	'SeoKeyword';
	    $page		=	1;
	    $rownum		=	isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters	=	Array($rownum,$page);
	    $options	=	Array();
	    $page 		= 	$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);

		$seokeyword_data = $this->SeoKeyword->find("all",array("conditions"=>$condition,"limit"=>$rownum,"page"=>$page));
		$this->set("seokeyword_data",$seokeyword_data);
	}
	function add(){
		$this->pageTitle = "关键字管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'功能管理','url'=>'');
		$this->navigations[] = array('name'=>'关键字管理','url'=>'/keywords/');
		$this->navigations[] = array('name'=>'新增关键字','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->SeoKeyword->saveAll($this->data);
			$this->flash("关键字  ".$this->data["SeoKeyword"]["name"]." 新增成功。点击这里继续编辑该关键字。",'/keywords/edit/'.$this->SeoKeyword->id,10);
		}
		
	}
	function edit($id){
		$this->pageTitle = "关键字管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'功能管理','url'=>'');
		$this->navigations[] = array('name'=>'关键字管理','url'=>'/keywords/');
		$this->navigations[] = array('name'=>'编辑关键字','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->SeoKeyword->saveAll($this->data);
			$this->flash("关键字  ".$this->data["SeoKeyword"]["name"]." 编辑成功。点击这里继续编辑该关键字。",'/keywords/edit/'.$this->SeoKeyword->id,10);
		}
		$seokeyword_info = $this->SeoKeyword->findbyid($id);
		$this->set("seokeyword_info",$seokeyword_info);
	}
	function remove($id){
		$this->SeoKeyword->del($id);
		die();
	}
}

?>