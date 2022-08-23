<?php /*a:1:{s:53:"D:\phpstudy_pro\project\auth\view\admin\userinfo.html";i:1603539712;}*/ ?>
<div class="layui-card layadmin-header">
  <div class="layui-breadcrumb" lay-filter="breadcrumb">
    <a lay-href="">控制面板</a>
    <a><cite>基本资料</cite></a>
  </div>
</div>

<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md6">
    <div class="layui-card">
        <div class="layui-card-header">账户信息<span class="layui-badge layuiadmin-badge" style="background-color:transparent"> <?php if($userInfo['token'] != ''): ?><a href="/Admin/QqLoginSet" class="layui-btn layui-btn-xs layui-btn-normal">更换QQ登录</a><?php else: ?><a href="/Admin/QqLoginSet" class="layui-btn layui-btn-xs layui-btn-normal">绑定QQ登录</a><?php endif; ?> </span></div>
		<script type="text/html" template lay-url="/AdminAjax/userInfo" >
        <div class="layui-card-body">
                        <div class="layui-card-header">用户名：{{ d.data.username }}</div>
            <div class="layui-card-header">QQ：{{ d.data.qq }}</div>
			 <div class="layui-card-header">邮箱：{{ d.data.mail }}</div>
                        <div class="layui-card-header">播放器额度：{{ d.data.pie }}</div>
            <div class="layui-card-header">歌单合计：<?php echo htmlentities($sheets); ?>个</div>
                        <div class="layui-card-header">注册时间：{{ d.data.regtime }}</div>
            <div class="layui-card-header">最近登录：<?php echo date('h:i:s',$userInfo['time']); ?></div>
            <div class="layui-card-header">创建IP：{{ d.data.regip }}</div>
            <div class="layui-card-header">登录地址：{{ d.data.city }}</div>
            <div class="layui-card-header">账户类型：{{ d.data.lv }}                </div>
        </div>
		</script>
    </div>
</div>
<div class="layui-col-md6">
    <div class="layui-card">
        <div class="layui-card-header">修改密码</div>
        <div class="layui-card-body">
            <div class="pass-form">
                <div class="layui-form layui-form-pane">
                    <form class="layui-form form-container" method="post">
                        <div class="layui-form-item">
                            <label class="layui-form-label">旧密码</label>
                            <div class="layui-input-inline">
                                <input type="password" id="outpass" required="" lay-verify="required" placeholder="请输入之前的密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">新密码</label>
                            <div class="layui-input-inline">
                                <input type="password" id="password" required="" lay-verify="required" placeholder="请输入新的密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">确认密码</label>
                            <div class="layui-input-inline">
                                <input type="password" id="chkPwd" required="" lay-verify="required" placeholder="请再输入一次密码" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" id="submit" type="button" lay-submit="" lay-filter="updPwd">立即修改</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
  </div>
</div>

<script>
    layui.use(['admin', 'form','colorpicker'], function(){
        var element = layui.element,
            $ = layui.jquery,
            form = layui.form;
        layer = layui.layer;
        element.render('collapse');
        form.on('submit(updPwd)', function (data) {
            var outpass = $("#outpass").val();
            var password = $("#password").val();
            var chkPwd = $("#chkPwd").val();

            if (password != chkPwd) {
                layer.msg("两次密码输入不一致！");
                return false;
            }
            layer.confirm('确定要修改新密码为：' + password, {
                btn: ['确定', '取消'] //按钮
            }, function (index) {
                var index = layer.load(3);
                $.post("/AdminAjax/password", {outpass: outpass, password: password}, function (data) {
                    layer.close(index);
                    layer.open({
                        content: data.message ? data.message : '操作失败！',
                        title: '修改成功',
                        btn: ['确认'],
                        yes: function (index, layero) {
                            location.reload();
                        },
                        cancel: function () {
                            location.reload();
                        }
                    });
                });
            }, function () {
            });
            return false;
        });

    });
</script>