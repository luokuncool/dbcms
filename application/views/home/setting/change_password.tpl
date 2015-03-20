{{extends file="../public/form.tpl"}}
{{block name="form"}}
    <tr>
        <td align="right">旧&nbsp;&nbsp;密&nbsp;&nbsp;码：</td>
        <td><input type="password" class="easyui-textbox" name="oldPassword" data-options="width:180"/></td>
    </tr>
    <tr>
        <td align="right">新&nbsp;&nbsp;密&nbsp;&nbsp;码：</td>
        <td><input type="password" class="easyui-textbox" name="password" data-options="width:180"/></td>
    </tr>
    <tr>
        <td align="right">确认新密码：</td>
        <td><input type="password" class="easyui-textbox" name="rePassword" data-options="width:180"/></td>
    </tr>
{{/block}}
