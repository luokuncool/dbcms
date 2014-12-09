{extends file="../public/layout.tpl"}
{block name="body"}
    <div id="w" class="easyui-window" title="登陆系统" data-options="closable:false,maximizable:false,collapsible:false,minimizable:false,draggable:true,resizeable:false,width:324,height:164" style="padding:10px 31px;">
        <form id="loginForm" method="post">
            <table>
                <tr>
                    <td align="right">用&nbsp;户&nbsp;名：</td>
                    <td><input class="easyui-textbox"  type="text" name="uName" data-options="width:180" /></td>
                </tr>
                <tr>
                    <td align="right">密&nbsp;&nbsp;&nbsp;&nbsp;码：</td>
                    <td><input class="easyui-textbox" type="password" name="password" data-options="width:180" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <a class="easyui-linkbutton" id="submitForm" onclick="App.login();" data-options="iconCls:'icon-ok'" href="javascript:;" style="padding:0 8px 0 3px; border-radius: 2px 2px 2px; font-size: 20px;">登陆</a>
                        &nbsp;&nbsp;
                        <a class="easyui-linkbutton" data-options="iconCls:'icon-undo'" onclick="App.redo();" href="javascript:;" style="padding:0 8px 0 3px; border-radius: 2px 2px 2px; font-size: 20px;">重填</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
{/block}
{block name="head"}
    <script type="text/javascript" src="{$basePath}/public/home/js/main.js"></script>
    <script type="text/javascript">
    $(function(){
        var loginForm = $('#loginForm');
        loginForm.form({
            url : '{$baseUrl}login',
            onSubmit : function() {
                App.processing();
            },
            success : function(res){
                res = $.parseJSON(res);
                App.processed();
                if (res.success) {
                    App.showMessage(res.message);
                    setTimeout(function(){
                        location.reload(true);
                    }, 1500);
                } else {
                    App.alert(res.message);
                }
            }
        });        
        loginForm.bind('keyup', function(e){
            if (e.keyCode == 13) {
                $('#submitForm').focus();
                loginForm.form('submit');
            }
        });
    });
    </script>
    <style type="text/css">
        table td { padding: 5px 0px; }
    </style>
{/block}
