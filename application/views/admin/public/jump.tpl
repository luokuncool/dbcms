<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>{{$systemName}}</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- Bootstrap 3.3.4 -->
<link href="/static/third/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<!-- FontAwesome 4.3.0 -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
      type="text/css"/>
<!-- Ionicons 2.0.0 -->
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
<!-- Theme style -->
<link href="/static/admin/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link href="/static/admin/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
</head>
<body class="login-page">
<div class="login-box">
    <div class="alert alert-success alert-dismissible" role="alert">
        <p>{{$message}}<a href="{{$jumpURL}}">页面将于<b>3</b>秒后跳转</a></p>
    </div>
</div>
<!-- ./wrapper -->
<!-- jQuery 2.1.4 -->
<script src="/static/third/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="/static/third/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
    setInterval(function () {
        var cur = $('b').text();
        cur --;
        if (cur == 0) {
            location.href = '{{$jumpURL}}';
        } else {
            $('b').text(cur);
        }
    }, 1000);
});
</script>
</body>
</html>
