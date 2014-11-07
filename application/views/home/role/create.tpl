{extends file="../public/form.tpl"}
{block name="form"}
    <tr>
        <td align="right" valign="top"><font color="red">*</font> 操作代码：</td>
        <td valign="top"><input class="easyui-textbox" type="text" name="code" data-options="width:200, required:false"></td>
    </tr>
    <tr>
        <td align="right" valign="top"><font color="red">*</font> 显示名：</td>
        <td valign="top"><input class="easyui-textbox" type="text" name="name" data-options="width:200, required:false"></td>
    </tr>
    <tr>
        <td align="right" valign="top">所属菜单组：</td>
        <td valign="top">
            <select class="easyui-combobox" name="groupId" data-options="width:200">
                <option value="">--请选择所属菜单组--</option>
                {foreach $node_group_list as $node_group}
                    <option value="{$node_group@key}">{$node_group}</option>
                {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top">状态：</td>
        <td valign="top">
            <label><input type="radio" name="status" value="1" checked />启用</label>
            <label><input type="radio" name="status" value="0" />禁用</label>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top">作为菜单：</td>
        <td valign="top">
            <label><input type="radio" name="type" value="1" checked />是</label>
            <label><input type="radio" name="type" value="0" />否</label>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top">排序号：</td>
        <td valign="top">
            <input type="text" class="easyui-numberspinner" name="sort" value="0" data-options="min:0,max:999,width:200" />
        </td>
    </tr>
    <tr>
        <td align="right" valign="top">描述：</td>
        <td valign="top">
            <input type="text" class="easyui-textbox" name="remark" data-options="width:200,height:80,multiline:true" />
        </td>
    </tr>
{/block}