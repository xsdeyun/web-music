<?php /*a:1:{s:48:"D:\phpstudy_pro\project\auth\view\user\find.html";i:1608972742;}*/ ?>

<script type="text/html" template>
  <link rel="stylesheet" href="{{ layui.setter.base }}style/login.css?v={{ layui.admin.v }}-1" media="all">
</script>


<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">
  <div class="layadmin-user-login-main">
    <div class="layadmin-user-login-box layadmin-user-login-header">
      <h2>找回密码</h2>
      <p>输入你注册时填写的邮箱地址,找回你的密码。</p>
    </div>
    <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
      <div class="layui-form-item">
        <label class="layadmin-user-login-icon layui-icon layui-icon-email" for="LAY-user-login-email"></label>
        <input type="text" name="mail" id="LAY-user-login-email" lay-verify="mail" placeholder="电子邮箱" class="layui-input">
      </div>
      <div class="layui-form-item">
        <div class="layui-row">
          <div class="layui-col-xs7">
            <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-code"></label>
            <input type="text" name="code" id="LAY-user-login-code" lay-verify="required" placeholder="验证码" class="layui-input">
          </div>
          <div class="layui-col-xs5">
            <div style="margin-left: 10px;">
              <button type="button" class="layui-btn layui-btn-primary layui-btn-fluid" id="LAY-user-reg-getcode">获取验证码</button>
            </div>
          </div>
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
        <input type="password" name="password" id="LAY-user-login-password" lay-verify="pass" placeholder="新密码" class="layui-input">
      </div>
      <div class="layui-form-item">
        <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-reg-submit">重置密码</button>
      </div>
    </div>
  </div>
  
  <div class="layui-trans layadmin-user-login-footer">
    
    <p>© 2020 <a href="https://music.xingyaox.com/" target="_blank">music.xingyaox.com</a></p>
    <p>
      <span><a lay-href="/user/act/login">登陆</a></span>
      <span><a href="https://jq.qq.com/?_wv=1027&k=MeJBm3Ts" target="_blank">交流群</a></span>
      <span><a href="/" target="_blank">首页</a></span>
    </p>
  </div>

</div>

<script>
layui.use(['admin', 'form', 'user'], function(){
  var $ = layui.$
  ,setter = layui.setter
  ,admin = layui.admin
  ,form = layui.form
  ,router = layui.router();

  form.render();
  
  //发送短信验证码
  admin.sendAuthCode({
    elem: '#LAY-user-reg-getcode'
    ,elemPhone: '#LAY-user-login-email'
    ,elemVercode: '#LAY-user-login-code'
    ,ajax: {
      url: '/LoginAjax/sendcode'
    }
  });

  //提交
  form.on('submit(LAY-user-reg-submit)', function(obj){
    var field = obj.field;
    
    
    //请求接口
    admin.req({
      url: 'LoginAjax/find' 
      ,data: field
      ,done: function(res){        
        layer.msg('重置成功', {
          offset: '15px'
          ,icon: 1
          ,time: 1000
        }, function(){
          location.hash = '/user/act/login'; //跳转到登入页
        });
      }
    });
    
    return false;
  });
});
</script>