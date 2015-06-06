<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
defined('WIDGET') OR show_404();

class Tools extends Widget_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 主题设置
     */
    public function attachment($data)
    {
        $this->smarty->view('admin/widget/tools/attachment.tpl', $data);
    }
}

/* End of file form.php */
/* Location: ./application/controllers/form.php */