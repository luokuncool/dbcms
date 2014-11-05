{extends file="admin/public/layout.tpl"}
{block name="main"}
  <div id="all">
  <form method="post" id="form">
    <div class="tableBox5">
      <table class="w">
        <tr>
          <td width="100">
            <label for="old_password">旧密码</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="password" name="old_password" class="w250" id="old_password" />
            </div>
          </td>
        </tr>
        <tr>
          <td class="vt">
            <label for="password">新密码</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="password" name="password" class="w250" id="password" />
            </div>
          </td>
        </tr>
        <tr>
          <td class="vt">
            <label for="re_password">再次输入</label>
          </td>
          <td>
            <div class="textBox1 w250">
              <input type="password" name="re_password" class="w250" id="re_password" />
            </div>
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
