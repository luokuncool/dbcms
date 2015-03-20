{extends file="../public/grid.tpl"}
{block name="searchBlock"}
	<table id="searchBlock" width="100%">
		<tr>
			<td width="70" align="right">创建日期：</td>
			<td width="200">
				<input class="easyui-datebox" id="startDate" data-options="editable:false,width:97,onSelect:Public.onSelectStartDate" type="text" name="startDate" value="{$defaultStartDate}" />
                <input class="easyui-datebox" id="endDate" data-options="editable:false,width:97,onSelect:Public.onSelectEndDate" type="text" name="endDate" value="{$defaultEndDate}" />
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
			<td>
				<a class="easyui-linkbutton" id="searchButton" data-options="height:24"><i class="iconfont icon-sousuo"></i> 检索</a>
			</td>
			<td align="right">
				<a class="easyui-linkbutton" onclick="Public.remove('{$baseUrl}test/remove')"><i class="iconfont icon-shanchu"></i> 删除</a>
				<a class="easyui-linkbutton" onclick=" Public.enable('{$baseUrl}test/enable');"><i class="iconfont icon-zhengque"></i> 启用</a>
				<a class="easyui-linkbutton" onclick="Public.disable('{$baseUrl}test/disable');"><i class="iconfont icon-jinzhi1"></i> 禁用</a>
			</td>
		</tr>
	</table>
{/block}
{block name="rowList"}
	<tr width="100%">
		<th data-options="field:'id',align:'center',checkbox:true">ID</th>
		<th data-options="field:'title',align:'center',sortable:true" width="15%">标题</th>
		<th data-options="field:'body',align:'center',sortable:false" width="63%">内容</th>
		<th formatter="Public.formatStatus" data-options="field:'status',align:'center',sortable:false" width="10%">状态</th>
		<th formatter="Public.formatDate" data-options="field:'createTime',align:'center',sortable:true" width="10%">创建日期</th>
	</tr>
{/block}
{block name="script"}
	<script type="text/javascript">
	!function(Public, parentWin){

		/**
		 * 获取开始日期对象
		 */
		Public.getStartDate = function() {
			return $('#startDate');
		};

		/**
		 * 获取结束日期对象
		 */
		Public.getEndDate = function(){
			return $('#endDate');
		};

        /**
         * 格式化日期
		 * @param time 创建日期
         * @returns { string }
         */
		Public.formatDate = function(time) {
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
		Public.onSelectStartDate = function(startDate) {
			var year = startDate.getFullYear()
				, month = (startDate.getMonth()+1)
				, day = startDate.getDate();
			month >= 9 && year ++;
			if ( month > 9 ) {
				month = month - 9;
			} else if (month < 9) {
				month = month + 3;
			}
			Public.getEndDate().datebox('setValue', [ year, month,  day ].join('-'));
		};

        /**
         * 结束日期选中
		 * @param endDate
         */
		Public.onSelectEndDate = function(endDate) {
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
			Public.getStartDate().datebox('setValue', [ year, month,  day ].join('-'));
		};

	}(parent.Public, parent);
	</script>
{/block}
