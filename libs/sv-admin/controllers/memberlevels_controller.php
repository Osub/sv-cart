<?php
/*****************************************************************************
 * SV-Cart 会员等级
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: memberlevels_controller.php 4691 2009-09-28 10:11:57Z huangbo $
*****************************************************************************/
class MemberlevelsController  extends AppController {

	var $name = 'Memberlevels';

	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler','Email'); 
	var $uses = array("UserRank",'UserRankI18n');
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('member_rank_view');
		/*end*/
		$this->pageTitle = "会员等级"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'客户管理','url'=>'');
		$this->navigations[] = array('name'=>'会员等级','url'=>'/memberlevels/');
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
		/*判断权限*/
		$this->operator_privilege('member_rank_edit');
		/*end*/
		$this->pageTitle = "编辑会员等级 - 会员等级"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'客户管理','url'=>'');
		$this->navigations[] = array('name'=>'会员等级','url'=>'/memberlevels/');
		$this->navigations[] = array('name'=>'编辑会员等级','url'=>'');
	
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
			foreach( $this->data['UserRankI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			$id=$this->UserRank->id;
            //操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑会员等级:'.$userinformation_name ,'operation');
    	    }
			$this->flash("会员等级  ".$userinformation_name." 添加成功。点击这里继续编辑该会员等级。",'/memberlevels/edit/'.$id,10);
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
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$userrank_info["UserRankI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	
	function add(){
		/*判断权限*/
		$this->operator_privilege('member_rank_add');
		/*end*/
		$this->pageTitle = "编辑会员等级 - 会员等级"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'客户管理','url'=>'');
		$this->navigations[] = array('name'=>'会员等级','url'=>'/memberlevels/');
		$this->navigations[] = array('name'=>'添加会员等级','url'=>'');
		$this->set('navigations',$this->navigations);


   	    if($this->RequestHandler->isPost()){
   	    	$this->data['UserRank']['discount'] = !empty($this->data['UserRank']['discount'])?$this->data['UserRank']['discount']:0;
					$this->UserRank->saveall(array("UserRank"=>$this->data['UserRank'])); //保存
					$id=$this->UserRank->id;
					foreach( $this->data['UserRankI18n'] as $k =>$v ){
						$v['user_rank_id']=$id;
						$this->UserRankI18n->saveall(array("UserRankI18n"=>$v)); 
					}
				foreach( $this->data['UserRankI18n'] as $k=>$v ){
					if($v['locale'] == $this->locale){
						$userinformation_name = $v['name'];
					}
				}
				$id=$this->UserRank->id;
                //操作员日志
    	        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加会员等级:'.$userinformation_name ,'operation');
    	        }
				$this->flash("会员等级  ".$userinformation_name." 添加成功。点击这里继续编辑该会员等级。",'/memberlevels/edit/'.$id,10);

			
		}
   	}

	function remove($id){
		/*判断权限*/
		$this->operator_privilege('member_rank_edit');
		/*end*/
		$pn = $this->UserRankI18n->find('list',array('fields' => array('UserRankI18n.user_rank_id','UserRankI18n.name'),'conditions'=> 
                                   array('UserRankI18n.user_rank_id'=>$id,'UserRankI18n.locale'=>$this->locale)));
		$this->UserRank->deleteAll("UserRank.id='".$id."'");
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除会员等级:'.$pn[$id] ,'operation');
    	}
		$this->flash("删除成功",'/memberlevels/',10);
	}
   	
}

?>