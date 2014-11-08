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

//全局过滤过滤
$config['var_filters'] = 'intval';

//默认过滤
$config['default_filter'] = '';

//缓存类型
$config['data_cache_type'] = 'memcache';

//缓存时间
$config['data_cache_time'] = 30;

//系统名称
$config['system_name'] = 'EasyUI System';

