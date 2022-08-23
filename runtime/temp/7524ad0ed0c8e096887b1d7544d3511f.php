<?php /*a:1:{s:56:"D:\phpstudy_pro\project\auth\view\admin\orders\list.html";i:1599399745;}*/ ?>
  <div class="layui-card layadmin-header">
    <div class="layui-breadcrumb" lay-filter="breadcrumb">
      <a lay-href="">控制面板</a>
      <a><cite>订单列表</cite></a>
    </div>
  </div>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">订单列表
		  
		</div>
          <div class="layui-card-body">
            <table class="layui-hide" id="test-table-operate" lay-filter="test-table-operate"></table>
            
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
      ,url: '/OrderAjax/lists'
      ,width: ''
      ,height: 632
      ,cols: [[
        {field:'trade_no', title: '商品交易号', sort: true, align: 'center'}
        ,{field:'orderid',title: '商品订单号'}
        ,{field:'name', title: '商品名称'}
		,{field:'money', title: '订单金额'}
		,{field:'type', title: '支付方式'}
		,{field:'time', title: '付款时间'}
      ]]
      ,page: true
    });
    
  });
  </script>