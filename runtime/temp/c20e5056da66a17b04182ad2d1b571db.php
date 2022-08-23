<?php /*a:1:{s:55:"D:\phpstudy_pro\project\auth\view\admin\users\edit.html";i:1603539712;}*/ ?>
<link rel="stylesheet" href="/static/css/global.css?v=20191008" media="all">

<div class="layui-card layadmin-header">
  <div class="layui-breadcrumb" lay-filter="breadcrumb">
    <a lay-href="">主页</a>
    <a><cite>网站管理</cite></a>
    <a><cite>用户管理</cite></a>
  </div>
</div>
  
<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md6">
      <div class="layui-card">
        <div class="layui-card-header">用户信息</div>
        <div class="layui-card-body" pad15>
          <div class="layui-form" >
            <div class="layui-form-item">
              <label class="layui-form-label">用户名</label>
              <div class="layui-input-block">
                <input type="text" name="username" id="username" value="<?php echo htmlentities($user['username']); ?>" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">QQ号码</label>
              <div class="layui-input-block">
                <input type="text" name="qq" id="qq" value="<?php echo htmlentities($user['qq']); ?>" class="layui-input">
              </div>
            </div>
			<div class="layui-form-item">
              <label class="layui-form-label">邮箱</label>
              <div class="layui-input-block">
                <input type="email" name="mail" id="mail" value="<?php echo htmlentities($user['mail']); ?>" class="layui-input">
              </div>
            </div>
			<div class="layui-form-item">
              <label class="layui-form-label">用户类型</label>
			  <div class="layui-input-inline">
					<select name="power">
						<option value="0" <?php if( $user['power'] == '0' ) echo  'selected = "selected"' ; ?>>管理员</option>
						<option value="1" <?php if( $user['power'] == '1' ) echo  'selected = "selected"' ; ?>>付费版</option>
						<option value="2" <?php if( $user['power'] == '2' ) echo  'selected = "selected"' ; ?>>免费版</option>
					</select>
				</div>
            </div>
			<div class="layui-form-item">
              <label class="layui-form-label">配额</label>
              <div class="layui-input-block">
                <input type="text" name="pie" id="pie" value="<?php echo htmlentities($user['pie']); ?>" class="layui-input">
              </div>
            </div>
			<div class="layui-form-item">
              <label class="layui-form-label">密码</label>
              <div class="layui-input-block">
                <input type="text" name="password" id="password" value="" placeholder="留空则不修改密码" class="layui-input">
              </div>
            </div>
            <input type="hidden" name="uid" id="uid" value="<?php echo htmlentities($user['uid']); ?>">
            <div class="layui-form-item">
              <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="edit">确认保存</button>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
	<div class="layui-col-md6">
            <div class="larry-personal layui-collapse">
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">用户播放器</h2>
                    <div class="layui-colla-content layui-show larry-personal-body clearfix" style="padding: 0;">
                        <div class="block__list_words">
                            <ul>
                              <?php if(is_array($player) || $player instanceof \think\Collection || $player instanceof \think\Paginator): $i = 0; $__LIST__ = $player;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                              <li>
                                  <span class="drag-handle"><img src="/static/images/type/sdtj.png" width="16px" height="16px">  <?php echo htmlentities($v['name']); ?> </span>
                                    <div style="float:right">
                                        <a lay-href="/player/id/<?php echo htmlentities($v['id']); ?>" class="layui-btn layui-btn-xs">管理</a>
                                    </div>
                              </li>
                              <?php endforeach; endif; else: echo "" ;endif; ?>
                         </ul>
                        </div>
                    </div>
                </div>
            </div>
			<div class="larry-personal layui-collapse">
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">用户歌单</h2>
                    <div class="layui-colla-content layui-show larry-personal-body clearfix" style="padding: 0;">
                        <div class="block__list_words">
                            <ul>
							<?php if(is_array($sheet) || $sheet instanceof \think\Collection || $sheet instanceof \think\Paginator): $i = 0; $__LIST__ = $sheet;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
							<li>
                                    <span class="drag-handle"><img src="/static/images/type/sdtj.png" width="16px" height="16px">  <?php echo htmlentities($v['name']); ?> </span>
                                        <div style="float:right">
                                            <a lay-href="/songSheet/id/<?php echo htmlentities($v['id']); ?>" class="layui-btn layui-btn-xs">管理</a>
                                        </div>
                                    </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                         </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </div>
</div>

<script>
layui.use(['admin', 'form', 'user'], function(){
  $ = layui.jquery;
  var element = layui.element,
	colorpicker = layui.colorpicker,
	form = layui.form;
element.render();
element.render('collapse');
form.render('radio');
form.render('select');
form.render('checkbox');

  form.render();

  //提交
  form.on('submit(edit)', function(obj){
  
    //请求接口
	 $.ajax({
		url:"/UserAjax/edit",
		data:obj.field,
		type:"Post",
		dataType:"json",
		success:function(data){
			if(data.code==0){
				layer.msg(data.message);
			}else{
        layer.msg(data.message);
      }
			
		}
	});
    
  });
  
});
</script>