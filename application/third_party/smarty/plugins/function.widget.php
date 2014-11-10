<?php
function smarty_function_widget($params,&$smarty){
	define('WIDGET', 1);
	$path = $params['path'];
	$args = isset($params['args']) ? $params['args'] : NULL;
	if($path){
		$ps = explode('/', $path);

		$method = array_pop($ps);
		$controller = array_pop($ps);
		$ps = join('/', $ps);
		require_once APPPATH.'controllers/'.$ps.'/'.$controller.'.php';

		$c = new $controller;

		if(!isset($params['args']))
			$c->$method();
		else
			$c->$method($args);
	}
}