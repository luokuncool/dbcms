{extends file="admin/public/layout.tpl"}
{block name="main"}
<div id="all">
  <div class="tipBox1 mb10">
    <p>● 图片类型的链接请注意上传图片</p>
    <p>● 链接地址需要带有http://</p>
  </div>
  <form method="post" id="form">
    <div class="tableBox5">
      <table class="w">
        <tr>
          <td width="100">
            <label for="link_name">链接标题</label>
          </td>
          <td>
            <input type="text" name="link_name" id="link_name" class="text1 w250" value="{$data.link_name}" />
          </td>
        </tr>
        <tr>
          <td>
            <label for="link_url">链接地址</label>
          </td>
          <td>
            <input type="text" name="link_url" id="link_url" class="text1 w250" value="{$data.link_url}" />
          </td>
        </tr>
        <tr>
          <td>链接图片</td>
          <td>
            <input type="text" name="link_pic" value="{$data.link_pic}" class="text1 w250 fl" />
            <div class="btnBox1 fl ml5" upload_pic="link_pic">
              <input type="button" value="上传图片" class="btn_text">
            </div>
          </td>
        </tr>
        <tr>
          <td class="vt">链接分类</td>
          <td id="content">
            <select name="sort_id" class="w260">
              {foreach $sort_list as $sort}
              <option value="{$sort.id}" {if $sort['id']==$data['sort_id']}selected{/if}>{$sort.sort_name}</option>
              {/foreach}
            </select>
          </td>
        </tr>
        <tr>
          <td>链接状态</td>
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
          <td class="vt">链接介绍</td>
          <td>
            <textarea name="content" class="textarea1 w250 h100">{$data.content}</textarea>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <div class="btnBox1">
              <input type="submit" class="btn_text" value="保存链接" />
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
