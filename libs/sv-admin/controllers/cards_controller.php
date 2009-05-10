<?php
/*****************************************************************************
 * SV-Cart 贺卡管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: cards_controller.php 943 2009-04-23 10:38:44Z huangbo $
*****************************************************************************/
class CardsController extends AppController {
	var $name = 'Cards';
	var $components = array('Pagination','RequestHandler');
	var $uses = array('Card','CardI18n');

	function index(){
		$this->pageTitle = '贺卡管理' ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'贺卡管理','url'=>'/cards/');
		$this->set('navigations',$this->navigations);
		
		$this->Card->set_locale($this->locale);
		$condition='';
   	    $total = $this->Card->findCount($condition,0);
	    $sortClass='Card';
	    $page=1;
	    $rownum=100;
	    $parameters=Array($rownum,$page);
	    $options=Array();
	    list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		$data = $this->Card->findAll($condition,'',"Card.orderby",$rownum,$page);
		/*foreach($data as $k=>$v){
			$data[$k]['Card']['name'] = '';
			$data[$k]['Card']['description'] = '';
			if(!empty($v['CardI18n']))foreach($v['CardI18n'] as $vv){
					$data[$k]['Card']['name'] .= $vv['name'] . "|";
					$data[$k]['Card']['description'] .= $vv['description'] . "<br/>";
			}
		}*/
		$this->set('cards',$data);
	}
	function edit( $id ){
		$this->pageTitle = "贺卡管理 - 贺卡管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'贺卡管理','url'=>'/cards/');
		$this->navigations[] = array('name'=>'编辑贺卡','url'=>'');
		$this->set('navigations',$this->navigations);
		
		if($this->RequestHandler->isPost()){
			$this->data['Card']['orderby'] = !empty($this->data['Card']['orderby'])?$this->data['Card']['orderby']:50;
			$this->data['Card']['fee'] = !empty($this->data['Card']['fee'])?$this->data['Card']['fee']:0;
			$this->data['Card']['free_money'] = !empty($this->data['Card']['free_money'])?$this->data['Card']['free_money']:0;

			foreach($this->data['CardI18n'] as $v){
              	     	    $cardI18n_info=array(
		                           'id'=>	isset($v['id'])?$v['id']:'',
		                           'locale'=>	$v['locale'],
		                           'card_id'=> isset($v['card_id'])?$v['card_id']:$id,
		                           'name'=>	isset($v['name'])?$v['name']:'',
		                           'description'=>	$v['description']
		                     );
		                     $this->CardI18n->saveall(array('CardI18n'=>$cardI18n_info));//更新多语言
            }
			$this->Card->save($this->data); //保存
			$this->flash("编辑成功",'/cards/edit/'.$id,10);
		}
		
		$card = $this->Card->localeformat( $id );
		//pr( $card );
		$this->set( "card",$card );
	}
	
	
	function add(){
		$this->pageTitle = "添加贺卡 - 贺卡管理" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'贺卡管理','url'=>'/cards/');
		$this->navigations[] = array('name'=>'添加贺卡','url'=>'');
		$this->set('navigations',$this->navigations);
		
		if($this->RequestHandler->isPost()){

			$this->data['Card']['orderby'] = !empty($this->data['Card']['orderby'])?$this->data['Card']['orderby']:50;
			$this->data['Card']['fee'] = !empty($this->data['Card']['fee'])?$this->data['Card']['fee']:0;
			$this->data['Card']['free_money'] = !empty($this->data['Card']['free_money'])?$this->data['Card']['free_money']:0;


			$this->Card->save($this->data); //保存
			$id=$this->Card->id;
			//新增多语言
			   	if(is_array($this->data['CardI18n']))
			          foreach($this->data['CardI18n'] as $k => $v){
				            $v['card_id']=$id;
				            $this->CardI18n->id='';
				            $this->CardI18n->save($v); 
			           }
			$this->flash("添加成功",'/cards/edit/'.$id,10);
		}

	
	}
	function remove($id){
		$this->Card->deleteAll("Card.id='$id'");
		$this->flash("删除成功",'/cards/',10);
    }
}

?>