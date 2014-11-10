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
        $data['themeList'] = $this->config->config['theme_list'];
        if (!$_POST) {
            parent::set_html_header();
            $this->smarty->view('home/setting/theme.tpl', $data);
            return;
        }
		$my_theme = $this->input->post('myTheme');
        in_array($my_theme, $data['themeList']) ? setcookie('myTheme', $my_theme, time()+3600*3600, '/') : exit(json_encode(array('message'=>'主题不存在')));
		in_array($my_theme, $data['themeList']) ? setcookie('myTheme', $my_theme, time()+3600*3600, '/') : ajax_exit('主题不存在');
		$res['message'] = '设置成功';
		$res['reload'] = 1;
		$res['success'] = 1;
		echo_json($res);
    }

	/**
	 * 常用菜单
	 */
	public function favorite_menu()
	{
		$this->load->model('node_model');
		$data = $this->node_model->get_list();
		$data['width'] = '100';
		$this->smarty->view('home/setting/favorite_menu.tpl', $data);
	}

	/**
	 * 密码修改
	 * todo
	 */
	public function change_password()
	{
		$assign['pageTitle'] = '密码修改';
		if (!$_POST) {
			parent::set_html_header();
			$this->smarty->view('home/setting/change_password.tpl', $data);
			return;
		}
	}

}