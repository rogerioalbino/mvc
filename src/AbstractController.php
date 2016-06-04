<?php

/**
 * @author 	  Rogério Albino
 * @link      http://github.com/rogerioalbino/mvc
 * @license   mit
 */

class AbstractController {
	
	public function loadModel($modelName){
		require(APP_DIR .'model/'. strtolower($modelName) .'.php');

		$model = new $modelName;
		return $model;
	}
	
	public function view($viewName, $data = null){
		$view = new AbstractView($viewName, $data);
		return $view;
	}
	
	public function redirect($loc){
		global $config;
		
		header('Location: '. $config['base_url'] . $loc);
	}

	
}