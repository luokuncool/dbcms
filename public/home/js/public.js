;(function(Public, parentWindow){

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
            res.closeSelf && setTimeout(Public.closeSelfHandler, 500);
            switch( res.reloadType) {
                case 1 :
                    reloadFn = function() {
                        parentWindow.location.reload();
                    };
                    break;
                case 2 :
                    reloadFn = function() {
                        Public.getGrid().datagrid('reload');
                    };
                    break;
                default :
                    reloadFn = function() {
                        location.reload(true);
                    };
            }
            setTimeout(reloadFn, 1000);
        } else {
            Public.alert(res.message);
        }
    };

    //暴露Public对象
    window.Public = Public;

})(parent.Main, parent);
