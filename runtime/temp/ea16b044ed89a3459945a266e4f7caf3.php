<?php /*a:1:{s:48:"D:\phpstudy_pro\project\auth\view\user\lock.html";i:1608969882;}*/ ?>

<script type="text/html" template>
  <link rel="stylesheet" href="{{ layui.setter.base }}style/login.css?v={{ layui.admin.v }}-1" media="all">
</script>


<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

  <div class="layadmin-user-login-main">
    <div class="layadmin-user-login-box layadmin-user-login-header">
      <h2><?php echo config('web.webname'); ?></h2>
      <p>欢迎回来,<?php echo htmlentities($userInfo['username']); ?></p>
    </div>
    <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
      <div class="layui-card-body" style="text-align: center;">
              <img src="https://q2.qlogo.cn/headimg_dl?bs=qq&dst_uin=<?php echo htmlentities($userInfo['qq']); ?>&spec=100" width="96" height="96" style="box-shadow: 0 0 0 4px rgba(0,0,0,.1);
    border-radius: 50%;margin-bottom:10PX;"> 
            <h4 style="margin-bottom:10PX;"><?php echo htmlentities($userInfo['username']); ?></h4>
            <a href="/console#/" class="layui-btn layui-btn-fluid">登陆</a>
          </div>
    </div>
  </div>
  
  <div class="layui-trans layadmin-user-login-footer">
    
    <p>© 2020 <a href="https://music.xingyaox.com/" target="_blank">music.xingyaox.com</a></p>
    <p>
      <span><a lay-href="/user/act/reg">注册</a></span>
      <span><a href="https://jq.qq.com/?_wv=1027&k=MeJBm3Ts" target="_blank">交流群</a></span>
      <span><a href="/" target="_blank">首页</a></span>
    </p>
  </div>
  
</div>
<script src="/static/gt.js"></script>
<script>
layui.use(['jquery','admin', 'form', 'user'], function(){
	var $ = layui.$
	,setter = layui.setter
	,admin = layui.admin
	,form = layui.form
	,router = layui.router()
	,search = router.search;

	form.render();
});
</script>