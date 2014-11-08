<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends HOME_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(
			array('role_model')
		);
	}

	/**
	 * 主题设置
	 */
	public function theme()
	{
		$data['theme_list'] = $this->config->config['theme_list'];
		if (!$_POST) {
			$this->smarty->view('widget/form/theme.tpl', $data);
			return;
		}
		$my_theme = $this->input->post('my_theme');
		in_array($my_theme, $data['theme_list']) ? setcookie('my_theme', $my_theme, time()+3600*3600, '/') : exit(json_encode(array('message'=>'主题不存在')));
		echo json_encode(array('message'=>'设置成功', 'reloadMain'=>1, 'success'=>1));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */