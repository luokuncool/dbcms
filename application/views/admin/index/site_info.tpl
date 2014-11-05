{extends file="../public/layout.tpl"}
{block name="main"}
  <div id="all">
    <div class="tipBox1 mb10">
      <p>● 为了系统的安全，账号不用时，请记得安全退出哦</p></div>
    <form action="" id="form" method="post">
      <div class="tableBox5 mt15">
        <table class="w">
          <tr class="first">
            <td width="120">站点名称</td>
            <td><input type="text" name="site_name" value="{$site_info.site_name}" class="text1 w300" /><span class="note">* 站点名称，将显示在网页title，网站底部等处</span></td>
          </tr>
          <tr>
            <td>站点URL</td>
            <td><input type="text" name="site_url" value="{$site_info.site_url}" class="text1 w300" /><span class="note">* 站点URL，将显示在网站底部等需要向客户提供网站URL处</span></td>
          </tr>
          <tr>
            <td>公司名称</td>
            <td><input type="text" name="company" value="{$site_info.company}" class="text1 w300" /></td>
          </tr>
          <tr>
            <td>公司地址</td>
            <td><input type="text" name="address" value="{$site_info.address}" class="text1 w400" /></td>
          </tr>
          <tr>
            <td>邮政编码</td>
            <td><input type="text" name="zipcode" maxlength="6" value="{$site_info.zipcode}" class="text1 w150" /></td>
          </tr>
          <tr>
            <td>固定电话</td>
            <td><input type="text" name="telephone" value="{$site_info.telephone}" class="text1 w150" /></td>
          </tr>
          <tr>
            <td>移动电话</td>
            <td><input type="text" name="cellphone" value="{$site_info.cellphone}" class="text1 w150" /></td>
          </tr>
          <tr>
            <td>电子邮箱</td>
            <td><input type="text" name="email" value="{$site_info.email}" class="text1 w150" /></td>
          </tr>
          <tr>
            <td>网站备案信息</td>
            <td><input type="text" name="icp" value="{$site_info.icp}" class="text1 w150" /><span class="note">* 在这里填入网站的备案信息（备案号），没有备案信息请留空</span></td>
          </tr>
          <tr>
            <td class="vt">第三方代码</td>
            <td><textarea name="third_code" class="textarea1 w400 h50">{$site_info.third_code}</textarea><span class="note">* 第三方代码，如第三方客服代码，统计代码等</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
              <div class="btnBox2 fl">
                <input type="submit" value="保存" class="btn_text" />
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
      successCallback : function(res) {
        layer.msg(res.message, 1, 1);
      },
      errorCallback : function(res){
        var field = form.find(res.selector);
        if (field.length) {
          field.focus();
          layer.tips(res.message, field, {
            style: ['background-color:#f00; color:#fff', '#f00'],
            maxWidth:185,
            time: 2,
            guide: 0
          });
        } else {
          layer.msg(res.message);
        }
      }
    });
  });
  </script>
{/block}