~function(Public, parentWindow){

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
            $.messager.show({
                title:'提示',
                msg:res.message,
                showType:'fade',
                timeout:400,
                style:{
                    right:'',
                    bottom:''
                }
            });
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

}(parent.Main, parent);
