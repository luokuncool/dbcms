<?php
class Home extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(
            array('node_model')
        );
    }

    /**
     * 系统主界面
     * @author Quentin
     * @since 2014-12-01 15:30
     *
     * @access public
     * return void
     */
    public function index()
    {
        parent::set_html_header();
        $accessNodeIds         = $_SESSION['accessNodeIds'];
        $accessNodeIds         OR exit('账号为配置权限请联系系统管理员！');
        $data['menuGroupList'] = config_item('node_group');
        $map[]                 = array('type'=>1);
        $map['status'] = 1;
        $map['order_by']       = array('sort', 'asc');
        $map[]                 = 'id in('.join(',', $accessNodeIds).')';
        $nodeList              = $this->node_model->get_list($map, 'id,name,code,groupId');
        $data['nodeList']      = $nodeList['rows'];
        foreach($data['menuGroupList'] as $groupId => $menuGroup)
        {
            $menuList = array();
            foreach($nodeList['rows'] as $rowKey=>$row)
            {
                $groupId == $row['groupId'] && array_push($menuList, $row);
            }
            unset($data['menuGroupList'][$groupId]);
            $menuList && $data['menuGroupList'][$groupId]['menuName'] = $menuGroup;
            $menuList && $data['menuGroupList'][$groupId]['menuList'] = $menuList;
        }
        $data['loginName'] = $_SESSION['userInfo']['name'];
        $this->smarty->view('admin/index/index.tpl', $data);
    }

    /**
     * 登陆系统
     * @author Quentin
     * @since 2014-12-01 15:30
     *
     * @access public
     * return void
     */
    public function login()
    {
        parent::set_html_header();
        $_SESSION['userInfo'] && direct_to('/');
        if (!is_post()) {
            $this->smarty->view('admin/index/login.tpl');
            return;
        }
        $this->load->model(array('user_model', 'role_model', 'role_user_model', 'role_node_model', 'node_model'));
        $uName    = I('post.uName', '', 'strip_tags,trim');
        $password = I('post.password', '', 'strip_tags,trim');
        regex($uName, 'require')    OR ajax_exit('请填写用户名！');
        regex($password, 'require') OR ajax_exit('请填写密码！');
        $result = $this->user_model->login($uName, $password);
        switch($result) {
            case 1 :
                ajax_exit('用户不存在！');
                break;
            case 2 :
                ajax_exit('密码不正确！');
                break;
            case 3 :
                ajax_exit('账号被禁用！');
                break;
        }
        $roleIds = $this->role_user_model->get_list(array('userId'=>$result['id']), 'roleId');
        $roleIds = get_field_list($roleIds['rows'], 'roleId');
        $roleIds OR ajax_exit('此用户为授权，请联系系统管理员授权！');
        $accessNodeIds = $this->role_node_model->get_list(array('roleId in('.$roleIds.')'), 'nodeId');
        $accessNodeIds = get_field_list($accessNodeIds['rows'], 'nodeId');
        $accessNodeList = $this->node_model->get_list(array('status = 1 AND id in('.$accessNodeIds.')'), 'code');
        $_SESSION['accessNodeCodes'] = explode(',', get_field_list($accessNodeList['rows'], 'code', ','));
        $_SESSION['accessNodeIds'] = explode(',', $accessNodeIds);
        $_SESSION['userInfo'] = $result;
        //toCheck 登陆成功操作
        echo_json(
            array(
                'success' => 1,
                'message' => '登陆成功！'
            )
        );
    }

    /**
     * 退出登录
     * @author Quentin
     * @since 2014-12-01 15:30
     *
     * @access public
     * return void
     */
    public function logout()
    {
        unset($_SESSION['accessNodeCodes']);
        unset($_SESSION['accessNodeIds']);
        unset($_SESSION['userInfo']);
        echo_json(
            array(
                'success' => 1,
                'message' => '退出系统~'
            )
        );
    }

    /**
     * 文件上传
     * @author Quentin
     * @since 2014-12-01 15:30
     *
     * @access public
     * return void
     */
    public function upload_file()
    {
        $this->load->library('Upload_File');
        $result = $this->upload_file->upload('Filedata', array('gif', 'jpg', 'jpeg', 'png', 'bmp'));
        echo_json($result);
        // require_once FCPATH . 'static/third/kindeditor/php/upload_json.php';
    }

    /**
     * 文件空间
     * @author Quentin
     * @since 2014-12-01 15:30
     *
     * @access public
     * return void
     */
    public function file_manager()
    {
        require_once FCPATH . 'static/third//kindeditor/php/file_manager_json.php';
    }

    /**
     * 获取设置
     * @author Quentin
     * @since 2015-03-21 15:30
     *
     * @access public
     * @return void
     */
    public function get_setting()
    {
        header('Content-Type:text/javascript; charset=UTF-8');
        $baseURL = config_item('base_url');
        $conf = <<<JAVASCRPT
!function(){
    var Public = {};
    Public.baseUrl = '${baseURL}';
    window.Public = Public;
}();
JAVASCRPT;
        echo $conf;
    }

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
