{extends file="../public/layout.tpl"}
{block name="body"}
    <form id="postForm" action="" method="post">
        <div class="easyui-panel" data-options="reigin:'center', collapsible:true, border: false" style="padding:10px;">
            <table>
                {block name="form"}{/block}
                <tr>
                    <td class="&nbsp;"></td>
                    <td>
                        <a class="easyui-linkbutton" id="submitForm" data-options="iconCls:'icon-save'" href="javascript:;" style="padding:0 5px; border-radius: 2px 2px 2px;">提交保存</a>
                    </td>
                </tr>
            </table>
        </div>
    </form>
{/block}
{block name="head"}
    <style type="text/css">
        table td { padding: 4px 0; }
    </style>
    <script type="text/javascript">
    $(function(){
        var submitForm = $('#submitForm'),
            postForm   = $('#postForm'),
            closeSelfHandler = function() {
                var  mainTab = parent.App.getMainTab(),
                     selectedTab = mainTab.tabs('getSelected'),
                     selectedIndex = mainTab.tabs('getTabIndex', selectedTab);
                parent.App.getMainTab().tabs('close', selectedIndex);
            },
            successHandler = function(data){
                $.messager.progress('close');
                try {
                    data = eval('('+data+')');
                    data.success ? $.messager.alert('提示', data.message, 'info') : $.messager.alert('错误', data.message, 'error');
                    data.closeSelf && setTimeout(closeSelfHandler, 1400);
                    if (data.reloadMain){
                        setTimeout(function(){
                            parent.window.location.reload(true);
                        }, 1500);
                    }
                    if (data.reload) {
                        location.reload(true);
                    }
                } catch (e) {
                    $.messager.alert('错误', '程序出错', 'error');
                }
            };
        submitForm.click(function(){
            postForm.form('submit', {
                onSubmit : function(){
                    $.messager.progress({
                        title : '提示',
                        text : '数据处理中，请稍后....',
                        interval : 1000
                    });
                },
                success : function(data) {
                    successHandler(data);
                }
            });
        });
    });
    </script>
{/block}