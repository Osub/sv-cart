<?php
/*****************************************************************************
 * SV-Cart 语言管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: languages_controller.php 4691 2009-09-28 10:11:57Z huangbo $
*****************************************************************************/
class LanguagesController extends AppController {
	var $name = 'Languages';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler'); 
	var $uses = array('Language','LanguageDictionarie');


	function index(){
		/*判断权限*/
		$this->operator_privilege('langauage_view');
		/*end*/
		$this->pageTitle = "语言管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'功能管理','url'=>'');
		$this->navigations[] = array('name'=>'语言管理','url'=>'/languages/');
		$this->set('navigations',$this->navigations);
		$data = $this->Language->findAll();
		$this->set('languages',$data);

	}
	function edit($id){
		$this->pageTitle = "编辑语言 - 语言管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'功能管理','url'=>'');
		$this->navigations[] = array('name'=>'语言管理','url'=>'/languages/');
		$this->navigations[] = array('name'=>'编辑语言','url'=>'');
		
		if($this->RequestHandler->isPost()){
			$this->Language->save($this->data);
            //操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑语言:'.$this->data['Language']['name'] ,'operation');
    	    }
			$this->flash("语言 ".$this->data['Language']['name']." 编辑成功。点击这里继续编辑该语言。","/languages/edit/".$id,10);
		}
		$this->data = $this->Language->findById($id);
		
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$this->data["Language"]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	
	}
	function add(){
		$this->pageTitle = "添加语言 - 语言管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'功能管理','url'=>'');
		$this->navigations[] = array('name'=>'语言管理','url'=>'/languages/');
		$this->navigations[] = array('name'=>'添加语言','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->Language->saveall($this->data);
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加语言:'.$this->data['Language']['name'] ,'operation');
    	    }
			$this->flash("语言 ".$this->data['Language']['name']." 添加成功。点击这里继续编辑该语言。","/languages/edit/".$this->Language->getLastInsertID(),10);
		}
	
	}
	function remove($id){
		
		$pn = $this->Language->find('list',array('fields' => array('Language.id','Language.name'),'conditions'=> 
                                        array('Language.id'=>$id,'Language.locale'=>$this->locale)));

		$this->Language->del($id);
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除语言:'.@$pn[$id] ,'operation');
    	}
		$this->flash('删除成功','/languages/',10);
	
	}
}
?>