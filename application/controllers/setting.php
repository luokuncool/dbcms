<?php
class Setting extends HOME_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 主题设置
     */
    public function theme()
    {
        $data['theme_list'] = $this->config->config['theme_list'];
        if (!$_POST) {
            parent::set_html_header();
            $this->smarty->view('home/setting/theme.tpl', $data);
            return;
        }
		$my_theme = $this->input->post('my_theme');
        in_array($my_theme, $data['theme_list']) ? setcookie('my_theme', $my_theme, time()+3600*3600, '/') : exit(json_encode(array('message'=>'主题不存在')));
        echo json_encode(array('message'=>'设置成功', 'reloadMain'=>1, 'success'=>1));
    }

	/**
	 * 常用菜单
	 */
	public function favorite_menu()
	{
		$this->load->model('node_model');
		$data = $this->node_model->get_list();
		$this->smarty->view('home/setting/favorite_menu.tpl', $data);
	}

}