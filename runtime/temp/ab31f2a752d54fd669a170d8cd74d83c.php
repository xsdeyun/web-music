<?php /*a:1:{s:52:"D:\phpstudy_pro\project\auth\view\console\index.html";i:1603539712;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>控制面板</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/static/layui/css/layui.css?t=20181101-1" media="all">
  <script>
  /^http(s*):\/\//.test(location.href) || alert('请先部署到 localhost 下再访问');
  </script>
</head>
<body>
  <div id="LAY_app"></div>
  <script src="/static/layui/layui.js?t=20181101-1"></script>
  <script>
  layui.config({
    base: '/static/' //指定 layuiAdmin 项目路径
    ,version: '1.2.1'
  }).use('index', function(){
    var layer = layui.layer, admin = layui.admin;
    layer.ready(function(){
    });
  });
  </script>
</body>
</html>
