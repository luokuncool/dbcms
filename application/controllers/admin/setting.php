<?php
class Setting extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 主题设置
     * @author Quentin
     * @since  2014-12-01 17:05
     *
     * @access public
     * @return void
     */
    public function theme()
    {
        $data['themeList'] = config_item('themeList');
        if (!is_post()) {
            parent::set_html_header();
            $this->smarty->view('admin/setting/theme.tpl', $data);
            return;
        }
        $myTheme = I('post.myTheme', 'default', 'strip_tags,trim');
        in_array($myTheme, $data['themeList']) ? setcookie('myTheme', $myTheme, time()+3600*3600, '/') : ajax_exit('主题不存在');
        $res['message'] = '设置成功';
        $res['reload'] = 1;
        $res['success'] = 1;
        echo_json($res);
    }

    /**
     * 常用菜单
     * @author Quentin
     * @since  2014-12-01 17:05
     *
     * @access public
     * @return void
     */
    public function favorite_menu()
    {

        $this->load->model(array('node_model', 'favorite_menu_model'));
        $userId = get_uid();
        if (!is_ajax()) {
            parent::set_html_header();
            $existsNodeIds = $this->favorite_menu_model->get_list(array('userId' => $userId), 'nodeId');
            $assign['nodeIds'] = explode(',', get_field_list($existsNodeIds['rows'], 'nodeId'));
            $assign['moduleTree'] = $this->node_model->getNodeTree(true);
            $this->smarty->view('admin/setting/favorite_menu.tpl', $assign);
            return;
        }

        $nodeIds = $this->input->post('nodeIds');
        $nodeIds = array_keys($nodeIds);
        $favoriteMenu = array();
        foreach($nodeIds as $nodeId) {
            $favoriteMenu[] = array(
                'userId' => $userId,
                'nodeId' => $nodeId
            );
        }
        $this->favorite_menu_model->delete(array('userId'=>$userId));
        if ($nodeIds) {
            $result = $this->favorite_menu_model->batch_insert($favoriteMenu);
            $result OR ajax_exit('保存失败');
        }
        echo json_encode(
            array(
                'message' => '保存成功',
                'redirect' => '/admin',
                'success' => 1
            )
        );
    }

    /**
     * 设置常用菜单
     * @author Quentin
     * @since  2014-12-01 17:04
     *
     * @access public
     * @return void
     */
    public function set_favorite_menu()
    {
        if (!is_post()) {
            return;
        }
        $userId = get_uid();
        $nodeIds = array_filter(explode(',', I('post.nodeIds', '', 'strip_tags,trim')));
        $this->load->model('favorite_menu_model');
        $favoriteMenu = array();
        foreach($nodeIds as $nodeId) {
            $favoriteMenu[] = array(
                'userId' => $userId,
                'nodeId' => $nodeId
            );
        }
        $this->favorite_menu_model->delete(array('userId'=>$userId));
        if ($nodeIds) {
            $result = $this->favorite_menu_model->batch_insert($favoriteMenu);
            $result OR ajax_exit('保存失败');
        }
        echo json_encode(
            array(
                'message' => '保存成功',
                'reloadType' => 'reloadGrid',
                'success' => 1
            )
        );
    }

    /**
     * 密码修改
     * @author Quentin
     * @since  2014-12-01 17:04
     *
     * @access public
     * @return void
     */
    public function change_password()
    {
        if (!is_post()) {
            parent::set_html_header();
            $this->smarty->view('admin/setting/change_password.tpl');
            return;
        }
        $this->load->model('user_model');
        $user = $this->user_model->get_row(get_uid());
        $oldPassword = I('post.oldPassword', '', 'trim');
        $password    = I('post.password', '', 'trim');
        $rePassword  = I('post.rePassword', '', 'trim');
        $user['password'] == md5($oldPassword) OR ajax_exit('旧密码错误');
        regex($password, 'require')            OR ajax_exit('请输入新密码');
        $rePassword == $password               OR ajax_exit('两次密码输入不一致');
        $result = $this->user_model->update('id = '.$user['id'], array('password' => md5($password)));
        $result === false                      && ajax_exit('数据保存失败，请稍后再试');
        echo_json(
            array(
                'message' => '保存成功',
                'success' => 1
            )
        );
    }

    public function set_info()
    {
        $this->load->model('user_model');
        $id = get_uid();
        $assign['node_group_list'] = config_item('node_group');
        $assign['data'] = $this->user_model->get_row($id);
        $assign['fileName1'] = array('fileName'=>'upload1');
        $assign['fileName2'] = array('fileName'=>'upload2');
        if (!is_post())
        {
            $this->smarty->view('admin/setting/set_info.tpl', $assign);
            return;
        }
        $update['name'] = I('post.name', '', 'strip_tags,trim');
        $update['face'] = I('post.face', '', 'strip_tags,trim');
        $update['email'] = I('post.email', '', 'strip_tags,trim');
        $update['updateTime'] = time();
        $result = $this->user_model->update(array('id'=>$id), $update);
        $res['message'] = $result ? '保存成功' : '保存失败';
        $id && $res['closeSelf'] = 1;
        $id && $res['success'] = 1;
        $res['reloadType'] = 'reloadGrid';
        echo json_encode($res);
    }

}
