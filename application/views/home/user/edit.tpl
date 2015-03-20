{extends file="../public/form.tpl"}
{block name="form"}
    <tr>
        <td align="right">操作代码：</td>
        <td><input class="easyui-textbox" type="text" name="name" data-options="width:160, required:false"></td>
    </tr>
    <tr>
        <td align="right">显示名：</td>
        <td><input class="easyui-textbox" type="text" name="name" data-options="width:160, required:false"></td>
    </tr>
    <tr>
        <td align="right">所属菜单组：</td>
        <td>
            <select class="easyui-combobox" name="groupId"  data-options="width:160, editable:false">
                <option value="">--请选择所属菜单组--</option>
                {foreach $node_group_list as $node_group}
                    <option value="{$node_group@key}">{$node_group}</option>
                {/foreach}
            </select>
        </td>
    </tr>
{/block}