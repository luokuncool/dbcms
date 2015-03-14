<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 3/14/15
 * Time: 11:27 PM
 */

class HomeControllerTest extends PHPUnit_Framework_TestCase {

    /**
     * 登陆测试方法
     */
    public function testLogin()
    {
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, "http://local.easyui.com/login");
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt ');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('uName'=>'Admin', 'password'=>'zz123asd'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $response = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        $response = json_decode($response);
        $this->assertEquals('登陆成功！', $response->message);
        print_r($response);
    }

    public function testIndex(){
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, "http://local.easyui.com");
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt ');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $response = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        file_put_contents('response.html', $response);
    }

}