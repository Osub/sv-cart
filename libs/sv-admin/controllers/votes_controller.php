<?php
/*****************************************************************************
 * SV-Cart 用户管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: votes_controller.php 3184 2009-07-22 06:09:42Z huangbo $
*****************************************************************************/
class VotesController extends AppController {

	var $name = 'Votes';
    var $components = array ('Pagination','RequestHandler');
    var $helpers = array('Pagination');
	var $uses = array("Vote","VoteI18n","VoteOption","VoteOptionI18n","VoteLog","User");
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('vote_view');
		/*end*/
	   	$this->pageTitle = "在线调查管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'在线调查管理','url'=>'/votes/');
		$this->set('navigations',$this->navigations);
		
		$this->Vote->set_locale($this->locale);
   	   	$condition='';
   	    $total = count($this->Vote->find("all",array("conditions"=>$condition,"fields"=>"DISTINCT Vote.id")));
	   	$sortClass='Vote';
	   	$page=1;
	   	$rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	   	$parameters=Array($rownum,$page);
	   	$options=Array();
	   	$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
   	   	$vote_list=$this->Vote->find("all",array("rownum"=>$rownum,"page"=>$page));
   	   	$this->set("vote_list",$vote_list);
	}
	function edit($id){
	   	$this->pageTitle = "在线调查管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'在线调查管理','url'=>'/votes/');
		$this->navigations[] = array('name'=>'在线调查编辑','url'=>'');
	
		if($this->RequestHandler->isPost()){
			$this->data["Vote"]["id"] = $id;
			$this->Vote->save(array("Vote"=>$this->data["Vote"]));
			foreach( $this->data["VoteI18n"] as $k=>$v ){
				$v["vote_id"] = $id;
				if($v["locale"] == $this->locale){
					$this_locale_vote_name = $v["name"];
				}
				$this->VoteI18n->save(array("VoteI18n"=>$v));
			}
			$this->flash("在线调查主题 ".$this_locale_vote_name."  编辑成功。点击继续编辑该 在线调查主题。",'/votes/edit/'.$id,10);
		}
		$this->Vote->hasOne = array();
		$this->Vote->hasMany = array('VoteI18n'=>array( 
			'className'    => 'VoteI18n',   
			'order'        => '',   
			'dependent'    =>  true,   
			'foreignKey'   => 'vote_id'
			) 
		);
		$vote_info = $this->Vote->findById($id);
		foreach( $vote_info["VoteI18n"] as $k=>$v ){
			$vote_info["VoteI18n"][$v["locale"]] = $v;
		}
		
		$this->set("vote_info",$vote_info);
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$vote_info["VoteI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	function add(){
	   	$this->pageTitle = "在线调查管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'在线调查管理','url'=>'/votes/');
		$this->navigations[] = array('name'=>'在线调查新增','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->Vote->saveAll(array("Vote"=>$this->data["Vote"]));
			foreach( $this->data["VoteI18n"] as $k=>$v ){
				$v["vote_id"] = $this->Vote->getLastInsertId();
				if($v["locale"] == $this->locale){
					$this_locale_vote_name = $v["name"];
				}
				$this->VoteI18n->saveAll(array("VoteI18n"=>$v));
			}
			$this->flash("在线调查主题 ".$this_locale_vote_name."  添加成功。点击继续编辑该 在线调查主题。",'/votes/edit/'.$this->Vote->getLastInsertId(),10);
		}
	}
	function remove($id){
		$this->Vote->hasOne = array();
		$this->Vote->deleteAll(array("id"=>$id));
		$this->VoteI18n->deleteAll(array("vote_id"=>$id));
		$this->flash("",'',10);
	}
	
	function option_list($vote_id){
	   	$this->pageTitle = "在线调查管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'在线调查管理','url'=>'/votes/');
		$this->Vote->set_locale($this->locale);
		$vote_info = $this->Vote->find(array("Vote.id"=>$vote_id));
		$this->navigations[] = array('name'=>'在线调查（'.$vote_info["VoteI18n"]["name"].'）选项','url'=>'');
		$this->set('navigations',$this->navigations);
		$this->VoteOption->set_locale($this->locale);
		$voteoption_list = $this->VoteOption->find("all",array("conditions"=>array("vote_id"=>$vote_id)));
		$this->set("voteoption_list",$voteoption_list);
		$this->set("vote_id",$vote_id);
	}
	function option_add($vote_id){
	   	$this->pageTitle = "在线调查管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'在线调查管理','url'=>'/votes/');
		$this->Vote->set_locale($this->locale);
		$vote_info = $this->Vote->find(array("Vote.id"=>$vote_id));		
		$this->navigations[] = array('name'=>'新增（'.$vote_info["VoteI18n"]["name"].'）选项','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->data["VoteOption"]["vote_id"] = $vote_id;
			$this->VoteOption->saveAll(array("VoteOption"=>$this->data["VoteOption"]));
			foreach( $this->data["VoteOptionI18n"] as $k=>$v ){
				$v["vote_option_id"] = $this->VoteOption->getLastInsertId();
				if($v["locale"] == $this->locale){
					$this_locale_vote_option_name = $v["name"];
				}
				$this->VoteOptionI18n->saveAll(array("VoteOptionI18n"=>$v));
			}
			$this->flash("调查选项 ".$this_locale_vote_option_name."  添加成功。点击继续编辑该 调查选项。",'/votes/option_edit/'.$vote_id."/".$this->VoteOption->getLastInsertId(),10);
		}

		$this->set('vote_id',$vote_id);
	}
	function option_edit($vote_id,$option_vote_id){
	   	$this->pageTitle = "在线调查管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'在线调查管理','url'=>'/votes/');
		$this->Vote->set_locale($this->locale);
		$vote_info = $this->Vote->find(array("Vote.id"=>$vote_id));		
		$this->navigations[] = array('name'=>'新增（'.$vote_info["VoteI18n"]["name"].'）选项','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			$this->data["VoteOption"]["id"] = $option_vote_id;
			$this->data["VoteOption"]["vote_id"] = $vote_id;
			$this->VoteOption->save(array("VoteOption"=>$this->data["VoteOption"]));
			foreach( $this->data["VoteOptionI18n"] as $k=>$v ){
				$v["vote_option_id"] =$option_vote_id;
				if($v["locale"] == $this->locale){
					$this_locale_vote_option_name = $v["name"];
				}
				$this->VoteOptionI18n->save(array("VoteOptionI18n"=>$v));
			
			}
			$this->flash("调查选项 ".$this_locale_vote_option_name."  编辑成功。点击继续编辑该 调查选项。",'/votes/option_edit/'.$vote_id.'/'.$option_vote_id.'/',10);
		}
		
		$this->VoteOption->hasOne = array();
		$this->VoteOption->hasMany = array('VoteOptionI18n'=>array( 
			'className'    => 'VoteOptionI18n',   
			'order'        => '',   
			'dependent'    =>  true,   
			'foreignKey'   => 'vote_option_id'
			) 
		);
		$vote_option_info = $this->VoteOption->findById($option_vote_id);
		foreach( $vote_option_info["VoteOptionI18n"] as $k=>$v ){
			$vote_option_info["VoteOptionI18n"][$v["locale"]] = $v;
		}
		
		$this->set("vote_option_info",$vote_option_info);
		$this->set('vote_id',$vote_id);
		$this->set('option_vote_id',$option_vote_id);
	}
	function option_remove($option_vote_id){
		$this->VoteOption->hasOne = array();
		$this->VoteOption->deleteAll(array("id"=>$option_vote_id));
		$this->VoteOptionI18n->deleteAll(array("vote_option_id"=>$option_vote_id));
		$this->flash("",'',10);
	}
	//log日志
	function vote_logs($id){
	   	$this->pageTitle = "在线调查日志" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'在线调查管理','url'=>'/votes/');
		$this->navigations[] = array('name'=>'在线调查日志','url'=>'');
		

		//用户
		$user_list = $this->User->find("all",array("fields"=>"DISTINCT User.id,User.name"));
		$new_user_list = array();
		foreach( $user_list as $v ){
			$new_user_list[$v["User"]["id"]] = $v["User"]["name"];
		}
		//主题
		$this->Vote->set_locale($this->locale);
   	   	$vote_list=$this->Vote->find("all",array("fields"=>"DISTINCT Vote.id,VoteI18n.name"));
		$new_vote_list = array();
		foreach( $vote_list as $v ){
			$new_vote_list[$v["Vote"]["id"]] = $v["VoteI18n"]["name"];
		}
		//日志
		$vote_logs_list = $this->VoteLog->find("all",array("conditions"=>array("VoteLog.vote_id"=>$id)));
		foreach( $vote_logs_list as $k=>$v ){
			$vote_logs_list[$k]["VoteLog"]["vote_option_id_arr"] = explode(",",$vote_logs_list[$k]["VoteLog"]["vote_option_id"]);
		}
		//选项
		$this->VoteOption->set_locale($this->locale);
		$voteoption_list = $this->VoteOption->find("all");
		$new_voteoption_list = array();
		foreach( $voteoption_list as $v ){
			$new_voteoption_list[$v["VoteOption"]["id"]] = $v["VoteOptionI18n"]["name"];
		}
		$this->set("new_user_list",$new_user_list);//用户
		$this->set("new_vote_list",$new_vote_list);//主题
		$this->set("vote_logs_list",$vote_logs_list);//日志
		$this->set("new_voteoption_list",$new_voteoption_list);//选项
		//leo20090722导航显示

		$this->navigations[] = array('name'=>$new_vote_list[$id],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	
	function vote_logs_edit($vote_logs_id){
	   	$this->pageTitle = "在线调查日志" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'在线调查日志','url'=>'/vote_logs/');
		$this->navigations[] = array('name'=>'在线调查日志编辑','url'=>'');
		$this->set('navigations',$this->navigations);
		$this->set('vote_logs_id',$vote_logs_id);

		//用户
		$user_list = $this->User->find("all",array("fields"=>"DISTINCT User.id,User.name"));
		$new_user_list = array();
		foreach( $user_list as $v ){
			$new_user_list[$v["User"]["id"]] = $v["User"]["name"];
		}
		//主题
		$this->Vote->set_locale($this->locale);
   	   	$vote_list=$this->Vote->find("all",array("fields"=>"DISTINCT Vote.id,VoteI18n.name"));
		$new_vote_list = array();
		foreach( $vote_list as $v ){
			$new_vote_list[$v["Vote"]["id"]] = $v["VoteI18n"]["name"];
		}
		//日志
		$vote_logs_list = $this->VoteLog->findById($vote_logs_id);
		$vote_logs_list["VoteLog"]["vote_option_id_arr"] = explode(",",$vote_logs_list["VoteLog"]["vote_option_id"]);
		if($this->RequestHandler->isPost()){
			$this->data["VoteLog"]["id"] = $vote_logs_id;
			$this->VoteLog->save($this->data);
			$this->flash("调查日志 ".$new_vote_list[$vote_logs_list["VoteLog"]["vote_id"]]."  编辑成功。点击继续编辑该 调查选项。",'/votes/vote_logs_edit/'.$vote_logs_id.'/',10);
		}
		//选项
		$this->VoteOption->set_locale($this->locale);
		$voteoption_list = $this->VoteOption->find("all");
		$new_voteoption_list = array();
		foreach( $voteoption_list as $v ){
			$new_voteoption_list[$v["VoteOption"]["id"]] = $v["VoteOptionI18n"]["name"];
		}
		$this->set("new_user_list",$new_user_list);//用户
		$this->set("new_vote_list",$new_vote_list);//主题
		$this->set("vote_logs_list",$vote_logs_list);//日志
		$this->set("new_voteoption_list",$new_voteoption_list);//选项

	}
}

?>