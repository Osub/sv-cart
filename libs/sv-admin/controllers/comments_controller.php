<?php
/*****************************************************************************
 * SV-Cart 评论查询
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: comments_controller.php 4433 2009-09-22 10:08:09Z huangbo $
*****************************************************************************/
class CommentsController extends AppController {

	var $name = 'Comments';

   	var $components = array ('Pagination','RequestHandler','Email'); // Added 
    var $helpers = array('Pagination','Javascript'); // Added 
	var $uses = array('Comment','Category','Product',"UserRank","User","ProductType");
	
	
	function index() {
 		/*判断权限*/
		$this->operator_privilege('comment_view');
		/*end*/
		$this->pageTitle = "评论查询"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'客户管理','url'=>'');
		$this->navigations[] = array('name'=>'评论查询','url'=>'/comments/');
		$this->set('navigations',$this->navigations);
		
		$condition='';
		if( isset($this->params['url']['content']) && $this->params['url']['content'] != '' ){
			$condition["Comment.content LIKE"]=	"%".$this->params['url']['content']."%";
			$this->set('content',$this->params['url']['content']);
		}
		if( isset($this->params['url']['cstatus']) && $this->params['url']['cstatus'] != '' ){
			$condition["Comment.status"]=	$this->params['url']['cstatus'];
			$this->set('cstatus',$this->params['url']['cstatus']);
		}
		if( isset($this->params['url']['end_time']) && $this->params['url']['end_time'] != '' ){
			$condition["Comment.created <"] = $this->params['url']['end_time'];
			$this->set('end_time',$this->params['url']['end_time']);
		}
			
		if( isset($this->params['url']['start_time']) && $this->params['url']['start_time'] != '' ){
			$condition["Comment.created >"]=$this->params['url']['start_time'];
			$this->set('start_time',$this->params['url']['start_time']);
		}
		$total = $this->Comment->findCount($condition,0);
	    $sortClass='Comment';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
 	    $options=Array();
	    $page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
   	    $this->data=$this->Comment->findAll($condition,'',"order by Comment.created desc",$rownum,$page);

			
		foreach($this->data as $k=>$v){	
			$wh['Product.id'] = $v["Comment"]["type_id"];
			$this->Product->set_locale($this->locale);
			$product = $this->Product->findAll($wh);
			$this->data[$k]['Comment']['object'] = "";
			if($v['Comment']['type'] == "P"){
				$this->data[$k]['Comment']['type_name'] = "商品";
			}
			if($v['Comment']['type'] == "A"){
				$this->data[$k]['Comment']['type_name'] = "文章";
			}
			foreach( $product as $kk=>$vv ){
				$this->data[$k]['Comment']['object']= $vv['ProductI18n']['name'];
				
			}
		}	

