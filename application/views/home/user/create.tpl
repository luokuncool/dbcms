{extends file="../public/form.tpl"}
{block name="form"}
    <tr>
        <td align="right">账号：</td>
        <td><input class="easyui-textbox" type="text" name="uName" data-options="width:160, required:false"></td>
    </tr>
    <tr>
        <td align="right">真实姓名：</td>
        <td><input class="easyui-textbox" type="text" name="name" data-options="width:160, required:false"></td>
    </tr>
    <tr>
        <td align="right">英文名：</td>
        <td><input class="easyui-textbox" type="text" name="name" data-options="width:160, required:false"></td>
    </tr>
    <tr>
        <td align="right">所属部门：</td>
        <td>
            <select class="easyui-combobox" name="groupId"  data-options="editable:false" style="width: 160px;">
                <option value="">--请选择所属部门--</option>
                {foreach $node_group_list as $node_group}
                    <option value="{$node_group@key}">{$node_group}</option>
                {/foreach}
            </select>
        </td>
    </tr>
{/block}