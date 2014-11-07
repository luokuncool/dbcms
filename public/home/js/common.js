var App = {};

/**
 * 获取选项卡对象
 * @returns {*|jQuery|HTMLElement}
 */
App.getMainTab = function(){
    return $('#mainTabs');
};
/**
 * 待载入的页面
 * @type {{}}
 */
App.queue = {};

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

    //var iFrame = mainTab.tabs('getSelected').find('iframe');
    //if (iFrame.length) iFrame[0].contentWindow.location.href = url;
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

App.getCurrentHash = function(){
    return location.hash.replace('#','');
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
