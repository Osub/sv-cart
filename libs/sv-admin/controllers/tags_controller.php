<?php
/*****************************************************************************
 * SV-Cart 标签管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: tags_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
class TagsController extends AppController {
	var $name = 'Tags';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("Tag","TagI18n","Article","Product","User");
	
	function index(){
		$this->operator_privilege('tags_view');
		$this->pageTitle = '标签管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'标签管理','url'=>'/tags/');
		$this->set('navigations',$this->navigations);
		$this->Tag->set_locale($this->locale);
		$tags = $this->Tag->findall();
		if(isset($tags) && sizeof($tags)>0){
			$p_ids = array();
			$a_ids = array();
			$u_ids = array();
			$p_ids[] = 0;
			$a_ids[] = 0;
			$u_ids[] = 0;			
			foreach($tags as $k=>$v){
				if($v['Tag']['type'] == "P"){
					$p_ids[] = $v['Tag']['type_id'];
				}else if($v['Tag']['type'] == "A"){
					$a_ids[] = $v['Tag']['type_id'];
				}
				if($v['Tag']['user_id']>0){
					$u_ids[] = $v['Tag']['user_id'];
				}
			}
			$this->Product->set_locale($this->locale);
			$this->Article->set_locale($this->locale);
			$product_infos = $this->Product->find('all',array('conditions'=>array('Product.id'=>$p_ids)));
			$article_infos = $this->Article->find('all',array('conditions'=>array('Article.id'=>$a_ids)));
			$user_infos = $this->User->find('all',array('conditions'=>array('User.id'=>$u_ids)));
			$product_lists = array();
			$article_lists = array();
			$user_lists = array();
			
			if(isset($product_infos) && sizeof($product_infos)>0){
				foreach($product_infos as $k=>$v){
					$product_lists[$v['Product']['id']] = $v;
				}
			}
			if(isset($article_infos) && sizeof($article_infos)>0){
				foreach($article_infos as $k=>$v){
					$article_lists[$v['Article']['id']] = $v;
				}
			}			
			if(isset($user_infos) && sizeof($user_infos)>0){
				foreach($user_infos as $k=>$v){
					$user_lists[$v['User']['id']] = $v;
				}
			}			
			
			foreach($tags as $k=>$v){
				if($v['Tag']['type'] == "P"){
				//	$product = $this->Product->findbyid($v['Tag']['type_id']);
					$tags[$k]['Tag']['type_name'] = isset($product_lists[$v['Tag']['type_id']]['ProductI18n']['name'])?$product_lists[$v['Tag']['type_id']]['ProductI18n']['name']:"";//商品不存在
				}
				if($v['Tag']['type'] == "A"){
				//	$article = $this->Article->findbyid($v['Tag']['type_id']);
					$tags[$k]['Tag']['type_name'] = isset($article_lists[$v['Tag']['type_id']]['ArticleI18n']['title'])?$article_lists[$v['Tag']['type_id']]['ArticleI18n']['title']:"";//文章不存在
				}
				if($v['Tag']['user_id']>0){
				//	$user = $this->User->findbyid($v['Tag']['user_id']);
					$tags[$k]['Tag']['user_name'] = isset($user_lists[$v['Tag']['user_id']]['User']['name'])?$user_lists[$v['Tag']['user_id']]['User']['name']:"";//用户不存在
				}
			}
		}	
		$this->set('tags',$tags);
		
	}
	
	function add(){
		$this->operator_privilege('tags_view');
		$this->pageTitle = '标签管理 - 新增标签'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'标签管理','url'=>'/tags/');
		$this->navigations[] = array('name'=>'新增标签','url'=>'/tags/add');
		$this->set('navigations',$this->navigations);
		$this->set('languages',$this->languages);
		if($this->RequestHandler->isPost()){
			if($_POST['select_type'] == "P"){
				$type_id = $_POST['source_select1'];
			}else{
				$type_id = $_POST['source_select2'];
			}
			$tag = array(	'id' => '',
							'type_id' => $type_id,
							'type' => $_POST['select_type'],
							'status' => $_POST['status']
							);
			$this->Tag->save($tag);
			$id = $this->Tag->id;
			foreach($this->languages as $k=>$v){
				if(isset($_POST['tag_name_'.$v['Language']['locale']]) && trim($_POST['tag_name_'.$v['Language']['locale']]) != ""){
					$tag_i18n = array(
									'id' => '',
									'locale' => $v['Language']['locale'],
									'tag_id' => $id,
									'name' => $_POST['tag_name_'.$v['Language']['locale']]
									);
					$this->TagI18n->save($tag_i18n);
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加标签:'.$_POST['tag_name_'.$this->locale] ,'operation');
            }
			$this->flash("标签  ".$_POST['tag_name_'.$this->locale]." 添加成功。点击继续编辑该标签。",'/tags/'.$id,10);
		}
	}
	
	function view($id){
		$this->operator_privilege('tags_view');
		$this->pageTitle = '标签管理 - 编辑标签'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'标签管理','url'=>'/tags/');
		$this->navigations[] = array('name'=>'新增标签','url'=>'/tags/add');
		$tag = $this->Tag->localeformat($id);
		//$this->set('navigations',$this->navigations);
		$this->set('languages',$this->languages);
		if($tag['Tag']['type'] == "P"){
			$this->Product->set_locale($this->locale);
			$product = $this->Product->findbyid($tag['Tag']['type_id']);
			$tag['Tag']['type_name'] = isset($product['ProductI18n']['name'])?$product['ProductI18n']['name']:"";//商品不存在
		}
		if($tag['Tag']['type'] == "A"){
			$this->Article->set_locale($this->locale);
			$article = $this->Article->findbyid($tag['Tag']['type_id']);
			$tag['Tag']['type_name'] = isset($article['ArticleI18n']['title'])?$article['ArticleI18n']['title']:"";//文章不存在
		}
		$this->set('tag',$tag);
		
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$tag["TagI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	
	function edit(){
		if($this->RequestHandler->isPost()){
			if($_POST['select_type'] == "P"){
				$type_id = $_POST['source_select1'];
			}else{
				$type_id = $_POST['source_select2'];
			}
			$tag = array(	'id' => $_POST['tag_id'],
							'type_id' => $type_id,
							'type' => $_POST['select_type'],
							'status' => $_POST['status']
							);
			$this->Tag->save($tag);
			$id = $this->Tag->id;
			foreach($this->languages as $k=>$v){
				if(isset($_POST['tag_name_'.$v['Language']['locale']]) && trim($_POST['tag_name_'.$v['Language']['locale']]) != ""){
					$tag_i18n = array(
									'id' => isset($_POST['tag_i18n_'.$v['Language']['locale']])?$_POST['tag_i18n_'.$v['Language']['locale']]:'',
									'locale' => $v['Language']['locale'],
									'tag_id' => $id,
									'name' => $_POST['tag_name_'.$v['Language']['locale']]
									);
					$this->TagI18n->save($tag_i18n);
				}
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑标签:'.$_POST['tag_name_'.$this->locale] ,'operation');
            }
			$this->flash("标签  ".$_POST['tag_name_'.$this->locale]." 编辑成功。点击继续编辑该标签。",'/tags/'.$id,10);
		}	
	
	}
	
	function remove($id,$name=''){
		$this->operator_privilege('tags_view');
		$condition=array("Tag.id"=>$id);
//		$this->Language->del($id);
//		$this->Tag->set_locale($this->locale);
//		$tag_info = $this->Tag->findById($id);
		$this->Tag->deleteAll( $condition );

		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除标签:'.$name ,'operation');
    	}
		$this->flash("标签 ".$name." 删除成功",'/tags/','');
	}
	
}