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

    public function pagination($data){
        $total = $data['total'];
        $rows = $data['rows'];
        $totalPage = $total%$rows ? ceil($total/$rows) : $total/$rows;
        $data['totalPage'] = $totalPage;
        $pages = array();
        array_chunk($pages, $totalPage);
        while($totalPage --> 0) {
            $pages[] = $totalPage + 1;
        }
        sort($pages);
        $data['pages'] = $pages;
        $activeURL = get_active_url('page', false);
        $data['pageURL'] = $activeURL .(strpos($activeURL, '?') === false ? '?page=' : '&page=');
        $this->smarty->view('admin/widget/tools/pagination.tpl', $data);
    }

}

/* End of file form.php */
/* Location: ./application/controllers/form.php */