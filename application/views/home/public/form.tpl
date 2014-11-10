{extends file="../public/layout.tpl"}
{block name="body"}
	<form id="postForm" action="" method="post">
		<div class="easyui-panel" data-options="reigin:'center', collapsible:true, border: false" style="padding:10px;">
			<table>
				{block name="form"}{/block}
				<tr>
					<td class="&nbsp;"></td>
					<td>
						<a class="easyui-linkbutton" id="submitForm" data-options="iconCls:'icon-save'" href="javascript:;" style="padding:0 5px; border-radius: 2px 2px 2px;">提交保存</a>
					</td>
				</tr>
			</table>
		</div>
	</form>
{/block}
{block name="head"}
	<style type="text/css">
		table td { padding: 4px 0; }
	</style>
	<script type="text/javascript">
	$(function(){
		var submitForm = $('#submitForm'),
			postForm   = $('#postForm'),
            App = App ? App : parent.App;
		submitForm.click(function(){
			postForm.form('submit', {
				onSubmit : App.submitBefore,
				success : App.successHandler
			});
		});
	});
	</script>
{/block}