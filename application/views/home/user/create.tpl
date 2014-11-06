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
            <select class="easyui-combobox" name="groupId"  data-options="editable:false" style="width: 160px;">
                <option value="">--请选择所属菜单组--</option>
                <option value="12">业务办理</option>
                <option value="1">待办事项</option>
                <option value="13">跟踪事项</option>
                <option value="11">历史记录</option>
                <option value="14">官文档案</option>
                <option value="15">财务核算</option>
                <option value="16">事务管理</option>
                <option value="10">系统配置</option>
                <option value="96">超凡网</option>
            </select>
        </td>
    </tr>
{/block}