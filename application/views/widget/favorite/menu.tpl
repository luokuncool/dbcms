<div style="width:25%; float: left;">
	<div style="padding: 3px">
		<div class="easyui-panel" title="常用菜单" data-options="collapsible:true,fit:true" style="padding: 5px;">
			{foreach $nodeList as $favorateMenu}
				<a class="easyui-linkbutton" href="javascript:App.addTab('{$favorateMenu.name}', '{$baseUrl}{$favorateMenu.code}');" style="padding:2px 15px; margin:3px 3px">{$favorateMenu.name}</a>
			{/foreach}
		</div>
	</div>
</div>
