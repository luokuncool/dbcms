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
        $data['themeList'] = config_item('themeList');
        if (!$_POST) {
            parent::set_html_header();
            $this->smarty->view('home/setting/theme.tpl', $data);
            return;
        }
		$myTheme = $this->input->post('myTheme');
		in_array($myTheme, $data['themeList']) ? setcookie('myTheme', $myTheme, time()+3600*3600, '/') : ajax_exit('主题不存在');
		$res['message'] = '设置成功';
		$res['reload'] = 1;
		$res['reloadType'] = 1;
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
	 * todo 密码修改
	 */
	public function change_password()
	{
		if (!$_POST) {
			parent::set_html_header();
			$this->smarty->view('home/setting/change_password.tpl');
			return;
		}
	}

}