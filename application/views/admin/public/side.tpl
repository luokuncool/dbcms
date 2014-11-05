<div id="hyNavTree" class="scrollBox navTreeBox preventDoubleClick scrollBarBox1">
  <ul>
    {foreach $side_menu_list as $side_menu_group}
      <li class="nTB_one">
        <div class="nTB_oneP cSTD cp">
          <b class="symbolFold iconBg iconBox00"></b>
          <b class="symbolUnfold iconBg iconBox01"></b>
          <span class="nTB_oneP_text">{if $side_menu_group['group_name']==''}其他{else}{$side_menu_group.group_name}{/if}</span>
        </div>
        <div class="nTB_oneC">
          <ul>
            {foreach $side_menu_group['router_list'] as $router}
              <li class="nTB_two">
                <div class="nTB_twoP cSTD {if $current_router['id']==$router['id']}current{/if}">
                  <a href="{$base_url}/{$router.directory}{$router.class}/{$router.method}?redirect={$active_url}" title="">{$router.menu_name}</a>
                  <a href="{$base_url}/admin/add_menu/{$router.id}" class="treeIcon ajaxGet" title="添加到顶部菜单"><span class="iconBg iconBox13"></span></a>
                </div>
              </li>
            {/foreach}
          </ul>
        </div>
      </li>
    {/foreach}
  </ul>
</div>