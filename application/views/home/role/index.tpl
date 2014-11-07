{extends file="../public/gird.tpl"}
{block name="row_list"}
	<tr width="100%">
		<th data-options="field:'id',align:'center',checkbox:true"></th>
		<th data-options="field:'name',sortable:true" width="18%">角色名</th>
		<th formatter="Role.formatStatus" data-options="field:'status',sortable:true" width="20%">状态</th>
		<th data-options="field:'remark',sortable:true" width="40%">描述</th>
		<th formatter='Role.formatOpt' data-options="field:'opt',align:'center'" width="20%">操作</th>
	</tr>
{/block}
{block name="script"}
	<script type="text/javascript">
	var Role = Object();
	Role.getGrid = function(){
		return $('#dataGrid');
	};
	/**
	 * 格式化菜单组名
	 * @param field
	 * @param row
	 * @returns { * }
	 */
	Role.formatGroupName = function(field, row) {
		var groupList = eval('({$groupList|json_encode})');
		return groupList[field] ? groupList[field] : '--';
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
	 * 编辑行
	 * @param index
	 */
	Role.editHandler = function(index) {
		var dataGrid = $('#dataGrid');
		dataGrid.datagrid('beginEdit', index);
	};

	/**
	 * 格式化操作栏
	 * @param field
	 * @param row
	 * @returns { string }
	 */
	Role.formatOpt = function(field, row) {
		var tools = '';
		tools += '<a href="javascript:App.addTab(\'编辑角色【'+row.name+'】\', \'{$baseUrl}role/edit/'+row.id+'\')">编辑</a>';
		tools += '&nbsp;&nbsp;<a href="javascript:App.addTab(\''+row.name+'授权\', \'{$baseUrl}role/set_rights/'+row.id+'\')">授权</a>';
		tools += '&nbsp;&nbsp;<a href="javascript:App.addTab(\''+row.name+'列表\', \'{$baseUrl}role/role_user/'+row.id+'\')">用户</a>';
		return tools;
	};

    /**
     * 禁用角色
	 */
	Role.disable = function(){
		var checkedRow = Role.getGrid().datagrid('getChecked'),
			roleId = '',
			successHandle = function(res) {
				$.messager.progress('close')
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
					Role.getGrid().datagrid('reload');
				} else {
					$.messager.alert('错误', res.message, 'error');
				}
			};
		for(var i=0; i<checkedRow.length; i++){
			roleId += (roleId === '') ? checkedRow[i].id : ','+checkedRow[i].id;
		}
		$.messager.progress();
		$.post('{$baseUrl}role/disable',  { roleId:roleId }, successHandle, 'json');
	};

	/**
	 * 启用角色
	 */
	Role.enable = function(){
		var checkedRow = Role.getGrid().datagrid('getChecked'),
			roleId = '',
			successHandle = function(res) {
				$.messager.progress('close')
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
					Role.getGrid().datagrid('reload');
				} else {
					$.messager.alert('错误', res.message, 'error');
				}
			};
		for(var i=0; i<checkedRow.length; i++){
			roleId += (roleId === '') ? checkedRow[i].id : ','+checkedRow[i].id;
		}
		$.messager.progress();
		$.post('{$baseUrl}role/enable',  { roleId:roleId }, successHandle, 'json');
	};

	$(function(){
		window.App = parent.App;
	});
	</script>
{/block}
{block name="search_block"}
	<table id="searchBlock" width="100%">
		<tr>
			<td width="70" align="right">角色名称：</td>
			<td width="70"><input class="easyui-textbox" data-options="width:200" type="text" name="name" /></td>
			<td width="100" align="right">状态：</td>
			<td width="70">
				<select class="easyui-combobox" data-options="editable:false" name="status" style="width: 200px;">
					<option value="">请选择</option>
					<option value="1">启用</option>
					<option value="0">禁用</option>
				</select>
			</td>
			<td><a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-search'" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">检索</a></td>
			<td align="right">
				<a class="easyui-linkbutton" data-options="iconCls:'icon-add'" href="javascript:App.addTab('添加节点', '{$baseUrl}role/create');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">添加</a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-remove'" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">删除</a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="Role.enable();" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">启用</a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="Role.disable()" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">禁用</a>
			</td>
		</tr>
	</table>
{/block}