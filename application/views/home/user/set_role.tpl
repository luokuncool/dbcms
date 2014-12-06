{extends file="../public/grid.tpl"}
{block name="searchBlock"}
    <table id="searchBlock" width="100%">
        <tr>
            <td width="70" align="right">角色名称：</td>
            <td width="70"><input class="easyui-textbox" data-options="width:200" type="text" name="name" /></td>
            <td width="60" align="right">状态：</td>
            <td width="210">
                <select class="easyui-combobox" data-options="editable:false,width:200,height:24" name="status">
                    <option value="">请选择</option>
                    <option value="1">启用</option>
                    <option value="0">禁用</option>
                </select>
            </td>
            <td><a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-search',height:24" style="padding-right: 5px; border-radius: 2px 2px 2px">检索</a></td>
            <td align="right">
                <a class="easyui-linkbutton" data-options="iconCls:'icon-save'" onclick="Role.setRole();" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">提交保存</a>
                </a>
            </td>
        </tr>
    </table>
{/block}
{block name="rowList"}
    <tr width="100%">
        <th data-options="field:'id',align:'center',checkbox:true"></th>
        <th data-options="field:'name',sortable:true,title:'角色名'" width="18%"></th>
        <th formatter="App.formatStatus" data-options="field:'status',sortable:true" width="20%">状态</th>
        <th data-options="field:'remark',sortable:true" width="60%">描述</th>
    </tr>
{/block}
{block name="script"}
    <script type="text/javascript">
    var Role = Object();

    /**
     * 提交选中角色
     */
    Role.setRole = function() {
        App.processing();
        $.post('{$baseUrl}user/set_role/{$userId}', { roles : App.getIds() }, App.successHandler, 'text');
    };

    $(function(){
        //设置表格对象
        var gridOptions = App.getGrid().datagrid('options');
        gridOptions.onLoadSuccess = function(){
            //选中已有身份
            var existsRoleIds = [{$roleIds}];
            for(var i = 0; i<existsRoleIds.length; i++) {
                App.getGrid().datagrid('selectRecord', existsRoleIds[i]);
            }
        };
    });
    </script>
{/block}