<?php
function smarty_function_pagination($params,&$smarty){
	defined('WIDGET') OR define('WIDGET', 1);
	$path = $params['path'];
	$args = isset($params['args']) ? $params['args'] : NULL;
	if($path){
		$ps = explode('/', $path);

		$method = array_pop($ps);
		$controller = array_pop($ps);
		$ps = join('/', $ps);
		require_once APPPATH.'controllers/'.$ps.'/'.$controller.'.php';
		$ci = &get_instance();

		$c = new $controller;

		if(!isset($params['args']))
			$c->$method($ci);
		else
			$c->$method($args,$ci);
	}
}