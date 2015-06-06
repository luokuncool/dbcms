{{extends file="../public/layout.tpl"}}
{{block name="body"}}
    <div data-options="region:'north',border:true" style="height: 44px;">
        <div
            style="float:left; font-size: 23px; padding-left: 10px; font-family:'微软雅黑','Arial Narrow';  line-height: 40px;">
            <i class="logo-font">{{$systemName}}</i></div>
        <div style="float: right; padding: 5px 10px 0 0;">
            <span style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">欢迎, {{$loginName}}</span>
            <a class="easyui-linkbutton" onclick="Public.updateCache();"><i class="iconfont icon-shuaxin"></i>更新缓存</a>
            <a class="easyui-linkbutton" onclick="Public.addTab('密码修改', '{{$baseUrl}}setting/change_password');"><i
                    class="iconfont icon-suoding"></i>密码修改</a>
            <a class="easyui-linkbutton" onclick="Public.logout()"><i class="iconfont icon-tuichu"></i>退出登录</a>
        </div>
    </div>
    <div data-options="region:'west',collapsed:false,split:true" title="菜单栏" style="width:10%;">
        <div class="easyui-accordion" data-options="border:false,multiple:false,animate:true,fit:true">
            {{foreach $menuGroupList as $menuGroup}}
                <div title="{{$menuGroup.menuName}}" data-options="collapsible:true" style="padding: 0 2px;">
                    {{foreach $menuGroup['menuList'] as $menu}}
                        <p><a class="easyui-linkbutton" style="width: 100%"
                              href="javascript:Public.addTab('{{$menu.name}}', '{{$baseUrl}}{{$menu.code}}')">{{$menu.name}}</a>
                        </p>
                    {{/foreach}}
                </div>
            {{/foreach}}
        </div>
        <ul class="easyui-tree" data-options="lines:true" style="display: none;">
            {{foreach $menuGroupList as $menuGroup}}
                <li>
                    <span>{{$menuGroup.menuName}}</span>
                    <ul>
                        {{foreach $menuGroup['menuList'] as $menu}}
                            <li><a onclick="Public.addTab('{{$menu.name}}', '{{$baseUrl}}{{$menu.code}}');">{{$menu.name}}</a>
                            </li>
                        {{/foreach}}
                    </ul>
                </li>
            {{/foreach}}
        </ul>
    </div>
    <div data-options="region:'center',border:true" title="">
        <div id="mainTabs" class="easyui-tabs" data-options="fit:true,border:false,plain:true">
            <div class="panel" title="系统首页" style="padding: 10px; height: 100%">
                {{*常用菜单*}}
                {{widget path="widget/favorite/menu" args= $nodeList}}
                {{*主题设置*}}
                {{widget path="widget/form/theme"}}
            </div>
        </div>
    </div>
{{/block}}
{{block name="head"}}
    <link rel="stylesheet" type="text/css" href="{{$basePath}}/static/third/logo-icon/webfont.css">
    <script type="text/javascript">$(Public.run)</script>
{{/block}}