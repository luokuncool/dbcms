<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ExtJS CodeIgnitor</title>
<link type="text/css" rel="stylesheet" href="{$basePath}/client/ext/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="{$basePath}/client/app/css/desktop.css" />
<script type="text/javascript" src="{$basePath}/client/ext/ext-all.js"></script>
<script type="text/javascript" src="{$basePath}/client/ext/locale/ext-lang-zh_CN.js"></script>
<script type="text/javascript">
Ext.Loader.setConfig({ enabled:true, disableCaching : false });
Ext.Loader.setPath({
	'Ext.ux.desktop': '/client/app/js',
	'MyDesktop' : '/client/app'
});
Ext.require('MyDesktop.App');
var myDesktopApp;
Ext.onReady(function () {
	myDesktopApp = new MyDesktop.App();
});
</script>
</head>
<body>
</body>
</html>