<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>AdminLTE 2 | Dashboard</title>
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
{{block name="stylesheets"}}{{/block}}
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">
    {{include file="../includes/header.tpl"}}
    <!-- Left side column. contains the logo and sidebar -->
    {{include file="../includes/left_side.tpl"}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            {{block name="location"}}
                <h1>
                    系统首页
                    <small>仪表盘</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{$baseURL}}"><i class="fa fa-home"></i>系统首页</a></li>
                    <li class="active">仪表盘</li>
                </ol>
            {{/block}}
        </section>
        <!-- Main content -->
        <section class="content">
            {{block name="content"}}{{/block}}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{include file="../includes/footer.tpl"}}

    <!-- Control Sidebar -->
    {{include file="../includes/right_side.tpl"}}
</div>
<!-- ./wrapper -->
<!-- jQuery 2.1.4 -->
<script src="/static/third/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="/static/third/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
{{block name="scripts"}}{{/block}}
<!-- AdminLTE App -->
<script src="/static/admin/js/app.min.js" type="text/javascript"></script>
</body>
</html>
