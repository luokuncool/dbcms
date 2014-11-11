{extends file="../public/gird.tpl"}
{block name="search_block"}
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
                <a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="Role.setIdentities();" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">确定</a>
                </a>
            </td>
        </tr>
    </table>
{/block}
{block name="row_list"}
    <tr width="100%">
        <th data-options="field:'id',align:'center',checkbox:true"></th>
        <th data-options="field:'name',sortable:true,title:'角色名'" width="18%"></th>
        <th formatter="Role.formatStatus" data-options="field:'status',sortable:true" width="20%">状态</th>
        <th data-options="field:'remark',sortable:true" width="60%">描述</th>
    </tr>
{/block}
{block name="script"}
    <script type="text/javascript">
    var Role = Object();
    /**
     * 被选中的角色
     */
    Role.ids = [];
    /**
     * 获取数据表对象
     */
    Role.getGrid = function(){
        return $('#dataGrid');
    };

    /**
     * 格式化状态
     * @param field
     * @param row
     * @returns { string }
     */
    Role.formatStatus = function(field, row) {
        return field == 1 ? '<font color="green">启用</font>' : '<font color="red">禁用</font>'
    };

    /**
     * 选中单行
     */
    Role.onSelect = function(index, row) {
        Role.ids.push(parseInt(row.id));
    };

    /**
     * 反选单行
     */
    Role.onUnSelect = function(index, row) {
        for(var i=0; i<Role.ids.length; i++) {
            if (Role.ids[i] == row.id) Role.ids.splice(i, 1);
        }
    };

    /**
     * 全选行
     */
    Role.onSelectAll = function(rows) {
        for(var i=0; i<rows.length; i++) {
            Role.ids.push(parseInt(rows[i].id));
        }
    };

    /**
     * 反选行
     */
    Role.onUnSelectAll = function(rows) {
        for(var i=0; i<rows.length; i++) {
            //Role.ids.push(rows[i].id);
            for(var j=0; j<Role.ids.length; j++) {
                if (Role.ids[j] == rows[i].id) Role.ids.splice(j, 1);
            }
        }
    };

    /**
     * Role.ids 去除重复值
     */
    Role.unique = function() {
        var result = [];
        for(var i = 0; i < Role.ids.length; i++)
        {
            if (Role.ids.indexOf(Role.ids[i]) == i) result.push(Role.ids[i]);
        }
        Role.ids = result;
    };

    /**
     * 提交选中角色
     */
    Role.setIdentities = function() {
        Role.unique();
        App.submitBefore();
        $.post('{$baseUrl}user/set_identities/{$userId}', { roles : Role.ids.sort().join(',') }, App.successHandler, 'text');
    };

    $(function(){
        window.App = parent.App;
        //设置表格对象
        var gridOptions = Role.getGrid().datagrid('options');
        gridOptions.onSelect = Role.onSelect;
        gridOptions.onUnselect = Role.onUnSelect;
        gridOptions.onSelectAll = Role.onSelectAll;
        gridOptions.onUnselectAll = Role.onUnSelectAll;
        gridOptions.onLoadSuccess = function(){
            //选中已有身份
            var existsRole = eval('({$roleUsers|json_encode})').rows;
            for(var i = 0; i<existsRole.length; i++) {
                Role.getGrid().datagrid('selectRecord', existsRole[i].roleId);
            }
        };
    });
    </script>
{/block}