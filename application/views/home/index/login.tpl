{extends file="../public/layout.tpl"}
{block name="body"}
    <div id="w" class="easyui-window" title="登陆系统" data-options="closable:false,maximizable:false,collapsible:false,minimizable:false,draggable:false" style="width:400px;height:200px;padding:10px;">
        <div style="padding:10px 60px 20px 60px">
            <form id="loginForm" method="post">
                <table cellpadding="5">
                    <tr>
                        <td>用户名:</td>
                        <td><input class="easyui-textbox" type="text" name="name" data-options="" /></td>
                    </tr>
                    <tr>
                        <td valign="top">密&nbsp;&nbsp;码:</td>
                        <td><input class="easyui-textbox" type="password" name="password" data-options=""  /></td>
                    </tr>
                </table>
            </form>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">登陆</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">重置</a>
            </div>
        </div>
    </div>
{/block}
{block name="head"}

{/block}