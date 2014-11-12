{extends file="../public/layout.tpl"}
{block name="body"}
    <div data-options="region:'north',border:true" style="height: 42px;">
        <div class="easyui-text" style="float:left; font-size: 22px; padding-left: 10px; font-family:'宋体','Arial Narrow';  line-height: 40px;">{$systemName}</div>
        <div style="float: right; padding: 5px 10px 0 0;">
            <a class="easyui-linkbutton" id="" style="padding:0 5px; border-radius: 2px 2px 2px;">站内消息<span style="font-weight: bold; padding-left: 5px;">15</span></a>
            <a class="easyui-linkbutton" id="" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">修改密码</a>
            <a class="easyui-linkbutton" id="" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">退出登录</a>
        </div>
    </div>
    <div data-options="region:'west',collapsed:false,split:true" title="菜单栏" style="width:10%;">
        <div class="easyui-accordion" data-options="border:false" style="width:100%;display: none;">
            {foreach $menuGroupList as $menuGroup}
                <div title="{$menuGroup.menuName}" data-options="collapsible:true" style="padding: 0 5px;">
                    {foreach $menuGroup['menuList'] as $menu}
                    <p><a href="javascript:App.addTab('{$menu.name}', '{$baseUrl}{$menu.code}')">{$menu.name}</a></p>
                    {/foreach}
                </div>
            {/foreach}
        </div>
        <ul class="easyui-tree" data-options="lines:true" style="display: block;">
            {foreach $menuGroupList as $menuGroup}
                <li>
                    <span>{$menuGroup.menuName}</span>
                    <ul>
                        {foreach $menuGroup['menuList'] as $menu}
                            <li><a onclick="App.addTab('{$menu.name}', '{$baseUrl}{$menu.code}');">{$menu.name}</a></li>
                        {/foreach}
                    </ul>
                </li>
            {/foreach}
        </ul>
    </div>
    <div data-options="region:'center',border:true" title="">
        <div id="mainTabs" class="easyui-tabs" data-options="fit:true,border:false,plain:true">
            <div class="panel" title="系统首页" style="padding: 10px; height: 100%">
				{*常用菜单*}
                {widget path="widget/favorite/menu" args= $nodeList}
				{*主题设置*}
				{widget path="widget/form/theme"}
            </div>
        </div>
    </div>
{/block}
{block name="head"}
	<script type="text/javascript" src="{$basePath}/public/home/js/main.js"></script>
    <script type="text/javascript">
    $(function(){
        App.run();
    });
    </script>
{/block}