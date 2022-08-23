<?php /*a:1:{s:51:"D:\phpstudy_pro\project\auth\view\admin\webset.html";i:1603539712;}*/ ?>
<title>网站设置</title>

<div class="layui-card layadmin-header">
  <div class="layui-breadcrumb" lay-filter="breadcrumb">
    <a lay-href="">主页</a>
    <a><cite>网站管理</cite></a>
    <a><cite>网站设置</cite></a>
  </div>
</div>
  
<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md12">
      <div class="layui-card">
        <div class="layui-card-header">网站设置</div>
        <div class="layui-card-body" pad15>
          
          <div class="layui-form" wid100 lay-filter="">
            <div class="layui-form-item">
              <label class="layui-form-label">网站名称</label>
              <div class="layui-input-block">
                <input type="text" name="webname" id="webname" value="<?php echo config('web.webname'); ?>" class="layui-input">
              </div>
            </div>
            
            <div class="layui-form-item layui-form-text">
              <label class="layui-form-label">首页标题</label>
              <div class="layui-input-block">
                <textarea name="title" id="title" class="layui-textarea"><?php echo config('web.title'); ?></textarea>
              </div>
            </div>
            <div class="layui-form-item layui-form-text">
              <label class="layui-form-label">META关键词</label>
              <div class="layui-input-block">
                <textarea name="keywords" id="keywords" class="layui-textarea" ><?php echo config('web.keywords'); ?></textarea>
              </div>
            </div>
            <div class="layui-form-item layui-form-text">
              <label class="layui-form-label">META描述</label>
              <div class="layui-input-block">
                <textarea name="description" id="descript" class="layui-textarea"><?php echo config('web.description'); ?></textarea>
              </div>
            </div>
			<div class="layui-form-item">
              <label class="layui-form-label">注册赠送配额</label>
              <div class="layui-input-block">
                <input type="text" name="regpie" id="regpie" value="<?php echo config('web.regpie'); ?>" class="layui-input">
              </div>
            </div>
			<div class="layui-form-item">
              <label class="layui-form-label">单配额价格</label>
              <div class="layui-input-block">
                <input type="text" name="piemoney" id="piemoney" value="<?php echo config('web.piemoney'); ?>" class="layui-input">
              </div>
            </div>
			<div class="layui-form-item">
              <label class="layui-form-label">付费版价格</label>
              <div class="layui-input-block">
                <input type="text" name="vipmoney" id="vipmoney" value="<?php echo config('web.vipmoney'); ?>" class="layui-input">
              </div>
            </div>
			<div class="layui-form-item">
              <label class="layui-form-label">易支付接口</label>
              <div class="layui-input-block">
				<select name="epay_url" id="epay_url" lay-verify="">
					<option value="https://pay.aiyqq.cn/" <?php if( config('web.epay_url') == 'https://pay.aiyqq.cn/' ) echo  'selected = "selected"' ; ?>>玖凌聚合支付</option>
					<option value="https://pay.ruomiu.com/" <?php if( config('web.epay_url') == 'https://pay.ruomiu.com/' ) echo  'selected = "selected"' ; ?>>若缪易支付</option>
				</select>
              </div>
            </div>
			<div class="layui-form-item">
              <label class="layui-form-label">商户ID</label>
              <div class="layui-input-block">
                <input type="text" name="epay_id" id="epay_id" value="<?php echo config('web.epay_id'); ?>" class="layui-input">
              </div>
            </div>
			<div class="layui-form-item">
              <label class="layui-form-label">商户KEY</label>
              <div class="layui-input-block">
                <input type="text" name="epay_key" id="epay_key" value="<?php echo config('web.epay_key'); ?>" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="set_website">确认保存</button>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>

<script>
layui.use(['admin', 'form', 'user'], function(){
  var $ = layui.$
  ,setter = layui.setter
  ,admin = layui.admin
  ,form = layui.form
  ,router = layui.router()
  ,search = router.search;

  form.render();

  //提交
  form.on('submit(set_website)', function(obj){
  
    //请求登入接口
	 $.ajax({
		url:"/AdminAjax/config",
		data:obj.field,
		type:"Post",
		dataType:"json",
		success:function(data){
			if(data.code==0){
				layer.msg(data.message);
			}
			
		}
	});
    
  });
  
});
</script>