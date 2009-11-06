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
 * $Id: users_controller.php 4893 2009-10-11 10:07:01Z huangbo $
 *****************************************************************************/
class UsersController extends AppController{

    var $name='Users';
    var $components=array('Pagination','RequestHandler'); // Added
    var $helpers=array('Pagination'); // Added

    var $uses=array("SystemResource","User","UserRank","UserInfo","UserInfoValue","UserMessage","UserAddress","Region","Order","Product","Comment","UserProductGallery","UserBalanceLog","UserPointLog","Order");


    function index($export=0,$csv_export_code="gbk",$orderby='id',$ordertype='ASC'){
        /*判断权限*/
        $this->operator_privilege('member_view');
        /*end*/
        $this->pageTitle="会员查询"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '客户管理','url' => '');
        $this->navigations[]=array('name' => '会员查询','url' => '/users/');
        $condition="";
        //会员搜索筛选条件
        if (isset($this->params['url']['user_email']) && $this->params['url']['user_email']!=''){
            $condition["User.email like"]="%".$this->params['url']['user_email']."%";
            $this->set('user_email',$this->params['url']['user_email']);
        }
        if (isset($this->params['url']['user_name']) && $this->params['url']['user_name']!=''){
            $condition["User.name like"]="%".$this->params['url']['user_name']."%";
            $this->set('user_name',$this->params['url']['user_name']);
        }
        if (isset($this->params['url']['user_rank']) && $this->params['url']['user_rank']!=0){
            $condition["User.rank"]=$this->params['url']['user_rank'];
            $this->set('user_rank',$this->params['url']['user_rank']);
        }
        if (isset($this->params['url']['min_balance']) && $this->params['url']['min_balance']!=''){
            $condition["User.balance >="]=$this->params['url']['min_balance'];
            $this->set('min_balance',$this->params['url']['min_balance']);
        }
        if (isset($this->params['url']['max_balance']) && $this->params['url']['max_balance']!=''){
            $condition["User.balance <="]=$this->params['url']['max_balance'];
            $this->set('max_balance',$this->params['url']['max_balance']);
        }
        if (isset($this->params['url']['min_points']) && $this->params['url']['min_points']!=''){
            $condition["User.point >="]=$this->params['url']['min_points'];
            $this->set('min_points',$this->params['url']['min_points']);
        }
        if (isset($this->params['url']['max_points']) && $this->params['url']['max_points']!=''){
            $condition["User.point <="]=$this->params['url']['max_points'];
            $this->set('max_points',$this->params['url']['max_points']);
        }
        if (isset($this->params['url']['date']) && $this->params['url']['date']!=''){
            $condition["User.created  >="]=$this->params['url']['date'];
            $this->set('date',$this->params['url']['date']);
        }
        if (isset($this->params['url']['date2']) && $this->params['url']['date2']!=''){
            $condition["User.created  <="]=$this->params['url']['date2']." 23:59:59";
            $this->set('date2',$this->params['url']['date2']);
        }
        if (isset($this->params['url']['verify_status']) && $this->params['url']['verify_status']!='-1'){
            $condition["User.verify_status"]=$this->params['url']['verify_status'];
            $this->set('verify_status',$this->params['url']['verify_status']);
        }
        $total=$this->User->findCount($condition,0);
        $sortClass='User';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
        if (isset($export) && $export==="export"){
            $users_list=$this->User->findAll($condition,'',"User.$orderby $ordertype");
        }
        else{
            $users_list=$this->User->findAll($condition,'',"User.$orderby $ordertype",$rownum,$page);
        }
        //用户等级
        $this->UserRank->set_locale($this->locale);
        $rank_list=$this->UserRank->findrank();
        $rank_lists=array();
        foreach($rank_list as $k => $v){
            $rank_lists[$v['UserRank']['id']]=$v;
        }
        foreach($users_list as $k => $v){

            if (!empty($rank_lists[$v['User']['rank']])){
                @$users_list[$k]['User']['UserRankname']=@$rank_lists[$v['User']['rank']]['UserRank']['name'];
            }
            else{
                $users_list[$k]['User']['UserRankname']='普通会员';
            }
        }
        //pr($rank_list);
        $user_rank=isset($this->params['url']['user_rank']) ? $this->params['url']['user_rank']: 0;
        $user_name=isset($this->params['url']['user_name']) ? $this->params['url']['user_name']: '';
        $min_balance=isset($this->params['url']['min_balance']) ? $this->params['url']['min_balance']: '';
        $max_balance=isset($this->params['url']['max_balance']) ? $this->params['url']['max_balance']: '';
        $min_points=isset($this->params['url']['min_points']) ? $this->params['url']['min_points']: '';
        $max_points=isset($this->params['url']['max_points']) ? $this->params['url']['max_points']: '';
        $start_date=isset($this->params['url']['start_date']) ? $this->params['url']['start_date']: '';
        $end_date=isset($this->params['url']['end_date']) ? $this->params['url']['end_date']: '';
        $verify_status=isset($this->params['url']['verify_status']) ? $this->params['url']['verify_status']: '';
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info=$this->SystemResource->resource_formated(); //find("first",array("conditions"=>array("code"=>"order_status")));
        //
        $this->set('systemresource_info',$systemresource_info);
        $this->set('orderby',$orderby);
        $this->set('ordertype',$ordertype);
        $this->set('users_list',$users_list);
        $this->set('rank_list',$rank_lists);
        $this->set('navigations',$this->navigations);
        $this->set('user_rank',$user_rank);
        $this->set('user_name',$user_name);
        $this->set('min_balance',$min_balance);
        $this->set('max_balance',$max_balance);
        $this->set('min_points',$min_points);
        $this->set('max_points',$max_points);
        $this->set('start_date',$start_date);
        $this->set('end_date',$end_date);
        $this->set('navigations',$this->navigations);

