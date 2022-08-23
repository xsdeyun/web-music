<?php /*a:1:{s:51:"D:\phpstudy_pro\project\auth\view\admin\layout.html";i:1603539712;}*/ ?>
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <!-- 头部区域 -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item layadmin-flexible" lay-unselect>
        <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
          <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
        </a>
      </li>
      <!--<li class="layui-nav-item layui-this layui-hide-xs layui-hide-sm layui-show-md-inline-block">
        <a lay-href="" title="">
          控制台
        </a>
      </li>-->
      <li class="layui-nav-item layui-hide-xs" lay-unselect>
        <a href="<?php echo get_domain(); ?>" target="_blank" title="前台">
          <i class="layui-icon layui-icon-website"></i>
        </a>
      </li>
      <li class="layui-nav-item" lay-unselect>
        <a href="javascript:;" layadmin-event="refresh" title="刷新">
          <i class="layui-icon layui-icon-refresh-3"></i>
        </a>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
      <li class="layui-nav-item layui-hide-xs" lay-unselect>
        <a href="javascript:;" layadmin-event="theme">
          <i class="layui-icon layui-icon-theme"></i>
        </a>
      </li>
      <li class="layui-nav-item layui-hide-xs" lay-unselect>
        <a href="javascript:;" layadmin-event="note">
          <i class="layui-icon layui-icon-note"></i>
        </a>
      </li>
      <li class="layui-nav-item" lay-unselect>
        <script type="text/html" template lay-url="/AdminAjax/userInfo" 
        lay-done="layui.element.render('nav', 'layadmin-layout-right');">
          <a href="javascript:;">
            <cite>{{ d.data.username }}</cite>
          </a>
          <dl class="layui-nav-child">
            <dd><a lay-href="userinfo">基本资料</a></dd>
            <dd><a lay-href="userinfo">修改密码</a></dd>
            <hr>
            <dd lay-href="logout"><a>退出</a></dd>
          </dl>
        </script>
      </li>
      <li class="layui-nav-item layui-hide-xs" lay-unselect>
        <a href="javascript:;" layadmin-event="fullscreen">
          <i class="layui-icon layui-icon-screen-full"></i>
        </a>
      </li>
      
    </ul>
  </div>
  
  <!-- 侧边菜单 -->
  <div class="layui-side layui-side-menu">
    <div class="layui-side-scroll">
      <script type="text/html" template lay-url="/AdminAjax/menu" 
      lay-done="layui.element.render('nav', 'layadmin-system-side-menu');" id="TPL_layout">
      
        <div class="layui-logo" lay-href="">
          <span>{{ d.config.logo }}</span>
        </div>
        
        <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
        {{# 
          var path =  layui.router().path
          ,pathURL = layui.admin.correctRouter(path.join('/'))
          ,dataName = layui.setter.response.dataName;
          
          layui.each(d[dataName], function(index, item){ 
            var hasChildren = typeof item.list === 'object' && item.list.length > 0
            ,classSelected = function(){
              var match = path[0] == item.name || (index == 0 && !path[0]) 
              || (item.jump && pathURL == layui.admin.correctRouter(item.jump)) || item.spread;
              if(match){
                return hasChildren ? 'layui-nav-itemed' : 'layui-this';
              }
              return '';
            }
            ,url = (item.jump && typeof item.jump === 'string') ? item.jump : item.name;
        }}
          <li data-name="{{ item.name || '' }}" data-jump="{{ item.jump || '' }}" class="layui-nav-item {{ classSelected() }}">
            <a href="javascript:;" {{ hasChildren ? '' : 'lay-href="'+ url +'"' }} lay-tips="{{ item.title }}" lay-direction="2">
              <i class="layui-icon {{ item.icon }}"></i>
              <cite>{{ item.title }}</cite>
            </a>
            {{# if(hasChildren){ }}
              <dl class="layui-nav-child">
              {{# layui.each(item.list, function(index2, item2){ 
                var hasChildren2 = typeof item2.list == 'object' && item2.list.length > 0
                ,classSelected2 = function(){
                  var match = (path[0] == item.name && path[1] == item2.name) 
                  || (item2.jump && pathURL == layui.admin.correctRouter(item2.jump)) || item2.spread;
                  if(match){
                    return hasChildren2 ? 'layui-nav-itemed' : 'layui-this';
                  }
                  return '';
                }
                ,url2 = (item2.jump && typeof item2.jump === 'string') 
                  ? item2.jump 
                : [item.name, item2.name, ''].join('/');
              }}
                <dd  data-name="{{ item2.name || '' }}"  data-jump="{{ item2.jump || '' }}" 
                {{ classSelected2() ? ('class="'+ classSelected2() +'"') : '' }}>
                  <a href="javascript:;" {{ hasChildren2 ? '' : 'lay-href="'+ url2 +'"' }}>{{ item2.title }}</a>
                  {{# if(hasChildren2){ }}
                    <dl class="layui-nav-child">
                      {{# layui.each(item2.list, function(index3, item3){ 
                        var match = (path[0] == item.name && path[1] == item2.name && path[2] == item3.name) 
                        || (item3.jump && pathURL == layui.admin.correctRouter(item3.jump))
                        ,url3 = (item3.jump && typeof item3.jump === 'string') 
                          ? item3.jump 
                        : [item.name, item2.name, item3.name].join('/')
                      }}
                        <dd data-name="{{ item3.name || '' }}"  data-jump="{{ item3.jump || '' }}" 
                        {{ match ? 'class="layui-this"' : '' }}>
                          <a href="javascript:;" lay-href="{{ url3 }}" {{ item3.iframe ? 'lay-iframe="true"' : '' }}>{{ item3.title }}</a>
                        </dd>
                      {{# }); }}
                    </dl>
                  {{# } }}
                </dd>
            {{# }); }}
            </dl>
            {{# } }}
          </li>
        {{# }); }}
			
			<li data-name="ad" data-jump="" class="layui-nav-item layui-nav-itemed"> <a href="javascript:;" lay-tips="赞助广告" lay-direction="2"> <i class="layui-icon layui-icon-flag"></i> <cite>赞助广告 [<?php echo htmlentities($linkcount); ?>]</cite> <span class="layui-nav-more"></span> </a> <dl class="layui-nav-child"> 
			<?php if(is_array($links) || $links instanceof \think\Collection || $links instanceof \think\Paginator): $i = 0; $__LIST__ = $links;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<dd data-name="ad"><a href="<?php echo htmlentities($vo['url']); ?>" target="_blank"><img src="https://api.qqsuu.cn/api/favicon/get.php?url=<?php echo htmlentities($vo['url']); ?>" class="typeico"><?php echo htmlentities($vo['title']); ?></a></dd>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			 </dl> 
			</li>
			
			<li data-name="addPlayer" data-jump="addPlayer" class="layui-nav-item "> <a href="javascript:;" onclick="addPlayer()"><i class="layui-icon layui-icon-add-circle-fine"></i><cite>新建播放器</cite></a> </li>
			<li data-name="addSongSheet" data-jump="addSongSheet" class="layui-nav-item "> <a href="javascript:;" onclick="addSongSheet()"><i class="layui-icon layui-icon-add-circle-fine"></i><cite>新建歌单</cite></a> </li>
        </ul>
      </script>
    </div>
  </div>
  

  <!-- 页面标签 -->
  <script type="text/html" template lay-done="layui.element.render('nav', 'layadmin-pagetabs-nav')">
    {{# if(layui.setter.pageTabs){ }}
    <div class="layadmin-pagetabs" id="LAY_app_tabs">
      <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
      <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
      <div class="layui-icon layadmin-tabs-control layui-icon-down">
        <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;"></a>
            <dl class="layui-nav-child layui-anim-fadein">
              <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
              <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
              <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
            </dl>
          </li>
        </ul>
      </div>
      <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
        <ul class="layui-tab-title" id="LAY_app_tabsheader">
          <li lay-id="/"><i class="layui-icon layui-icon-home"></i></li>
        </ul>
      </div>
    </div>
    {{# } }}
  </script>
  
  
  <!-- 主体内容 -->
  <div class="layui-body" id="LAY_app_body">
    <div class="layadmin-tabsbody-item layui-show"></div>
  </div>
  
  <!-- 辅助元素，一般用于移动设备下遮罩 -->
  <div class="layadmin-body-shade" layadmin-event="shade"></div>
  
</div>
<script>
layui.use(['jquery','admin', 'form', 'user'], function(){
	var $ = layui.$
	,setter = layui.setter
	,admin = layui.admin
	,form = layui.form
	,router = layui.router()
	,search = router.search;
	
    window.addSongSheet = function () {
        //默认prompt
        layer.prompt({title: '请输入歌单名称'}, function (val, index) {
            layer.closeAll();
            var index = layer.load(3);
            var gdsl = parseInt($("#gdsl").val()) + 1;
            var gdname = val;
            $.post("/AdminAjax/songSheet/act/add", {name: val}, function (data) {
                layer.close(index);
                if (data.code === 0) {
                  layer.msg("歌单《" + gdname + "》添加成功！", {icon: 6, time: 2000, shade: [0.3, '#000']});
                        setTimeout(function () {
                    location.replace('#/songSheet/id/'+data.id);
                        }, 1000);
                } else {
                    layer.alert('添加失败！');
                }
            });
        });
    };
    window.addPlayer = function () {
      layer.closeAll();
        //默认prompt
        layer.prompt({title: '请输入播放器名称'}, function (val, index) {
            layer.closeAll();
            var index = layer.load(3);
            var bfqname = val;
            $.post("/AdminAjax/Player/act/add", {name: bfqname}, function (data) {
                layer.close(index);
                if (data.code === 0) {
                    layer.open({
                        title: false,
                        closeBtn: 0, //不显示关闭按钮
                        content: data.msg,
                        title: '创建成功',
                        btn: ['下一步'],
                        yes: function () {
                            layer.closeAll();
                            layer.prompt({
                                title: '请授权默认使用的网站域名',
                                closeBtn: 0, //不显示关闭按钮
                                btn: ['下一步']
                            }, function (val, index) {
                                layer.closeAll();
                                var index = layer.load(3);
                                var bfqsl = parseInt($("#bfqsl").val()) + 1;
                                var domain = val.replace(" ", "").replace("http://", "").replace("https://", "")
                                $.post("/AdminAjax/Player/act/auth", {domain: domain, id: data.id, remark: ''}, function (datas) {
                                    layer.close(index);
                                    if (data.code === 0) {
										layer.msg("播放器《" + bfqname + "》添加成功！", {icon: 6, time: 2000, shade: [0.3, '#000']});
											setTimeout(function () {

										location.replace('#/player/id/'+data.id);
											}, 1000);

                                    } else {
                                        layer.alert(data.msg);
                                    }
                                });
                            });
                        }
                    });
                } else {
                    layer.alert(data.msg);
                }
            });
        });
    };
});
</script>
