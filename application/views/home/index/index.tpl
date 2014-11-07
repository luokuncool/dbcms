{extends file="../public/layout.tpl"}
{block name="body"}
    <div data-options="region:'north',border:true" style="height:52px;">
        <div style="float:left; font-size: 26px; padding-left: 10px; font-weight: bold; line-height: 50px;">jQuery EasyUI</div>
        <div style="float: right; padding: 10px 10px 0 0;">
            <a class="easyui-linkbutton" id="searchButton" data-options="" style="padding:0 5px; border-radius: 2px 2px 2px;">站内消息<span style="color: #ff9e00;font-weight: bold; padding-left: 5px;">15</span></a>
            <a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-man'" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">退出登录</a>
            <a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-lock'" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">修改密码</a>
        </div>
    </div>
    <div data-options="region:'west', collapsed:true" title="菜单栏" style="width:10%;padding:5px">
        <ul class="easyui-tree" data-options="lines:true">
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
            <div class="panel" title="系统首页" style="padding: 10px;">
                {widget path="widget/favorite/menu" args= $nodeList}
            </div>
        </div>
    </div>
{/block}
{block name="head"}
    <script type="text/javascript" src="{$base_path}/public/home/js/common.js"></script>
    <script type="text/javascript">
    $(function(){
        App.run();
    });
    </script>
{/block}