        /*	if(isset($_REQUEST['page'])&& !empty($_REQUEST['page'])){
        $this->set('ex_page',$this->params['url']['page']);
        }
        if(isset($_REQUEST['user_name'])){
        $ex_url="date=".$this->params['url']['date']."&date2=".$this->params['url']['date2']."&user_name=".$this->params['url']['user_name']."&user_email=".$this->params['url']['user_email'].
        "&user_rank=".$this->params['url']['user_rank']."&min_balance=".$this->params['url']['min_balance']."&max_balance=".$this->params['url']['max_balance']."&min_points=".$this->params['url']['min_points']."&max_points=".$this->params['url']['max_points'];
        }else{
        $ex_url="date=&date2=&user_name=&user_email=&user_rank=0&min_balance=&max_balance=&min_points=&max_points=";
        }
        $this->set('ex_url',$ex_url);			
        /*CSV导出*/

        //	if(isset($_REQUEST['export'])&&$_REQUEST['export']==="export")
        if (isset($export) && $export==="export"){
      		$condition = "";
      		$languagedictionary[] = "back_member_export";
      		$languagedictionary[] = "back_number";//编号
      		$languagedictionary[] = "back_username";//会员名称
      		$languagedictionary[] = "back_member_level";//会员等级
      		$languagedictionary[] = "back_email_address";//邮件地址
      		$languagedictionary[] = "back_registration_date";//注册日期
      		$condition["name"] = $languagedictionary;
			$csv_systemResource = $this->SystemResource->findbyresource_value($csv_export_code);
			$condition["locale"] = $csv_systemResource["SystemResource"]["code"];
      		$languagedictionary_info = $this->LanguageDictionary->find("all",array("conditions"=>$condition));
      		$csv_str = array();
      		foreach( $languagedictionary_info as $csv_k=>$csv_v ){
      			$csv_str[$csv_v["LanguageDictionary"]["name"]] = $csv_v["LanguageDictionary"]["value"];
      		}

            $filename=$csv_str["back_member_export"].''.date('Ymd').'.csv';//back_member_export
            $ex_data=$csv_str["back_number"].",";
            $ex_data.=$csv_str["back_username"].",";
            $ex_data.=$csv_str["back_member_level"].",";
            $ex_data.=$csv_str["back_email_address"].",";
            $ex_data.=$csv_str["back_registration_date"]."\n";
            foreach($users_list as $k => $v){
                $ex_data.=$v['User']['id'].",";
                $ex_data.=$v['User']['name'].",";
                $ex_data.=$v['User']['UserRankname'].",";
                $ex_data.=$v['User']['email'].",";
                $ex_data.=$v['User']['created']."\n";
            }
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=".$csv_export_code);
            header("Content-Disposition: attachment; filename=".iconv('utf-8',$csv_export_code,$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8',$csv_export_code,$ex_data."\n");
            exit;
        }
    }

    function search($act='unvalidate',$id=''){
        /*判断权限*/
        $this->operator_privilege('member_undeal_view');
        /*end*/
        $user_info=$this->User->findById($id);
        if ($act=="cancel" && ($id > 0)){
            if ($this->User->findById($id)){
                $this->User->updateAll(array('User.verify_status' => '2'),array('User.id' => $id));

                $this->flash("会员 ".$user_info['User']['name']." 取消认证成功",'/users/',10);
            }

        }
        if ($act=="userconfirm" && ($id > 0)){
            if ($this->User->findById($id)){
                $this->User->updateAll(array('User.verify_status' => '1'),array('User.id' => $id));
                $this->flash("会员 ".$user_info['User']['name']." 认证成功",'/users/',10);
            }

        }
        $this->pageTitle='待处理会员查询'." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '客户管理','url' => '');
        $this->navigations[]=array('name' => '待处理会员查询','url' => '/users/search/unvalidate');
        $this->set('navigations',$this->navigations);

        $condition="User.verify_status='1'";
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=array($rownum,$page);
        $options=array();
        $total=$this->User->findCount($condition,0);
        $sortClass='User';
        list($page)=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);

        $users=$this->User->findAll($condition);
        $this->set("users",$users);
        if (isset($_REQUEST['page']) && !empty($_REQUEST['page'])){
            $this->set('ex_page',$this->params['url']['page']);
        }
        /*CSV导出*/
        if (isset($_REQUEST['export']) && $_REQUEST['export']==="export"){
            $filename='待处理会员导出'.date('Ymd').'.csv';
            $ex_data="待处理会员统计报表,";
            $ex_data.="日期,";
            $ex_data.=date('Y-m-d')."\n";
            $ex_data.="编号,";
            $ex_data.="会员名称,";
            $ex_data.="邮件地址,";
            $ex_data.="注册日期,";
            $ex_data.="余额\n";

            foreach($users as $k => $v){
                $ex_data.=$v['User']['id'].",";
                $ex_data.=$v['User']['name'].",";
                $ex_data.=$v['User']['email'].",";
                $ex_data.=$v['User']['created'].",";
                $ex_data.=$v['User']['balance']."\n";
            }
            Configure::write('debug',0);
            header("Content-type: text/csv; charset=gb2312");
            header("Content-Disposition: attachment; filename=".iconv('utf-8','gb2312',$filename));
            header('Cache-Control:   must-revalidate,   post-check=0,   pre-check=0');
            header('Expires:   0');
            header('Pragma:   public');
            echo iconv('utf-8','gb2312',$ex_data."\n");
            exit;
        }
    }


