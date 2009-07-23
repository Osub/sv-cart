<?php
/* SVN FILE: $Id: app_model.php 2699 2009-07-08 11:07:31Z huangbo $ */
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.model
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model
 */
class AppModel extends Model {
	function cacheFind($model_name ,$method , $params = array()) {
		$cache_key = md5($model_name.$method.serialize($params));
		
		$data = cache::read($cache_key);
		if ($data){
			return $data;
		}else{
			return false;
		}
	}
	
	function cacheSave($model_name ,$method , $params = array(),$arr) {
		$cache_key = md5($model_name.$method.serialize($params));
		$data = cache::write($cache_key,$arr);
	}
	
	
	function cache_find($type, $params = array(),$model_name) {
		$cache_key = md5($type.serialize($params).$model_name);
		$data = cache::read($cache_key);
		if ($data){
			return $data;
		}else{
			$data = $this->find($type,$params);
			cache::write($cache_key,$data);
			return $data;
		}
	}
	
	
}
?>