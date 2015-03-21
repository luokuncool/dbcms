~function(parentWindow){

    /**
     * 待载入的页面
     * @type {object}
     */
    Public.queueTabs = {};

    /**
     * 获取选项卡对象
     * @returns {*|jQuery|HTMLElement}
     */
    Public.getMainTab = function(){
        return $('#mainTabs');
    };

    /**
     * 新打开选项卡
     * @param title
     * @param url
     * @param select
     */
    Public.addTab = function(){
        var args = arguments,
            title = args[0],
            url = args[1],
            select = args[2],
            mainTab = Public.getMainTab();
        select  = select === undefined ? true : select;
        var onSelectHandler = function (title) {
            location.hash = title;
            if (Public.queueTabs[title] !== undefined) {
                Public.getMainTab().tabs('update',{
                    tab: Public.getMainTab().tabs('getSelected'),
                    options: {
                        title: title,
                        content: '<iframe scrolling="no" frameborder="0" width="100%" height="99%" src="' + Public.queueTabs[title]+ '"></iframe>'
                    }
                });
                delete Public.queueTabs[title];
            }
        };
        if (!mainTab.tabs('exists', title)){
            mainTab
                .tabs({
                    onSelect: onSelectHandler,
                    onClose: function(thisTitle){
                        Public.setTabsStorage(thisTitle, undefined);
                    }
                })
                .tabs('add', {
                    selected: select,
                    title: title,
                    content: select ? '<iframe scrolling="no" frameborder="0" width="100" height="99%" src="' + url+ '" style="width:100%;"></iframe>' : '',
                    closable: true
                });
            if (select) {
                delete Public.queueTabs[title];
            } else {
                Public.queueTabs[title] = url;
            }
            Public.setTabsStorage(title, url);
        } else {
            mainTab.tabs('select', title);
        }
    };

    /**
     * 选项卡数据存储
     * @param title
     * @param url
     */
    Public.setTabsStorage = function(title, url){
        var tabs =  Public.getTabLocalStorage();
        if (url === undefined) {
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
    Public.getTabLocalStorage = function(){
        var title = arguments[0],
            tabs =  $.parseJSON(localStorage.tabs) || {};
        return title ? (tabs[title] || '') : tabs;
    };

    /**
     * 获取location.hash
     * @returns {string}
     */
    Public.getCurrentHash = function(){
        return location.hash.replace('#','');
    };

    /**
     * 关闭选项卡回调
     */
    Public.closeSelfHandler = function() {
        var  mainTab = Public.getMainTab(),
             selectedTab = mainTab.tabs('getSelected'),
             selectedIndex = mainTab.tabs('getTabIndex', selectedTab);
        mainTab.tabs('close', selectedIndex);
        Public.reloadGrid();
    };

    /**
     * 获取表格对象
     */
    Public.getGrid = function() {
        return Public.getSelectWin().$('#dataGrid');
    };

    /**
     * 刷新表格
     */
    Public.reloadGrid = function() {
        Public.getGrid().datagrid('reload');
    };

    /**
     * 获取当前选项卡文档
     * @returns {*|jQuery|HTMLElement}
     */
    Public.getSelectDoc = function(){
        return Public.getSelectFrame().contentDocument;
    };

    /**
     * 获取dataGrid选中行Ids
     * @returns {string}
     */
    Public.getIds = function(){
        var checkedRow = Public.getGrid().datagrid('getChecked'),
            ids = '';
        for(var i=0; i<checkedRow.length; i++){
            ids += (ids === '') ? checkedRow[i].id : ','+checkedRow[i].id;
        }
        return ids;
    };

    /**
     * 初始化应用
     */
    Public.run = function(){
        var currentTab = decodeURIComponent(Public.getCurrentHash()),
            tabs =  Public.getTabLocalStorage(),
            mainTab = Public.getMainTab(),
            select;
        for(var title in tabs) {
            if(currentTab == title) {
                select = { title : title, url : tabs[title]};
            }
            Public.addTab(title, tabs[title], false);
        }
        select === undefined ? mainTab.tabs('select', 0) : mainTab.tabs('select', select.title);
    };

    /**
     * 获取当前选项卡框架对象
     * @returns {*}
     */
    Public.getSelectFrame = function(){
        var  mainTab = Public.getMainTab(),
             selectedTab = mainTab.tabs('getSelected'),
             iFrame = selectedTab.find('iframe');
        return iFrame.length ? iFrame[0] : $();
    };

    /**
     * 处理进度条
     */
    Public.processing = function() {
        $.messager.progress({
            text : '处理中，请稍后....',
            interval : 1000
        });
    };

    /**
     * 关闭进度条
     */
    Public.processed = function() {
        $.messager.progress('close');
    };

    /**
     * 确认框
     * @param title
     * @param msg
     * @param fn
     */
    Public.confirm = function(title, msg, fn) {
        $.messager.confirm(title, msg, fn);
    };

    /**
     * 错误框
     * @param msg
     */
    Public.alert = function(msg) {
        $.messager.alert('错误', msg, 'error');
    };

    /**
     * 显示提示
     * @param msg
     */
    Public.showMessage = function(msg) {
        $.messager.show({
            title:'提示',
            msg:msg,
            showType:'fade',
            timeout:500,
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
    Public.minEditorConfig = {
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
    Public.editorConfig = {
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
    Public.updateCache = function() {
        Public.processing();
        $.get(Public.baseUrl+'update_cache', function(res){
            Public.processed();
            if (res.success) {
                Public.showMessage(res.message);
                setTimeout(function(){
                    location.reload(true);
                }, 1500);
            } else {
                Public.alert(res.message);
            }
        }, 'json');
    };

    /**
     * 退出登录
     */
    Public.logout = function() {
        Public.processing();
        $.get(Public.baseUrl+'logout', Public.successHandler, 'text');
    };

    /**
     * 获取子窗口对象
     */
    Public.getSelectWin = function() {
        return Public.getSelectFrame().contentWindow;
    };

    /**
     * 格式化状态
     * @param field
     * @param row
     * @returns { string }
     */
    Public.formatStatus = function(field) {
        return field == 1 ? '<font color="green">启用</font>' : '<font color="red">禁用</font>';
    };

    /**
     * 启用
     */
    Public.enable = function(url){
        Public.processing();
        $.post(url,  { ids:Public.getIds() }, Public.successHandler, 'text');
    };


    /**
     * 禁用
     */
    Public.disable = function(url){
        Public.processing();
        $.post(url,  { ids:Public.getIds() }, Public.successHandler, 'text');
    };

    /**
     * 删除
     */
    Public.remove = function(url) {
        Public.confirm('确认框', '确定要删除所选？', function(ok){
            if (ok) {
                Public.processing();
                $.post(url,  { ids:Public.getIds() }, Public.successHandler, 'text');
            }
        });
    };

    /**
     * AJAX请求成功回调函数
     * @param res
     */
    Public.successHandler = function(res) {
        Public.processed();
        res = $.parseJSON(res);
        if (res.success) {
            Public.showMessage(res.message);
            res.closeSelf && setTimeout(Public.closeSelfHandler, 500);
            setTimeout(res.reloadType === undefined ? Public.reload : Public[res.reloadType], 500);
        } else {
            Public.alert(res.message);
        }
    };

    /**
     * 刷新表格
     */
    Public.reloadGrid = function(){
        Public.getGrid().datagrid('reload');
    };

    /**
     * 刷新父窗体
     */
    Public.reloadParentWin = function(){
        parentWindow.location.reload();
    };

    /**
     * 刷新当前窗体
     */
    Public.reload = function(){
        location.reload(true);
    };

    //暴露Public对象
    window.Public = Public;

}(parent);
