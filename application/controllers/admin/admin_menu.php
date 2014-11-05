<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-29
 * Time: 下午3:40
 */

class Admin_Menu extends ADMIN_Controller
{

  /**
   * 构造函数
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->model(
      array('admin_model', 'admin_router_model')
    );
  }

  /**
   * 管理组列表
   */
  public function menu_list()
  {
    $where = array();
    $keyword = deep_htmlspecialchars($_GET['s']);
    $keyword == '1' || $where[] = 'INSTR(menu_name, "'.$keyword.'")>0';
    $where = join(' AND ', $where);
    $data['menu_list'] = $this->admin_menu_model->get_admin_menu_list($where);
    $this->smarty->view('admin/admin_menu/menu_list.tpl', $data);
  }

  /**
   * 添加管理组
   */
  public function add_menu($id)
  {
    $id = intval($id);
    $active_admin = $this->admin->active_admin;
    if (IS_AJAX)
    {
      $menu = $this->admin_router_model->get_router(array('id'=>$id, 'side_menu'=>'1'));
      $menu OR exit('{"message":"该菜单不存在！"}');
      $where = array(
        'admin_id' => $active_admin['id'],
        'router_id' => $menu['id'],
        'menu_url' => '/'.$menu['directory'].$menu['class'].'/'.$menu['method'],
      );
      $exists = $this->admin_menu_model->exists($where, $this->admin_menu_model->admin_menu_table);
      $exists && exit('{"message":"已经添加过了！"}');
      //添加
      $data = $where;
      $data['menu_name'] = $menu['menu_name'];
      $this->admin_menu_model->add_admin_menu($data);
      echo '{"success":1, "message":"添加成功！"}';
    }
    else
    {
      redirect($this->config->config['base_url'].'/admin/menu_list');
    }
  }

  /**
   * 删除管理组
   */
  public function delete_menu($id)
  {
    parent::set_json_header();
    $id = intval($id);
    if (IS_AJAX) {
      $id && $_POST['id'][] = $id;
      $id_list = join(',', $_POST['id']);
      if ($id_list)
      {
        $this->admin_menu_model->delete_admin_menu('id in('.$id_list.')');
      }
      echo '{"success":1, "message":"删除成功！", "id":"'.$id_list.'"}';
    } else {
      redirect($this->config->config['base_url'].'/admin/menu_list');
    }
  }

  /**
   * 编辑管理组
   */
  public function edit_menu()
  {
    if (IS_AJAX)
    {
      $this->load->library('form_validation');
      $this->load->helper('array_helper');
      $POST = deep_htmlspecialchars($_POST);
      $this->form_validation->required($POST['menu_name']) OR exit('{"message":"请填写分组名称！", "selector":"[name=menu_name]"}');
      foreach($POST['menu_name'] as $id=>$menu_name)
      {
        $this->admin_menu_model->update_admin_menu(array('id'=>$id), array('menu_name'=>$menu_name));
      }
      echo '{"success":1, "message":"保存成功！"}';
    }
    else
    {
      redirect($this->config->config['base_url'].'/admin/menu_list');
    }
  }

  /**
   * 菜单排序
   */
  public function sequence_menu()
  {
    if (IS_AJAX)
    {
      foreach($_POST['sequence'] as $id=>$sequence)
      {
        $this->admin_menu_model->update_admin_menu(array('id'=>$id), array('sequence'=>$sequence));
      }
      echo '{"success":1, "message":"保存成功！"}';
    }
    else
    {
      redirect($this->config->config['base_url'].'/admin/menu_list');
    }
  }

}