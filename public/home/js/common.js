var App = {
    getMainTab : function(){
        return $('#easyui-tabs');
    },
    /**
     * 新打开选项卡
     * @param title
     * @param url
     */
    addTab : function(title, url){
        var self    = this,
            mainTab = self.getMainTab();
        if (!mainTab.tabs('exists', title)){
            mainTab
                .tabs({
                    onSelect: function (title) {
                        location.hash = self.getLocalStorage(title);
                        self.setTabsStorage(title, location.hash.replace('#',''));
                    },
                    onClose: function(thisTitle){
                        self.setTabsStorage(thisTitle, '', true);
                    }
                })
                .tabs('add', {
                    selected: true,
                    title: title,
                    //href : url,
                    //refresh:url,
                    content: '<iframe scrolling="no" frameborder="0"  src="' + url+ '" style="width:100%;height:99%;"></iframe>',
                    closable: true
                });
            self.setTabsStorage(title, url);
        }
        mainTab.tabs('select', title);
        //mainTab.tabs('refresh', url);
        var iFrame = mainTab.tabs('getSelected').find('iframe');
        if (iFrame.length) iFrame[0].contentWindow.location.href = url;
    },
    /**
     * 选项卡数据存储
     * @param title
     * @param url
     * @param remove
     */
    setTabsStorage : function(title, url, remove){
        var self = this,
            tabs =  self.getLocalStorage();
        if (remove) {
            delete tabs[title];
        } else {
            tabs[title] = url;
        }
        localStorage.tabs = JSON.stringify(tabs);
    },
    /**
     * 获取选项卡
     * @param title
     * @returns {*}
     */
    getLocalStorage : function(title){
        var tabs =  localStorage.tabs ? eval('('+localStorage.tabs+')') : {};
        return title ? (tabs[title] ?  tabs[title] : '') : tabs;
    },
    /**
     * 初始化应用
     */
    run : function(){
        var url = location.hash.replace('#',''),
            self = this,
            tabs =  self.getLocalStorage(),
            mainTab = self.getMainTab(),
            select;
        for(var title in tabs) {
            //self.addTab(title, tabs[title].replace('#',''));
            if(url == tabs[title].replace('#','')) select = title;
        }
        select && self.addTab(select, url);
        //mainTab.tabs('select', select);
    }
};