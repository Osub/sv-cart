<?php
/*****************************************************************************
 * SV-Cart 专题管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: topics_controller.php 1116 2009-04-28 11:04:43Z huangbo $
*****************************************************************************/
class TopicsController extends AppController {
	var $name = 'Topics';
    var $components = array ('Pagination','RequestHandler');
   	var $helpers = array('Pagination','Html', 'Form', 'Javascript', 'Fck'); 
	var $uses = array('Topic','TopicI18n','Brand','ProductType','Category','Product','TopicProduct');

	function index(){
		$this->pageTitle = '专题管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'专题管理','url'=>'/topics/');
		$this->set('navigations',$this->navigations);
		
		$this->Topic->set_locale($this->locale);
		$condition = '1=1';
		$page = 1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
		$parameters = array($rownum,$page);		
		$options = array();
		$total = $this->Topic->findCount($condition,0);
		$sortClass = 'Topic';
		$page = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		
		$data = $this->Topic->findAll($condition,'',"Topic.start_time,Topic.id",$rownum,$page);
		/*foreach($data as $k=>$v){
			$v['Topic']['title'] = '';
			if(!empty($v['TopicI18n']))foreach($v['TopicI18n'] as $vv){
				$v['Topic']['title'] .= $vv['title'].'|';
			}
			$data[$k] = $v;
		}*/
		//pr($data);
		$this->set('topics',$data);		

	}
	
	function edit( $id ){
		$this->pageTitle = "专题部门 - 专题管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'专题管理','url'=>'/topics/');
		$this->navigations[] = array('name'=>'专题部门','url'=>'');
		$this->set('navigations',$this->navigations);
		
		if($this->RequestHandler->isPost()){

			//$this->Topic->deleteall("id = '".$this->data['Topic']['id']."'",false); 
			//$this->TopicI18n->deleteall("topic_id = '".$this->data['Topic']['id']."'",false); //删除原有多语言
			foreach($this->data['TopicI18n'] as $v){
              	     	    $topicI18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'topic_id'=> isset($v['topic_id'])?$v['topic_id']:$id,
		                           'title'=>	isset($v['title'])?$v['title']:'',
		                           'intro'=>	isset($v['intro'])?$v['intro']:''
		                     );
		                $this->TopicI18n->saveall(array('TopicI18n'=>$topicI18n_info));//更新多语言
            }
			$this->Topic->save($this->data); //保存
			$this->flash("编辑成功",'/topics/edit/'.$id,10);
		}
		$topic = $this->Topic->localeformat( $id );
		$categories_tree=$this->Category->tree('P',$this->locale);
		$brands_tree=$this->Brand->getbrandformat();
		$types_tree=$this->ProductType->gettypeformat();
		//$categories_tree=$this->Category->tree('P');
		$wh['topic_id'] = $topic['Topic']['id'];
		$topicproduct = $this->TopicProduct->find( $wh );
		//pr($topicproduct);
		
		@$topicproduct=$this->requestAction("/commons/get_linked_topic_products/".$topicproduct['TopicProduct']['topic_id']."");
		
		$this->data=$this->Product->localeformat($id);
		
		
		$this->set("topic",$topic);
		$this->set('categories_tree',$categories_tree);
		$this->set('brands_tree',$brands_tree);
		$this->set('types_tree',$types_tree);
		$this->set('topicproduct', $topicproduct);
		//pr( $topicproduct );
		
		
		
		
	}
	
	function add(){
		$this->pageTitle = "专题部门 - 专题管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'专题管理','url'=>'/topics/');
		$this->navigations[] = array('name'=>'专题部门','url'=>'');
		$this->set('navigations',$this->navigations);
		if($this->RequestHandler->isPost()){
			
			$this->Topic->save($this->data); //保存
			$id=$this->Topic->id;
			//新增商品多语言
			   
		    if(is_array($this->data['TopicI18n']))
			      foreach($this->data['TopicI18n'] as $k => $v){
			           $v['topic_id']=$id;
			           $this->TopicI18n->id='';
			           $this->TopicI18n->save($v); 
			     }
			$this->flash("编辑成功",'/topics/edit/'.$id,10);
		}
		
	}
	
	function remove( $id ){
		$this->Topic->deleteall("Topic.id = '".$id."'",false); 
		$this->TopicI18n->deleteall("TopicI18n.topic_id = '".$id."'",false); //删除原有多语言
		$this->flash("删除成功",'/topics/',10);
	}
	
	//批量处理
 	function batch(){
   	  if( isset( $this->params['url']['act_type'] ) && !empty( $this->params['url']['checkbox'] ) ){
	   	    $id_arr = $this->params['url']['checkbox'];
           	$condition = "";
           	for( $i=0;$i<=count( $id_arr )-1;$i++ ){
           		if ( $this->params['url']['act_type'] == 'delete' ){
           			$condition['id'] = $id_arr[$i];
                    $this->Topic->deleteAll( $condition );
                    
           		}
           	}
           	$this->flash("删除成功",'/topics/','');
	   }else{
	   		$this->flash("请选择",'/topics/','');
		
	   }
   }
}

?>