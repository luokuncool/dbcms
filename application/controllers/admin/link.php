<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-24
 * Time: 上午10:44
 */
class Link extends ADMIN_Controller {

  public $max_grade = 1;

  public $system_link_sort = array('16');

  function __construct()
  {
    parent::__construct();
    $this->smarty->assign('system_link_sort', $this->system_link_sort);
    $this->load->model('link_model');
  }

  /**
   * 链接模块
   */
  public function index()
  {
    parent::set_html_header();


    $where = array();
    $sort_id = intval($_GET['sort_id']);
    $sort_id && $where[] = 'link.sort_id='.$sort_id;
    $keyword = deep_htmlspecialchars($_GET['s']);
    $keyword == '' || $where[] = 'INSTR('.$this->link_model->link_table.'.link_name, "'.$keyword.'")>0';
    $where = join(' AND ', $where);
    $data = $this->link_model->get_link_page_list($where);
    //分类
    $sort_list = $this->link_model->get_sort_tree(0, $this->max_grade);
    $sort_list = $this->link_model->set_sort_tree($sort_list);
    $data['sort_list'] = $sort_list;
    $this->smarty->view('admin/link/index.tpl', $data);
  }

  /**
   * 链接添加
   */
  public function add_link()
  {
    if ($_POST)
    {
      parent::set_json_header();
      $POST = deep_htmlspecialchars($_POST);
      $this->load->library('form_validation');
      $this->form_validation->required($POST['link_name']) OR exit('{"message":"请填写链接标题!", "selector":"[name=link_name]"}');
      $this->form_validation->required($POST['link_url']) OR exit('{"message":"请填写链接地址!", "selector":"[name=link_url]"}');
      $_POST['add_time'] = time();
      $this->link_model->add_link($_POST);
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    }
    else
    {
      parent::set_html_header();
      $sort_list = $this->link_model->get_sort_tree(0, $this->max_grade);
      $sort_list = $this->link_model->set_sort_tree($sort_list);
      $data['sort_list'] = $sort_list;
      $this->smarty->view('admin/link/add_link.tpl', $data);
    }
  }

  /**
   * 链接删除
   */
  public function delete_link()
  {
    parent::set_json_header();
    if ($_POST) {
      $id_list = join(',', $_POST['id']);
      if ($id_list)
      {
        $this->link_model->delete_link('id in('.$id_list.')');
      }
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    } else {
      redirect('/admin/link');
    }
  }

  /**
   * 链接编辑
   * @param $id
   */
  public function edit_link($id)
  {
    $id = intval($id);
    if ($_POST)
    {
      parent::set_json_header();
      $POST = deep_htmlspecialchars($_POST);
      $this->load->library('form_validation');
      $this->form_validation->required($POST['link_name']) OR exit('{"message":"请填写链接标题!", "selector":"[name=link_name]"}');
      $this->form_validation->required($POST['link_url']) OR exit('{"message":"请填写链接地址!", "selector":"[name=link_url]"}');
      $this->link_model->update_link(array('id'=>$id), $POST);
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    }
    else
    {
      parent::set_html_header();
      $data['data'] = $this->link_model->get_link(intval($id));
      $sort_list = $this->link_model->get_sort_tree(0, $this->max_grade);
      $sort_list = $this->link_model->set_sort_tree($sort_list);
      $data['sort_list'] = $sort_list;
      $this->smarty->view('admin/link/add_link.tpl', $data);
    }
  }

  /**
   * 添加分类
   */
  public function add_sort()
  {
    if ($_POST)
    {
      parent::set_json_header();
      $POST = deep_htmlspecialchars($_POST);
      $this->load->library('form_validation');
      $this->load->helper('array_helper');
      $this->form_validation->required($POST['sort_name']) OR exit('{"message":"请填写分类名!", "selector":"[name=sort_name]"}');
      $data = elements(array('sort_name', 'parent_id', 'alias', 'intro'), $POST);
      $this->link_model->add_sort($data);
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    }
    else
    {
      $sort_list = $this->link_model->get_sort_tree(0, $this->max_grade-1);
      $sort_list = $this->link_model->set_sort_tree($sort_list);
      $data['sort_list'] = $sort_list;
      $this->smarty->view('admin/link/add_sort.tpl', $data);
    }
  }

  /**
   * 分类删除
   */
  public function delete_sort()
  {
    parent::set_json_header();
    if ($_POST) {
      $id_list = join(',', $_POST['id']);
      if ($id_list)
      {
        $id_list = $this->link_model->get_sort_id($id_list);
        $this->link_model->update_link('sort_id in('.$id_list.')', array('sort_id' => '-1'));
        $this->link_model->delete_sort('id in('.$id_list.')');
      }
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    } else {
      redirect('/admin/link/sort_list');
    }
  }

  /**
   * 分类编辑
   * @param $id
   */
  public function edit_sort($id)
  {
    $id = intval($id);
    if ($_POST)
    {
      parent::set_json_header();
      $POST = deep_htmlspecialchars($_POST);
      $this->load->library('form_validation');
      $this->load->helper('array_helper');
      $this->form_validation->required($POST['sort_name']) OR exit('{"message":"请填写分类名!", "selector":"[name=sort_name]"}');
      $data = elements(array('sort_name', 'parent_id', 'alias', 'intro'), $POST);
      $this->link_model->update_sort(array('id'=>$id), $data);
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    }
    else
    {
      $data['data'] = $this->link_model->get_sort($id);

      $sort_list = $this->link_model->get_sort_tree(0, $this->max_grade-1, 'id<>'.$id);
      $sort_list = $this->link_model->set_sort_tree($sort_list);
      $data['sort_list'] = $sort_list;
      $this->smarty->view('admin/link/add_sort.tpl', $data);
    }
  }

  /**
   * 分类排序
   */
  public function sequence_sort()
  {
    if (IS_AJAX)
    {
      foreach($_POST['sequence'] as $id=>$sequence)
      {
        $this->link_model->update_sort(array('id'=>$id), array('sequence'=>$sequence));
      }
      echo '{"success":1, "message":"保存成功！"}';
    }
    else
    {
      redirect('/admin/link/sort_list');
    }
  }

  /**
   * 分类列表
   */
  public function sort_list()
  {
    $keyword = deep_htmlspecialchars($_GET['s']);
    $where = array();
    $keyword && $where[] = 'INSTR(sort_name, "'.$keyword.'")>0';
    $where = join(' AND ', $where);
    $sort_list = $this->link_model->get_sort_tree(0, $this->max_grade, $where);
    $sort_list = $this->link_model->set_sort_tree($sort_list);
    $data['sort_list'] = $sort_list;
    $this->smarty->view('admin/link/sort_list.tpl', $data);
  }
}