<?php
/*****************************************************************************
 * SV-Cart 模板管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: themes_controller.php 1608 2009-05-21 02:50:04Z huangbo $
*****************************************************************************/
class ThemesController extends AppController {
	var $name = 'Themes';
	var $uses = array('Config','Template');
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('template_view');
		/*end*/
		$this->pageTitle = '模板管理'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'模板管理','url'=>'/themes/');
		$this->set('navigations',$this->navigations);
	
		
		/* 获得当前的模版的信息 */
		$curr_template = $this->Template->find("where is_default ='1'");
		if($curr_template){
			$curr_template_arr = $this->get_template_info($curr_template['Template']['name']);
		}else{
			$curr_template_arr = $this->get_template_info('SV_G00');			
		}
	    /* 获得目录可用的模版 */
	    $available_templates = array();
	    $template_dir        = @opendir('../themed/');
	    while ($file = readdir($template_dir))
	    {
	        if ($file != '.' && $file != '..' && is_dir('../themed/' . $file) && $file != '.svn' && $file != 'index.htm')
	        {
	            $available_templates[] = $this->get_template_info($file);
	        }
	    }
	    $install_templates=$available_templates;
		@closedir($template_dir);
		$tem=array();
		$temp=array();
	    $template_list=$this->Template->findAll("where is_default ='0'  and status ='1'","DISTINCT Template.name");//可用模板
	    foreach( $template_list as $k=>$v ){
	    	 $tem[$k]=$v['Template']['name'];
	    }
	    $template_in=$this->Template->findAll('','DISTINCT Template.name');//数据库模板信息
	    foreach( $template_in as $k=>$v ){
	    	 $temp[$k]=$v['Template']['name'];
	    }
	    /*可用模板信息*/
	    foreach($available_templates as $k=>$v ){
	    	if(in_array($v['code'],$tem)){
	    		$available_templates[$k]['flag']="1";
	    	}else{
	    		$available_templates[$k]['flag']="";
	    	}
	    	if(in_array($v['code'],$temp)){
	    	}else{
	    		unset($available_templates[$k]);
	    	}
	    	if($v['code']===$curr_template_arr['code']){
	    		unset($available_templates[$k]);
	    	}   	
	    }
      /*未安装模板信息*/
  	    foreach($install_templates as $k=>$v ){
	    	if(in_array($v['code'],$temp)){
	    		unset($install_templates[$k]);
	    	}
	    }  

	    $this->set('curr_template',       $curr_template_arr);
	    $this->set('available_templates', $available_templates);
	    $this->set('install_templates', $install_templates);	    
	}


	function installthemed(){//安装
		Configure::write('debug',0);
		$code=$_REQUEST['code'];
		$curr = $this->get_template_info($code);
		$this->data['Template']['name'] = $curr['code'];
		$this->data['Template']['author'] = $curr['author'];
		$this->data['Template']['url'] = $curr['author_uri'];
		$this->data['Template']['version'] = $curr['version'];
		$this->Template->saveall($this->data['Template']);
		die();
	}
	
	function usethemed(){
		Configure::write('debug',0);
		$code=$_REQUEST['code'];
		$this->Template->updateAll(array('Template.is_default' => "0"));
		$this->Template->updateAll(array('Template.is_default' => "1"),array('Template.name' => $code));
		die();
	}
	function deletethemed(){//卸载
		Configure::write('debug',0);
		$name=$_REQUEST['code'];
		$this->Template->deleteAll("Template.name='$name'");
		die();
	}	
	
	function currencythemed(){//是否可用
		Configure::write('debug',0);
		$code=$_REQUEST['code'];
		$flag=$_REQUEST['flag'];
		if($flag=="yes"){
			$this->Template->updateAll(array('Template.status' => "1"),array('Template.name' => $code));
		}
		if($flag=="no"){
			$this->Template->updateAll(array('Template.status' => "0"),array('Template.name' => $code));
		}
		die();		
	}	
	


	function tmp_show(){		
		/* 获得当前的模版的信息 */
		$curr_template = $this->Template->find("where is_default ='1'");
		if($curr_template){
			$curr_template_arr = $this->get_template_info($curr_template['Template']['name']);
		}else{
			$curr_template_arr = $this->get_template_info('SV_G00');			
		}
	    /* 获得目录可用的模版 */
	    $available_templates = array();
	    $template_dir        = @opendir('../themed/');
	    while ($file = readdir($template_dir))
	    {
	        if ($file != '.' && $file != '..' && is_dir('../themed/' . $file) && $file != '.svn' && $file != 'index.htm')
	        {
	            $available_templates[] = $this->get_template_info($file);
	        }
	    }
	    $install_templates=$available_templates;
		@closedir($template_dir);
		$tem=array();
		$temp=array();
	    $template_list=$this->Template->findAll("where is_default =0  and status ='1'",'DISTINCT Template.name');//可用模板
	    foreach( $template_list as $k=>$v ){
	    	 $tem[$k]=$v['Template']['name'];
	    }
	    $template_in=$this->Template->findAll('','DISTINCT Template.name');//数据库模板信息
	    foreach( $template_in as $k=>$v ){
	    	 $temp[$k]=$v['Template']['name'];
	    }
	    /*可用模板信息*/
	    foreach($available_templates as $k=>$v ){
	    	if(in_array($v['code'],$tem)){
	    		$available_templates[$k]['flag']="1";
	    	}else{
	    		$available_templates[$k]['flag']="";
	    	}
	    	if(in_array($v['code'],$temp)){
	    	}else{
	    		unset($available_templates[$k]);
	    	}
	    	if($v['code']===$curr_template_arr['code']){
	    		unset($available_templates[$k]);
	    	}   	
	    }
      /*未安装模板信息*/
  	    foreach($install_templates as $k=>$v ){
	    	if(in_array($v['code'],$temp)){
	    		unset($install_templates[$k]);
	    	}
	    }  

	    $this->set('curr_template',       $curr_template_arr);
	    $this->set('available_templates', $available_templates);
	    $this->set('install_templates', $install_templates);
	}


	
	function get_template_info($template_name)
	{
	    $info = array();
	    $ext  = array('png', 'gif', 'jpg', 'jpeg');

	    $info['code']       = $template_name;
	    $info['screenshot'] = '';

	    foreach ($ext AS $val)
	    {
	        if (file_exists('../themed/' . $template_name . "/screenshot.$val"))
	        {
	            $info['screenshot'] = '../themed/' . $template_name . "/screenshot.$val";

	            break;
	        }
	    }

	    if (file_exists('../themed/' . $template_name . '/readme.txt') && !empty($template_name))
	    {
	        $arr = array_slice(file('../themed/'. $template_name. '/readme.txt'), 0, 6);

	        $template_name      = explode(': ', $arr[0]);
	        $template_uri       = explode(': ', $arr[1]);
	        $template_desc      = explode(': ', $arr[2]);
	        $template_version   = explode(': ', $arr[3]);
	        $template_author    = explode(': ', $arr[4]);
	        $author_uri         = explode(': ', $arr[5]);


	        $info['name']       = isset($template_name[1]) ? trim($template_name[1]) : '';
	        $info['uri']        = isset($template_uri[1]) ? trim($template_uri[1]) : '';
	        $info['desc']       = isset($template_desc[1]) ? trim($template_desc[1]) : '';
	        $info['version']    = isset($template_version[1]) ? trim($template_version[1]) : '';
	        $info['author']     = isset($template_author[1]) ? trim($template_author[1]) : '';
	        $info['author_uri'] = isset($author_uri[1]) ? trim($author_uri[1]) : '';
	    }
	    else
	    {
	        $info['name']       = '';
	        $info['uri']        = '';
	        $info['desc']       = '';
	        $info['version']    = '';
	        $info['author']     = '';
	        $info['author_uri'] = '';
	    }

	    return $info;
	}
	
	
}

?>