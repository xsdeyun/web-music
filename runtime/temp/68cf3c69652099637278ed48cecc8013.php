<?php /*a:1:{s:55:"D:\phpstudy_pro\project\auth\view\admin\links\list.html";i:1599399737;}*/ ?>
  <div class="layui-card layadmin-header">
    <div class="layui-breadcrumb" lay-filter="breadcrumb">
      <a lay-href="">控制面板</a>
      <a><cite>广告列表</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
	  <div class="layui-col-md6">
      <div class="layui-card">
        <div class="layui-card-header">添加广告</div>
        <div class="layui-card-body">
          <div class="layui-form layui-form-pane">
			<div class="layui-form-item">
				<div class="layui-form layui-form-pane">
					<blockquote class="layui-elem-quote">请输入完整链接,包括<b style="color:#f00">“http:”</b>和<b style="color:#f00">“//”</b>等特殊符号,发布广告后会出现在侧边导航栏中,ICO图标将自动获取。<br>
					链接超过150位请使用短链接工具缩短。
					</blockquote>
					<label class="layui-form-label">广告链接</label>
					<div class="layui-input-block">
						<input type="text" id="url" placeholder="请输入完整广告链接 最长支持150位" autocomplete="off" class="layui-input">
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-form layui-form-pane">
					<label class="layui-form-label">广告标题</label>
					<div class="layui-input-block">
						<input type="text" id="title" placeholder="请输入广告标题" autocomplete="off" class="layui-input">
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-input-block">
					<button id="addlink" class="layui-btn layui-btn-normal layui-btn-sm">新增广告</button>
				</div>
			</div>
		</div>
        </div>
      </div>
    </div>
      <div class="layui-col-md6">
        <div class="layui-card">
          <div class="layui-card-header">侧边栏广告列表
		  
		</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-operate" lay-filter="test-table-operate"></table>
            
            <script type="text/html" id="test-table-operate-barDemo">
              <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="del">删除</a>
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
  layui.use(['admin', 'table'], function(){
    var $ = layui.$
  ,admin = layui.admin
  ,view = layui.view
  ,table = layui.table
  ,form = layui.form;
  
    table.render({
      elem: '#test-table-operate'
      ,url: '/LinkAjax/lists'
      ,width: ''
      ,height: 632
      ,cols: [[
        {field:'id', width:70, title: 'ID', sort: true, align: 'center'}
        ,{field:'title',title: '标题'}
        ,{field:'url', title: '链接地址'}
        ,{title: '操作', align:'center', fixed: 'right', toolbar: '#test-table-operate-barDemo'}
      ]]
      ,page: true
    });
    
    //监听工具条
    table.on('tool(test-table-operate)', function(obj){
      var data = obj.data;
      if(obj.event === 'del'){
        layer.confirm('真的要删除此广告吗?', {
                icon: 3,
                title: '删除广告'
		}, function () {
			$.post("/LinkAjax/del", data, function (data) {
				if (data.code === 0) {
					layer.msg(data.message, {icon: 6, time: 2000, shade: [0.3, '#000']});
					table.reload('test-table-operate');
				} else {
					layer.alert(data.message,{icon:5,shade:0.3});
				}
			});
		});
      }
    });
	
	$('#addlink').click(function () {
		if ($("#url").val() == '') {
			layer.msg("请填写广告链接！");
		} else if ($("#title").val() == '') {
			layer.msg("请填写广告标题！");
		} else {
			var url = $("#url").val();
			var title = $("#title").val();
			jsonData = {
				url: url,
				title: title,
			};
			layer.confirm('确定新增广告?', {
				icon: 3,
				title: '新增授权'
			}, function () {
				$.ajax({
				url:"/LinkAjax/add",
				data:jsonData,
				type:"Post",
				dataType:"json",
				success:function(data){
					if(data.code==0){
						layer.msg(data.message, {icon: 6, time: 2000, shade: [0.3, '#000']});
						table.reload('test-table-operate');
					}else{
						layer.msg(data.message,{icon:5,shade:0.3});
					}
					
				}
			});
			});
		}
	});
  });
  </script>