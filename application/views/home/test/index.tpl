{extends file="../public/gird.tpl"}
{block name="searchBlock"}
	<table id="searchBlock" width="100%">
		<tr>
			<td width="70" align="right">账号：</td>
			<td width="70"><input class="easyui-textbox" data-options="width:200" type="text" name="uName" /></td>
			<td width="100" align="right">title：</td>
			<td width="70" colspan="2"><input class="easyui-textbox" data-options="width:200" type="text" name="name" /></td>

		</tr>
		<tr>
			<td width="100" align="right">状态：</td>
			<td width="70">
				<select class="easyui-combobox" data-options="editable:false,width:200,height:24" name="status">
					<option value="">请选择</option>
					<option value="1">启用</option>
					<option value="0">禁用</option>
				</select>
			</td>
			<td>&nbsp;</td>
			<td><a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-search',height:24" style="padding-right: 5px; border-radius: 2px 2px 2px">检索</a></td>
            <td align="right">
                <a class="easyui-linkbutton" data-options="iconCls:'icon-add'" href="javascript:parent.App.addTab('添加用户', '/user/create');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">添加</a>
                <a class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onclick="App.remove('{$baseUrl}test/remove')" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">删除</a>
                <a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick=" App.enable('{$baseUrl}test/enable');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">启用</a>
                <a class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="App.disable('{$baseUrl}test/disable');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">禁用</a>
            </td>
		</tr>
	</table>
{/block}
{block name="rowList"}
	<tr width="100%">
		<th data-options="field:'id',align:'center',checkbox:true"></th>
        <th data-options="field:'title',align:'center',sortable:true" width="15%">Title</th>
        <th data-options="field:'body',align:'center',sortable:true" width="55%">Body</th>
		<th formatter="App.formatStatus" data-options="field:'status',align:'center',sortable:true" width="10%">状态</th>
		<th formatter="User.formatOpt" data-options="field:'opt',align:'left'" width="18%">&nbsp;&nbsp;操作</th>
	</tr>
{/block}
{block name="script"}
	<script type="text/javascript">
	var User = Object();
    App

	/**
	 * 格式化菜单组名
	 * @param field
	 * @param row
	 * @returns { * }
	 */
	User.formatGroupName = function(field, row) {
		var groupList = eval('({$groupList|json_encode})');
		return groupList[field] ? groupList[field] : '--';
	};

	/**
	 * 格式化操作栏
	 * @param field
	 * @param row
	 * @returns { string }
	 */
	User.formatOpt = function(field, row) {
		var tools = '';
		tools += '&nbsp;&nbsp;<a href="javascript:App.addTab(\'编辑节点【'+row.id+'】\', \'{$baseUrl}user/edit/'+row.id+'/'+row.pId+'/'+row.level+'\')" onclick="">编辑</a>';
		tools += '&nbsp;&nbsp;<a href="javascript:App.addTab(\'设置身份【'+row.name+'】\', \'{$baseUrl}user/set_role/'+row.id+'\')" onclick="">设置身份</a>';
		return tools;
	};
	</script>
{/block}