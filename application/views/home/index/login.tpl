{{extends file="../public/layout.tpl"}}
{{block name="body"}}
	<div data-options="region:'center',fit:true">
		<div class="easyui-window" title="{{$systemName}}"
			 data-options="closable:false,maximizable:false,collapsible:false,minimizable:false,draggable:false,resizable:false,width:400,height:260"
			 style="padding:16px 31px;">
			<form id="loginForm" method="post">
				<table>
					<tr>
						<td style="position: relative; z-index: 1;">
							<input class="easyui-textbox iconfont" type="text" name="uName"
								   data-options="width:320,height:36" style="padding-left: 30px;"/>
							<i class="iconfont icon-yonghu"
							   style="color:#000000; position: absolute; left: 4px; top:16px; font-size: 22px; z-index: 20"></i>
						</td>
					</tr>
					<tr>
						<td style="position: relative; z-index: 1;">
							<input class="easyui-textbox" type="password" name="password"
								   data-options="width:320,height:36" style="padding-left: 30px;"/>
							<i class="iconfont icon-suoding"
							   style="color:#000000; position: absolute; left: 4px; top:16px; font-size: 22px; z-index: 20"></i>
						</td>
					</tr>
					<tr>
						<td align="center">
							<a class="easyui-linkbutton" id="submitForm" href="javascript:;"
							   style="padding:7px 99px">
                                <span style="font-size: 22px"><i class="iconfont icon-zhengque"></i>登录系统</span>
							</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
{{/block}}
{{block name="head"}}
	<script type="text/javascript">
	$(function () {
		var submitForm = $('#submitForm');
		submitForm.click(function () {
			Public.processing();
			$.post('{{$baseURL}}/login', $('#loginForm').serializeArray(), function (res) {
				Public.processed();
				if (res.success) {
					Public.showMessage(res.message);
					setTimeout(function () {
						location.reload(true);
					}, 1500);
				} else {
					Public.alert(res.message);
				}
			}, 'json');
		});
	});
	</script>
	<style type="text/css">
		table td {
			padding: 10px 0;
		}
	</style>
{{/block}}
