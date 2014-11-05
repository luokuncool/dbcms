{extends file="admin/public/layout.tpl"}
{block name="main"}
  <div id="all">
  <form method="post" id="form">
    <div class="tableBox5">
      <table class="w">
        <tr>
          <td width="100">
            <label for="article_name">文章标题</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="text" name="article_name" class="w250" id="article_name" value="{$data.article_name}" />
            </div>
          </td>
        </tr>
        <tr>
          <td class="vt">文章分类</td>
          <td id="content">
            <select name="sort_id" class="w260">
              {foreach $sort_list as $sort}
                <option value="{$sort.id}" {if $sort['id']==$data['sort_id']}selected{/if}>{$sort.sort_name}</option>
              {/foreach}
            </select>
          </td>
        </tr>
        <tr>
          <td>文章状态</td>
          <td>
            <label>
              <input type="radio" name="status" value="1" {if $data['status']=='1'}checked{/if} />
              启用
            </label>
            <label class="pl10">
              <input type="radio" name="status" value="0" {if $data['status']=='0'}checked{/if} />
              禁用
            </label>
          </td>
        </tr>
        <tr>
          <td class="vt">文章详情</td>
          <td id="content">
            <textarea name="content" class="w h300" editor_field>{$data.content}</textarea>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <div class="btnBox1">
              <input type="submit" class="btn_text" value="保存文章" />
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
