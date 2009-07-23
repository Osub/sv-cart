<?php
/*****************************************************************************
 * SV-Cart 用户中心首页
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: pages_controller.php 2784 2009-07-13 06:14:07Z zhengli $
*****************************************************************************/
class TagsController extends AppController {
	var $name = 'Tags';
	var $helpers = array('Html','Javascript');
	var $uses = array("Tag");
	var $components = array('RequestHandler');

	function index(){
		if(!isset($_SESSION['User'])){
				$this->redirect('/login/');
		}
		$this->page_init();		
		$this->navigations[] = array('name'=>$this->languages['my_tags'],'url'=>"");
		$this->set('locations',$this->navigations);
		$this->Tag->set_locale($this->locale);
		$tags = $this->Tag->find('all',array(
		'fields'=>array('Tag.id','Tag.type_id','Tag.type','TagI18n.name'),
		'conditions'=>array('Tag.user_id = '.$_SESSION['User']['User']['id'])));
	//	pr($tags);
		$tags_p =array();
		$tags_a =array();
		if(isset($tags) && sizeof($tags)>0){
			foreach($tags as $k=>$v){
				if($v['Tag']['type'] == 'P'){
					$tags_p[] = $v;
				}elseif($v['Tag']['type'] == 'A'){
					$tags_a[] = $v;
				}
			}
		}
		
	//	pr($tags);
	   	$this->pageTitle = $this->languages['my_tags']." - ".$this->configs['shop_title'];
	    $js_languages = array("confirm_to_remove_label" => $this->languages['confirm_to_remove_label']);
		$this->set('js_languages',$js_languages);	   	
		$this->set('tags_p',$tags_p);
		$this->set('tags_a',$tags_a);

	}
	
	
	function remove($id){
		
		$tag = $this->Tag->find('Tag.id = '.$id.' and Tag.user_id = '.$_SESSION['User']['User']['id']);
		$this->Tag->del($tag);
	    $this->redirect("/tags/");

	}
	
}
?>