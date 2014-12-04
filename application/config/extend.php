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
    '4' => '测试模块',
);

//主题列表
$config['themeList'] = array(
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
$config['var_filters'] = '';

//默认过滤
$config['default_filter'] = 'trim';

//缓存时间
$config['dataCacheTime'] = 0;

//系统名称
$config['system_name'] = 'EasyUI System';

$config['cache_type'] = array('adapter'=>'redis'); // 支持类型：apc, file, memcached, dummy, redis, default

$config['changedRow'] = 'changedRow';

//分页配置
$config['pageSetting'] = array(
    'pageSize'=>'25',
    'pageList'=>'[10,15,20,25,30,35,40,45,50,100,200]'
);

//不需要登录验证的节点
$config['withoutCheckLogin'] = array(
    'home/login'
);

$config['withoutCheckAccess'] = array(
    'home/index','home/logout',
);

