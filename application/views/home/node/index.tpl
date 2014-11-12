{extends file="../public/gird.tpl"}
{*数据列表*}
{block name="row_list"}
    <tr width="100%">
        <th data-options="field:'id',align:'center',checkbox:true"></th>
        <th data-options="field:'code',align:'left',sortable:true,editor:'text'" width="20%">节点代码</th>
        <th data-options="field:'name',align:'center',sortable:true,editor:'text'" width="10%">显示名</th>
        <th data-options="field:'pNodeName',align:'center',sortable:false" width="10%">所属模块</th>
        <th formatter="Node.formatGroupName" data-options="field:'groupId',align:'center',sortable:false" width="15%">所属菜单组</th>
        <th formatter="Node.formatLevel" data-options="field:'level',align:'center',sortable:true" width="5%">节点类型</th>
        <th formatter="Node.formatType" data-options="field:'type',align:'center',sortable:true" width="5%">是否菜单</th>
        <th data-options="field:'sort',align:'center',sortable:true,editor:'numberspinner'" width="5%">序号</th>
        <th formatter="Node.formatStatus" data-options="field:'status',align:'center',sortable:true" width="5%">状态</th>
        <th formatter="Node.formatOpt" data-options="field:'opt',align:'left'" width="23.5%">&nbsp;&nbsp;操作</th>
    </tr>
{/block}
{* 搜索栏 *}
{block name="search_block"}
    <table id="searchBlock" width="100%">
        <tr>
            <td width="70" align="right">节点代码：</td>
            <td width="70"><input class="easyui-textbox" data-options="width:200" type="text" name="code" /></td>
            <td width="100" align="right">显示名：</td>
            <td width="70" colspan="2"><input class="easyui-textbox" data-options="width:200" type="text" name="name" /></td>
        </tr>
        <tr>
            <td width="100" align="right">状态：</td>
            <td width="70">
                <select class="easyui-combobox" data-options="editable:false,width:200,height:24" name="status" style="width: 200px;">
                    <option value="">请选择</option>
                    <option value="1">启用</option>
                    <option value="0">禁用</option>
                </select>
            </td>
            <td>&nbsp;</td>
            <td><a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-search',height:24" style="padding-right: 5px; border-radius: 2px 2px 2px;">检索</a></td>
            <td align="right">
                <a class="easyui-linkbutton" data-options="iconCls:'icon-add'" href="javascript:parent.App.addTab('添加节点', '{$baseUrl}node/create');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">添加模块</a>
                <a class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onclick="Node.remove();" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">删除</a>
                <a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="Node.enable();" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">启用</a>
                <a class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="Node.disable();" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">禁用</a>
            </td>
        </tr>
    </table>
{/block}
{block name="script"}
    <script type="text/javascript">
    var Node = Object();
	/**
	 *  获取表格对象
	 */
	Node.getGrid = function(){
		return $('#dataGrid');
	};

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

    /**
     * 格式化操作栏
	 * @param field
     * @param row
     * @returns { string }
     */
    Node.formatOpt = function(field, row) {
        var tools = '';
		tools += '&nbsp;&nbsp;<a href="javascript:App.addTab(\'编辑节点【'+row.id+'】\', \'{$baseUrl}node/edit/'+row.id+'/'+row.pId+'/'+row.level+'\')" onclick="">编辑</a>';
		row.level == 1 && (tools += '&nbsp;&nbsp;<a href="javascript:App.addTab(\'添加操作【'+row.name+'】\', \'{$baseUrl}node/create_method/'+row.id+'\')" onclick="">添加操作</a>');
        return tools;
    };

	/**
	 * 禁用
	 */
	Node.disable = function(){
		$.messager.progress();
		$.post('{$baseUrl}node/disable',  { ids:Node.getIds() }, Node.successHandle, 'json');
	};

	/**
	 * 启用
	 */
	Node.enable = function(){
		$.messager.progress();
		$.post('{$baseUrl}node/enable',  { ids:Node.getIds() }, Node.successHandle, 'json');
	};

    /**
     * 删除
	 */
	Node.remove = function() {
		$.messager.confirm('确认框', '确定要删除所选？', function(ok){
			if (ok) {
				$.messager.progress();
				$.post('{$baseUrl}node/remove',  { ids:Node.getIds() }, Node.successHandle, 'json');
			}
		});
	};

    /**
     * 获取选中行
	 * @returns { string }
     */
	Node.getIds = function(){
		var checkedRow = Node.getGrid().datagrid('getChecked'),
			ids = '';
		for(var i=0; i<checkedRow.length; i++){
			ids += (ids === '') ? checkedRow[i].id : ','+checkedRow[i].id;
		}
		return ids;
	};

    /**
     * Ajax请求回调函数
	 * @param res
     */
	Node.successHandle = function(res) {
		$.messager.progress('close');
		if (res.success) {
			$.messager.show({
				title:'提示',
				msg:res.message,
				showType:'fade',
				timeout:1500,
				style:{
					right:'',
					bottom:''
				}
			});
			Node.getGrid().datagrid('reload');
		} else {
			$.messager.alert('错误', res.message, 'error');
		}
	};

	$(function(){
		window.App = parent.App;
	});
	</script>
{/block}