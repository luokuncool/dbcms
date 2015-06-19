<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>AdminLTE 2 | Log in</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- Bootstrap 3.3.4 -->
<link href="/static/third/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<!-- Font Awesome Icons -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
      type="text/css"/>
<!-- Theme style -->
<link href="/static/admin/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
<!-- iCheck -->
<link href="/static/third/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css"/>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">登录系统</p>
        <form id="loginForm" action="" method="post">
            <div class="form-group has-feedback">
                <input type="text" name="uName" class="form-control" placeholder="请输入用户名"/>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="请输入登录密码"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> 自动登录
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <a href="#">忘记密码？</a><br>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<div id="alert" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">提示框</h4>
            </div>
            <div class="modal-body"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- jQuery 2.1.4 -->
<script src="/static/third/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="/static/third/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="/static/third/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script>
$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
    $('#loginForm').submit(function (e) {
        e.preventDefault();
        var postData = $(this).serializeArray(),
            self = this,
            fn = arguments.callee;
        $(this).unbind('submit', fn);
        $('[type=submit]').text('登录中...').attr('disabled', true);
        $.post('{{$baseURL}}/home/login', postData, function (res) {
            if (res.success) {
                location.reload();
                return;
            }
            $('#alert .modal-body').text(res.message);
            $('#alert').modal('show');
            $('[type=submit]').text('登录').removeAttr('disabled');
            $(self).bind('submit', fn);
        }, 'json');
    });
});
</script>
</body>
</html>