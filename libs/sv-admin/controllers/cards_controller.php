<?php
/*****************************************************************************
 * SV-Cart 贺卡
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: cards_controller.php 4691 2009-09-28 10:11:57Z huangbo $
*****************************************************************************/
class CardsController extends AppController {
	var $name = 'Cards';
	var $helpers = array('Html','Pagination');
	var $components = array('Pagination','RequestHandler');
	var $uses = array('Card','CardI18n');

	function index(){
		/*判断权限*/
		$this->operator_privilege('card_view');
		/*end*/
		$this->pageTitle = '贺卡' ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'促销栏目','url'=>'');
		$this->navigations[] = array('name'=>'贺卡','url'=>'/cards/');
		$this->set('navigations',$this->navigations);
		
		$this->Card->set_locale($this->locale);
		$condition='';
   	    $total = count($this->Card->find("all",array("conditions"=>$condition,"fields"=>"DISTINCT Card.id")));
	    $sortClass='Card';
	    $page=1;
	    $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']:((!empty($rownum)) ?$rownum:20);
	    $parameters=Array($rownum,$page);
	    $options=Array();
	    list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		$data = $this->Card->findAll($condition,'',"Card.orderby",$rownum,$page);
		$this->set('cards',$data);
	}
	function edit( $id ){
		/*判断权限*/
		$this->operator_privilege('card_operation');
		/*end*/
		$this->pageTitle = "贺卡 - 贺卡" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'促销栏目','url'=>'');
		$this->navigations[] = array('name'=>'贺卡','url'=>'/cards/');
		$this->navigations[] = array('name'=>'编辑贺卡','url'=>'');
		
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
			
			foreach( $this->data['CardI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			$id=$this->Card->id;
            //操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑贺卡:'.$userinformation_name ,'operation');
            }
			$this->flash("贺卡  ".$userinformation_name." 编辑成功。点击这里继续编辑该贺卡。",'/cards/edit/'.$id,10);

		}
		
		$card = $this->Card->localeformat( $id );
	
		$this->set( "card",$card );
		//leo20090722导航显示
		$this->navigations[] = array('name'=>$card["CardI18n"][$this->locale]["name"],'url'=>'');
	    $this->set('navigations',$this->navigations);

	}
	
	
	function add(){
		$this->pageTitle = "添加贺卡 - 贺卡" ." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'促销栏目','url'=>'');
		$this->navigations[] = array('name'=>'贺卡','url'=>'/cards/');
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
			foreach( $this->data['CardI18n'] as $k=>$v ){
				if($v['locale'] == $this->locale){
					$userinformation_name = $v['name'];
				}
			}
			$id=$this->Card->id;
            //操作员日志
        	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'增加贺卡:'.$userinformation_name ,'operation');
            }
			$this->flash("贺卡  ".$userinformation_name." 添加成功。点击这里继续编辑该贺卡。",'/cards/edit/'.$id,10);
		}

	
	}
	function remove($id){
		/*判断权限*/
		$this->operator_privilege('card_operation');
		/*end*/
		$pn = $this->CardI18n->find('list',array('fields' => array('CardI18n.card_id','CardI18n.name'),'conditions'=> 
                                        array('CardI18n.card_id'=>$id,'CardI18n.locale'=>$this->locale)));
		$this->Card->deleteAll("Card.id='$id'");
		//操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除贺卡:'.$pn[$id],'operation');
        }
		$this->flash("删除成功",'/cards/',10);
    }
}

?>