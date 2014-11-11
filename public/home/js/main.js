(function(){
    var App = {};

    /**
     * 待载入的页面
     * @type {{}}
     */
    App.queue = {};

    /**
     * 获取选项卡对象
     * @returns {*|jQuery|HTMLElement}
     */
    App.getMainTab = function(){
        return $('#mainTabs');
    };

    /**
     * 新打开选项卡
     * @param title
     * @param url
     * @param select
     */
    App.addTab = function(){
        var args = arguments,
            title = args[0],
            url = args[1],
            select = args[2],
            mainTab = App.getMainTab();
        select  = select === undefined ? true : select;
        var onSelectHandler = function (title) {
            location.hash = title;
            if (App.queue[title] !== undefined) {
                App.getMainTab().tabs('update',{
                    tab: App.getMainTab().tabs('getSelected'),
                    options: {
                        title: title,
                        //href: App.queue[title]
                        content: '<iframe scrolling="no" frameborder="0" width="100%" height="99%" src="' + App.queue[title]+ '"></iframe>'
                    }
                });
                delete App.queue[title];
            }
        };
        if (!mainTab.tabs('exists', title)){
            mainTab
                .tabs({
                    onSelect: onSelectHandler,
                    onClose: function(thisTitle){
                        App.setTabsStorage(thisTitle, '', true);
                    }
                })
                .tabs('add', {
                    selected: select,
                    title: title,
                    //href: select ? url : '',
                    content: select ? '<iframe scrolling="no" frameborder="0" width="100" height="99%" src="' + url+ '" style="width:100%;"></iframe>' : '',
                    closable: true
                });
            if (select) {
                delete App.queue[title];
            } else {
                App.queue[title] = url;
            }
            App.setTabsStorage(title, url);
        } else {
            mainTab.tabs('select', title);
        }
    };

    /**
     * 选项卡数据存储
     * @param title
     * @param url
     * @param remove
     */
    App.setTabsStorage = function(title, url, remove){
        var App = this,
            tabs =  App.getLocalStorage();
        if (remove) {
            delete tabs[title];
        } else {
            tabs[title] = url;
        }
        localStorage.tabs = JSON.stringify(tabs);
    };

    /**
     * 获取选项卡
     * @param title
     * @returns {*}
     */
    App.getLocalStorage = function(title){
        var tabs =  localStorage.tabs ? eval('('+localStorage.tabs+')') : {};
        return title ? (tabs[title] ?  tabs[title] : '') : tabs;
    };

    /**
     * 获取location.hash
     * @returns {string}
     */
    App.getCurrentHash = function(){
        return location.hash.replace('#','');
    };


    /**
     * 关闭选项卡回调
     */
    App.closeSelfHandler = function() {
        var  mainTab = App.getMainTab(),
            selectedTab = mainTab.tabs('getSelected'),
            selectedIndex = mainTab.tabs('getTabIndex', selectedTab);
        mainTab.tabs('close', selectedIndex);
        mainTab.tabs('select',selectedIndex-1);
    };

    /**
     * 获取当前选项卡文档
     * @returns {*|jQuery|HTMLElement}
     */
    App.getSelectDoc = function(){
        return App.getSelectFrame().contentDocument;
    };

    /**
     * 获取表格对象
     * @returns {*}
     */
    App.getGrid = function(){
        return $(App.getSelectDoc()).find('#dataGrid');
    };

    /**
     * fixme 获取dataGrid选中行Ids
     * @returns {string}
     */
    App.getIds = function(){
        var checkedRow = App.getGrid().datagrid('getChecked'),
            ids = '';
        for(var i=0; i<checkedRow.length; i++){
            ids += (ids === '') ? checkedRow[i].id : ','+checkedRow[i].id;
        }
        return ids;
    };

    /**
     * 表单提交前函数
     */
    App.submitBefore = function(){
        $.messager.progress({
            title : '提示',
            text : '数据处理中，请稍后....',
            interval : 1000
        });
    };

    /**
     * 初始化应用
     */
    App.run = function(){
        var currentTab = decodeURIComponent(App.getCurrentHash()),
            tabs =  App.getLocalStorage(),
            mainTab = App.getMainTab(),
            select;
        for(var title in tabs) {
            if(currentTab == title) {
                select = { title : title, url : tabs[title]};
            }
            App.addTab(title, tabs[title], false);
        }
        select === undefined ? mainTab.tabs('select', 0) : mainTab.tabs('select', select.title);
    };

    /**
     * 获取当前选项卡框架对象
     * @returns {*}
     */
    App.getSelectFrame = function(){
        var  mainTab = App.getMainTab(),
            selectedTab = mainTab.tabs('getSelected'),
            iFrame = selectedTab.find('iframe');
        return iFrame.length ? iFrame[0] : $();
    };

    /**
     * 处理进度条
     */
    App.processing = function() {
        $.messager.progress({
            text : '数据处理中，请稍后....',
            interval : 1000
        });
    };

    /**
     * 关闭进度条
     */
    App.processed = function() {
        $.messager.progress('close');
    };

    /**
     * 确认框
     * @param msg
     * @param fn
     */
    App.confirm = function(msg, fn) {
        $.messager.confirm(msg, fn);
    };

    /**
     * 错误框
     * @param msg
     */
    App.alert = function(msg) {
        $.messager.alert('错误', msg, 'error');
    };

    /**
     * 显示提示
     * @param msg
     */
    App.showMessage = function(msg) {
        $.messager.show({
            title:'提示',
            msg:msg,
            showType:'fade',
            timeout:1500,
            style:{
                right:'',
                bottom:''
            }
        });
    };

    //暴露全局变量App
    window.App = App;
})();