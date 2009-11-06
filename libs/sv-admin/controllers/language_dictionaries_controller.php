<?php
/*****************************************************************************
 * SV-Cart 字典语言管理
 * ===========================================================================
 * 版权所有  上海实玮网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.seevia.cn
 * ---------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ===========================================================================
 * $开发: 上海实玮$
 * $Id: language_dictionaries_controller.php 3616 2009-08-12 10:06:26Z shenyunfeng $
*****************************************************************************/
class LanguageDictionariesController extends AppController {
	var $name = 'LanguageDictionaries';
	var $helpers = array('Html','Pagination');
	var $components = array ('Pagination','RequestHandler'); 
	var $uses = array('Language','LanguageDictionary','SystemResource','SystemResourceI18n');
	
	function index(){
		/*判断权限*/
		$this->operator_privilege('dictionary_manage_view');
		/*end*/
		$this->pageTitle = "字典管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'功能管理','url'=>'');
		$this->navigations[] = array('name'=>'字典管理','url'=>'/language_dictionaries/');
		unset($is_select_locale);
		unset($is_select_type);
		unset($_SESSION['is_select_locale']);
		unset($_SESSION['is_select_type']);
		unset($_SESSION['is_keywords']);
		unset($_SESSION['is_location']);
		$language = $this->Language->findall();
		if(isset($language) && count($language)>0 && isset($_GET['locale'])){
			foreach($language as $k=>$v){
				if($v['Language']['locale'] == $_GET['locale']){
					$is_select_locale = $_GET['locale'];
					$_SESSION['is_select_locale'] = $is_select_locale; 
					$this->set('is_select_locale',$is_select_locale);
				}
			}
		}
        //资源库信息
        $this->SystemResource->set_locale($this->locale);
        $language_type = $this->SystemResource->find_tree('language_dictionary_type');
		if(isset($language_type) && count($language_type)>0 && isset($_GET['language_type'])){
			foreach($language_type as $k=>$v){
				if($v['SystemResource']['resource_value'] == $_GET['language_type']){
					$is_select_type = $_GET['language_type'];
					$this->set('is_select_type',$is_select_type);
					$_SESSION['is_select_type'] = $is_select_type; 
				}
			}
		}
		$language_type_assoc = $this->SystemResource->find_assoc('language_dictionary_type');
		//pr($language_type_assoc);
		$this->set('language_type_assoc',$language_type_assoc);
		$this->set('language_type',$language_type);
		
		if(!empty($is_select_locale)){
			$condition['AND'][0]= "LanguageDictionary.locale = '$is_select_locale' ";
		
			if(!empty($is_select_type) && $is_select_type != "all_type"){
				$condition['AND'][1]= "LanguageDictionary.type = '$is_select_type' ";
			}
			if(isset($_GET['language_location'])){
				$is_select_location = $_GET['language_location'];
				$_SESSION['is_select_location'] = $is_select_location;
				if($_GET['language_location'] != "all_location"){
					$condition['AND'][2]= "LanguageDictionary.location = '$is_select_location' ";
				}
			}
			if(isset($_GET['keywords'])){
				$keywords =$_GET['keywords'];
				$condition['OR'][0] = "LanguageDictionary.name like '%$keywords%' ";
				$condition['OR'][1] = "LanguageDictionary.description like '%$keywords%' ";
				$condition['OR'][2] = "LanguageDictionary.value like '%$keywords%' ";
				$_SESSION['is_keywords'] = $keywords; 
			}
			
			$total = $this->LanguageDictionary->findCount($condition,0);
		 	$page=1;
	  		$rownum=10;
	 	    $parameters=array($rownum,$page);
	 	    $options=array();
	 	   	$sortClass='LanguageDictionary';
	 	  	list($page) = $this->Pagination->init($condition,$parameters,$options,$total,$rownum,$sortClass);
	 	    $language_dictionaries = $this->LanguageDictionary->findall($condition,"","LanguageDictionary.id",$rownum,$page);

		    $this->set('language_dictionaries',$language_dictionaries);
		}
		
	
		
		$this->set('locale',$this->locale);
		$this->set('language',$language);
		$this->set('navigations',$this->navigations);
	}
	
