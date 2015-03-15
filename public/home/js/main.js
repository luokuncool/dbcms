(function(){
    var Main = {};

    Main.baseUrl = '/';
    /**
     * 待载入的页面
     * @type {{}}
     */
    Main.queue = {};

    /**
     * 获取选项卡对象
     * @returns {*|jQuery|HTMLElement}
     */
    Main.getMainTab = function(){
        return $('#mainTabs');
    };

    /**
     * 新打开选项卡
     * @param title
     * @param url
     * @param select
     */
    Main.addTab = function(){
        var args = arguments,
            title = args[0],
            url = args[1],
            select = args[2],
            mainTab = Main.getMainTab();
        select  = select === undefined ? true : select;
        var onSelectHandler = function (title) {
            location.hash = title;
            if (Main.queue[title] !== undefined) {
                Main.getMainTab().tabs('update',{
                    tab: Main.getMainTab().tabs('getSelected'),
                    options: {
                        title: title,
                        //href: Main.queue[title]
                        content: '<iframe scrolling="no" frameborder="0" width="100%" height="99%" src="' + Main.queue[title]+ '"></iframe>'
                    }
                });
                delete Main.queue[title];
            }
        };
        if (!mainTab.tabs('exists', title)){
            mainTab
                .tabs({
                    onSelect: onSelectHandler,
                    onClose: function(thisTitle){
                        Main.setTabsStorage(thisTitle, '', true);
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
                delete Main.queue[title];
            } else {
                Main.queue[title] = url;
            }
            Main.setTabsStorage(title, url);
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
    Main.setTabsStorage = function(title, url, remove){
        var Main = this,
            tabs =  Main.getLocalStorage();
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
    Main.getLocalStorage = function(title){
        var tabs =  localStorage.tabs ? eval('('+localStorage.tabs+')') : {};
        return title ? (tabs[title] ?  tabs[title] : '') : tabs;
    };

    /**
     * 获取location.hash
     * @returns {string}
     */
    Main.getCurrentHash = function(){
        return location.hash.replace('#','');
    };


    /**
     * 关闭选项卡回调
     */
    Main.closeSelfHandler = function() {
        var  mainTab = Main.getMainTab(),
            selectedTab = mainTab.tabs('getSelected'),
            selectedIndex = mainTab.tabs('getTabIndex', selectedTab);
        mainTab.tabs('close', selectedIndex);
        Main.reloadGrid();
    };

    /**
     * 获取表格对象
     */
    Main.getGrid = function() {
        return Main.getSelectWin().$('#dataGrid');
    };

    /**
     * 刷新表格
     */
    Main.reloadGrid = function() {
        Main.getGrid().datagrid('reload');
    };

    /**
     * 获取当前选项卡文档
     * @returns {*|jQuery|HTMLElement}
     */
    Main.getSelectDoc = function(){
        return Main.getSelectFrame().contentDocument;
    };

    /**
     * 获取dataGrid选中行Ids
     * @returns {string}
     */
    Main.getIds = function(){
        var checkedRow = Main.getGrid().datagrid('getChecked'),
            ids = '';
        for(var i=0; i<checkedRow.length; i++){
            ids += (ids === '') ? checkedRow[i].id : ','+checkedRow[i].id;
        }
        return ids;
    };

    /**
     * 表单提交前函数
     */
    Main.submitBefore = function(){
        $.messager.progress({
            title : '提示',
            text : '数据处理中，请稍后....',
            interval : 1000
        });
    };

    /**
     * 初始化应用
     */
    Main.run = function(){
        var currentTab = decodeURIComponent(Main.getCurrentHash()),
            tabs =  Main.getLocalStorage(),
            mainTab = Main.getMainTab(),
            select;
        for(var title in tabs) {
            if(currentTab == title) {
                select = { title : title, url : tabs[title]};
            }
            Main.addTab(title, tabs[title], false);
        }
        select === undefined ? mainTab.tabs('select', 0) : mainTab.tabs('select', select.title);
    };

    /**
     * 获取当前选项卡框架对象
     * @returns {*}
     */
    Main.getSelectFrame = function(){
        var  mainTab = Main.getMainTab(),
            selectedTab = mainTab.tabs('getSelected'),
            iFrame = selectedTab.find('iframe');
        return iFrame.length ? iFrame[0] : $();
    };

    /**
     * 处理进度条
     */
    Main.processing = function() {
        $.messager.progress({
            text : '数据处理中，请稍后....',
            interval : 1000
        });
    };

    /**
     * 关闭进度条
     */
    Main.processed = function() {
        $.messager.progress('close');
    };

    /**
     * 确认框
     * @param title
     * @param msg
     * @param fn
     */
    Main.confirm = function(title, msg, fn) {
        $.messager.confirm(title, msg, fn);
    };

    /**
     * 错误框
     * @param msg
     */
    Main.alert = function(msg) {
        $.messager.alert('错误', msg, 'error');
    };

    /**
     * 显示提示
     * @param msg
     */
    Main.showMessage = function(msg) {
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

    /**
     * 精简版编辑器配置
     * @type {{resizeType: number, allowPreviewEmoticons: boolean, allowImageUpload: boolean, allowFileManager: boolean, uploadJson: string, fileManagerJson: string, afterBlur: Function, items: string[]}}
     */
    Main.minEditorConfig = {
        minWidth : 400,
        minHeight : 150,
        resizeType : 1,
        allowPreviewEmoticons : false,
        allowImageUpload : true,
        allowFileManager : true,
        uploadJson : '/upload_file',
        fileManagerJson : '/file_manager',
        afterBlur : function() { this.sync(); },
        items : [
            'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
            'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
            'insertunorderedlist', 'link']
    };

    /**
     * 编辑器完整版
     * @type {{minWidth: number, resizeType: number, allowPreviewEmoticons: boolean, allowImageUpload: boolean, allowFileManager: boolean, uploadJson: string, fileManagerJson: string, afterBlur: Function, items: string[]}}
     */
    Main.editorConfig = {
        minWidth : 600,
        minHeight : 200,
        resizeType : 1,
        allowPreviewEmoticons : false,
        allowImageUpload : true,
        allowFileManager : true,
        uploadJson : '/upload_file',
        fileManagerJson : '/file_manager',
        afterBlur : function() { this.sync(); },
        items : [
            'source', '|', 'undo', 'redo', '|', 'cut', 'copy', 'paste', 'plainpaste', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'clearhtml', 'selectall', '|',
            'baidumap', 'link', 'unlink', 'table', '/',
            'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', '|', 'bold',
            'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|','image', 'multiimage', 'insertfile', 'hr'
        ]
    };

    /**
     * 更新缓存
     */
    Main.updateCache = function() {
        Main.processing();
        $.get(Main.baseUrl+'update_cache', function(res){
            Main.processed();
            if (res.success) {
                Main.showMessage(res.message);
                setTimeout(function(){
                    location.reload(true);
                }, 1500);
            } else {
                Main.alert(res.message);
            }
        }, 'json');
    };

    /**
     * 退出登录
     */
    Main.logout = function() {
        Main.processing();
        $.get(Main.baseUrl+'logout', Main.successHandler, 'text');
    };

    /**
     * 获取子窗口对象
     */
    Main.getSelectWin = function() {
        return Main.getSelectFrame().contentWindow;
    };

    //暴露全局变量Main
    window.Main = Main;
})();
