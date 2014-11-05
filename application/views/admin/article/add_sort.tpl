{extends file="admin/public/layout.tpl"}
{block name="main"}
  <div id="all">
  <form method="post" id="form">
    <div class="tableBox5">
      <table class="w">
        <tr>
          <td width="100">
            <label for="sort_name">分类名称</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="text" name="sort_name" class="w250" id="sort_name" value="{$data.sort_name}" />
            </div>
          </td>
        </tr>
        <tr>
          <td>上级分类：</td>
          <td id="content">
            <select name="parent_id" class="w260" {if in_array($data['id'], $system_article_sort)}disabled{/if}>
              <option value="0">作为顶级分类</option>
              {foreach $sort_list as $sort}
                <option value="{$sort.id}" {if $sort['id'] == $data['parent_id']}selected{/if}>{$sort.sort_name}</option>
              {/foreach}
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <label for="alias">分类别名</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="text" name="alias" class="w250" id="alias" value="{$data.alias}" />
            </div>
          </td>
        </tr>
        <tr>
          <td class="vt">
            <label for="intro">分类描述</label>
          </td>
          <td>
            <textarea class="textarea1 w250 h100" name="intro">{$data.intro}</textarea>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <div class="btnBox1">
              <input type="submit" class="btn_text" value="保存分类" />
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
  });
  </script>
{/block}
