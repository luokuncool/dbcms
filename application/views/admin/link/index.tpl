{extends file="admin/public/layout.tpl"}
{block name="main"}
  <div id="all">
    <form id="form" action="" method="get">
      <div class="fr btnBox1 pl10">
        <input type="submit" class="btn_text" value="链接搜索" />
      </div>
      <div class="textBox1 fr">
        <input type="text" class="w150" placeholder="请输入关键词" name="s" value="{$smarty.get.s|default:''}">
      </div>
      <div class="fr pr10">
        <select  class="fl pl10" name="sort_id" onchange="document.getElementById('form').submit()">
          <option value="0" {if $smarty.get.sort_id|intval==0}selected{/if}>分类筛选</option>
          <option value="-1" {if $smarty.get.sort_id|intval==-1}selected{/if}>未分类</option>
          {foreach $sort_list as $sort}
            <option value="{$sort.id}" {if $smarty.get.sort_id|intval==$sort['id']}selected{/if}>{$sort.sort_name}</option>
          {/foreach}
        </select>
      </div>
      <div class="fl pb10">
        <div class="fl ">
          <select name="action" class="w150 fl vm">
            <option value="-1" selected="selected">批量操作</option>
            <option value="delete">删除</option>
          </select>
          <span class="pr10 btnBox2 fl vm pl10">
            <input type="submit" name="" class="btn_text" value="应用">
          </span>
        </div>
      </div>
      <br class="cb">
      <div class="tableBox5">
        {if count($list)}
          <table class="w table">
            <thead>
            <tr>
              <th><input type="checkbox" class="checkAll" /></th>
              <th class="tl">标题</th>
              <th class="tl">链接地址</th>
              <th class="tl">分类目录</th>
              <th class="tl">状态</th>
              <th class="tl">日期</th>
              <th class="tl">操作</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
              <th><input type="checkbox" class="checkAll" /></th>
              <th class="tl">标题</th>
              <th class="tl">链接地址</th>
              <th class="tl">分类目录</th>
              <th class="tl">状态</th>
              <th class="tl">日期</th>
              <th class="tl">操作</th>
            </tr>
            </tfoot>
            <tbody id="the-list">
            {foreach $list as $link}
              <tr>
                <th>
                  <input id="cb-select-5" type="checkbox" name="id[]" value="{$link.id}" />
                  <div class="locked-indicator"></div>
                </th>
                <td>
                  <a class="a-black-n" href="{$base_url}/admin/link/edit_link/{$link.id}?redirect={$active_url}">{$link.link_name}</a>
                </td>
                <td>{$link.link_url}</td>
                <td>{$link.sort_name}</td>
                <td>{if $link['status']=='1'}发布{else}禁用{/if}</td>
                <td>{$link.add_time|date_format:'Y-m-d H:i:s'}</td>
                <td>
                  <a class="a-black-n" href="{$base_url}/admin/link/edit_link/{$link.id}?redirect={$active_url}">编辑</a>
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
        <div class="fl pb10">
          <div class="fl ">
            <select name="action" class="w150 fl vm">
              <option value="-1" selected="selected">批量操作</option>
              <option value="delete">删除</option>
            </select>
          <span class="pr10 btnBox2 fl vm pl10">
            <input type="submit" name="" class="btn_text" value="应用">
          </span>
          </div>
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
    });
    form.bind('submit', function(){
      var action = $('[name=action]').val()
        , url = '';
      if (action != -1) {
        switch (action) {
          case 'delete' :
            url = '{$base_url}/admin/link/delete_link';
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
