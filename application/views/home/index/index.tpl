{extends file="../public/layout.tpl"}
{block name="body"}
    <div data-options="region:'north',border:true" style="height:52px;">
        <div style="float:left; font-size: 26px; padding-left: 10px; font-weight: bold; line-height: 50px;"> EasyUI+CodeIgniter</div>
        <div style="float: right; padding: 10px 10px 0 0;">
            <a class="easyui-linkbutton" id="searchButton" data-options="" style="padding:0 5px; border-radius: 2px 2px 2px;">站内消息<span style="color: #ff9e00;font-weight: bold; padding-left: 5px;">15</span></a>
            <a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-man'" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">退出登录</a>
            <a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-lock'" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">修改密码</a>
        </div>
    </div>
    <div data-options="region:'west'" title="菜单栏" style="width:12%;padding:5px">
        <ul class="easyui-tree" data-options="lines:true">
            <li>
                <span>节点管理</span>
                <ul>
                    <li><a href="javascript:App.addTab('节点列表', '/node/index')">节点列表</a></li>
                    <li><a href="javascript:App.addTab('添加节点', '/node/create')">添加节点</a></li>
                </ul>
            </li>
            <li>
                <span>主菜单</span>
                <ul>
                    <li><a href="javascript:App.addTab('iframeTest10', '/home/test/10')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest11', '/home/test/11')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest12', '/home/test/12')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest13', '/home/test/13')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest14', '/home/test/14')">添加文章</a></li>
                </ul>
            </li>
            </li>
        </ul>
    </div>
    <div data-options="region:'center',border:true" title="">
        <div id="easyui-tabs" class="easyui-tabs" data-options="fit:true,border:false,plain:true">
            <div class="panel" title="系统首页" data-options="href:'/home/test'">
                <div style="padding: 10px">test</div>
            </div>
        </div>
    </div>

    </div>
    <!--<div data-options="region:'east',split:true,collapsed:true,title:'East'" style="width:100px;padding:10px;">east region</div>-->

{/block}
{block name="head"}
    <script type="text/javascript" src="{$base_path}/public/home/js/common.js"></script>
    <script type="text/javascript">
    $(function(){
        App.run();
    });
    </script>
{/block}