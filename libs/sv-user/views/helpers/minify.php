<?php 
/***
 * Cakephp view helper to interface with http://code.google.com/p/minify/ project.
 * Minify: Combines, minifies, and caches JavaScript and CSS files on demand to speed up page loads.
 * @author: Ketan Shah - ketan.shah@gmail.com - http://www.innovatechnologies.in
 * Requirements: An entry in core.php - "MinifyAsset" - value of which is either set 'true' or 'false'. False would be usually set during development and/or debugging. True should be set in production mode.
 */

Class MinifyHelper extends AppHelper{
        
        var $helpers = array('Javascript','Html'); //used for seamless degradation when MinifyAsset is set to false;
        
        function js($assets){
            if(Configure::read('MinifyAsset')){
               e(sprintf("<script type='text/javascript' src='%s'></script>",$this->_path($assets, 'js')));
            }
            else{
                e($this->Javascript->link($this->right_path($assets,'js')));
            }
        }
        
        
        function css($assets){
            if(Configure::read('MinifyAsset')){
                e(sprintf("<link type='text/css' rel='stylesheet' href='%s' />",$this->_path($assets, 'css')));
            }
            else{
                e($this->Html->css($this->right_path($assets,'css')));
            }
        }
        
        function _path($assets, $ext){
        //	print_r($assets);
            $path = $this->webroot . "../min/f=";
        	if(Configure::read('App.baseUrl'))
            	$path = str_replace(APP_DIR."/","",$this->webroot) . "../min/index.php?f=";
            foreach($assets as $asset){
            	
            	if (strpos($asset, '?') === false) {
					if (strpos($asset, '.'.$ext) === false) {
						$asset .= '.'.$ext;
					}
				}
		//	echo $this->webroot($asset);
                $path .= ($this->webroot($asset) . ",");
            }
            return substr($path, 0, count($path)-2);
        }
        function right_path($assets,$ext){
        	if($this->themeWeb){
	        	foreach($assets as $k=>$v){
	        		$assets[$k] = str_replace($this->themeWeb.$ext.'/','',$v);
	        	}
        	}
        	return $assets;
        }
    }

?>