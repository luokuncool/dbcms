{{extends file="../public/form.tpl"}}
{{block name="form"}}
    <tr>
        <td align="right" valign="top"><font color="red">*</font> 角色名：</td>
        <td valign="top"><input class="easyui-textbox" type="text" name="name" value="{{$data.name}}"
                                data-options="width:200, required:false"></td>
    </tr>
    <tr>
        <td align="right" valign="top">状态：</td>
        <td valign="top">
            <label><input type="radio" name="status" value="1" {{if $data['status']}}checked{{/if}} />启用</label>
            <label><input type="radio" name="status" value="0" {{if $data['status']  eq 0}}checked{{/if}} />禁用</label>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top">描述：</td>
        <td valign="top">
            <input type="text" class="easyui-textbox" name="remark" value="{{$data.remark}}"
                   data-options="width:200,height:80,multiline:true"/>
        </td>
    </tr>
{{/block}}