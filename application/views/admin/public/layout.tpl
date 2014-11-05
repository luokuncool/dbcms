<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>{$page_title}</title>
{include file="admin/public/head.tpl"}
{block name="head"}{/block}
</head>
<body>
<div id="topBox">
  {include file="admin/public/top.tpl"}
</div>
<div id="sideBox">
  {include file="admin/public/side.tpl"}
</div>
<div id="mainBox">
  <div id="hyMainC" class="scrollBarBox1 jspScrollable">
    {block name="main"}{/block}
  </div>
</div>
<div class="skinBox">
  <div class="skinBox_wrap"></div>
  <div class="skinBox_top"></div>
  <div class="skinBox_top_wrap"></div>
  <div class="skinBox_side"></div>
</div>
</body>
</html>
