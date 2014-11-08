<div style="width:25%; float: left;">
	<div style="padding: 3px">
		<div class="easyui-panel" title="设置主题" data-options="collapsible:true,fit:true" style="padding: 5px;">
			<form id="postForm" action="{$baseUrl}widget/form/theme" method="post">
				<div class="easyui-panel" data-options="reigin:'center', collapsible:true, border: false" style="padding:10px;">
					<table>
						<tr>
							<td align="right">选择主题：</td>
							<td>
								<select class="easyui-combobox" name="my_theme"  data-options="editable:true,width:150">
									{foreach $theme_list as $theme}
										<option value="{$theme}" {if $theme eq $my_theme}selected{/if}>{$theme}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td class="&nbsp;"></td>
							<td>
								<a class="easyui-linkbutton" id="submitForm" data-options="iconCls:'icon-save'" href="javascript:;" style="padding:0 5px; border-radius: 2px 2px 2px;">提交保存</a>
							</td>
						</tr>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<style type="text/css">
	table td { padding: 4px 0; }
</style>
<script type="text/javascript">
$(function(){
	var submitForm = $('#submitForm'),
		postForm   = $('#postForm'),
		closeSelfHandler = function() {
			var  mainTab = App.getMainTab(),
				selectedTab = mainTab.tabs('getSelected'),
				selectedIndex = mainTab.tabs('getTabIndex', selectedTab);
			mainTab.tabs('close', selectedIndex);
			mainTab.tabs('select',selectedIndex-1);
		},
		successHandler = function(res){
			$.messager.progress('close');
			try {
				res = eval('('+res+')');
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
					res.closeSelf && setTimeout(closeSelfHandler, 1400);
					res.reloadMain && setTimeout(function(){
						parent.window.location.reload(true);
					}, 1500);
					res.reload &&location.reload(true);
				} else {
					$.messager.alert('错误', res.message, 'error');
				}

			} catch (e) {
				$.messager.alert('错误', '程序出错', 'error');
			}
		};
	submitForm.click(function(){
		postForm.form('submit', {
			onSubmit : function(){
				$.messager.progress({
					title : '提示',
					text : '数据处理中，请稍后....',
					interval : 1000
				});
			},
			success : function(data) {
				successHandler(data);
			}
		});
	});
});
</script>

