<div style="padding: 10px;">
	<div class="easyui-panel" title="Favorites Menu" data-options="collapsible:true,fit:true" style="padding: 15px;">
		{foreach $nodeList as $favorateMenu}
			<a class="easyui-linkbutton" href="javascript:App.addTab('{$favorateMenu.name}', '{$baseUrl}{$favorateMenu.code}');" style="padding:5px 15px; margin:3px 3px">{$favorateMenu.name}</a>
		{/foreach}
	</div>
</div>