<?php

/**
 * @author 	  Rogério Albino
 * @link      http://github.com/rogerioalbino/mvc
 * @license   mit
 */

class AbstractApplication{


	public function __construct(){

		global $config;

    // Set our defaults
		$controller = $config['default_controller'];
		$action = 'indexAction';
		$url = '';

	// Get request url and script url
		$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';

	// Get our url path and trim the / of the left and the right
		if($request_url != $script_url) 
			$url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');

	// Split the url into segments
		$segments = explode('/', $url);


	// Do our default checks
		if(isset($segments[0]) && $segments[0] != '') $controller = $segments[0];
		if(isset($segments[1]) && $segments[1] != '') $action = $segments[1];

	// Get our controller file
		$path = APP_DIR . 'controller/' . $controller . '.php';
		if(file_exists($path)){
			require_once($path);
		} else {
			$controller = $config['error_controller'];
			require_once(APP_DIR . 'controller/' . $controller . '.php');
		}

    // verificar se o metodo existe
		if(!method_exists($controller, $action)){
			$controller = $config['error_controller'];
			require_once(APP_DIR . 'controller/' . $controller . '.php');
			$action = 'indexAction';
		}

	// cria objeto chama metodo
		$object = new $controller;
		die(call_user_func_array(array($object, $action), array_slice($segments, 2)));
	}

}