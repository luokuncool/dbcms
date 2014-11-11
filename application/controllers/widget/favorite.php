<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('WIDGET') OR show_404();

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
		$assign['width'] = '100';
		$this->smarty->view('home/widget/favorite/menu.tpl', $assign);
	}
}

/* End of file favorite.php */
/* Location: ./application/controllers/favorite.php */