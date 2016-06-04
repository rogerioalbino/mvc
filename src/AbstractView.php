<?php

/**
 * @author 	  Rogério Albino
 * @link      http://github.com/rogerioalbino/mvc
 * @license   mit
 */

class AbstractView {

	private $pageVars = array();
	private $template;

	public function __construct($template){
		$this->template = VIEW_DIR .'view/'. $template .'.php';

		$this->render();
	}

	public function set($var, $val){
		$this->pageVars[$var] = $val;
	}

	public function render(){
		extract($this->pageVars);

		ob_start();
		require($this->template);
		echo ob_get_clean();
	}
    
}