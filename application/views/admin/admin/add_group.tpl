{extends file="admin/public/layout.tpl"}
{block name="main"}
  <div id="all">
  <form method="post" id="form">
    <div class="tableBox5">
      <table class="w">
        <tr>
          <td width="100">
            <label for="group_name">分组名称</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="text" name="group_name" class="w250" id="group_name" value="{$data.group_name}" />
            </div>
          </td>
        </tr>
        <tr id="purviewTr">
          <td class="vt">
            <label for="alias">
              分组权限
              <input type="checkbox" id="checkAll" />
            </label>
          </td>
          <td id="purviewTd">
            {foreach $purview_group_list as $purview_group}
              <div class="purview_group">
                <div class="group_item">
                  <label>
                    <input type="checkbox" />
                    {$purview_group.group_name}
                  </label>
                </div>
                {foreach $purview_group['router_list'] as $purview}
                  <label class="pr10">
                    <input type="checkbox" name="purview_key[]" value="{$purview.id}" {if in_array($purview['id'], unserialize($data['purview_key']))}checked{/if}/>
                    {$purview.purview_name}
                  </label>
                {/foreach}
              </div>
            {/foreach}
          </td>
        </tr>
        <tr>
          <td class="vt">
            <label for="intro">分组描述</label>
          </td>
          <td>
            <textarea class="textarea1 w250 h100" name="intro">{$data.intro}</textarea>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <div class="btnBox1">
              <input type="submit" class="btn_text" value="保存分组" />
            </div>
          </td>
        </tr>
      </table>
    </div>
  </form>
  </div>
{/block}
{block name="head"}
  <script type="text/javascript">
  $(function(){
    var form = $('#form');
    form.ajaxSubmit({
      errorCallback : function(res){
        var field = form.find(res.selector);
        if (field.length) {
          field.focus();
          layer.tips(res.message, field, {
            style: ['background-color:#f00; color:#fff', '#f00'],
            maxWidth:185,
            time: 1,
            guide: 0
          });
        } else {
          layer.msg(res.message);
        }
      },
      successCallback : function(res) {
        layer.msg(res.message, 1, 1, function(){
          if (res.redirect){
            location.href = res.redirect;
          } else {
            location.reload(true);
          }
        });
      }
    });
    //权限选择
    var purviewTr = $('#purviewTr')
      , checkAll = purviewTr.find('#checkAll')
      , purviewTd = $('#purviewTd')
      , purviewGroup = purviewTd.find('.group_item');
    checkAll.on('ifChecked', function(){
      purviewTd.find('input[type=checkbox]').iCheck('check');
    }).on('ifUnchecked', function(){
      purviewTd.find('input[type=checkbox]').iCheck('uncheck');
    });
    purviewGroup.on('ifChecked', function(){
      $(this).parents('.purview_group').find('input[type=checkbox]').iCheck('check');
    }).on('ifUnchecked', function(){
      $(this).parents('.purview_group').find('input[type=checkbox]').iCheck('uncheck');
    });
  });
  </script>
{/block}