	function export(){
		
        if(isset($_REQUEST['export']) && $_REQUEST['export']==="export"){
        	
			$is_select_locale = $_REQUEST['export_locale'];
		
			$is_select_type = $_REQUEST['export_type'];
		
		
		if(!empty($is_select_locale)){
			$condition['AND'][0]= "LanguageDictionary.locale = '$is_select_locale' ";
		
				if(!empty($is_select_type) && $is_select_type != "all_type"){
					$condition['AND'][1]= "LanguageDictionary.type = '$is_select_type' ";
				}
				if(isset($_REQUEST['export_location']) && $_REQUEST['export_location'] != ''){
					$is_select_location = $_REQUEST['export_location'];
					if($_REQUEST['export_location'] != "all_location"){
						$condition['AND'][2]= "LanguageDictionary.location = '$is_select_location' ";
					}
				}
				if(isset($_REQUEST['export_keyword']) && $_REQUEST['export_keyword'] != ''){
					$keywords =$_REQUEST['export_keyword'];
					$condition['OR'][0] = "LanguageDictionary.name like '%$keywords%' ";
					$condition['OR'][1] = "LanguageDictionary.description like '%$keywords%' ";
					$condition['OR'][2] = "LanguageDictionary.value like '%$keywords%' ";
				}
		//		pr($condition);exit;
		 	    $language_dictionaries = $this->LanguageDictionary->find('all',array('conditions'=>array($condition),'order'=>"LanguageDictionary.id ASC"));
	            $filename='字典语言导出'.date('Ymd').'.csv';
	            $ex_data="字典语言,";
	            $ex_data.="日期,";
	            $ex_data.=date('Y-m-d')."\n";
	            $ex_data.="编号,";
	            $ex_data.="名称,";
	            $ex_data.="语言编码,";
	            $ex_data.="位置,";
	            $ex_data.="类型,";
	            $ex_data.="内容,";
	            $ex_data.="描述\n";
	            foreach($language_dictionaries as $k => $v){
	                $ex_data.= $v['LanguageDictionary']['id'].",";
	                $ex_data.= $v['LanguageDictionary']['name'].",";
	                $ex_data.= $v['LanguageDictionary']['locale'].",";
	                $ex_data.= $v['LanguageDictionary']['location'].",";
	                $ex_data.= $v['LanguageDictionary']['type'].",";
	                $ex_data.= "\"".$v['LanguageDictionary']['value']."\",";
	                $ex_data.= "\"".$v['LanguageDictionary']['description']."\"\n";
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
	}
	
	function import(){
        $this->pageTitle="字典语言批量上传"." - ".$this->configs['shop_name'];
        $this->navigations[] = array('name'=>'功能管理','url'=>'');
        $this->navigations[]=array('name' => '字典管理','url' => '/language_dictionaries/');
        $this->navigations[]=array('name' => '字典语言批量上传','url' => '');
        $this->set('navigations',$this->navigations);
        if(!empty($_FILES['file'])){
            if($_FILES['file']['error'] > 0){
                $this->flash("文件上传错误",'/language_dictionaries','');
            }else{
                $handle=@fopen($_FILES['file']['tmp_name'],"r");
                $key_arr=array('id','name','locale','location','type','value','description','','');
                while($row=fgetcsv($handle,10000,",")){
                    foreach($row as $k => $v){
                        $temp[$key_arr[$k]]=iconv('gb2312','utf-8',$v);
                    }
                 // $temp['description']=htmlspecialchars($temp['description']);
                    $data[]=$temp;
                }

            }
        }
        
        
        if(isset($data) && sizeof($data)>0){
        	$all_lang = $this->LanguageDictionary->getcode($this->locale);
        	foreach($data as $k=>$v){
        		if(isset($v['id']) && $v['id'] != '' && isset($v['name']) && $v['name'] != '' && !in_array($v['name'],$all_lang) && isset($v['locale']) && $v['locale'] != '' && isset($v['location']) && $v['location'] != '' && isset($v['type']) && $v['type'] != '' && isset($v['value']) && $v['value'] != '' && isset($v['description']) && $v['description'] != ''){
        			$mew = array('id' =>'',
			        				'name' => $v['name'],
			        				'locale' => $v['locale'],
			        				'location' => $v['location'],
			        				'type' => $v['type'],
			        				'value' => $v['value'],
			        				'description' => $v['description'],
        							);
        	  		$this->LanguageDictionary->save($mew);
        		}
        	}
        }
                $this->flash("上穿成功",'/language_dictionaries','');
	}
	
	
	function add(){
		/*判断权限*/
		$this->operator_privilege('dictionary_manage_add');
		/*end*/
		$this->pageTitle = "添加字典 - 字典管理"." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'功能管理','url'=>'');
		$this->navigations[] = array('name'=>'字典管理','url'=>'/language_dictionaries/');
		$this->navigations[] = array('name'=>'添加字典','url'=>'');
		$this->set('navigations',$this->navigations);

		if($this->RequestHandler->isPost()){
			$lang['name'] = $_REQUEST['name'];
			$lang['type'] = $_REQUEST['type'];
			$lang['location'] = $_REQUEST['location'];
			

			foreach($this->data['LanguageDictionary'] as $k=>$v){
				$lang['id'] = "";
				$lang['locale'] = $k;
				$lang['value'] = $v['value'];
				$lang['description'] = $v['description'];
				if($lang['description'] != "" && $lang['value'] != ""){
				$this->LanguageDictionary->save($lang);
				}
			}
			$localeUrl = "?";
			if(isset($_SESSION['is_select_locale'])){
				$localeUrl .= "locale=".$_SESSION['is_select_locale']."&";
			}
			if(isset($_SESSION['is_select_type'])){
				$localeUrl .= "language_type=".$_SESSION['is_select_type']."&";
			}
			if(isset($_SESSION['is_keywords'])){
			$localeUrl .= "keywords=".$_SESSION['is_keywords']."&";
			}
			if(isset($_SESSION['is_select_location'])){
			$localeUrl .= "language_location=".$_SESSION['is_select_location']."&";
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'添加字典语言' ,'operation');
    	    }
			$this->flash('添加成功',"/language_dictionaries/".$localeUrl,10 );
		}
	}
	
	
	
	function remove($id){
		
		$pn = $this->LanguageDictionary->find('list',array('fields' => array('LanguageDictionary.id','LanguageDictionary.name'),'conditions'=> 
                                        array('LanguageDictionary.id'=>$id,'LanguageDictionary.locale'=>$this->locale)));
		$this->LanguageDictionary->remove($id);
			$localeUrl = "?";
			if(isset($_SESSION['is_select_locale'])){
				$localeUrl .= "locale=".$_SESSION['is_select_locale']."&";
			}
			if(isset($_SESSION['is_select_type'])){
				$localeUrl .= "language_type=".$_SESSION['is_select_type']."&";
			}
			if(isset($_SESSION['is_keywords'])){
			$localeUrl .= "keywords=".$_SESSION['is_keywords']."&";
			}
			if(isset($_SESSION['is_select_location'])){
			$localeUrl .= "language_location=".$_SESSION['is_select_location']."&";
			}
			//操作员日志
    	    if(isset($this->configs['open_operator_log']) && $this->configs['open_operator_log'] == 1){
    	    $this->log('操作员'.$_SESSION['Operator_Info']['Operator']['name'].' '.'删除字典语言:'.$pn[$id] ,'operation');
    	    }
		$this->flash('删除成功',"/language_dictionaries/".$localeUrl,10 );
	}
	
	function go_input(){
		if($this->RequestHandler->isPost()){
			Configure::write('debug',0);
			$result['id'] = $_REQUEST['id'];
			$result['value'] = $_REQUEST['value'];
			$result['len'] = $_REQUEST['len'];
			$result['style'] = $_REQUEST['type'];
			if($result['style'] == "type"){
				$result['change_type'] = "select";
		        //资源库信息
		        $this->SystemResource->set_locale($this->locale);
				$result['language_type'] = $this->SystemResource->find_tree('language_dictionary_type');
				$result['language_type_assoc'] = $this->SystemResource->find_assoc('language_dictionary_type');
			}else{
				$result['change_type'] = "input";
			}
			$result['type'] = 0;
			$result['message'] = 'test';
		}
	//	die(json_encode($result));
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function update_lang_dictionarie(){
		if($this->RequestHandler->isPost()){
			Configure::write('debug',0);
			$result['id'] = $_POST['id'];
			$result['value'] = $_POST['value'];
			$result['style'] = $_POST['type'];
			$result['len'] = $_POST['len'];
			$lang_dictionarie['id'] = $_REQUEST['id'];
			$lang_dictionarie[$_REQUEST['type']] = $_POST['value'];
			if(trim($_POST['value']) != ""){
			$this->LanguageDictionary->save($lang_dictionarie);
			}else{
			$language_dictionary = $this->LanguageDictionary->findbyid($_POST['id']);
			$result['value'] = $language_dictionary['LanguageDictionary'][$_POST['type']];
			}
			$result['type'] = 0;
			$result['message'] = 'test';
		}
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function translate(){
		if($this->RequestHandler->isPost()){
			Configure::write('debug',0);
			$sl = $_POST['sl'];
			$lang_value = urlencode($_POST['value']);
			$tl = $_POST['google'];
			$url = "http://translate.google.cn/translate_a/t?client=t&ie=utf8"."&sl=".$sl."&tl=".$tl."&text=".$lang_value;
			$req_value = $this->translates($url);
			if($req_value[0] !="\""){
				$result['value'] = $req_value;
			}else{
				$n = strlen($req_value);
				$result['value'] = substr($req_value,1,$n-2);
			}
			$result['locale'] = $_POST['locale'];
			//$language = $this->Language->findall();
		//	$g = 0;
			//pr($this->loacle);exit;
			/*
			foreach($language as $k=>$v){
			//	print($v['Language']['locale']."-".$_REQUEST['locale']."<br />");
				if($v['Language']['locale'] != $_REQUEST['locale']){
				//	print($v['Language']['google_translate_code']."<br />");
					$url = "http://translate.google.cn/translate_a/t?client=t&ie=utf8"."&sl=".$sl."&tl=".$v['Language']['google_translate_code']."&text=".$lang_value;
					$req_value = $this->translates($url);
					if($req_value[0] !="\""){
					$result['value'][$g] = $req_value;
					}else{
					$n = strlen($req_value);
					$result['value'][$g] = substr($req_value,1,$n-2);
					}
					$result['locale'][$g] = $v['Language']['locale'];
					$g ++;
				}
			}*/
			//$result['num'] = count($language)-1;
			$result['type'] = 0;
			//$result['locale'] = $_REQUEST['locale'];
		}
		//print("result:");
		//pr($result);
		$this->set('result',$result);
		$this->layout = 'ajax';
	}
	
	function translates($url){

		$handle = file_get_contents($url);

		$handle = mb_convert_encoding($handle, 'UTF-8', 'GBK');
		if(preg_match("/.*(\[).*/",$handle))
		{
			$r= json_decode($handle);
			$value=$r[0];
		//	$desc= json_encode($r[0]);
		//	$desc = preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $desc);
		}else
		{
			$value = $handle;
			$desc = "";
		}
		$result[0] = $value;
		//$result[1] = $desc;

		return $value;
	}
}

?>