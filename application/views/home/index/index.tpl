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
    <div data-options="region:'west', collapsed:false" title="菜单栏" style="width:10%;padding:5px">
        <ul class="easyui-tree" data-options="lines:true">
            <li data-options="state:'closed'">
                <span>节点管理</span>
                <ul>
                    <li><a onclick="App.addTab('节点列表', '/node/index');">节点列表</a></li>
                    <li iconCls="icon-add"><a onclick="App.addTab('添加节点', '/node/create');">添加节点</a></li>
                </ul>
            </li>
            <li data-options="state:'closed'">
                <span>历史记录</span>
                <ul>
                    <li><a onclick="App.addTab('节点列表', '/node/index');">节点列表</a></li>
                    <li><a onclick="App.addTab('添加节点', '/node/create');">添加节点</a></li>
                </ul>
            </li>
            <li>
                <span>系统设置</span>
                <ul>
                    <li><a onclick="App.addTab('用户管理', '/user/index');">用户管理</a></li>
                </ul>
            </li>
            <li>
                <span>个人设置</span>
                <ul>
                    <li><a onclick="App.addTab('主题设置', '/setting/theme');">主题设置</a></li>
                </ul>
            </li>
            <li><a onclick="App.addTab('待办事项', '/home/test/10')">待办事项</a></li>
        </ul>
    </div>
    <div data-options="region:'center',border:true" title="">
        <div id="easyui-tabs" class="easyui-tabs" data-options="fit:true,border:false,plain:true">
            <div class="panel" title="系统首页" data-options="" style="padding: 10px">
                <p>欢迎使用本系统！</p>
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