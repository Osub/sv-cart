<?php
/*****************************************************************************
 * SV-Cart 操作员日志
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: operator_logs_controller.php 2703 2009-07-08 11:54:52Z huangbo $
 *****************************************************************************/
class OperatorLogsController extends AppController
{
    var $name='OperatorLogs';
    var $uses=array("Config");
    
    function index()
    {
        $this->pageTitle="操作员日志"." - ".$this->configs['shop_name'];
        $this->navigations[]=array('name' => '操作员日志','url' => '/operator_logs/');
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