    /*------------------------------------------------------ */
    //-- 编辑会员页
    /*------------------------------------------------------ */
    function view($id){
        /*判断权限*/
        $this->operator_privilege('member_operation');
        /*end*/
        $this->Order->belongsTo=array();
        $this->pageTitle="编辑会员-会员查询"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '客户管理','url' => '');
        $this->navigations[]=array('name' => '会员查询','url' => '/users/');
        $this->navigations[]=array('name' => '编辑会员','url' => '');
        $this->set('navigations',$this->navigations);
        $this->UserRank->set_locale($this->locale);
        if ($this->RequestHandler->isPost()){
            $user_info=$this->User->findbyid($this->data['User']['id']);
            if (!empty($this->data['User']['new_password']) && !empty($this->data['User']['new_password2'])){
                if (strcmp($this->data['User']['new_password'],$this->data['User']['new_password2'])!=0){
                    $this->flash("两次输入的新密码不一样",'/users/'.$this->data['User']['id'],10,false);
                }
                else{
                    $this->data['User']['password']=md5($this->data['User']['new_password']);
                }
            }
            else{
                //echo $user_info['User']['password'];
                $this->data['User']['password']=$user_info['User']['password'];
            }
            //操作员日志
            if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑会员:'.$this->data['User']['name'],'operation');
            }
            $this->User->save($this->data);
            /* 资金 */
            if (!empty($_POST['balance']) && is_numeric($_POST['balance'])){
                if ($_POST['balance_type']){
                    $BalanceLog['UserBalanceLog']['user_id']=$id;
                    $BalanceLog['UserBalanceLog']['amount']=$_POST['balance'];
                    $BalanceLog['UserBalanceLog']['admin_user']=$_SESSION['Operator_Info']['Operator']['name'];
                    $BalanceLog['UserBalanceLog']['admin_note']="";
                    $BalanceLog['UserBalanceLog']['system_note']="管理员:".$_SESSION['Operator_Info']['Operator']['name']." 增加该用户资金";
                    $BalanceLog['UserBalanceLog']['log_type']="A";
                    $BalanceLog['UserBalanceLog']['type_id']=0;

                    $this->UserBalanceLog->save($BalanceLog);
                    $this->User->updateAll(array('User.balance' => 'User.balance + '.$_POST['balance']),array('User.id =' => "$id"));
                    //操作员日志
                    if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'会员:'.$this->data['User']['name'].' 的可用资金增加'.$_POST['balance'],'operation');
                    }
                }
                else{
                    $BalanceLog['UserBalanceLog']['user_id']=$id;
                    $BalanceLog['UserBalanceLog']['amount']='-'.$_POST['balance'];
                    $BalanceLog['UserBalanceLog']['admin_user']=$_SESSION['Operator_Info']['Operator']['name'];
                    $BalanceLog['UserBalanceLog']['admin_note']="";
                    $BalanceLog['UserBalanceLog']['system_note']="管理员:".$_SESSION['Operator_Info']['Operator']['name']." 减少该用户资金";
                    $BalanceLog['UserBalanceLog']['log_type']="A";
                    $BalanceLog['UserBalanceLog']['type_id']=0;

                    $this->UserBalanceLog->save($BalanceLog);
                    $this->User->updateAll(array('User.balance' => 'User.balance - '.$_POST['balance']),array('User.id =' => "$id"));
                    //操作员日志
                    if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'会员:'.$this->data['User']['name'].' 的可用资金减少'.$_POST['balance'],'operation');
                    }
                }
            }
            /* 冻结资金 */
            if (!empty($_POST['frozen']) && is_numeric($_POST['frozen'])){
                if ($_POST['frozen_type']){
                    $this->User->updateAll(array('User.frozen' => 'User.frozen + '.$_POST['frozen']),array('User.id =' => "$id"));
                    //操作员日志
                    if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'会员:'.$this->data['User']['name'].' 的冻结资金增加'.$_POST['frozen'],'operation');
                    }
                }
                else{
                    $this->User->updateAll(array('User.frozen' => 'User.frozen - '.$_POST['frozen']),array('User.id =' => "$id"));
                    //操作员日志
                    if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'会员:'.$this->data['User']['name'].' 的冻结资金减少'.$_POST['frozen'],'operation');
                    }
                }
            }
            /* 积分 */
            if (!empty($_POST['point']) && is_numeric($_POST['point'])){
                if ($_POST['point_type']){
                    $PointLog['UserPointLog']['user_id']=$id;
                    $PointLog['UserPointLog']['point']=$_POST['point'];
                    $PointLog['UserPointLog']['admin_user']=$_SESSION['Operator_Info']['Operator']['name'];
                    $PointLog['UserPointLog']['admin_note']="";
                    $PointLog['UserPointLog']['system_note']="管理员:".$_SESSION['Operator_Info']['Operator']['name']." 增加该用户积分";
                    $PointLog['UserPointLog']['log_type']="A";
                    $PointLog['UserPointLog']['type_id']=0;

                    $this->UserPointLog->save($PointLog);

                    $this->User->updateAll(array('User.point' => 'User.point + '.$_POST['point']),array('User.id =' => "$id"));
                    //操作员日志
                    if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'会员:'.$this->data['User']['name'].' 的消费积分增加'.$_POST['point'],'operation');
                    }

                }
                else{
                    $PointLog['UserPointLog']['user_id']=$id;
                    $PointLog['UserPointLog']['point']='-'.$_POST['point'];
                    $PointLog['UserPointLog']['admin_user']=$_SESSION['Operator_Info']['Operator']['name'];
                    $PointLog['UserPointLog']['admin_note']="";
                    $PointLog['UserPointLog']['system_note']="管理员:".$_SESSION['Operator_Info']['Operator']['name']." 扣除该用户积分";
                    $PointLog['UserPointLog']['log_type']="A";
                    $PointLog['UserPointLog']['type_id']=0;

                    $this->UserPointLog->save($PointLog);
                    $this->User->updateAll(array('User.point' => 'User.point - '.$_POST['point']),array('User.id =' => "$id"));
                    //操作员日志
                    if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                        $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'会员:'.$this->data['User']['name'].' 的消费积分减少'.$_POST['point'],'operation');
                    }
                }
            }
            //更新会员项目
            // pr($this->params);

            if (!empty($this->params['form']['info_value']) && is_array($this->params['form']['info_value'])){
                $this->UserInfoValue->deleteall(array('user_id' => $this->data['User']['id']));

                foreach($this->params['form']['info_value']as $k => $v){
                    if (is_array($this->params['form']['info_value'][$k])){
                        $this->params['form']['info_value'][$k]=implode(';',$this->params['form']['info_value'][$k]);
                    }

                    $info_value=array('id' => "",'user_id' => $this->data['User']['id'],'user_info_id' => $k,'value' => !empty($this->params['form']['info_value'][$k]) ? $this->params['form']['info_value'][$k]: "0"
                    );

                    $this->UserInfoValue->save(array('UserInfoValue' => $info_value));
                }
            }
            //操作员日志
            if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'编辑会员:'.$this->data['User']['name'],'operation');
            }
            $this->flash("会员  ".$this->data['User']['name']." 编辑成功。点击这里继续编辑该会员。",'/users/'.$id,10);


        }
        //会员基本信息
        $this->data=$this->User->findbyid($id);
        //会员等级信息
        $rank_list=$this->UserRank->findrank();
        //pr($rank_list);
        //用户项目信息
        $condition=" user_id='".$id."'";
        $res=$this->UserInfoValue->findall($condition);
        $values_id=array();
        foreach($res as $k => $v){
            $user_info_value[$v['UserInfoValue']['user_info_id']]['UserInfoValue']=$v['UserInfoValue'];
            $values_id[$k]=$v['UserInfoValue']['user_info_id'];
        }
        // pr($user_info_value);
        $this->UserInfo->hasOne=array();
        $this->UserInfo->hasMany=array('UserInfoI18n' => array('className' =>
            'UserInfoI18n','order' => '','dependent' => true,'foreignKey' =>
            'user_info_id'
        ));

        $user_infoarr=$this->UserInfo->findAll();

        $arres=array();
        foreach($user_infoarr as $k => $v){
            $arres[$v['UserInfo']['id']]=$v;

        }
        $user_infoarr=$arres;
        foreach($user_infoarr as $k => $v){
            if (@is_array($user_info_value[$k])){
                @$user_infoarr[$k]['value']=$user_info_value[$k]['UserInfoValue'];
            }
        }
        //pr($user_infoarr);
        foreach($user_infoarr as $k => $v){
            foreach($v['UserInfoI18n']as $kk => $vv){
                if ($vv['locale']==$this->locale){
                    $user_infoarr[$k]['UserInfo']['name']=$vv['name'];
                    $user_infoarr[$k]['UserInfo']['user_info_values']=$vv['user_info_values'];

                }
            }
        }
        //默认收货地址
        $user_address=$this->UserAddress->findAll(" user_id = '".$id."'");
       
        //会员订单
        $orders_list=$this->Order->findAll(" user_id = '".$id."'","","created desc");
        foreach($orders_list as $k => $v){
            $price_format=$this->configs['price_format'];
            //DAM
            if (isset($this->configs["mlti_currency_module"]) && $this->configs["mlti_currency_module"]==1){
                if ($v["Order"]["order_locale"]!=' '){
                    $price_format=$this->currency_format[$v["Order"]["order_locale"]];
                }
                else{
                    $price_format=$this->configs['price_format'];
                }
            }
            //
            $orders_list[$k]['Order']['subtotal']=sprintf($price_format,$v['Order']['subtotal']);
            $orders_list[$k]['Order']['total']=sprintf($price_format,$v['Order']['total']);
            $orders_list[$k]['Order']['should_pay']=sprintf($price_format,$v['Order']['subtotal']-$v['Order']['money_paid']);
        }
        //pr($orders_list);
        //资金日志
        $balances_list=$this->UserBalanceLog->findAll(" user_id = '".$id."'");
        foreach($balances_list as $k => $v){
            if ($v['UserBalanceLog']['log_type']=='O'){
                $join_order=$this->Order->findbyid($v['UserBalanceLog']['type_id']);
                $balances_list[$k]['Order']=$join_order['Order'];
            }
        }
        // pr($balances_list);
        //积分日志
        $points_list=$this->UserPointLog->findAll(" user_id = '".$id."'");
        foreach($points_list as $k => $v){
            if ($v['UserPointLog']['log_type']=='O' || $v['UserPointLog']['log_type']=='B'){
                $join_orders=$this->Order->findbyid($v['UserPointLog']['type_id']);
                $points_list[$k]['Order']=$join_orders['Order'];
            }
        }
        //提问查询
        $condition="";
        $condition["UserMessage.parent_id ="]=0;
        $condition["UserMessage.type ="]="P";
        $condition["UserMessage.user_id ="]=$id;
        $UserMessage_list=$this->UserMessage->findAll($condition,'',"created desc");
        //评论
        $condition='';
        $condition["Comment.user_id ="]=$id;
        $thisComment=$this->Comment->findAll($condition,'',"order by Comment.created desc");
        //相册
        $condition='';
        $condition["UserProductGallery.user_id ="]=$id;
        $userproductgalleries_data=$this->UserProductGallery->find("all",array("conditions" => $condition));
        $product_id[]=0;
        foreach($userproductgalleries_data as $k => $v){
            $product_id[]=$v["UserProductGallery"]["product_id"];
        }
        $this->Product->hasMany=array();
        $this->Product->hasOne=array('ProductI18n' => array('className' =>
            'ProductI18n','order' => '','dependent' => true,'foreignKey' =>
            'product_id'
        ));
        $this->Product->set_locale($this->locale);
        $product_info=$this->Product->find("all",array("conditions" => array("Product.id" => $product_id)));
        $product_list=array();
        foreach($product_info as $k => $v){
            $product_list[$v["Product"]["id"]]=$v;
        }
        $this->set("product_list",$product_list);
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $systemresource_info=$this->SystemResource->resource_formated(); //find("first",array("conditions"=>array("code"=>"order_status")));
        //
        $this->set('systemresource_info',$systemresource_info);
        $this->set('UserMessage_list',$UserMessage_list);
        $this->set('userproductgalleries_data',$userproductgalleries_data);
        $this->set('comments_info',$thisComment);
        $this->set('rank_list',$rank_list);
        $this->set('user_address',$user_address);
        $this->set('orders_list',$orders_list);
        $this->set('user_infoarr',$user_infoarr);
        $this->set('balances_list',$balances_list);
        $this->set('points_list',$points_list);
        $this->set('user_info',$this->data);
        //leo20090722导航显示
        $this->navigations[]=array('name' => $this->data["User"]["name"],'url' => '');
        $this->set('navigations',$this->navigations);

    }
    function addr($id){
    	$thisconsignee = $_REQUEST["thisconsignee"];
    	$thisaddress = $_REQUEST["thisaddress"];
    	$thistelephone = $_REQUEST["thistelephone"];
    	$thismobile = $_REQUEST["thismobile"];
    	$thisemail = $_REQUEST["thisemail"];
    	$thisbest_time = $_REQUEST["thisbest_time"];
    	$thissign_building = $_REQUEST["thissign_building"];
    	$thiszipcode = $_REQUEST["thiszipcode"];
    	$this->UserAddress->deleteAll(array("user_id"=>$id));
    	foreach( $thisconsignee as $k=>$v ){
    		$addr = array(
    			"consignee"=>$thisconsignee[$k],
    			"name"=>$thisconsignee[$k],
    			"address"=>$thisaddress[$k],
    			"telephone"=>$thistelephone[$k],
    			"mobile"=>$thismobile[$k],
    			"email"=>$thisemail[$k],
    			"best_time"=>$thisbest_time[$k],
    			"sign_building"=>$thissign_building[$k],
    			"zipcode"=>$thiszipcode[$k],
    			"user_id"=>$id
    		);
    		$this->UserAddress->saveAll(array("UserAddress"=>$addr));
    	}
    	$this->flash("收货地址 编辑成功。点击这里继续编辑该会员。",'/users/'.$id,10);
    }
    function add(){
        $this->pageTitle="编辑会员-会员查询"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '客户管理','url' => '');
        $this->navigations[]=array('name' => '会员查询','url' => '/users/');
        $this->navigations[]=array('name' => '新增会员','url' => '');
        $this->set('navigations',$this->navigations);
        if ($this->RequestHandler->isPost()){
            $this->data['User']['password']=md5($this->data['User']['new_password']);
            $this->data['User']['question']=!empty($this->data['User']['question']) ? $this->data['User']['question']: "";
            $this->data['User']['answer']=!empty($this->data['User']['answer']) ? $this->data['User']['answer']: "";
            $this->data['User']['balance']=!empty($this->data['User']['balance']) ? $this->data['User']['balance']: "0";
            $this->data['User']['frozen']=!empty($this->data['User']['frozen']) ? $this->data['User']['frozen']: "0";
            $this->data['User']['login_times']=!empty($this->data['User']['login_times']) ? $this->data['User']['login_times']: "0";
            $this->data['User']['login_ipaddr']=!empty($this->data['User']['login_ipaddr']) ? $this->data['User']['login_ipaddr']: "";
            $this->data['User']['unvalidate_note']=!empty($this->data['User']['unvalidate_note']) ? $this->data['User']['unvalidate_note']: "";

            $this->User->saveAll($this->data);

            if (!empty($this->params['form']['info_value']) && is_array($this->params['form']['info_value'])){
                foreach($this->params['form']['info_value']as $k => $v){
                    if (isset($this->params['form']['info_value_id'][$k]) && is_array($this->params['form']['info_value_id'][$k])){
                        $this->params['form']['info_value_id'][$k]=implode(';',$this->params['form']['info_value_id'][$k]);
                    }
                    $info_value=array('id' => "",'user_id' => $this->User->getLastInsertId(),'user_info_id' => $this->params['form']['info_value'][$k],'value' => !empty($this->params['form']['info_value_id'][$k]) ? $this->params['form']['info_value_id'][$k]: ""
                    );
                    $this->UserInfoValue->save(array('UserInfoValue' => $info_value));
                }
            }
            //操作员日志
            if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'新增会员:'.$this->data['User']['name'],'operation');
            }
            $this->flash("会员  ".$this->data['User']['name']." 添加成功。点击这里继续编辑该会员。",'/users/'.$this->User->getLastInsertId(),10);
        }
        //用户项目信息
        $this->UserInfo->set_locale($this->locale);
        $user_infoarr=$this->UserInfo->findAll();
        foreach($user_infoarr as $k => $v){
            $user_infoarr[$k]['UserInfo']['name']=$v['UserInfoI18n']['name'];
            $user_infoarr[$k]['UserInfo']['user_info_values']=$v['UserInfoI18n']['user_info_values'];

        }

        $this->set('user_infoarr',$user_infoarr);
    }
    /*------------------------------------------------------ */
    //-- 删除会员
    /*------------------------------------------------------ */
    function remove($id){
        /*判断权限*/
        $this->operator_privilege('member_operation');
        /*end*/
        $this->pageTitle="删除会员-会员查询"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '客户管理','url' => '');
        $this->navigations[]=array('name' => '会员查询','url' => '/users/');
        $this->navigations[]=array('name' => '删除会员','url' => '');
        $user_info=$this->User->findById($id);
        $this->User->del($id);
        //操作员日志
        if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
            $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除会员:'.$user_info['User']['name'],'operation');
        }
        $this->flash("删除成功",'/users/',10);
    }
    /*------------------------------------------------------ */
    //-- 批量处理
    /*------------------------------------------------------ */
    function batch(){
        //批量处理
        if (isset($this->params['url']['act_type']) && $this->params['url']['act_type']!="0"){
            $users_id=!empty($this->params['url']['checkboxes']) ? $this->params['url']['checkboxes']: 0;
            if ($this->params['url']['act_type']=='del'){
                $condition=array("User.id" => $users_id);
                $this->User->deleteAll($condition);
                //操作员日志
                if (isset($this->configs['open_operator_log']) && $this->configs['open_operator_log']==1){
                    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'批量删除会员','operation');
                }
                $this->flash("删除成功",'/users/','');
            }
        }
    }
	
	
	function order_search_user_information(){
		Configure::write('debug',0);
		$condition = "";
		$condition["User.status"] = "1";
        if (isset($this->params['url']['user_name']) && $this->params['url']['user_name']!=''){
            $condition["User.name like"]="%".$this->params['url']['user_name']."%";
            $this->set('user_name',$this->params['url']['user_name']);
        }
        $total=$this->User->findCount($condition,0);
        $sortClass='User';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
		$user_list = $this->User->find("all",array("conditions"=>$condition,"page"=>$page,"limit"=>$rownum));
		$this->set("user_list",$user_list);
	}
}

?>