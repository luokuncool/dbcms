<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('WIDGET') OR show_404();

class Form extends HOME_Controller {

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
		$data['width'] = '25';
		$data['widgetName'] = '设置主题';
		$data['action'] = $this->config->config['base_url'].'widget/form/theme';
		$data['formId'] = 'themeSetForm';
		$data['submitButtonId'] = 'themeSetSubmitButton';
		if (!$_POST) {
			$this->smarty->view('widget/form/theme.tpl', $data);
			return;
		}
		$my_theme = $this->input->post('myTheme');
		in_array($my_theme, $data['themeList']) ? setcookie('myTheme', $my_theme, time()+3600*3600, '/') : ajax_exit('主题不存在');
		$res['message'] = '设置成功';
		$res['reload'] = 1;
		$res['success'] = 1;
		echo_json($res);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */