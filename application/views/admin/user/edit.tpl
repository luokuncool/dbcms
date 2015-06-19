{{extends file="../public/form.tpl"}}
{{block name="form"}}
    <tr>
        <td align="right">账户名称：</td>
        <td><input class="easyui-textbox" type="text" name="name" data-options="width:160, required:false"
                   value="{{$data.uName}}"/></td>
    </tr>
    <tr>
        <td align="right">真实名称：</td>
        <td><input class="easyui-textbox" type="text" name="name" data-options="width:160, required:false"
                   value="{{$data.name}}"/></td>
    </tr>
{{/block}}