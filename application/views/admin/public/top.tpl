<h1 class="logo"><a href="javascript:;" title=""><img src="{$base_path}/themes/admin/images/Blue/logo.png" alt=""></a></h1>
<span class="version">v5.1.0</span>
<!--<div id="system_name">网站管理系统</div>-->
<div class="topNavBox">
  <ul>
    <li class="f-white fb">欢迎回来，{$active_admin.real_name|default:$active_admin['login_name']}</li>
    <li class="line">|</li>
    <li class="item"><a href="{$base_url}" target="_blank" title="" class="noStop radius3">前台首页</a></li>
    <li class="line">|</li>
    <li class="item"><a href="{$base_url}/admin/clear_cache" title="" class="radius3 ajaxGet">清空缓存</a></li>
    <li class="line">|</li>
    <li class="item"><a href="{$base_url}/admin/logout" title="" class="radius3 ajaxGet">安全退出</a></li>
  </ul>
</div>
<div class="topMenuBox">
  <ul>
    <li class="item first {if !$current_router['id']}selected{/if}" style="width:90px;"><a href="{$base_url}/admin" title="" class="menu_url">后台首页</a></li>
    {foreach array_slice($top_menu_list, 0, 8) as $top_menu}
      <li class="item {if $current_router['id']==$top_menu['router_id']}selected{/if}" style="width:100px;">
        <a href="{$base_url}{$top_menu.menu_url}?redirect={$active_url}" title="" class="menu_url">{$top_menu.menu_name}</a>
        <a href="{$base_url}/admin/delete_menu/{$top_menu.id}" class="menuIcon ajaxGet" title="移除常用菜单">
          <span class="iconBg iconBox03"></span>
        </a>
      </li>
    {/foreach}
    <li class="drop">
      <div class="iconBg iconBox01"></div>
      <div class="dropMenu">
        <div id="hyTopMenuMore" class="scroll scrollBarBox1">
          <ul>
            {foreach array_slice($top_menu_list, 8) as $top_menu}
              <li class="dropItem"><a href="{$base_url}{$top_menu.menu_url}?redirect={$active_url}" title="">{$top_menu.menu_name}</a></li>
            {/foreach}
            <li class="dropItem"><a href="{$base_url}/admin/menu_list" title=""><span class="dropIcon"><div class="icon1Set_14"></div></span>顶部菜单设置</a></li>
          </ul>
        </div>
      </div>
    </li>
  </ul>
</div>