		$this->set('comments_info',$this->data);
	}
	
 	function search(){
 		/*判断权限*/
		$this->operator_privilege('comment_undea_view');
		/*end*/
		$this->pageTitle = "待处理评论"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'客户管理','url'=>'');
		$this->navigations[] = array('name'=>'待处理评论','url'=>'/comments/search/uncheck');
		$this->set('navigations',$this->navigations);
		$condition["Comment.status"]="0";
		$condition["Comment.parent_id"]=0;
   	    $total = $this->Comment->findCount($condition,0);
	    $sortClass='Comment';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
 	    $options=Array();
		$page  = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
   	    $this->data=$this->Comment->findAll($condition,'',"order by Comment.id",$rownum,$page);
		//会员等级信息
		$rank_list=$this->UserRank->findrank();
		foreach($this->data as $k=>$v){
			$wh['Product.id'] = $v["Comment"]["type_id"];
			$this->Product->set_locale($this->locale);
			$product = $this->Product->findAll($wh);
			$this->data[$k]['Comment']['object'] = "";
			if($v['Comment']['type'] == "P"){
				$this->data[$k]['Comment']['type'] = "商品";
			}
			if($v['Comment']['type'] == "A"){
				$this->data[$k]['Comment']['type'] = "文章";
			}
			$user_id = $this->data[$k]['Comment']['user_id'];
			$user_id = !empty($user_id)?$user_id:"0";
			$user = $this->User->findById($user_id);
			if(!empty($user)){
				@$this->data[$k]['Comment']['user_rank'] = $rank_list[$user['User']['rank']]['UserRank']['name'];
			}else{
				$this->data[$k]['Comment']['user_rank'] = "未知道等级";
			}
			
			foreach( $product as $kk=>$vv ){
				$this->data[$k]['Comment']['object']= $vv['ProductI18n']['name'];
				
			}
		}		
		$this->set('comments_info',$this->data);
		if(isset($_REQUEST['page'])&& !empty($_REQUEST['page'])){
			$this->set('ex_page',$this->params['url']['page']);
		}		
		/*CSV导出*/
		if(isset($_REQUEST['export'])&&$_REQUEST['export']==="export")
		{
			$filename = '待处理评论导出'.date('Ymd').'.csv';
			$ex_data= "待处理评论统计报表,";
			$ex_data.= "日期,";
			$ex_data.= date('Y-m-d')."\n";
			$ex_data.= "编号,";
			$ex_data.= "用户名,";
			$ex_data.= "会员等级,";
			$ex_data.= "类型,";
			$ex_data.= "评论对象,";
			$ex_data.= "IP地址,";
			$ex_data.= "评论时间\n";

			foreach($this->data as $k=>$v) {
				$ex_data.= $v['Comment']['id'].",";
				$ex_data.= $v['Comment']['name'].",";
				$ex_data.= $v['Comment']['user_rank'].",";
				$ex_data.= $v['Comment']['type'].",";
				$ex_data.= $v['Comment']['object'].",";
				$ex_data.= $v['Comment']['ipaddr'].",";
				$ex_data.= $v['Comment']['created']."\n";				
			}
		 	Configure::write('debug',0);
			header("Content-type: text/csv; charset=gb2312");
			header ("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
			header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
			header('Expires:   0');
			header('Pragma:   public');
			echo iconv('utf-8','gb2312',$ex_data."\n");
			exit;		
		}			
	}
		
   	function remove( $id){
 		/*判断权限*/
		$this->operator_privilege('comment_view_cancel');
		/*end*/
		$pn = $this->Comment->find('list',array('fields' => array('Comment.id','Comment.name'),'conditions'=> 
                                        array('Comment.id'=>$id)));
		$this->Comment->deleteAll("Comment.id='".$id."'");
		//操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除:'.$pn[$id].'的评论' ,'operation');
        }
   	}
   	function searchremove( $id ){
   		$this->Comment->deleteAll("Comment.id='".$id."'");
   	}
   	
 	function edit( $id ){
 		/*判断权限*/
		$this->operator_privilege('comment_view_cancel');
		/*end*/
		$this->pageTitle = "回复评论 - 评论查询"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'客户管理','url'=>'');
		$this->navigations[] = array('name'=>'评论查询','url'=>'/comments/');
		$this->navigations[] = array('name'=>'回复评论','url'=>'');
		
		if($this->RequestHandler->isPost()){
			if($this->data['Comment']['content'] != "" ){
				$this->data['Comment']['ipaddr'] = $_SERVER["REMOTE_ADDR"];
				$this->Comment->save( $this->data );
				$this->Comment->updateAll(
			              array('Comment.status' => "1"),
			              array('Comment.id' => $id)
			           );
			    //操作员日志
        		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'回复评论' ,'operation');
        		}
				$this->flash("评论回复成功",'/comments/edit/'.$id,10);
			}else{
				$this->flash("- 回复的评论内容不能为空!",'/comments/edit/'.$id,10 ,false);
			}
		}
		

 		$comment = $this->Comment->findById( $id );
		$condition['id'] = $comment['Comment']['type_id'];
		$producttype = $this->ProductType->find( $condition );
		$comment['Comment']['type_name'] = "";
		if( !empty($producttype) ){	
			foreach( $producttype['ProductTypeI18n'] as $kk=>$vv ){
				$comment['Comment']['type_name'].= $vv['name']."|";
			}
		}
		$wh['parent_id'] = $comment['Comment']['id'];
		$restore = $this->Comment->findAll( $wh );

		$this->set('comment',$comment);
		if( !empty( $restore ) ){
			$this->set('restore',$restore);
		}
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$comment["Comment"]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

 	}
	
	function edit_search( $id ){
		$this->pageTitle = "回复评论 - 评论查询"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'客户管理','url'=>'');
		$this->navigations[] = array('name'=>'评论查询','url'=>'/comments/');
		$this->navigations[] = array('name'=>'回复评论','url'=>'');
		
		if($this->RequestHandler->isPost()){

			if($this->data['Comment']['content'] != "" ){
				$this->data['Comment']['ipaddr'] = $_SERVER["REMOTE_ADDR"];
				$this->Comment->save( $this->data );
				$this->Comment->updateAll(
			              array('Comment.status' => "1"),
			              array('Comment.id' => $id)
			           );
			    //操作员日志
        		if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'回复评论' ,'operation');
        		}
				$this->flash("评论回复成功",'/comments/search/',10);
			}else{
				$this->flash("- 回复的评论内容不能为空!",'/comments/',10,false);
			}
		}


 		$comment = $this->Comment->findById( $id );
 
		$condition['id'] = $comment['Comment']['type_id'];
		$producttype = $this->ProductType->findById( $condition );
		$comment['Comment']['type_name'] = "";
		if( !empty($producttype) ){	
			foreach( $producttype['ProductTypeI18n'] as $kk=>$vv ){
				$comment['Comment']['type_name'].= $vv['name']."|";
			}
		}
		$wh['parent_id'] = $comment['Comment']['id'];
		$restore = $this->Comment->find( $wh );
		$this->set('comment',$comment);
		if( !empty( $restore ) ){
			$this->set('restore',$restore);
		}
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$comment["Comment"]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

 	}
 	
 	//批量处理
 	function batch(){
   	  if( isset( $this->params['url']['act_type'] ) && !empty( $this->params['url']['checkbox'] ) ){
	   	    $id_arr = $this->params['url']['checkbox'];
           	$condition = "";
           	for( $i=0;$i<=count( $id_arr )-1;$i++ ){
           		if ( $this->params['url']['act_type'] == 'delete' ){
           			$condition['id'] = $id_arr[$i];
                    $this->Comment->deleteAll( $condition );
                    //操作员日志
        		    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除评论' ,'operation');
        		}
                    
           		}
           	}	
           	if( $this->params['url']['search'] != "search" ){
           		$this->flash("删除成功",'/comments/','');
           	}else{
           		$this->flash("删除成功",'/comments/search/','');
           	}
	   }else{
	   	   if( $this->params['url']['search'] != "search" ){
	   			$this->flash("请选择",'/comments/','');
	   	   }else{
	   	   		$this->flash("请选择",'/comments/search/','');
	   	   }

	   }
   }
   function commentverify($id,$status){
		$this->Comment->updateAll(
			              array('Comment.status' => $status),
			              array('Comment.id' => $id)
			           );
		//操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'更改评论显示状态' ,'operation');
        }
		echo $status;
		Configure::write('debug',0);
    	die();
   }
   
}

?>