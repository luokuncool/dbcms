{{extends file="../public/grid.tpl"}}
{{*数据列表*}}
{{block name="rowList"}}
    <tr width="100%">
        <th data-options="field:'id',align:'center',checkbox:true"></th>
        <th data-options="field:'code',align:'left',sortable:true,editor:'text'" width="20%">节点代码</th>
        <th data-options="field:'name',align:'center',sortable:true,editor:'text'" width="10%">显示名</th>
        <th data-options="field:'pNodeName',align:'center',sortable:false" width="10%">所属模块</th>
        <th formatter="Node.formatGroupName" data-options="field:'groupId',align:'center',sortable:false" width="15%">
            所属菜单组
        </th>
        <th formatter="Node.formatLevel" data-options="field:'level',align:'center',sortable:true" width="5%">节点类型</th>
        <th formatter="Node.formatType" data-options="field:'type',align:'center',sortable:true" width="5%">是否菜单</th>
        <th data-options="field:'sort',align:'center',sortable:true,editor:'numberspinner'" width="5%">序号</th>
        <th formatter="Node.formatStatus" data-options="field:'status',align:'center',sortable:true" width="5%">状态</th>
        <th formatter="Node.formatOpt" data-options="field:'opt',align:'left'" width="23.5%">&nbsp;&nbsp;操作</th>
    </tr>
{{/block}}
{{* 搜索栏 *}}
{{block name="searchBlock"}}
    <table id="searchBlock" width="100%">
        <tr>
            <td width="70" align="right">节点代码：</td>
            <td width="70"><input class="easyui-textbox" data-options="width:200" type="text" name="code"/></td>
            <td width="100" align="right">显示名：</td>
            <td width="70" colspan="2"><input class="easyui-textbox" data-options="width:200" type="text" name="name"/>
            </td>
        </tr>
        <tr>
            <td width="100" align="right">状态：</td>
            <td width="70">
                <select class="easyui-combobox" data-options="editable:false,width:200,height:24" name="status"
                        style="width: 200px;">
                    <option value="">请选择</option>
                    <option value="1">启用</option>
                    <option value="0">禁用</option>
                </select>
            </td>
            <td>&nbsp;</td>
            <td><a class="easyui-linkbutton" id="searchButton" data-options="height:24"><i
                        class="iconfont icon-sousuo"></i> 检索</a></td>
            <td align="right">
                <a class="easyui-linkbutton" href="javascript:parent.Public.addTab('添加模块', '{{$baseUrl}}node/create');"><i
                        class="iconfont icon-jia"></i> 添加模块</a>
                <a class="easyui-linkbutton" onclick="Public.remove('{{$baseUrl}}node/remove')"><i class="iconfont icon-shanchu"></i> 删除</a>
                <a class="easyui-linkbutton" onclick="Public.enable('{{$baseUrl}}node/enable')"><i class="iconfont icon-zhengque"></i> 启用</a>
                <a class="easyui-linkbutton" onclick="Public.disable('{{$baseUrl}}node/disable')"><i class="iconfont icon-jinzhi1"></i> 禁用</a>
            </td>
        </tr>
    </table>
{{/block}}
{{block name="script"}}
    <script type="text/javascript">
    var Node = Object();

    /**
     * 格式化菜单组名
     * @param field
     * @param row
     * @returns {{ * }}
     */
    Node.formatGroupName = function (field, row) {
        var groupList = eval('({{$groupList|json_encode}})');
        return groupList[field] ? groupList[field] : '--';
    };

    /**
     * 格式化状态
     * @param field
     * @param row
     * @returns {{ string }}
     */
    Node.formatStatus = function (field, row) {
        return field == 1 ? '<font color="green">启用</font>' : '<font color="red">禁用</font>'
    };

    /**
     * 格式化操作栏
     * @param field
     * @param row
     * @returns {{ string }}
     */
    Node.formatOpt = function (field, row) {
        var tools = '';
        tools += '&nbsp;&nbsp;<a href="javascript:Public.addTab(\'编辑节点【' + row.id + '】\', \'{{$baseUrl}}node/edit/' + row.id + '/' + row.pId + '/' + row.level + '\')" onclick="">编辑</a>';
        row.level == 1 && (tools += '&nbsp;&nbsp;<a href="javascript:Public.addTab(\'添加操作【' + row.name + '】\', \'{{$baseUrl}}node/create_method/' + row.id + '\')" onclick="">添加操作</a>');
        return tools;
    };
    </script>
{{/block}}