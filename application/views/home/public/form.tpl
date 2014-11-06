{extends file="../public/layout.tpl"}
{block name="body"}
    <form id="postForm" action="" method="post">
        <div class="easyui-panel" title="" data-options="collapsible:true, border: false" style="padding:10px;">
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
    <script type="text/javascript">
    $(function(){
        var submitForm = $('#submitForm'),
            postForm   = $('#postForm');
        submitForm.click(function(){
            postForm.form('submit', {
                success : function(data) {
                    try {
                        data = eval('('+data+')');
                        data.success ? $.messager.alert(data.message, 'info') : $.messager.alert(data.message, 'error');
                        data.reloadMain && parent.window.location.reload(true);
                        console.log(data);
                    } catch (e) {
                        $.messager.alert('提交失败', '程序出错', 'error');
                    }
                }
            });
        });
    });
    </script>
{/block}