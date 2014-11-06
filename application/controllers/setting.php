<?php
class Setting extends HOME_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(
        //array('news_model', 'user_model')
        );
    }

    /**
     * 主题设置
     */
    public function theme()
    {
        $data['theme_list'] = array(
            'black',
            'bootstrap',
            'default',
            'gray',
            'metro',
            'metro-blue',
            'metro-gray',
            'metro-green',
            'metro-orange',
            'metro-red',
            'ui-cupertino',
            'ui-dark-hive',
            'ui-pepper-grinder',
            'ui-sunny',
        );
        if (!$_POST) {
            parent::set_html_header();
            $this->smarty->view('home/setting/theme.tpl', $data);
            return;
        }
        setcookie('my_theme', $_POST['my_theme'], time()+3600*3600, '/');
        echo json_encode(array('message'=>'设置成功', 'reloadMain'=>1, 'success'=>1));
    }

}