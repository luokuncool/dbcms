<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the 'welcome' class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

/**
 * 前台部分
 */
$route['default_controller'] = 'home/home';
$route['404_override'] = '';


/**
 * 后台部分
 */
$route['admin'] = 'admin/index';
$route['admin/login'] = 'admin/index/login';
$route['admin/site_info'] = 'admin/index/site_info';
$route['admin/clear_cache'] = 'admin/index/clear_cache';
$route['admin/change_password'] = 'admin/index/change_password';
$route['admin/logout'] = 'admin/index/logout';
$route['admin/delete_menu/(:num)'] = 'admin/admin_menu/delete_menu/$1';
$route['admin/add_menu/(:num)'] = 'admin/admin_menu/add_menu/$1';
$route['admin/menu_list'] = 'admin/admin_menu/menu_list';
$route['admin/sequence_menu'] = 'admin/admin_menu/sequence_menu';
$route['admin/edit_menu'] = 'admin/admin_menu/edit_menu';
$route['admin/delete_menu'] = 'admin/admin_menu/delete_menu';
//文章
$route['admin/article'] = 'admin/article/index';
$route['admin/article/add_article'] = 'admin/article/add_article';
$route['admin/article/delete_article'] = 'admin/article/delete_article';
$route['admin/article/edit_article/(:num)'] = 'admin/article/edit_article/$1';
$route['admin/article/sort_list'] = 'admin/article/sort_list';
$route['admin/article/add_sort'] = 'admin/article/add_sort';
$route['admin/article/delete_sort'] = 'admin/article/delete_sort';
$route['admin/article/edit_sort/(:num)'] = 'admin/article/edit_sort/$1';
//管理员
$route['admin/group_list'] = 'admin/admin/group_list';
$route['admin/add_group'] = 'admin/admin/add_group';
$route['admin/delete_group'] = 'admin/admin/delete_group';
$route['admin/edit_group/(:num)'] = 'admin/admin/edit_group/$1';
$route['admin/admin_list'] = 'admin/admin/admin_list';
$route['admin/add_admin'] = 'admin/admin/add_admin';
$route['admin/delete_admin'] = 'admin/admin/delete_admin';
$route['admin/edit_admin/(:num)'] = 'admin/admin/edit_admin/$1';

//EasyUI
$route['login'] = 'home/login';
/* End of file routes.php */
/* Location: ./application/config/routes.php */