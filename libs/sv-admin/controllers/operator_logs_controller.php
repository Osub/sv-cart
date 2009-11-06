<?php
/*****************************************************************************
 * SV-Cart 操作日志
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: operator_logs_controller.php 4366 2009-09-18 09:49:37Z huangbo $
 *****************************************************************************/
class OperatorLogsController extends AppController
{
    var $name='OperatorLogs';
    var $components=array('Pagination','RequestHandler','Email');
    var $helpers=array('Pagination','Html','Form','Javascript','Tinymce');

    var $uses=array("Config");
    
    function index(){
		/*判断权限*/
		$this->operator_privilege('operator_log_view');
		/*end*/
        $this->pageTitle="操作日志"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'内部管理','url'=>'');
        $this->navigations[]=array('name' => '操作日志','url' => '/operator_logs/');
        $this->set('navigations',$this->navigations);
        $condition = "";
        if(isset($this->params['url']['date']) && $this->params['url']['date']!=''){
        	$condition["and"]["created >="] = $this->params['url']['date']." 00:00:00";
            
        }
        if(isset($this->params['url']['date2']) && $this->params['url']['date2']!=''){
        	$condition["and"]["created <="] = $this->params['url']['date2']." 23:59:59";
            
        }
        if(isset($this->params['url']['operator_id']) && $this->params['url']['operator_id']!=''){
        	$condition["and"]["operator_id"] = $this->params['url']['operator_id'];
            
        }
        if(isset($this->params['url']['keywords']) && $this->params['url']['keywords']!=''){
        	$condition["and"]["or"]["info like"] = "%".$this->params['url']['keywords']."%";
        	$condition["and"]["or"]["action_url like"] = "%".$this->params['url']['keywords']."%";
        	$condition["and"]["or"]["ipaddress like"] = "%".$this->params['url']['keywords']."%";
        }

        $total=$this->Operator_log->findCount($condition,0);
        $sortClass='Operator_log';
        $page=1;
        $rownum=isset($this->configs['show_count']) ? $this->configs['show_count']: ((!empty($rownum)) ? $rownum : 20);
        $parameters=Array($rownum,$page);
        $options=Array();
        $page=$this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
    	$operator_log_info = $this->Operator_log->find("all",array("conditions"=>$condition,"order"=>"id desc","page"=>$page,"limit"=>$rownum));
    	$operator_list = $this->Operator->find("all");
    	$date=isset($this->params['url']['date']) ? $this->params['url']['date']: "";
    	$date2=isset($this->params['url']['date2']) ? $this->params['url']['date2']: "";
    	$operator_id=isset($this->params['url']['operator_id']) ? $this->params['url']['operator_id']: "";
    	$keywords=isset($this->params['url']['keywords']) ? $this->params['url']['keywords']: "";
	
    	$this->set('keywords',$keywords);
    	$this->set('operator_id',$operator_id);
    	$this->set('date',$date);
    	$this->set('date2',$date2);
    	$this->set("operator_log_info",$operator_log_info);
    	$this->set("operator_list",$operator_list);
    }
	function remove($id){
		/*判断权限*/
		$this->operator_privilege('operator_log_del');
		/*end*/
		$this->pageTitle = "删除操作日志-操作日志"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'内部管理','url'=>'');
		$this->navigations[] = array('name'=>'操作日志','url'=>'/operator_logs/');
		$this->navigations[] = array('name'=>'删除操作日志','url'=>'');
		//$operator_log = $this->Operator_log->findById($id);
		$this->Operator_log->del($id);

		$this->flash("删除成功",'/operator_logs/',10);
    }
    function batch(){
		/*判断权限*/
		$this->operator_privilege('operator_log_del');
		/*end*/
   	   //批量处理
	   if(isset($this->params['url']['act_type']) && $this->params['url']['act_type'] !="0"){
	   	   $operator_log_id = !empty($this->params['url']['checkboxes']) ? $this->params['url']['checkboxes'] : 0;
         	   if ($this->params['url']['act_type'] == 'del')
               {
                     $condition=array("Operator_log.id"=>$operator_log_id);
                     $this->Operator_log->deleteAll($condition);
                     $this->flash("选定的操作日志，批量删除成功",'/operator_logs/','');
                }
	   }
    }
    function index1()
    {
        $this->pageTitle="操作日志"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'内部管理','url'=>'');
        $this->navigations[]=array('name' => '操作日志','url' => '/operator_logs/');
        $this->set('navigations',$this->navigations);
        
        $path = dirname(dirname(__FILE__)) . '\tmp\logs\operation.log';
        $log_array = array();
        $log_array1 = array();
	    $file_handle = fopen($path, "a+");
        while (!feof($file_handle)) {
        $line = fgets($file_handle);
        $log_array[] = $line;
        }
        fclose($file_handle);
        foreach($log_array as $k => $v){
        	$line1 = explode('Operation:', $v);
        	$line2 = explode(' ', trim(@$line1[1]));

        	$line3[0]= $line1[0];
        	$line3[1]= substr($line2[0],9);
        	$line3[2]= @$line2[1];

        	foreach($line3 as $kk => $vv){
        		$log_array1[$k][$kk]=$vv;
        	}
        }
        $this->set('log_array',$log_array1);
    }
}
?>