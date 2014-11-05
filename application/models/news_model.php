<?php
class News_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  /**
   * 获取新闻
   * @param bool $slug
   * @return mixed
   */
  public function get_news($slug = FALSE){
    if ($slug === FALSE)
    {
      $query = $this->db->get('news');
      return $query->result_array();
    }

    $query = $this->db->get_where('news', array('slug' => $slug));
    return $query->row_array();
  }

  /**
   * 插入新闻
   * @return mixed
   */
  public function set_news()
  {
    $this->load->helper('url');

    $slug = url_title($this->input->post('title'), 'dash', TRUE);

    $data = array(
      'title' => $this->input->post('title'),
      'slug' => $slug,
      'text' => $this->input->post('text')
    );

    return $this->db->insert('news', $data);
  }
}