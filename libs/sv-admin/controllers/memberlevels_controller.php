<?php
/*****************************************************************************
 * SV-Cart 会员等级管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: memberlevels_controller.php 1201 2009-05-05 13:30:17Z huangbo $
*****************************************************************************/
class MemberlevelsController  extends AppController {

	var $name = 'Memberlevels';

	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("UserRank",'UserRankI18n');
	
	function index(){
		$this->pageTitle = "会员等级管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'会员等级管理','url'=>'/memberlevels/');
		$this->set('navigations',$this->navigations);
		
		$this->UserRank->hasOne = array();
		$this->UserRank->hasOne = array('UserRankI18n' =>   
									                        array('className'    => 'UserRankI18n',   
									                              'order'        => '',   
									                              'dependent'    =>  true,   
									                              'foreignKey'   => 'user_rank_id'  
									                        )   
            						);
    	$this->UserRank->set_locale($this->locale);
    	$condition='';
   	    $total = $this->UserRank->findCount($condition,0);
	    $sortClass='UserRank';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
		$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
   		$memberlevel_list=$this->UserRank->findAll($condition,'',"",$rownum,$page);
  
		$this->set('memberlevel_list',$memberlevel_list);

    
    }
   	
	function edit($id){
		$this->pageTitle = "编辑会员等级 - 会员等级管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'会员等级管理','url'=>'/memberlevels/');
		$this->navigations[] = array('name'=>'编辑会员等级','url'=>'');
		$this->set('navigations',$this->navigations);
		$this->UserRank->hasOne = array();
		$this->UserRank->hasMany = array('UserRankI18n' =>   
                        array('className'    => 'UserRankI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'user_rank_id'  
                        )
                  );
		if($this->RequestHandler->isPost()){
		
			$this->UserRank->deleteall("UserRank.id = '$id'",false); 
			$this->UserRankI18n->deleteall("UserRankI18n.user_rank_id = '$id'",false);
			$this->UserRank->saveAll($this->data); //保存 
			$this->flash("编辑成功",'/memberlevels/edit/'.$id,'');
		}
		
		$userrank_info = $this->UserRank->findById($id);
		foreach($userrank_info['UserRankI18n'] as $k=>$v){
			$userrank_info['UserRankI18n'][$v['locale']] = $v;
		}
		
		$this->set('userrank_info',$userrank_info);
		$this->UserRank->hasMany = array();
		$this->UserRank->hasOne = array('UserRankI18n' =>   
                        array('className'    => 'UserRankI18n', 
                              'conditions'    =>  '',
                              'order'        => '',   
                              'dependent'    =>  true,   
                              'foreignKey'   => 'user_rank_id'  
                        )
                  );
	}
	
	function add(){
		$this->pageTitle = "编辑会员等级 - 会员等级管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'会员等级管理','url'=>'/memberlevels/');
		$this->navigations[] = array('name'=>'添加会员等级','url'=>'');
		$this->set('navigations',$this->navigations);


   	    if($this->RequestHandler->isPost()){
   	    	$this->data['UserRank']['discount'] = !empty($this->data['UserRank']['discount'])?$this->data['UserRank']['discount']:0;
   	    	//pr($this->data);
					//pr(count($this->data['UserRankI18n']));
					$this->UserRank->save($this->data['UserRank']); //保存
					$id=$this->UserRank->id;
					foreach( $this->data['UserRankI18n'] as $k =>$v ){
						$v['user_rank_id']=$id;
						$this->UserRankI18n->id='';
						$this->UserRankI18n->save($v); 
					}
			
				$this->flash("添加成功",'/memberlevels/','');
			
		}
   	}

	function remove($id){
		$this->UserRank->deleteAll("UserRank.id='".$id."'");
		$this->flash("删除成功",'/memberlevels/',10);
	}
   	
}

?>