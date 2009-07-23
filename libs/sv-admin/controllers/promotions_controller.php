<?php
/*****************************************************************************
 * SV-Cart 促销管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: promotions_controller.php 3184 2009-07-22 06:09:42Z huangbo $
 *****************************************************************************/
class PromotionsController extends AppController{
    var $name='Promotions';
    var $components=array('Pagination','RequestHandler');
    var $helpers=array('Pagination','Html');
    var $uses=array('Promotion','PromotionI18n','PromotionProduct','Product');
    function index(){
        /*判断权限*/
        $this->operator_privilege('promotion_view');
        /*end*/
        $this->pageTitle='促销活动管理'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '促销活动管理','url' => '/promotions/');
        $this->set('navigations',$this->navigations);
        $this->Promotion->set_locale($this->locale);
        $condition="1=1";
        $start_time='';
        $end_time='';
        $promotion_title='';
        if(isset($this->params['url']['start_time']) && $this->params['url']['start_time']!=''){
            $condition .= " and Promotion.start_time >= '".$this->params['url']['start_time']." 00:00:00'";
            $start_time=$this->params['url']['start_time']."";
        }
        if(isset($this->params['url']['end_time']) && $this->params['url']['end_time']!=''){
            $condition .= " and Promotion.end_time <= '".$this->params['url']['end_time']." 23:59:59'";
            $end_time=$this->params['url']['end_time'];
        }
        if(isset($this->params['url']['promotion_title']) && $this->params['url']['promotion_title']!=''){
            $condition2=" PromotionI18n.title like '%".$this->params['url']['promotion_title']."%'";
            $promotion_title=$this->params['url']['promotion_title'];
            $promotionid=$this->PromotionI18n->find('list',array('fields' => array('PromotionI18n.promotion_id'),'conditions' => $condition2));
            $promotionid[]=0;
            //pr($promotionid);exit;
            $condition .= " and Promotion.id in (".implode(',',$promotionid).")";
        }
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=array($rownum,$page);
        $options=array();
        $total=$this->Promotion->findCount($condition,0);
        $sortClass='Promotion';
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        $data=$this->Promotion->findAll($condition,'',"Promotion.start_time,Promotion.id",$rownum,$page);
        foreach($data as $k => $v){
            switch($v['Promotion']['type']){
                case 0:
                $v['Promotion']['typename']='减免';
                break;
                case 1:
                $v['Promotion']['typename']='折扣';
                break;
                case 2:
                $v['Promotion']['typename']='特惠品';
                break;
                default:
                $v['Promotion']['typename']='其他';
                break;
            }
            $data[$k]=$v;
        }
        $this->set('promotions',$data);
        $this->set('start_time',$start_time);
        $this->set('end_time',$end_time);
        $this->set('promotion_title',$promotion_title);
    }
    function edit($id){
        /*判断权限*/
        $this->operator_privilege('promotion_operation');
        /*end*/
        $this->pageTitle="促销活动管理 - 促销活动管理"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '促销活动管理','url' => '/promotions/');
        $this->navigations[]=array('name' => '编辑促销活动','url' => '');
        $this->set('navigations',$this->navigations);
        if($this->RequestHandler->isPost()){
            $this->data['Promotion']['min_amount']=!empty($this->data['Promotion']['min_amount']) ? $this->data['Promotion']['min_amount']: 0;
            $this->data['Promotion']['max_amount']=!empty($this->data['Promotion']['max_amount']) ? $this->data['Promotion']['max_amount']: 0;
            $this->data['Promotion']['type_ext']=!empty($this->data['Promotion']['type_ext']) ? $this->data['Promotion']['type_ext']: 0;
            $this->data['Promotion']['end_time']=date("Y-m-d",strtotime($this->data['Promotion']['end_time']))." 23:59:59";
            //$this->Promotion->deleteall("id = '".$this->data['Promotion']['id']."'",false);
            //$this->PromotionI18n->deleteall("promotion_id = '".$this->data['Promotion']['id']."'",false);
            foreach($this->data['PromotionI18n']as $v){
                $promotionI18n_info=array('id' => isset($v['id']) ? $v['id']: '','locale' => $v['locale'],'promotion_id' => isset($v['promotion_id']) ? $v['promotion_id']: $id,'title' => isset($v['title']) ? $v['title']: '','meta_description' => $v['meta_description']);
                $this->PromotionI18n->saveall(array('PromotionI18n' => $promotionI18n_info)); //更新多语言
            }
            $this->Promotion->save($this->data); //保存
            if(isset($_REQUEST['specialpreferences']) && isset($_REQUEST['prices'])){
                $specialpreferences=$_REQUEST['specialpreferences'];
                $prices=$_REQUEST['prices'];
                $this->PromotionProduct->deleteall("promotion_id = '".$id."'",false);
                for($i=0;$i <= count($specialpreferences)-1;$i++){
                    $data["PromotionProduct"]["promotion_id"]=$id;
                    $data["PromotionProduct"]["product_id"]=$specialpreferences[$i];
                    $data["PromotionProduct"]["price"]=$prices[$i];
                    $this->PromotionProduct->saveAll($data);
                }
            }
            foreach($this->data['PromotionI18n']as $k => $v){
                if($v['locale']==$this->locale){
                    $userinformation_name=$v['title'];
                }
            }
            $id=$this->Promotion->id;
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑促销活动'.$userinformation_name,'operation');
            }
            $this->flash("促销活动  ".$userinformation_name." 编辑成功。点击继续编辑该促销活动。",'/promotions/edit/'.$id,10);
        }
        $this->Product->hasOne=array();
        $this->Product->hasMany=array('ProductI18n' => array('className' =>
            'ProductI18n','conditions' => '','order' => '','dependent' => true,
            'foreignKey' => 'product_id'
        ));
        $PromotionProduct=$this->PromotionProduct->findall(array("promotion_id" => $id));
        $condition2="";
        foreach($PromotionProduct as $v){
            $condition2["or"][]["id"]=$v["PromotionProduct"]["product_id"];
        }
        if($condition2!=""){
            $products=$this->Product->findall($condition2);
        }
        else{
            $products=array();
        }
        foreach($products as $kk => $vv){
            $PromotionProduct[$kk]["PromotionProduct"]["name"]="";
            foreach($vv['ProductI18n']as $kkk => $vvv){
                if($vvv['locale']==$this->locale){
                    $PromotionProduct[$kk]["PromotionProduct"]["name"]=$vvv['name'];
                }
            }
        }
        $promotion=$this->Promotion->localeformat($id);
        $this->set("promotion",$promotion);
        $this->set("PromotionProduct",$PromotionProduct);
		//leo20090722导航显示
	
		$this->navigations[] = array('name'=>$promotion["PromotionI18n"][$this->locale]["title"],'url'=>'');
	    $this->set('navigations',$this->navigations);

    }
    function remove($id){
        /*判断权限*/
        $this->operator_privilege('promotion_operation');
        /*end*/
        $pn=$this->PromotionI18n->find('list',array('fields' => array('PromotionI18n.promotion_id','PromotionI18n.title'),'conditions' => array('PromotionI18n.promotion_id' => $id,'PromotionI18n.locale' => $this->locale)));
        $this->PromotionProduct->deleteall(array("promotion_id" => $id));
        $this->Promotion->del($id);
        //操作员日志
        if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除促销活动'.$pn[$id],'operation');
        }
        $this->flash("删除成功",'/promotions/',10);
    }
    function add(){
        $this->pageTitle="添加促销活动 - 促销活动管理"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '促销活动管理','url' => '/promotions/');
        $this->navigations[]=array('name' => '添加促销活动','url' => '');
        $this->set('navigations',$this->navigations);
        if($this->RequestHandler->isPost()){
            $this->data['Promotion']['min_amount']=!empty($this->data['Promotion']['min_amount']) ? $this->data['Promotion']['min_amount']: 0;
            $this->data['Promotion']['max_amount']=!empty($this->data['Promotion']['max_amount']) ? $this->data['Promotion']['max_amount']: 0;
            $this->data['Promotion']['type_ext']=!empty($this->data['Promotion']['type_ext']) ? $this->data['Promotion']['type_ext']: 0;
            $this->data['Promotion']['end_time']=date("Y-m-d",strtotime($this->data['Promotion']['end_time']))." 23:59:59";
            $this->Promotion->save($this->data); //保存
            $id=$this->Promotion->id;
            //新增多语言
            if(is_array($this->data['PromotionI18n']))
            foreach($this->data['PromotionI18n']as $k => $v){
                $v['promotion_id']=$id;
                $this->PromotionI18n->id='';
                $this->PromotionI18n->save($v);
            }
            foreach($this->data['PromotionI18n']as $k => $v){
                if($v['locale']==$this->locale){
                    $userinformation_name=$v['title'];
                }
            }
            $id=$this->Promotion->id;
            //操作员日志
            if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加促销活动'.$userinformation_name,'operation');
            }
            $this->flash("促销活动  ".$userinformation_name." 添加成功。点击继续编辑该促销活动。",'/promotions/edit/'.$id,10);
            if(isset($_REQUEST['specialpreferences']) && isset($_REQUEST['prices'])){
                $specialpreferences=$_REQUEST['specialpreferences'];
                $prices=$_REQUEST['prices'];
                for($i=0;$i <= count($specialpreferences)-1;$i++){
                    //$data["PromotionProduct"]["promotion_id"] = $datas[$total-1]['Promotion']['id'];
                    $data['PromotionProduct']['promotion_id']=$id;
                    $data["PromotionProduct"]["product_id"]=$specialpreferences[$i];
                    $data["PromotionProduct"]["price"]=$prices[$i];
                    $this->PromotionProduct->saveAll($data);
                }
            }
        }
    }
}

?>