<?php /*a:1:{s:50:"D:\phpstudy_pro\project\auth\view\admin\index.html";i:1603539712;}*/ ?>
<div class="layui-fluid">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">
      <div class="layui-row layui-col-space15">
	  <div class="layui-col-md6">
      <div class="layui-card">
                <div class="layui-card-header">
                    快捷方式               </div>
                <div class="layui-card-body">
                    <div class="layui-carousel layadmin-carousel layadmin-shortcut" lay-anim="" style="width: 100%; height: 280px;">
                        <div carousel-item="">
                            <ul class="layui-row layui-col-space10 layui-this">
                                <li class="layui-col-xs3">
                                    <a lay-href="/shop">
                                        <i class="layui-icon layui-icon-cart-simple"></i>
                                        <cite>账户升级</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a lay-href="/userinfo">
                                        <i class="layui-icon layui-icon-about"></i>
                                        <cite>账户信息</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a href="javascript:;" onclick="addPlayer()">
                                        <i class="layui-icon layui-icon-headset"></i>
                                        <cite>+ 播放器</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a href="javascript:;" onclick="addSongSheet()">
                                        <i class="layui-icon layui-icon-form"></i>
                                        <cite>+ 歌单</cite>
                                    </a>
                                </li>
                                                                <li class="layui-col-xs3">
                                    <a lay-href="/index/help">
                                        <i class="layui-icon layui-icon-survey"></i>
                                        <cite>使用帮助</cite>
                                    </a>
                                </li>
                                <li class="layui-col-xs3">
                                    <a href="javascript:;" id="qqhc">
                                        <i class="layui-icon layui-icon-fonts-clear"></i>
                                        <cite>清除缓存</cite>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
          </div>
	  <div class="layui-col-md6">
          <div class="layui-card">
            <div class="layui-card-header">我的数据</div>
            <div class="layui-card-body">
              <script type="text/html" template lay-url="/AdminAjax/MycountList" >
              <div class="layui-carousel layadmin-carousel layadmin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%; height: 280px;">
                <div carousel-item="">
                  <ul class="layui-row layui-col-space10 layui-this">
                    <li class="layui-col-xs6">
                      <a class="layadmin-backlog-body">
                        <h3>播放器</h3>
                        <p><cite style="font-size: 20px;">{{ d.data.players }} 个</cite></p>
                      </a>
                    </li>
                    <li class="layui-col-xs6">
                      <a class="layadmin-backlog-body">
                        <h3>我的歌单</h3>
                        <p><cite style="font-size: 20px;">{{ d.data.sheets }} 个</cite></p>
                      </a>
                    </li>
                    <li class="layui-col-xs6">
                      <a class="layadmin-backlog-body">
                        <h3>剩余配额</h3>
                        <p><cite style="font-size: 20px;">{{ d.data.pies }} 个</cite></p>
                      </a>
                    </li>
                    <li class="layui-col-xs6">
                      <a class="layadmin-backlog-body">
                        <h3>最近播放</h3>
                        <p><cite style="font-size: 20px;">{{ d.data.plays }}</cite></p>
                      </a>
                    </li>
                  </ul>
                </div>
              <button class="layui-icon layui-carousel-arrow" lay-type="sub"></button><button class="layui-icon layui-carousel-arrow" lay-type="add"></button></div>
              </script>
            </div>
          </div>
        </div>
		<div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">
                    最新版本
                    <span class="layui-badge layui-bg-black layuiadmin-badge">新</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font">V.<?php echo config('web.version'); ?></p>
                </div>
            </div>
        </div>
		<div class="layui-col-md6">
            <div class="layui-card">
                <div class="layui-card-header">
                    最新播放
                    <span id="newplaytime" class="layui-badge layui-bg-green layuiadmin-badge">00-00-00 00:00:00</span>
                </div>
                <div class="layui-card-body layuiadmin-card-list">
                    <p class="layuiadmin-big-font" style="font-size:28px">
                    	<span id="newplay" style="color: #009688">等待获取</span>
                    </p>
                </div>
            </div>
        </div>
    <div class="layui-col-md6">
      <div class="layui-card">
        <div class="layui-card-header" style="border-bottom: 0;">实时播放<span class="layui-badge layui-bg-blue layuiadmin-badge">最近播放</span></div>
        <div class="layui-card-body layui-text">
		<table class="layui-table layuiadmin-page-table" lay-skin="line">
			<colgroup>
				<col width="40%">
				<col width="30%">
				<col width="30%">
			</colgroup>
			<thead>
			<tr>
				<th>播放器名称</th>
				<th>播放时间</th>
				<th>用户类型</th>
			</tr>
			</thead>
			<tbody id="ssbfb"></tbody>
		</table>
        <br>
        </div>
    </div>
    </div>
	<div class="layui-col-md6">
      <div class="layui-card">
        <div class="layui-card-header" style="border-bottom: 0;">活跃用户<span class="layui-badge layui-bg-blue layuiadmin-badge">最近登陆</span></div>
        <div class="layui-card-body layui-text">
        <table class="layui-table layuiadmin-page-table" lay-skin="line">
			<colgroup>
											<col width="50%">
											<col width="30%">
				<col width="20%">
										</colgroup>
			<thead>
			<tr>
				<th>用户名</th>
				<th>登录时间</th>
				<th>用户类型</th>
										</tr>
			</thead>
			<tbody id="xdls"></tbody>
		</table>
        <br>
        </div>
    </div>
    </div>
      </div>
    </div>
    <div class="layui-col-md4">
	<script type="text/html" template lay-url="/AdminAjax/userInfo" >
      <div class="layui-card">
        <div class="layui-card-header">
		<img src="https://q2.qlogo.cn/headimg_dl?bs=qq&dst_uin=<?php echo htmlentities($userInfo['qq']); ?>&spec=100" width="20px" style="border-radius: 5px;" class="getface"> {{ d.data.username }}</div>
        <div class="layui-card-body layui-text" style="
    padding-bottom: 26px;
