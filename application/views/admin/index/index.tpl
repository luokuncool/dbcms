{extends file="../public/layout.tpl"}
{block name="main"}
  <div id="all">
    <div class="tipBox1">
      <p>您好，<span class="f-blue">{$active_admin['group_name']}：{$active_admin['real_name']|default:$active_admin['login_name']}</span> 您上次登录的时间是 <span class="f-blue">{$active_admin['last_login_time']|date_format:'Y-m-d H:i:s'}</span> 共计登录 <span class="f-blue">{$active_admin['login_times']}</span> 次</p>
    </div>
    <div class="styleBox1 mt10">
      <div class="imgtxtBox1">
        <div class="imgtxtBox1_img"><div class="iconSys_48"></div></div>
        <div class="imgtxtBox1_txt">
          <div class="titleBox1 pt5 pb5"><h3>系统信息</h3></div>
          <p>提供当前网站运行所处的环境，</p>
          <p>了解这些信息，可以帮助您的网站运行得更好。</p>
        </div>
      </div>
      <div class="tableBox1 p12">
        <table class="w">
          <tr>
            <td class="fb tr f-grey52" width="100">服务器系统：</td>
            <td class="pr" colspan="3"><span class="ellipsis">{$phpsys['php_uname']}</span></td>
          </tr>
          <tr>
            <td class="fb tr f-grey52">系统运行端口：</td>
            <td width="350">{$phpsys['php_port']}</td>
            <td class="fb tr f-grey52" width="100">GD库支持：</td>
            <td>{if $phpsys['php_gd']}支持{else}不支持{/if}</td>
          </tr>
          <tr>
            <td class="fb tr f-grey52">服务器引擎：</td>
            <td>{$phpsys['php_software']}</td>
            <td class="fb tr f-grey52">PHP版本：</td>
            <td>{$phpsys['php_version']}</td>
          </tr>
          <tr>
            <td class="fb tr f-grey52">程序存活时间：</td>
            <td>{$phpsys['php_max_time']}</td>
            <td class="fb tr f-grey52">PHP运行方式：</td>
            <td>{$phpsys['php_sapi_name']}</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="styleBox1 mt10">
      <div class="imgtxtBox1">
        <div class="imgtxtBox1_img"><div class="iconDev_48"></div></div>
        <div class="imgtxtBox1_txt">
          <div class="titleBox1 pt5 pb5"><h3>开发信息</h3></div>
          <p>与系统开发相关的信息，</p>
          <p>当系统运行过程中出现故障时，这里的开发信息或许能帮助您修复系统。</p>
        </div>
      </div>
      <div class="tableBox1 p12">
        <table class="w">
          <tr>
            <td class="fb tr f-grey52" width="100">版权所有：</td>
            <td>成都伯仁网络科技有限公司 保留所有权利</td>
          </tr>
          <tr>
            <td class="fb tr f-grey52" width="100">技术支持网站：</td>
            <td><a href="http://www.boren.cn" class="noStop" target="_blank">成都伯仁网络科技有限公司</a> - <a href="http://www.boren.cn"  class="noStop" target="_blank">http://www.boren.cn</a></td>
          </tr>
          <tr>
            <td class="fb tr f-grey52">开发团队：</td>
            <td>成都伯仁网络技术部</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
{/block}