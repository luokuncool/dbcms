<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	http://example.com/
|
| If this is not set then CodeIgniter will guess the protocol, domain and
| path to your installation.
|
*/

//节点分组
$config['node_group'] = array(
	'1' => '节点管理',
	'2' => '系统设置',
	'3' => '个人设置',
);

//主题列表
$config['theme_list'] = array(
	'black',
	'bootstrap',
	'default',
	'gray',
	'metro',
	'metro-blue',
	'metro-gray',
	'metro-green',
	'metro-orange',
	'metro-red',
	'ui-cupertino',
	'ui-dark-hive',
	'ui-pepper-grinder',
	'ui-sunny',
);
