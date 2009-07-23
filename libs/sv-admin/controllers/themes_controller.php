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
 * $Id: themes_controller.php 3251 2009-07-23 03:39:24Z huangbo $
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
			$curr_template_arr['template_style'] = $curr_template['Template']['template_style'];
		}else{
			$curr_template_arr = $this->get_template_info('SV_DEFAULT');
			$curr_template_arr['template_style'] = "";			
		}
	//	pr($curr_template_arr);
	    /* 获得目录可用的模版 */
	    $available_templates = array();
	    $theme_styles = array();
	    $template_dir        = @opendir('../themed/');
	    while ($file = readdir($template_dir))
	    {
	        if ($file != '.' && $file != '..' && is_dir('../themed/' . $file) && $file != '.svn' && $file != 'index.htm')
	        {
	            $available_templates[] = $this->get_template_info($file);
	            //$theme_styles[$file] = $this->theme_styles($file);
	        }
	    }
	 // pr($available_templates);
	    $this->set('theme_styles',$theme_styles);
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
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'安装模板:'.$curr['code'] ,'operation');
    	}
		die();
	}
	function get_cache_dirs($dirs){
		if(is_array($dirs)){
			$cache_dirs = array();
			foreach($dirs as $dir){
				if(is_dir(ROOT . $dir) && is_dir(ROOT . $dir .'/tmp/cache')){
					$cache_dirs[] = ROOT . $dir .'/tmp/cache/';
					$cache_dirs[] = ROOT . $dir .'/tmp/cache/models/';
					$cache_dirs[] = ROOT . $dir .'/tmp/cache/persistent/';
					$cache_dirs[] = ROOT . $dir .'/tmp/cache/views/';
				}
			}
			return $cache_dirs;
		}
	}
	
	
	function usethemed(){
		Configure::write('debug',0);
		$code=$_REQUEST['code'];
		$curr_template_arr = $this->get_template_info($code);
		$temp = $this->Template->findbyname($code);
		if(isset($temp['Template']['id']) && isset($curr_template_arr['style'][0])){
			$temp['Template']['template_style'] = $curr_template_arr['style'][0];
			$this->Template->save($temp['Template']);
		}
		$dirs = array('sv-cart','sv-user');
		$cache_dirs = $this->get_cache_dirs($dirs);
		$cache_key = md5("template_list_");
	    foreach ($cache_dirs AS $dir)
	    {
	        $folder = @opendir($dir);
	        if ($folder === false)
	        {
	            continue;
	        }
	        while ($file = readdir($folder))
	        {
	            if ($file == '.' || $file == '..' || $file == '.svn')
	            {
	                continue;
	            }
	            if (is_file($dir . $file) && ($dir . $file == $dir ."cake_".$cache_key || $dir . $file == $dir ."cake_model_default_svcart_templates"))
	            {
	            	//echo $dir . $file.'<br>';
                    if (@unlink($dir . $file))
                    {
                        $count++;
                    }
	            }
	        }
	        closedir($folder);
	    }
	//	if(){
	//		$this->Template->updateAll(array('Template.template_style' => $curr_template_arr['style'][0]),array('Template.name' => $code));
	//	}
		$this->Template->updateAll(array('Template.is_default' => "0"));
		$this->Template->updateAll(array('Template.is_default' => "1"),array('Template.name' => $code));
		die();
	}
	function deletethemed(){//卸载
		Configure::write('debug',0);
		$name=$_REQUEST['code'];
		$this->Template->deleteAll("Template.name='$name'");
		//操作员日志
    	if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	$this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'卸载模板:'.$name ,'operation');
    	}
		die();
	}	
	
	function currencythemed(){//是否可用
		Configure::write('debug',0);
		$code=$_REQUEST['code'];
		$flag=$_REQUEST['flag'];
		if($flag=="yes"){
			$this->Template->updateAll(array('Template.status' => "1"),array('Template.name' => $code));
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'设置模板:'.$code .' 为当前可用模板','operation');
    	    }
		}
		if($flag=="no"){
			$this->Template->updateAll(array('Template.status' => "0"),array('Template.name' => $code));
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'设置模板:'.$code .' 为不可用模板','operation');
    	    }
		}
		die();		
	}	
	
	function select_style(){
		$curr_template = $this->Template->find("where is_default ='1'");
		if($curr_template){
			$curr_template['Template']['template_style'] = $_POST['template_style'];
			$this->Template->save($curr_template);
		}
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



	    if (file_exists('../themed/' . $template_name . '/readme.txt') && !empty($template_name))
	    {
	        $arr = array_slice(file('../themed/'. $template_name. '/readme.txt'), 0, 7);
	        $template_name      = explode(': ', $arr[0]);
	        $template_style     = explode(': ', $arr[6]);
	        $template_uri       = explode(': ', $arr[1]);
	        $template_desc      = explode(': ', $arr[2]);
	        $template_version   = explode(': ', $arr[3]);
	        $template_author    = explode(': ', $arr[4]);
	        $author_uri         = explode(': ', $arr[5]);
	        
	        
	        $info['style']       = explode(',', $template_style[1]);
	        $info['name']       = isset($template_name[1]) ? trim($template_name[1]) : '';
	        $info['uri']        = isset($template_uri[1]) ? trim($template_uri[1]) : '';
	        $info['desc']       = isset($template_desc[1]) ? trim($template_desc[1]) : '';
	        $info['version']    = isset($template_version[1]) ? trim($template_version[1]) : '';
	        $info['author']     = isset($template_author[1]) ? trim($template_author[1]) : '';
	        $info['author_uri'] = isset($author_uri[1]) ? trim($author_uri[1]) : '';
	    }
	    else
	    {
	    	$info['style']      = '';
	        $info['name']       = '';
	        $info['uri']        = '';
	        $info['desc']       = '';
	        $info['version']    = '';
	        $info['author']     = '';
	        $info['author_uri'] = '';
	    }
	    $screenshot = isset($info['style'][0])?"screenshot_".$info['style'][0]:'screenshot';
	    foreach ($ext AS $val)
	    {
	        if (file_exists('../themed/' .  $info['code'] . "/{$screenshot}.{$val}"))
	        {
	            $info['screenshot'] = '/themed/' .  $info['code'] . "/{$screenshot}.{$val}";
	            break;
	        }
	    }
	    return $info;
	}
	
	

	function theme_styles($tpl_name, $flag=1)
	{
	    if (empty($tpl_name) && $flag == 1)
	    {
	        return 0;
	    }

	    /* 获得可用的模版 */
	    $temp = '';
	    $start = 0;
	    $available_templates = array();
	    $dir = '../themed/' . $tpl_name . '/css/';
	    $tpl_style_dir = @opendir($dir);
	    while ($file = readdir($tpl_style_dir))
	    {
	        if ($file != '.' && $file != '..' && is_file($dir . $file) && $file != '.svn' && $file != 'index.htm')
	        {
	            if (eregi("^(style|style_)(.*)*", $file)) // 取模板风格缩略图
	            {
	                $start = strpos($file, '.');
	                $temp = substr($file, 0, $start);
	                $temp = explode('_', $temp);
	                if (count($temp) == 2)
	                {
	                    $available_templates[] = $temp[1];
	                }
	            }
	        }
	    }
	    @closedir($tpl_style_dir);

	    $templates_temp = array('');
	    if (count($available_templates) > 0)
	    {
	        foreach ($available_templates as $value)
	        {
	            $templates_temp[] = $value;
	        }
	    }
	    return $templates_temp;
	}	
}

?>