
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$page_title}</title>
{include file="../public/head.tpl"}
</head>

<body>
<div id="loginTop">
  <div class="loginTop_wrap">
    <h1 class="loginLogo"><a href="{$base_path}/admin" title=""><img src="{$base_path}/themes/admin/images/Blue/logo2.png" alt="" /></a></h1>
    <div class="loginNav">
      <a href="/" target="_blank" class="a-grey74-n mr10" title="点击访问前台首页">前台首页</a>
      <a href="http://www.boren.cn" target="_blank" class="a-grey74-n" title="点击获取技术支持">技术支持</a>
    </div>
  </div>
</div>
<div id="loginMain" style="background:url({$base_path}/themes/admin/images/theme1_bg.png) repeat-x left top #67B4E0;">
  <div class="loginMain_wrap" style="background:url({$base_path}/themes/admin/images/theme1.png) no-repeat left top;">

    <div class="loginBox">
      <div class="loginBox_title">管理员登录</div>
      <div class="loginForm">
        <form action="" id="loginForm" method="post">
          <div class="loginBox_input loginBox_ipt1">
            <div class="loginBox_icon1 icon1User_16"></div>
            <input type="text" name="login_name" autocomplete="off" value="" placeholder="用户名" />
          </div>
          <div class="loginBox_input loginBox_ipt1">
            <div class="loginBox_icon1 icon1Pass_16"></div>
            <input type="password" name="password" value="" placeholder="密码" />
          </div>
          <div class="loginBox_input loginBox_ipt2 fl">
            <div class="loginBox_icon1 icon1Pass_16"></div>
            <input type="text" name="code" autocomplete="off" value="" placeholder="验证码" />
          </div>
          <img src="{$base_path}/code.php" class="fl ml5" style="cursor:pointer" onclick="this.src='{$base_path}/code.php?'+Math.random()" />
          <div class="cb"></div>
          <input type="submit" class="btnLogin" value="登&nbsp;&nbsp;&nbsp;录" />
          <div class="loginBottomBox">
            <div class="loginBottomBox_item">
              <div class="icon1Hint_14 loginBottomBox_icon1"></div><span>经常修改登录密码，可降低账号被盗用风险</span>
            </div>
            <div class="loginBottomBox_item mt5">
              <div class="icon1Hint_14 loginBottomBox_icon1"></div><span>账号不用时，请安全退出</span>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div id="loginEnd">
  <div class="loginEnd_wrap">
    <div class="copy pl50 pt20">成都伯仁网络科技有限公司 &copy 2014 All rights reserved. 版权所有</div>
  </div>
</div>
<script type="text/javascript">
$(function() {
  var loginForm = $('#loginForm');
  loginForm.ajaxSubmit({
    errorCallback : function(res){
      var field = loginForm.find(res.selector);
      if (field.length) {
        field.focus();
        layer.tips(res.message, field, {
          style: ['background-color:#f00; color:#fff', '#f00'],
          maxWidth:185,
          time: 1,
          guide: 2
        });
      } else {
        layer.msg(res.message);
      }
    },
    successCallback : function(res) {
      layer.msg(res.message, 1, 1, function(){
        location.reload(true);
      });
    }
  });
});
</script>
</body>
</html>