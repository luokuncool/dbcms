;(function(App, parentWindow){

    /**
     * 格式化状态
     * @param field
     * @param row
     * @returns { string }
     */
    App.formatStatus = function(field) {
        return field == 1 ? '<font color="green">启用</font>' : '<font color="red">禁用</font>';
    };

    /**
     * 启用
     */
    App.enable = function(url){
        App.processing();
        $.post(url,  { ids:App.getIds() }, App.successHandler, 'text');
    };


    /**
     * 禁用
     */
    App.disable = function(url){
        App.processing();
        $.post(url,  { ids:App.getIds() }, App.successHandler, 'text');
    };

    /**
     * 删除
     */
    App.remove = function(url) {
        App.confirm('确认框', '确定要删除所选？', function(ok){
            if (ok) {
                App.processing();
                $.post(url,  { ids:App.getIds() }, App.successHandler, 'text');
            }
        });
    };

    /**
     * AJAX请求成功回调函数
     * @param res
     */
    App.successHandler = function(res) {
        App.processed();
        try {
            var reloadFn;
            res = $.parseJSON(res); //eval('('+res+')');
            if (res.success) {
                $.messager.show({
                    title:'提示',
                    msg:res.message,
                    showType:'fade',
                    timeout:500,
                    style:{
                        right:'',
                        bottom:''
                    }
                });
                res.closeSelf && setTimeout(App.closeSelfHandler, 500);
                switch( res.reloadType) {
                    case 1 :
                        reloadFn = function() {
                            parentWindow.location.reload();
                        };
                        break;
                    case 2 :
                        reloadFn = function() {
                            App.getGrid().datagrid('reload');
                        };
                        break;
                    default :
                        reloadFn = function() {
                            location.reload(true);
                        };
                }
                setTimeout(reloadFn, 1000);
            } else {
                App.alert(res.message);
            }
        } catch (e) {
            App.alert('程序出错');
        }
    };

    //暴露App对象
    window.App = App;

})(parent.App, parent);
