{extends file="admin/public/layout.tpl"}
{block name="main"}
  <div id="all">
  <form method="post" id="form">
    <div class="tableBox5">
      <table class="w">
        <tr>
          <td width="100">
            <label for="admin_name">登录名称</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="text" name="login_name" class="w250" id="login_name" value="{$data.login_name}" />
            </div>
          </td>
        </tr>
        <tr>
          <td class="vt">
            <label for="password">登录密码</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="password" name="password" class="w250" id="password" />
            </div>
          </td>
        </tr>
        <tr>
          <td class="vt">
            <label for="real_name">真实姓名</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="text" name="real_name" class="w250" id="real_name" value="{$data.real_name}" />
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <label for="email">电子邮箱</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="text" name="email" class="w250" id="email" value="{$data.email}" />
            </div>
          </td>
        </tr>
        <tr>
          <td>使用状态</td>
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
          <td class="vt">
            <label for="group_id">所属分组</label>
          </td>
          <td>
            <select name="group_id">
              <option value="-1">未授权管理员</option>
              {foreach $group_list as $group}
                <option value="{$group.id}">{$group.group_name}</option>
              {/foreach}
            </select>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
            <div class="btnBox1">
              <input type="submit" class="btn_text" value="提交保存" />
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
