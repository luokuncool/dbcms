{extends file="../public/grid.tpl"}
{block name="searchBlock"}
	<table id="searchBlock" width="100%">
		<tr>
			<td width="70" align="right">日期区间：</td>
			<td width="200">
				<input class="easyui-datebox" id="startDate" data-options="width:95,onSelect:App.onSelectStartDate" type="text" name="startDate" value="{$defaultStartDate}" /> -
				<input class="easyui-datebox" id="endDate" data-options="width:95,onSelect:App.onSelectEndDate" type="text" name="endDate" value="{$defaultEndDate}" />
			</td>
			<td width="100" align="right">状态：</td>
			<td colspan="2">
				<select class="easyui-combobox" data-options="editable:false,width:100,height:24" name="status">
					<option value="">请选择</option>
					<option value="1">启用</option>
					<option value="0">禁用</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right">标&nbsp;&nbsp;&nbsp;&nbsp;题：</td>
			<td><input type="text" class="easyui-textbox" data-options="width:200" name="title" /></td>
			<td>&nbsp;</td>
			<td><a class="easyui-linkbutton" id="searchButton" data-options="iconCls:'icon-search',height:24" style="padding-right: 5px; border-radius: 2px 2px 2px">检索</a></td>
			<td align="right">
				<a class="easyui-linkbutton" data-options="iconCls:'icon-remove'" onclick="App.remove('{$baseUrl}test/remove')" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">删除</a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick=" App.enable('{$baseUrl}test/enable');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">启用</a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="App.disable('{$baseUrl}test/disable');" style="padding:0 5px 0 0; border-radius: 2px 2px 2px;">禁用</a>
			</td>
		</tr>
	</table>
{/block}
{block name="rowList"}
	<tr width="100%">
		<th data-options="field:'id',align:'center',checkbox:true">ID</th>
		<th data-options="field:'title',align:'center',sortable:true" width="15%">标题</th>
		<th data-options="field:'body',align:'center',sortable:false" width="63%">内容</th>
		<th formatter="App.formatStatus" data-options="field:'status',align:'center',sortable:false" width="10%">状态</th>
		<th formatter="App.formatDate" data-options="field:'createTime',align:'center',sortable:true" width="10%">创建日期</th>
	</tr>
{/block}
{block name="script"}
	<script type="text/javascript">
	!function(App, parentWin){

		/**
		 * 获取开始日期对象
		 */
		App.getStartDate = function() {
			return $('#startDate');
		};

		/**
		 * 获取结束日期对象
		 */
		App.getEndDate = function(){
			return $('#endDate');
		};

        /**
         * 格式化日期
		 * @param time 创建日期
         * @returns { string }
         */
		App.formatDate = function(time) {
			var date      = new Date(parseInt(time)*1000)
				,  fullYear = date.getFullYear()
				,  month   = date.getMonth()+1
				,  day       = date.getDate();
			if (month < 10) month = ('0'+month);
			if (day < 10) day = ('0'+day);
			return [fullYear, month, day].join('-');
		};

        /**
         * 开始日期选中
		 * @param startDate
         */
		App.onSelectStartDate = function(startDate) {
			var year = startDate.getFullYear()
				, month = (startDate.getMonth()+1)
				, day = startDate.getDate();
			month >= 9 && year ++;
			if ( month > 9 ) {
				month = month - 9;
			} else if (month < 9) {
				month = month + 3;
			}
			App.getEndDate().datebox('setValue', [ year, month,  day ].join('-'));
		};

        /**
         * 结束日期选中
		 * @param endDate
         */
		App.onSelectEndDate = function(endDate) {
			var year = endDate.getFullYear()
				, month = (endDate.getMonth()+1)
				, day = endDate.getDate();
			month <= 3 && year --;
			if ( month < 3 ) {
				month = month + 9;
			} else if ( month == 3  ) {
				month = 12;
			} else {
				month = month - 3;
			}
			App.getStartDate().datebox('setValue', [ year, month,  day ].join('-'));
		};

	}(parent.App, parent);
	</script>
{/block}