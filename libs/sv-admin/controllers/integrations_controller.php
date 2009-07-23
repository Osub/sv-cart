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
 * $Id: integrations_controller.php 2703 2009-07-08 11:54:52Z huangbo $
*****************************************************************************/
class IntegrationsController extends AppController {

	var $name = 'Integrations';
    var $components = array ('Pagination','RequestHandler'); // Added 
    var $helpers 	= array('Pagination'); // Added 
	var $uses 		= array("Plugin");
		
	function index(){
		$this->pageTitle = '会员整合'." - ".$this->configs['shop_name'];
		$this->navigations[] = array('name'=>'会员整合','url'=>'/integrations/');
		$this->set('navigations',$this->navigations);
		
		$dir = ROOT.APP_DIR."/plugins/";
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					if ($file!="." && $file!=".." && $file!="empty" && $file!=".svn" && $file!=".svn") {
						$mydir[] = $file;
					}
				}
				closedir($dh);
			}
		}
		$modules = array();
		foreach( $mydir as $k=>$v){
			$plugin = $this->Plugin->find(array("code"=>$v));
			if(!empty($plugin)&&file_exists($dir.$v."/".$v.".php")){
				include($dir.$v."/".$v.".php");
			}
		}
		$integrate_code = isset($this->configs["integrate_code"])?$this->configs["integrate_code"]:"";
		
		$this->set("modules",$modules);
		$this->set("integrate_code",$integrate_code);
		
	}
    
    /* ucenter模块的基本信息 */
    function ucenter(){
	    /* 会员数据整合插件的代码必须和文件名保持一致 */
	    $modules['code']    = 'ucenter';

	    /* 被整合的第三方程序的名称 */
	    $modules['name']    = 'UCenter';

	    /* 被整合的第三方程序的版本 */
	    $modules['version'] = '1.1';

	    /* 插件的作者 */
	    $modules['author']  = 'SVCART R&D TEAM';

	    /* 插件作者的官方网站 */
	    $modules['website'] = 'http://www.seevia.com';

	    /* 插件的初始的默认值 */
	    $modules['default']['db_host'] = 'localhost';
	    $modules['default']['db_user'] = 'root';
	    $modules['default']['prefix'] = 'uc_';
	    $modules['default']['cookie_prefix'] = 'xnW_';

    	return $modules;
    }
}



?>