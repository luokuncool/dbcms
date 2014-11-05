<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-24
 * Time: 上午10:44
 */
class Article extends ADMIN_Controller {

  public $max_grade = 2;

  public $system_article_sort = array(1,2,3,4,5,6,7);

  function __construct()
  {
    parent::__construct();
    $this->smarty->assign('system_article_sort', $this->system_article_sort);
    $this->load->model('article_model');
  }

  /**
   * 文章模块
   */
  public function index()
  {
    parent::set_html_header();
    $where = array();
    $sort_id = intval($_GET['sort_id']);
    $sort_id && $where[] = 'article.sort_id='.$sort_id;
    $keyword = deep_htmlspecialchars($_GET['s']);
    $keyword == '' || $where[] = 'INSTR(article.article_name, "'.$keyword.'")>0';
    $where = join(' AND ', $where);
    $data = $this->article_model->get_article_page_list($where);
    //分类
    $sort_list = $this->article_model->get_sort_tree(0, $this->max_grade);
    $sort_list = $this->article_model->set_sort_tree($sort_list);
    $data['sort_list'] = $sort_list;
    $this->smarty->view('admin/article/index.tpl', $data);
  }

  /**
   * 文章添加
   */
  public function add_article()
  {
    if ($_POST)
    {
      parent::set_json_header();
      $POST = deep_htmlspecialchars($_POST);
      $this->load->library('form_validation');
      $this->form_validation->required($POST['article_name']) OR exit('{"message":"请填写文章标题!", "selector":"[name=article_name]"}');
      $this->form_validation->required($POST['content']) OR exit('{"message":"请填写文章详情!", "selector":"#content"}');
      $_POST['add_time'] = time();
      $this->article_model->add_article($_POST);
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    }
    else
    {
      parent::set_html_header();
      $sort_list = $this->article_model->get_sort_tree(0, $this->max_grade);
      $sort_list = $this->article_model->set_sort_tree($sort_list);
      $data['sort_list'] = $sort_list;
      $this->smarty->view('admin/article/add_article.tpl', $data);
    }
  }

  /**
   * 文章删除
   */
  public function delete_article()
  {
    parent::set_json_header();
    if ($_POST) {
      $id_list = join(',', $_POST['id']);
      if ($id_list)
      {
        $this->article_model->delete_article('id in('.$id_list.')');
      }
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    } else {
      redirect('/admin/article');
    }
  }

  /**
   * 文章编辑
   * @param $id
   */
  public function edit_article($id)
  {
    $id = intval($id);
    if ($_POST)
    {
      parent::set_json_header();
      $POST = deep_htmlspecialchars($_POST);
      $this->load->library('form_validation');
      $this->form_validation->required($POST['article_name']) OR exit('{"message":"请填写文章标题!", "selector":"[name=article_name]"}');
      $this->form_validation->required($POST['content']) OR exit('{"message":"请填写文章详情!", "selector":"#content"}');
      $this->article_model->update_article(array('id'=>$id), $POST);
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    }
    else
    {
      parent::set_html_header();
      $data['data'] = $this->article_model->get_article(intval($id));
      $sort_list = $this->article_model->get_sort_tree(0, $this->max_grade);
      $sort_list = $this->article_model->set_sort_tree($sort_list);
      $data['sort_list'] = $sort_list;
      $this->smarty->view('admin/article/add_article.tpl', $data);
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
      $this->article_model->add_sort($data);
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    }
    else
    {
      $sort_list = $this->article_model->get_sort_tree(0, $this->max_grade-1);
      $sort_list = $this->article_model->set_sort_tree($sort_list);
      $data['sort_list'] = $sort_list;
      $this->smarty->view('admin/article/add_sort.tpl', $data);
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
        $id_list = $this->article_model->get_sort_id($id_list);
        $this->article_model->update_article('sort_id in('.$id_list.')', array('sort_id' => '-1'));
        $this->article_model->delete_sort('id in('.$id_list.')');
      }
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    } else {
      redirect('/admin/article/sort_list');
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
      $this->article_model->update_sort(array('id'=>$id), $data);
      echo '{"success":1, "message":"操作成功！", "redirect":"'.urldecode($_GET['redirect']).'"}';
    }
    else
    {
      $data['data'] = $this->article_model->get_sort($id);

      $sort_list = $this->article_model->get_sort_tree(0, $this->max_grade-1, 'id<>'.$id);
      $sort_list = $this->article_model->set_sort_tree($sort_list);
      $data['sort_list'] = $sort_list;
      $this->smarty->view('admin/article/add_sort.tpl', $data);
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
        $this->article_model->update_sort(array('id'=>$id), array('sequence'=>$sequence));
      }
      echo '{"success":1, "message":"保存成功！"}';
    }
    else
    {
      redirect('/admin/article/sort_list');
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
    $sort_list = $this->article_model->get_sort_tree(0, $this->max_grade, $where);
    $sort_list = $this->article_model->set_sort_tree($sort_list);
    $data['sort_list'] = $sort_list;
    $this->smarty->view('admin/article/sort_list.tpl', $data);
  }
}