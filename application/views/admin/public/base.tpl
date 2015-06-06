<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{$systemName}}</title>
    <link rel="stylesheet" type="text/css" href="{{$basePath}}/static/third/jquery-easy-ui/themes/{{$myTheme}}/easyui.css">
    <link rel="stylesheet" type="text/css" href="{{$basePath}}/static/third/jquery-easy-ui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="{{$basePath}}/static/third/jquery-easy-ui/themes/icon.css">
    <script type="text/javascript" src="{{$basePath}}/static/third/jquery.js"></script>
    <script type="text/javascript" src="{{$basePath}}/static/third/jquery-easy-ui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="{{$basePath}}/static/third/jquery-easy-ui/locale/easyui-lang-zh_CN.js"></script>
    <link rel="stylesheet" type="text/css" href="{{$basePath}}/static/third/jquery-easy-ui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="{{$basePath}}/static/home/css/home.css">
    <link rel="stylesheet" type="text/css" href="{{$basePath}}/static/third/iconfont/iconfont.css">
    <script type="text/javascript">Public = parent.Public;</script>
{{block name="head"}}{{/block}}
</head>
<body class="easyui-layout" style="overflow-y:auto;">
{{block name="body"}}{{/block}}
</body>
</html>