">
          <table class="layui-table">
            <colgroup>
              <col width="100">
              <col>
            </colgroup>
            <tbody>
              <tr>
                <td>账户类型</td>
                <td>
                  <span class="layui-badge-dot"></span> {{ d.data.lv }}
               </td>
              </tr>
              <tr>
                <td>注册时间</td>
                <td>
                  <span class="layui-badge-dot layui-bg-orange"></span> <span>{{ d.data.regtime }}</span>
                </td>
              </tr>
              <tr>
                <td>登录地址</td>
                <td><span class="layui-badge-dot layui-bg-green"></span> {{ d.data.city }}</td>
              </tr>
              <tr>
                <td>剩余配额</td>
                <td>
					<span class="layui-badge-rim">{{ d.data.pie }}个</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
		
      </div>
      </script>
      <div class="layui-card">
        <div class="layui-card-header">
          平台播放
          <span class="layui-badge layui-bg-red layuiadmin-badge">今日</span>
        </div>
        <div class="layui-card-body layuiadmin-card-list">
          <p class="layuiadmin-big-font" style="color: #FF5722;"><span id="todayplay" style="transform: translateY(-180px); transition: all 2s ease 0s;">0</span>次</p>
          <p>
            总播放
            <span class="layuiadmin-span-color"><span id="play" style="transform: translateY(-180px); transition: all 2s ease 0s;">0</span>次</span>
          </p>
        </div>
      </div>
      
      <div class="layui-card">
        <div class="layui-card-header">
          我的播放
          <span class="layui-badge layui-bg-blue layuiadmin-badge">今日</span>
        </div>
        <div class="layui-card-body layuiadmin-card-list">

          <p class="layuiadmin-big-font" style="color: #01AAED;"><span id="metodayplay" style="transform: translateY(-180px); transition: all 2s ease 0s;">0</span>次</p>
          <p>
            总播放
            <span class="layuiadmin-span-color"><span id="meplay" style="transform: translateY(-180px); transition: all 2s ease 0s;">0</span>次</span>
          </p>
        </div>
      </div>
    <div class="layui-card">
      <div class="layui-card-header">实时监控</div>
      <div class="layui-card-body layadmin-takerates">
        <div class="layui-progress" lay-showpercent="yes" lay-filter="cpu">
          <h3>CPU使用率</h3>
          <div id="cpu" class="layui-progress-bar" lay-percent="0%" style="width: 0%;"><span class="layui-progress-text" >0%</span></div>
        </div>
        <div class="layui-progress" lay-showpercent="yes" lay-filter="mem">
          <h3>内存占用率(<span id="memRealUsed">0</span>/<span id="memTotal">0</span>)</h3>
          <div id="mem" class="layui-progress-bar layui-bg-red" lay-percent="0%" style="width: 0%;"><span class="layui-progress-text">0%</span></div>
        </div>
      </div>
    </div>
    </div>
    
  </div>
</div>
<script>
layui.use(['console', 'carousel', 'table'], function(){
  var $ = layui.$
  ,admin = layui.admin
  ,table = layui.table
  ,carousel = layui.carousel
  ,element = layui.element
  ,router = layui.router();

  element.render('collapse');
  
  //监听折叠
  element.on('collapse(component-panel)', function(data){
    layer.msg('展开状态：'+ data.show);
  });
  
  if (typeof(loads)!="undefined") {
	clearInterval(loads);
  }
  
   $('#qqhc').click(function () {
        layer.confirm('确定要清除所有播放器缓存？', {
            btn: ['确定', '取消'] //按钮
        }, function (index) {
            var index = layer.load(3);
            $.post("/AdminAjax/clearCache", function (data) {
                layer.close(index);
                if (data.code === 0) {
                    layer.msg("清除缓存成功！", {icon: 6, time: 2000});
                } else {
                    layer.alert('清除缓存失败！');
                }
            });
        }, function () {
        });
    });
	
  function load(){
    //console.log(new Date());
      $.post("/AdminAjax/load", function (data) {
            layui.element.progress('mem', data.data.mem);
            layui.element.progress('cpu', data.data.cpu);
            $('#cpu').attr("class",data.data.cpus);
            $('#mem').attr("class",data.data.mems);
            $("#memRealUsed").html(data.data.memRealUsed);
            $("#memTotal").html(data.data.memTotal);
			$('#play').text(data.data.play);
			$('#todayplay').text(data.data.todayplay);
			$('#meplay').text(data.data.meplay);
			$('#metodayplay').text(data.data.metodayplay);
			$('#newplay').text(data.data.newplay);
			$('#newplaytime').text(data.data.newplaytime);
			$('#ssbfb').html(data.data.newplaylist);
			$('#xdls').html(data.data.newloginlist);
      });
  }
  loads=setInterval(load,3000);
});
</script>

