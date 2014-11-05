{extends file="admin/public/layout.tpl"}
{block name="main"}
  <div id="all">
    <form id="form" action="" method="get">
      <div class="fr btnBox1 pl10">
        <input type="submit" class="btn_text" value="菜单搜索" />
      </div>
      <div class="textBox1 fr">
        <input type="text" class="w150" placeholder="请输入关键词" name="s" value="{$smarty.get.s|default:''}">
      </div>
      <div class="fl pb10">
        <div class="fl ">
          <select name="action" class="w150 fl vm">
            <option value="-1" selected="selected">批量操作</option>
            <option value="sequence" class="hide-if-no-js">排序</option>
            <option value="edit" class="hide-if-no-js">修改</option>
            <option value="delete" class="hide-if-no-js">删除</option>
          </select>
      <span class="pr10 btnBox2 fl vm pl10">
        <input type="submit" name="" class="btn_text" value="应用">
      </span>
        </div>
      </div>
      <br class="cb">
      <div class="tableBox5 w">
        {if count($menu_list)}
          <table class="w table">
            <thead>
            <tr>
              <th width="80"><input type="checkbox" class="checkAll" /></th>
              <th class="tl">排序号</th>
              <th class="tl">标题</th>
              <th class="tl">地址</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
              <th><input type="checkbox" class="checkAll" /></th>
              <th class="tl">排序号</th>
              <th class="tl">标题</th>
              <th class="tl">地址</th>
            </tr>
            </tfoot>
            <tbody id="the-list">
            {foreach $menu_list as $admin_menu}
              <tr>
                <th>
                  <input id="cb-select-5" type="checkbox" name="id[]" value="{$admin_menu.id}">
                  <div class="locked-indicator"></div>
                </th>
                <td>
                  <div class="textBox1 w30">
                    <input type="text" class="w30 tc" name="sequence[{$sort.id}]" value="{$admin_menu.sequence}" />
                  </div>
                </td>
                <td><input type="text" class="text1 w80" value="{$admin_menu.menu_name}" name="menu_name[{$admin_menu.id}]" /></td>
                <td>
                  <a href="{$base_url}{$admin_menu.menu_url}" class="a-black-n">{$base_url}{$admin_menu.menu_url}</a>
                </td>
              </tr>
            {/foreach}
            </tbody>
          </table>
        {else}
          <div class="tc">无相关数据</div>
        {/if}
      </div>
      <div class="pt10 pb5">
        <div class="fl">
          <select name="action" class="w150 fl vm">
            <option value="-1" selected="selected">批量操作</option>
            <option value="sequence" class="hide-if-no-js">排序</option>
            <option value="edit" class="hide-if-no-js">修改</option>
            <option value="delete" class="hide-if-no-js">删除</option>
          </select>
          <span class="pr10 btnBox2 fl vm pl10">
            <input type="submit" name="" class="btn_text" value="应用">
          </span>
        </div>
        <div class="pageBox1 fr">{$page}</div>
        <br class="cb">
      </div>
    </form>
  </div>
{/block}
{block name="head"}
  <script type="text/javascript">
  $(function(){
    $('.checkAll').on('ifChecked', function(event){
      $('input[type=checkbox]').iCheck('check');
    }).on('ifUnchecked', function(){
      $('input[type=checkbox]').iCheck('uncheck');
    });
    var form = $('#form');
    $('[name=action]').bind('change', function(){
      $('[name=action]').val($(this).val());
    })
    form.bind('submit', function(){
      var action = $('[name=action]').val()
        , url = '';
      if (action != -1) {
        switch (action) {
          case 'sequence' :
            url = '{$base_url}/admin/sequence_menu';
            break;
          case 'edit' :
            url = '{$base_url}/admin/edit_menu';
            break;
          case 'delete' :
            url = '{$base_url}/admin/delete_menu';
            break;
        }
        layer.load('请稍等...');
        $.post(url, form.serializeArray(), function(res){
          if (res.success) {
            layer.msg(res.message, 1, 1, function(){
              location.reload(true);
            });
          }
        },'json');
        return false;
      }

    });
  });
  </script>
{/block}
