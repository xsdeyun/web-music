<?php /*a:1:{s:51:"D:\phpstudy_pro\project\auth\view\common\error.html";i:1603539712;}*/ ?>

<title><?php echo htmlentities($alert); ?></title>

<div class="layui-fluid" style="width: 300px;">
  <div class="layadmin-tips">
    <i class="layui-icon" style="font-size: 200px;" face>&#xe664;</i>
    
    <div class="layui-text" style="font-size: 20px;width: 100%;">
      <?php echo htmlentities($alert); ?><br><br><a href="<?php echo htmlentities($url); ?>" class="layui-btn layui-btn-primary">跳转页面</a>
    </div>
  </div>
</div>