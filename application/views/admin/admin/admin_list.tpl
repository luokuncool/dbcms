{extends file="admin/public/layout.tpl"}
{block name="main"}
  <div id="all">
    <form id="form" action="" method="get">
      <div class="fr btnBox1 pl10">
        <input type="submit" class="btn_text" value="搜索分组" />
      </div>
      <div class="textBox1 fr">
        <input type="text" class="w150" placeholder="请输入关键词" name="s" value="{$smarty.get.s|default:''}">
      </div>
      <div class="fl pb10">
        <div class="fl ">
          <select name="action" class="w150 fl vm">
            <option value="-1" selected="selected">批量操作</option>
            <option value="delete" class="hide-if-no-js">删除</option>
          </select>
      <span class="pr10 btnBox2 fl vm pl10">
        <input type="submit" name="" class="btn_text" value="应用">
      </span>
        </div>
      </div>
      <br class="cb">
      <div class="tableBox5 w">
        {if count($admin_list)}
          <table class="w table">
            <thead>
            <tr>
              <th width="80"><input type="checkbox" class="checkAll" /></th>
              <th class="tl">登录名</th>
              <th class="tl">真实名字</th>
              <th class="tl">电子邮箱</th>
              <th class="tl">所属分组</th>
              <th class="tl">操作</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
              <th><input type="checkbox" class="checkAll" /></th>
              <th class="tl">登录名</th>
              <th class="tl">真实名字</th>
              <th class="tl">电子邮箱</th>
              <th class="tl">所属分组</th>
              <th class="tl">操作</th>
            </tr>
            </tfoot>
            <tbody id="the-list">
            {foreach $admin_list as $admin}
              <tr>
                <th>
                  <input id="cb-select-5" type="checkbox" name="id[]" value="{$admin.id}" {if $admin['id']=='1'}disabled{/if}/>
                  <div class="locked-indicator"></div>
                </th>
                <td>{$admin.login_name|default:'-'}</td>
                <td>{$admin.real_name|default:'-'}</td>
                <td>{$admin.email|default:'-'}</td>
                <td>
                  {if $admin['id']=='1'}
                    超级管理员
                  {else}
                    {$admin.group_name|default:'未授权'}
                  {/if}
                </td>
                <td>
                  {if $admin['id']=='1'}
                    <span class="f-red">×</span>
                  {else}
                    <a class="a-black-n" href="{$base_url}/admin/edit_admin/{$admin.id}?redirect={$active_url}">编辑</a>
                  {/if}
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
    $('.checkAll').on('ifChecked', function(){
      $('input[type=checkbox]').not('[disabled]').iCheck('check');
    }).on('ifUnchecked', function(){
      $('input[type=checkbox]').not('[disabled]').iCheck('uncheck');
    });
    var form = $('#form');
    $('[name=action]').bind('change', function(){
      $('[name=action]').val($(this).val());
    });
    form.bind('submit', function(){
      var action = $('[name=action]').val()
        , url = '';
      if (action != -1) {
        switch (action) {
          case 'delete' :
            url = '{$base_url}/admin/delete_admin';
            break;
        }
        layer.load('请稍等...');
        $.post(url, form.serializeArray(), function(res){
          if (res.success) {
            layer.msg(res.message, 1, 1, function(){
              location.reload(true);
            });
          } else {
            layer.msg(res.message, 1, 3, function(){
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
