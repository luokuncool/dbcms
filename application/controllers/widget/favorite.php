<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favorite extends HOME_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(
			array('role_model')
		);
	}

	public function menu($data)
	{
		$assign['nodeList'] = $data;
		$this->smarty->view('widget/favorite/menu.tpl', $assign);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */