{extends file="../public/grid.tpl"}
{*数据列表*}
{block name="rowList"}
	<tr width="100%">
		<th data-options="field:'id',align:'center',checkbox:true"></th>
		<th data-options="field:'code',align:'left',sortable:true,editor:'text'" width="20%">节点代码</th>
		<th data-options="field:'name',align:'center',sortable:true,editor:'text'" width="10%">显示名</th>
		<th data-options="field:'pNodeName',align:'center',sortable:false" width="10%">所属模块</th>
		<th formatter="Node.formatGroupName" data-options="field:'groupId',align:'center',sortable:false" width="15%">所属菜单组</th>
		<th formatter="Node.formatLevel" data-options="field:'level',align:'center',sortable:true" width="5%">节点类型</th>
		<th formatter="Node.formatType" data-options="field:'type',align:'center',sortable:true" width="15%">是否菜单</th>
		<th data-options="field:'sort',align:'center',sortable:true,editor:'numberspinner'" width="10%">序号</th>
		<th formatter="App.formatStatus" data-options="field:'status',align:'center',sortable:true" width="13.5%">状态</th>
	</tr>
{/block}
{* 搜索栏 *}
{block name="searchBlock"}
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
				<a class="easyui-linkbutton" data-options="iconCls:'icon-save'" onclick="App.setRights();" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">提交保存</a>
			</td>
		</tr>
	</table>
{/block}
{block name="script"}
	<script type="text/javascript">
	!function(App, parentWin){
		App.setRights = function() {
			App.processing();
			$.post('{$baseUrl}role/set_rights/{$roleId}', { nodeIds : App.getIds() }, App.successHandler, 'text');
		};
		window.App = App;
	}(App, window.parent);

	$(function(){
		//设置表格对象
		var gridOptions = App.getGrid().datagrid('options');
		gridOptions.onLoadSuccess = function(){
			//选中已有用户
			var existsNodeIds = [{$nodeIds}];
			for(var i = 0; i<existsNodeIds.length; i++) {
				App.getGrid().datagrid('selectRecord', existsNodeIds[i]);
			}
		};
	});
	</script>
{/block}