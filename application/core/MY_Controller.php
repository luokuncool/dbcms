<?php

/**
 * 基础控制器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-24
 * Time: 下午5:13
 */
class MY_Controller extends CI_Controller
{

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $assign['systemName'] = config_item('system_name');
        $assign['baseUrl'] = config_item('base_url');
        $assign['basePath'] = config_item('base_path');
        $assign['activeUrl'] = get_active_url('redirect');
        $this->smarty->assign($assign);
    }

    /**
     * 设置HTML输出的header
     */
    public function set_html_header()
    {
        header('Content-Type:text/html;charset=utf-8;');
    }

    /**
     * 设置JSON输出的header
     */
    public function set_json_header()
    {
        header('Content-Type:text/json;charset=utf-8;');
    }

}

/**
 * 后台基础类
 * Class Home_Controller
 */
class Admin_Controller extends MY_Controller
{

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        $data['myTheme'] = isset($_COOKIE['myTheme']) ? $_COOKIE['myTheme'] : 'default';
        $data['baseURL'] = config_item('base_url') . '/admin';
        $data['systemName'] = config_item('system_name');
        $data['pageSetting'] = config_item('pageSetting');
        $data['loginName'] = $_SESSION['userInfo']['name'];
        $data['face'] = $_SESSION['userInfo']['face'];
        $this->smarty->assign($data);
        $this->set_menu();
    }

	public function jump($message, $jumpURL, $type = 'success')
	{
		$data['message'] = $message;
		$data['jumpURL'] = $jumpURL;
		$data['type']    = $type;
		$this->smarty->view('admin/public/jump.tpl', $data);
	}

    /**
     * 登陆验证
     */
    protected function check_login()
    {
        $rsegmentArray = $this->uri->rsegment_array();
        $thisNode = join('/', array_slice($rsegmentArray, 0, 2));
        $this->smarty->assign('thisNode', $thisNode);
        $withoutCheckLogin = config_item('withoutCheckLogin');
        if (in_array($thisNode, $withoutCheckLogin)) return;
        if (!isset($_SESSION['userInfo'])) {
            direct_to('/admin/login');
            exit();
        }
        $this->check_access($thisNode);
    }

    protected function getCurrentNode()
    {
        $rsegmentArray = $this->uri->rsegment_array();
        $thisNode = join('/', array_slice($rsegmentArray, 0, 2));
        return $thisNode;
    }

    /**
     * toCheck 权限验证
     * @author Quentin
     * @since  2014-12-02
     *
     * @param  $thisNode
     *
     * @access public
     * @return void
     */
    protected function check_access($thisNode)
    {
        $withoutCheckAccess = config_item('withoutCheckAccess');
        if (in_array($thisNode, $withoutCheckAccess)) return;
        $result = in_array($thisNode, $_SESSION['accessNodeCodes']);
        if ($result) return;
       // (is_ajax() OR is_post()) ? ajax_exit('没有操作权限！') : show_404();
    }

    protected function set_menu()
    {
        $this->load->model('node_model');
        $accessNodeIds         = $_SESSION['accessNodeIds'];
        if (!$accessNodeIds) return;
        $data['menuGroupList'] = config_item('node_group');
        $map[]                 = array('isMenu'=>1);
        $map['order_by']       = array('sort', 'asc');
        $map[]                 = 'id in('.join(',', $accessNodeIds).')';
        $nodeList              = $this->node_model->get_list($map, 'id,name,code,groupId,iconCls');
        $data['nodeList']      = $nodeList['rows'];
        $currentNode = $this->getCurrentNode();
        foreach($data['menuGroupList'] as $groupId => $menuGroup)
        {
            $menuList = array();
            foreach($nodeList['rows'] as $rowKey=>$row)
            {
                if ($groupId == $row['groupId']) {
                    array_push($menuList, $row);
                    unset($nodeList['rows'][$rowKey]);
                    $row['code'] == $currentNode &&  $menuGroup['isCurrentGroup'] = 1;
                }
            }
            unset($data['menuGroupList'][$groupId]);
            if ($menuList) {
                $data['menuGroupList'][$groupId]['group'] = $menuGroup;
                $data['menuGroupList'][$groupId]['menuList'] = $menuList;
            }
        }

        $userId = get_uid();
        $this->load->model(
            array(
                'favorite_menu_model','node_model'
            )
        );

        $nodeIds   = $this->favorite_menu_model->get_list(array('userId'=>$userId), 'nodeId');
        $menus = array();
        foreach($nodeIds['rows'] as $row) {
            $node =  $this->node_model->get_row($row['nodeId'], 'code,name,id,iconCls');
            $node['id'] && $menus[] = $node;
        }
        $menus = array_filter($menus);
        $data['favorite'] = $menus;
        $this->smarty->assign('sideMenu', $data);
    }

}

class Home_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
		$assign['baseURL'] = 'http://'.$_SERVER['HTTP_HOST'];
		$this->smarty->assign($assign);
    }
}

class Widget_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}
