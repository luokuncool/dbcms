{extends file="../public/layout.tpl"}
{block name="body"}
    <div data-options="region:'north',border:false" style="height:70px;">
        <h1 style="padding:20px 0 0 10px; margin: 0;">EasyUI+CodeIgniter</h1>
    </div>
    <div data-options="region:'west',split:true,title:'West'" style="width:150px;">

        <ul class="easyui-tree">
            <li>
                <span>My Documents</span>
                <ul>
                    <li><a href="javascript:App.addTab('iframeTest1', '/home/gird')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest2', '/home/test/2?m=ddd')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest3', '/home/test/3')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest4', '/home/test/4')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest5', '/home/test/5')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest6', '/home/test/6')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest7', '/home/test/7')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest8', '/home/test/8')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest9', '/home/test/9')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest10', '/home/test/10')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest11', '/home/test/11')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest12', '/home/test/12')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest13', '/home/test/13')">添加文章</a></li>
                    <li><a href="javascript:App.addTab('iframeTest14', '/home/test/14')">添加文章</a></li>
                </ul>
            </li>

        </ul>
    </div>
    <div data-options="region:'east',split:true,collapsed:true,title:'East'" style="width:100px;padding:10px;">east region</div>
    <div data-options="region:'center'">
        <div id="easyui-tabs" class="easyui-tabs" data-options="fit:true,border:false,plain:true">
            <div class="panel" title="iframe">
                <div style="padding: 10px">test</div>
            </div>
        </div>
    </div>
{/block}
{block name="head"}
    <script type="text/javascript">
    var App = {
        addTab : function(title, url){
            var self = this;
            if ($('#easyui-tabs').tabs('exists', title)) {

            } else {
                $('#easyui-tabs')
                    .tabs({
                        onSelect: function (title, index) {
                            location.hash = self.getLocalStorage(title);
                            self.setTabsStorage(title, location.hash.replace('#',''));
                        },
                        onClose: function(thisTitle){
                            self.setTabsStorage(thisTitle, '', true);
                        }
                    })
                    .tabs('add', {
                        title: title,
                        content: '<div style="padding:10px"><iframe scrolling="no" frameborder="0"  src="' + url
                        + '" style="width:100%;height:99%;"></iframe></div>',
                        closable: true
                    });
                self.setTabsStorage(title, url);
            }
            $('#easyui-tabs').tabs('select', title);
            var t = $('#easyui-tabs').tabs('getSelected').find('iframe');
            if (t.length) t[0].contentWindow.location.href = url;
        },
       setTabsStorage : function(title, url, remove){
            var self = this
                ,  tabs =  self.getLocalStorage();
            if (remove) {
                delete tabs[title];
            } else {
                tabs[title] = url;
            }
            localStorage.tabs = JSON.stringify(tabs);
           location.hash = self.getLocalStorage(title);
        },
        getLocalStorage : function(title){
            var tabs =  localStorage.tabs ? eval('('+localStorage.tabs+')') : {};
            return title ? (tabs[title] ?  tabs[title] : '') : tabs;
        },
        run : function(){
            var url = location.hash.replace('#','');
            var self = this
                ,  tabs =  self.getLocalStorage()
                ,  select;
            for(var title in tabs) {
                self.addTab(title, tabs[title].replace('#',''));
                if(url == tabs[title]) select = title;
            }
            $('#easyui-tabs').tabs('select', select);
        }
    };
    $(function(){
        App.run();
    });
    </script>
{/block}