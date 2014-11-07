{extends file="../public/gird.tpl"}
{block name="search_block"}
    <table id="searchBlock" width="100%">
        <tr>
            <td width="70" align="right">节点代码：</td>
            <td width="70"><input class="easyui-textbox" data-options="width:200" type="text" name="code" /></td>
            <td width="100" align="right">显示名：</td>
            <td width="70"><input class="easyui-textbox" data-options="width:200" type="text" name="name" /></td>
            <td align="right">
                <a class="easyui-linkbutton" data-options="iconCls:'icon-add'" href="javascript:parent.App.addTab('添加节点', '/node/create');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">添加</a>
                <a class="easyui-linkbutton" data-options="iconCls:'icon-remove'" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">删除</a>
            </td>
        </tr>
        <tr>
            <td width="100" align="right">状态：</td>
            <td width="70">
                <select class="easyui-combobox" data-options="editable:false" name="status" style="width: 200px;">
                    <option value="">请选择</option>
                    <option value="1">启用</option>
                    <option value="0">禁用</option>
                </select>
            </td>
            <td>&nbsp;</td>
            <td colspan="2"><a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-search'" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">检索</a></td>

        </tr>
    </table>
{/block}
{block name="row_list"}
    <tr width="100%">
        <th data-options="field:'id',align:'center',checkbox:true"></th>
        <th data-options="field:'code',align:'left',sortable:true,editor:'text'" width="15%">节点代码</th>
        <th data-options="field:'name',align:'center',sortable:true,editor:'text'" width="10%">显示名</th>
        <th data-options="field:'pnodename',align:'center',sortable:false" width="10%">所属模块</th>
        <th formatter="Node.formatGroupName" data-options="field:'groupId',align:'center',sortable:false" width="10%">所属菜单组</th>
        <th formatter="Node.formatLevel" data-options="field:'level',align:'center',sortable:true" width="10%">节点类型</th>
        <th formatter="Node.formatType" data-options="field:'type',align:'center',sortable:true" width="10%">是否菜单</th>
        <th data-options="field:'sort',align:'center',sortable:true,editor:'numberspinner'" width="10%">序号</th>
        <th formatter="Node.formatStatus" data-options="field:'status',align:'center',sortable:true" width="10%">状态</th>
        <th formatter="Node.formatOpt" data-options="field:'opt',align:'center'" width="13.5%">操作</th>
    </tr>
{/block}
{block name="script"}
    <script type="text/javascript">
    var Node = Object();
    /**
     * 格式化菜单组名
     * @param field
     * @param row
     * @returns { * }
     */
    Node.formatGroupName = function(field, row) {
        var groupList = eval('({$groupList|json_encode})');
        return groupList[field] ? groupList[field] : '--';
    };
    /**
     * 格式化状态
     * @param field
     * @param row
     * @returns { string }
     */
    Node.formatStatus = function(field, row) {
        return field == 1 ? '<font color="green">启用</font>' : '<font color="red">禁用</font>'
    };
    /**
     * 编辑行
     * @param index
     */
    Node.editHandler = function(index) {
        var dataGrid = $('#dataGrid');
        dataGrid.datagrid('beginEdit', index);
    };

    Node.formatOpt = function(field, row) {
        var tools = '';
        tools += '<a href="javascript:parent.App.addTab(\'编辑节点【'+row.id+'】\', \'/node/edit/'+row.id+'\')" onclick="">编辑</a>';
        return tools;
    }
    </script>
{/block}