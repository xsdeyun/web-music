<?php /*a:1:{s:55:"D:\phpstudy_pro\project\auth\view\admin\song_sheet.html";i:1603539712;}*/ ?>
<link rel="stylesheet" href="/static/css/global.css?v=20191008" media="all">

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md6">
            <div class="larry-personal layui-collapse">
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">歌单歌曲（拖拽歌曲名排序）<button id="saveSongSheetSongTaxis" type="button" class="layui-badge layuiadmin-badge layui-bg-blue layui-btn layui-btn-danger layui-btn-xs">保存列表</button></h2>
                    <div class="layui-colla-content layui-show larry-personal-body clearfix" id="scroll" style="padding: 0;">
                        <div class="block__list_words">
                            <input type="hidden" id="songSheetId" value="<?php echo htmlentities($entity['id']); ?>">
                            <ul id="musiclist" lay-templateid="musiclist">
							<?php if(is_array($songs) || $songs instanceof \think\Collection || $songs instanceof \think\Paginator): $i = 0; $__LIST__ = $songs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$song): $mod = ($i % 2 );++$i;?>
							<li song_id="<?php echo htmlentities($song['song_id']); ?>" name="<?php echo htmlentities($song['name']); ?>" type="<?php echo htmlentities($song['type']); ?>"
                                album_name="<?php echo htmlentities($song['album_name']); ?>" artist_name="<?php echo htmlentities($song['artist_name']); ?>"
                                album_cover="<?php echo htmlentities($song['album_cover']); ?>" location="<?php echo htmlentities($song['location']); ?>" lyric="<?php echo htmlentities($song['lyric']); ?>">
                                    <span class="drag-handle"><img src="/static/images/type/<?php echo htmlentities($song['type']); ?>.png" width="16px" height="16px">  <?php echo htmlentities($song['name']); ?> <span class="layui-badge-rim"><?php echo htmlentities($song['artist_name']); ?></span></span>
                                        <div style="float:right">
                                            <a class="layui-btn layui-btn-danger layui-btn-xs"
                                               onclick="delPlayerSongSheet(this)" href="javascript:"
                                               ss-name="<?php echo htmlentities($song['name']); ?>"><i
                                                    class="layui-icon layui-icon-delete"></i>删除</a>
                                        </div>
                                       <input type="hidden" name="ids[]" value="<?php echo htmlentities($song['id']); ?>">
                                    </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                         </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="larry-personal layui-collapse">
                    <div class="layui-tab layui-tab-card" style="margin: 0;border-width: 0;">
                        <ul class="layui-tab-title">
                            <li class="layui-this">基本设置</li>
                            <li class="sdtj_option">网络歌曲</li>
                            <li class="sdtj_option">搜索添加</li>
                            <li class="sdtj_option">手动添加</li>
                            <li class="sdtj_option">歌单导入</li>
                            <li class="sdtj_option">随机找歌</li>
                        </ul>
                        <div class="layui-tab-content" style="padding: 0;">
						
                            <div class="layui-tab-item layui-show" style="padding:10px">
							<form id="sheetset">
						<input type="hidden" name="id" value="<?php echo htmlentities($entity['id']); ?>">
                                <div class="layui-form layui-form-pane">
                                	<blockquote class="layui-elem-quote">保存设置后自动清理缓存
                                    </blockquote>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">歌单类型</label>
                                        <div class="layui-input-inline">
                                            <select name="status" id="status">
                                                <option value="0" id="status" <?php if( $entity['status'] == '0' ) echo  'selected = "selected"' ; ?> >仅自己使用</option>
												<option value="1" id="status" <?php if( $entity['status'] == '1' ) echo  'selected = "selected"' ; ?> >共享到平台</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">歌单名称</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="name" value="<?php echo htmlentities($entity['name']); ?>"
                                                   placeholder="请输入歌单名称" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">歌单作者</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="author" value="<?php echo htmlentities($entity['author']); ?>"
                                                   placeholder="请输入歌单作者" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="jcload layui-progress layui-progress-big" style="display:none;position: unset;border-radius: 0;margin-bottom: 10px" lay-showpercent="true" lay-filter="component-progress-test">
                                    <div class="layui-progress-bar layui-bg-red" style="position: unset;border-radius: 0;" lay-percent="0%"></div>
                                </div>
                                <div class="layui-input-block save-button">
                                    <button class="layui-btn layui-btn-sm" onclick="set()" type="button">保存</button>
                                    <button onclick="delSheet()" type="button"  class="layui-btn layui-btn-danger layui-btn-sm">删除</button>
                                </div>
								</form>
                            </div>
							
                            <div class="layui-tab-item" style="padding:10px">
							<form id="idaddsong">
                                <div class="layui-form layui-form-pane">
                                	<blockquote class="layui-elem-quote">音乐ID获取请到主页帮助文档查看详细说明
                                    </blockquote>
                                    <div class="layui-form-item" pane="">
                                        <label class="layui-form-label">选择位置</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="position" value="top" title="添加到顶部" checked>
                                            <input type="radio" name="position" value="bottom" title="添加到底部">
                                        </div>
                                    </div>
									<div class="layui-form-item">
                                        <label class="layui-form-label">歌单类型</label>
                                        <div class="layui-input-inline">
                                            <select name="type" class="form-control" id="songType">
												<option value="netease">网易音乐</option>
												<option value="kugou">酷狗音乐</option>
												<option value="qq">QQ音乐</option>
												<option value="kuwo">酷我音乐</option>
												<option value="xiami">虾米音乐</option>
											</select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">歌曲ID</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="songid" id="songId" placeholder="请输入歌曲ID或酷狗32位HASH值"
                                                   autocomplete="off"
                                                   class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-input-block">
                                        <button class="layui-btn layui-btn-normal"  onclick="idaddsong()" type="button">
                                            添加歌曲
                                        </button>
                                    </div>
                                </div>
							</form>
                            </div>
                            <div class="layui-tab-item" style="padding:10px">
                                <div class="layui-form layui-form-pane">
                                	<blockquote class="layui-elem-quote">请使用“歌曲名”或“歌曲名歌手名”搜索</blockquote>
                                    <div class="layui-form-item" pane="">
                                        <label class="layui-form-label">选择位置</label>
                                        <div class="layui-input-block">
                                            <input type="radio" name="position3" value="top" title="添加到顶部" checked>
                                            <input type="radio" name="position3" value="bottom" title="添加到底部">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">搜索来源</label>
                                        <div class="layui-input-inline">
                                            <select id="soutype" >
                                                <option value="netease">网易音乐</option>
                                                <option value="kugou">酷狗音乐</option>
                                            </select>
                                        </div>
                                    </div>
									<div class="layui-form-item">
                                        <label class="layui-form-label">搜索内容</label>
                                        <div class="layui-input-block">
                                            <input type="text" name="song_name" placeholder="请输入要搜索的歌曲或歌手" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                    <div class="layui-input-block">
                                        <button class="layui-btn layui-btn-normal" id="search">
                                            搜索歌曲
                                        </button>
                                    </div>
                                </div>
                                <table class="layui-table layuiadmin-page-table" lay-skin="line">
			<colgroup>
											<col width="50%">
											<col width="30%">
				<col width="20%">
										</colgroup>
			<thead>
			<tr>
				<th>歌曲名称</th>
				<th>歌手</th>
				<th></th>
										</tr>
			</thead>
			<tbody id="search_list"></tbody>
		</table>
                            </div>
                            <div class="layui-tab-item" style="padding:10px">
                                <div class="layui-form layui-form-pane">
                                	<blockquote class="layui-elem-quote">外链最长150位，如果链接地址过长，请使用
                                            <button onclick="dwz();return false;" class="layui-btn layui-btn-xs">
                                                缩短网址
                                            </button>
                                            后填写
                                        </blockquote>
                                    <div class="layui-form-item">
									<form id="sdaddsong">
                                        <div class="layui-form-item" pane="">
                                            <label class="layui-form-label">选择位置</label>
                                            <div class="layui-input-block">
                                                <input type="radio" name="position2" value="top" title="添加到顶部"
                                                       checked>
                                                <input type="radio" name="position2" value="bottom" title="添加到底部">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">歌曲名</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="name" placeholder="请输入歌曲名称" maxlength="150"
                                                       autocomplete="off"
                                                       class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">歌手名</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="artist_name" placeholder="请输入歌手名称" maxlength="150"
                                                       autocomplete="off"
                                                       class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">专辑名</label>
                                            <div class="layui-input-inline">
                                                <input type="text" name="album_name" placeholder="请输入专辑名称" maxlength="150"
                                                       autocomplete="off"
                                                       class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">专辑图片</label>
                                            <div class="layui-input-block">
                                                <input type="text" name="album_cover" placeholder="请输入专辑封面地址(PNG/JPG格式)"
                                                       maxlength="150" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                        <div class="layui-form-item">
                                            <label class="layui-form-label">歌曲地址</label>
                                            <div class="layui-input-block">
                                                <input type="text" name="location" placeholder="请输入歌曲播放地址(MP3格式)"
                                                       maxlength="150" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
										<div class="layui-form-item">
                                            <label class="layui-form-label">歌词地址</label>
                                            <div class="layui-input-block">
                                                <input type="text"  name="lyric" placeholder="请输入歌曲的歌词地址(LRC格式)"
                                                       maxlength="150" autocomplete="off" class="layui-input">
                                            </div>
                                        </div>
                                                                                <div class="layui-input-block">
                                            <button class="layui-btn layui-btn-normal" onclick="sdaddsong()" type="button">
                                                添加歌曲
                                            </button>
                                        </div>
										</form>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-tab-item" style="padding:10px">
							<form id="sheetaddsong">
                                <div class="layui-form layui-form-pane">
                                    <blockquote class="layui-elem-quote">使用歌单ID直接导入歌曲到当前歌单，建议歌单内歌曲不超过100首
                                    </blockquote>
									<div class="layui-form-item" pane="">
                                            <label class="layui-form-label">选择位置</label>
                                            <div class="layui-input-block">
                                                <input type="radio" name="position4" value="top" title="添加到顶部"
                                                       checked>
                                                <input type="radio" name="position4" value="bottom" title="添加到底部">
                                            </div>
                                        </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">歌单类型</label>
                                        <div class="layui-input-inline">
                                            <select name="type">
												<option value="wy">网易歌单</option>
												<option value="kg">酷狗音乐</option>
											</select>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">歌单ID</label>
                                        <div class="layui-input-inline">
                                            <input type="text"  name="sheetid" placeholder="请输入歌单ID" autocomplete="off" class="layui-input">
                                        </div>
                                    </div>
                                                                        <div class="layui-input-block">
                                        <button class="layui-btn layui-btn-normal" onclick="sheetidaddsong()" type="button">
                                            导入歌单
                                        </button>
                                    </div>
                                </div>
							</form>
                            </div>
                            <div class="layui-tab-item">
                                <div class="layui-form layui-form-pane">
                                    <table class="layui-table" style="margin: 0;">
                                        <tbody>
										<?php if(is_array($suiji) || $suiji instanceof \think\Collection || $suiji instanceof \think\Paginator): $i = 0; $__LIST__ = $suiji;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
											<tr>
                                            <td width="2%"><img  src="/static/images/type/<?php echo htmlentities($v['type']); ?>.png" width="16px" height="16px"></td>
                                            <td> <?php echo htmlentities($v['name']); ?> -  <?php echo htmlentities($v['artist_name']); ?></td>
                                            <td width="2%"><a class="layui-btn layui-btn-primary layui-btn-xs" href='javascript:;' type='<?php echo htmlentities($v['type']); ?>' name='<?php echo htmlentities($v['song_id']); ?>' onclick='getSearchAdd(this)'><i class="layui-icon layui-icon-add-1"></i>添加</a></td>
                                        </tr>
										<?php endforeach; endif; else: echo "" ;endif; ?>
                                                                                
                                                                                </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/static/plugins/sortable/Sortable.min.js"></script>
<script>
    layui.use(['admin', 'form','colorpicker'], function(){
		$ = layui.jquery;
        var element = layui.element,
            colorpicker = layui.colorpicker,
            form = layui.form;
        element.render();
        element.render('collapse');
        form.render('radio');
        form.render('select');
        form.render('checkbox');
		
		$('#saveSongSheetSongTaxis').click(function () {
            var data = $("#musiclist li");
            var jsonData = new Array();
            for (var x = 0; x < data.length; x++) {
                var row = $(data[x]);
				if(row.attr("type")=='baidu'){
					pic = row.attr("album_cover").replace('@s_2,w_150,h_150', '');
				}else{
					pic = row.attr("album_cover");
				}
                jsonData[x] = {
                    song_id: row.attr("song_id"),
                    name: row.attr("name"),
                    type: row.attr("type"),
                    album_name: row.attr("album_name"),
                    artist_name: row.attr("artist_name"),
                    album_cover: pic,
                    location: row.attr("location"),
					lyric: row.attr("lyric"),
                    taxis: x
                };
            }
            jsonData = JSON.stringify(jsonData);

            $.post("/AdminAjax/Song/act/save", {
                jsonData: jsonData,
                songSheetId: $("#songSheetId").val(),
            }, function (data) {
                if(data.code==0){
					layer.msg('保存成功[缓存已清除]', {icon: 6,time: 2000});
				}else{
					layer.msg('保存失败',{icon:5,shade:0.3});
				}
            });
        });
		
		$("[id=search]").click(function() {
			var name = $("input[name='song_name']").val();
			var type = $("#soutype").val();
			 $.ajax({
				url: '<?php echo url("/AdminAjax/Song/act/search"); ?>',
				type: 'GET',
				dataType: 'json',
				data:{
					"song_name":name,
					"type":type
				},
				success: function(data) {
				var html = '';

					for (x in data['songs']) {

						html = html + "<tr>";

						html = html + "<td><span class='first'><img src=\"/static/images/type/"+type+".png\" width=\"16px\" height=\"16px\"> "+ data['songs'][x]["song_name"] +"</span></td>";

						html = html + "<td><span class='first'>"+ data['songs'][x]["artist_name"]+"</span></td>";

						html = html + "<td><a class='layui-btn layui-btn-primary layui-btn-xs' href='javascript:;' type='"+ data['songs'][x]['type'] +"' name='"+ data['songs'][x]['id'] +"' onclick='getSearchAdd(this)' ><i class='layui-icon layui-icon-add-1'></i>添加</a></td>";

						html = html + "</tr>";

					}
				$('#search_list').html(html);
				}
			});
		});
		
		var tul = document.getElementById("musiclist");
            Sortable.create(tul, {
                handle: '.drag-handle',
                animation: 150,
                onEnd: function () {
					var data = $("#musiclist li");
					var jsonData = new Array();
					for (var x = 0; x < data.length; x++) {
						var row = $(data[x]);
						if(row.attr("type")=='baidu'){
							pic = row.attr("album_cover").replace('@s_2,w_150,h_150', '');
						}else{
							pic = row.attr("album_cover");
						}
						jsonData[x] = {
							song_id: row.attr("song_id"),
							name: row.attr("name"),
							type: row.attr("type"),
							album_name: row.attr("album_name"),
							artist_name: row.attr("artist_name"),
							album_cover: pic,
							location: row.attr("location"),
							lyric: row.attr("lyric"),
							taxis: x
						};
					}
					jsonData = JSON.stringify(jsonData);

					$.post("/AdminAjax/Song/act/save", {
						jsonData: jsonData,
						songSheetId: $("#songSheetId").val(),
					}, function (data) {
						if(data.code==0){
							layer.msg('保存成功[缓存已清除]', {icon: 6,time: 2000});
						}else{
							layer.msg('保存失败',{icon:5,shade:0.3});
						}
					});
                }
            });

    });
	
	</script>
	<script>
	function getSearchAdd(that) {
		position = $(":radio[name='position3']:checked").val();
		jsonData = {
				songid: $(that).attr("name"),
				type: $(that).attr("type"),
			};
		$.post("/AdminAjax/Song/act/info", jsonData, function (data) {
			if (data.code === 0) {
				layer.confirm('歌曲名称：' + data['song_name'] + '<br/>歌手：' + data['artist_name'] + ' <br/> 确认添加到歌单吗？', {
					icon: 3,
					title: '确认'
				}, function (index) {
					var liHtml = '<li song_id="' + jsonData.songid +
						'" name="' + data['song_name'] + '" type="' + jsonData.type +
						'" album_name="' + data['album_name'] +
						'" artist_name="' + data['artist_name'] +
						'"album_cover="' + data['album_cover'] +
						'" location="' + data['location'] +
						'" lyric="' + data['lyric'] +
						'"><span class="drag-handle"><img src="/static/images/type/' + jsonData.type +
						'.png" width="16px" height="16px">  ' + data['song_name'] + ' <span class="layui-badge-rim">' + data['artist_name'] +
						'</span></span><div style="float:right"><a class="layui-btn layui-btn-danger layui-btn-xs" onclick="delPlayerSongSheet(this)" href="javascript:" ss-name="' + data['song_name'] + '"><i class="layui-icon layui-icon-delete"></i>删除</a></div><input type="hidden" name="ids[]" value="' + jsonData.songid +'"></li>';
					position == 'top' ? $("#musiclist").prepend(liHtml) : $("#musiclist").append(liHtml);
					layer.msg("已添加到歌单");
					layer.close(index);
				});
			} else {
				layer.alert(data.msg,{icon:5,shade:0.3});
			}
		});
	}
	
	function delPlayerSongSheet(entity) {
        $(entity).parent().parent().remove();
    }
	
	function idaddsong() {
		songType = $("#songType").val();
		songId = $("#songId").val();
		position = $(":radio[name='position']:checked").val();
		$.post("/AdminAjax/Song/act/info", $("#idaddsong").serialize(), function (data) {
			if (data.code === 0) {
				layer.confirm('歌曲名称：' + data['song_name'] + '<br/>歌手：' + data['artist_name'] + ' <br/> 确认添加到歌单吗？', {
					icon: 3,
					title: '确认'
				}, function (index) {
					var liHtml = '<li song_id="' + songId +
						'" name="' + data['song_name'] + '" type="' + songType +
						'" album_name="' + data['album_name'] +
						'" artist_name="' + data['artist_name'] +
						'"album_cover="' + data['album_cover'] +
						'" location="' + data['location'] +
						'" lyric="' + data['lyric'] +
						'"><span class="drag-handle"><img src="/static/images/type/' + songType +
						'.png" width="16px" height="16px">  ' + data['song_name'] + ' <span class="layui-badge-rim">' + data['artist_name'] +
						'</span></span><div style="float:right"><a class="layui-btn layui-btn-danger layui-btn-xs" onclick="delPlayerSongSheet(this)" href="javascript:" ss-name="' + data['song_name'] + '"><i class="layui-icon layui-icon-delete"></i>删除</a></div><input type="hidden" name="ids[]" value="' + songId +'"></li>';
					position == 'top' ? $("#musiclist").prepend(liHtml) : $("#musiclist").append(liHtml);
					layer.msg("已添加到歌单");
					layer.close(index);
				});
			} else {
				layer.alert(data.msg,{icon:5,shade:0.3});
			}
		});
	};
	
	function set() {
		$.post("/AdminAjax/songSheet/act/edit", $("#sheetset").serialize(), function (data) {
			if (data.code === 0) {
				layer.msg(data.msg, {icon: 6,time: 2000});
			} else {
				layer.alert(data.msg,{icon:5,shade:0.3});
			}
		});
    };
		
	function delSheet() {
		layer.confirm('真的要删除此歌单吗?', {
                icon: 3,
                title: '删除歌单'
		}, function () {
			$.post("/AdminAjax/songSheet/act/del", $("#sheetset").serialize(), function (data) {
				if (data.code === 0) {
					layer.msg(data.msg, {icon: 6, time: 2000, shade: [0.3, '#000']});
					setTimeout(function () {
						window.location.href = '/console#/';
					}, 1000);
				} else {
					layer.alert(data.msg,{icon:5,shade:0.3});
				}
			});
		});
    };
	
	function sdaddsong() {
		position = $(":radio[name='position2']:checked").val();
		$.post("/AdminAjax/Song/act/check", $("#sdaddsong").serialize(), function (data) {
			if(data.code==0){
				layer.confirm('歌曲名称：' + data['name'] + '<br/>歌手：' + data['artist_name'] + ' <br/> 确认添加到歌单吗？', {
					icon: 3,
					title: '确认'
				}, function (index) {
					var liHtml = '<li song_id="" name="' + data['name'] + '" type="local" album_name="' + data['album_name'] +
						'" artist_name="' + data['artist_name'] +
						'"album_cover="' + data['album_cover'] +
						'" location="' + data['location'] +
						'" lyric="' + data['lyric'] +
						'"><span class="drag-handle"><img src="/static/images/type/local.png" width="16px" height="16px">  ' + data['name'] + ' <span class="layui-badge-rim">' + data['artist_name'] +
			'</span></span><div style="float:right"><a class="layui-btn layui-btn-danger layui-btn-xs" onclick="delPlayerSongSheet(this)" href="javascript:" ss-name="' + data['name'] + '"><i class="layui-icon layui-icon-delete"></i>删除</a></div><input type="hidden" name="ids[]" value="' + data['name'] + '"></li>';
					position == 'top' ? $("#musiclist").prepend(liHtml) : $("#musiclist").append(liHtml);
					layer.msg("已添加到歌单");
					layer.close(index);
				});
			}else{
				layer.msg(data.msg,{icon:5,shade:0.3});
			}
		});
	};
	
	function sheetidaddsong() {
	position = $(":radio[name='position4']:checked").val();
	$.post("AdminAjax/Song/act/sheet", $("#sheetaddsong").serialize(), function (data) {
		if(data.code==0){
			layer.confirm('确认添加到此网络歌单的歌曲到歌单吗？', {
				icon: 3,
				title: '确认'
			}, function (index) {
				html = '';

				for (x in data["songs"]) {
					html = html + '<li song_id="' + data['songs'][x]['song_id'] + '" name="' + data['songs'][x]['name'] +
							'" type="' + data['songs'][x]['type'] +
							'" album_name="' + data['songs'][x]['album_name'] +
							'" artist_name="' + data['songs'][x]['artist_name'] +
							'"album_cover="' + data['songs'][x]['album_cover'] +
							'" location="" lyric="">';

					html = html + '<span class="drag-handle"><img src="/static/images/type/' + data['songs'][x]['type'] +
							'.png" width="16px" height="16px">  ' + data['songs'][x]['name'] +
							' <span class="layui-badge-rim">' + data['songs'][x]['artist_name'] +
							'</span></span>';

					html = html + '<div style="float:right"> <a class="layui-btn layui-btn-danger layui-btn-xs" onclick="delPlayerSongSheet(this)" href="javascript:" ss-name="' + data['songs'][x]['name'] +
							'"><i class="layui-icon layui-icon-delete"></i>删除</a></div><input type="hidden" name="ids[]" value="' + data['songs'][x]['name'] + '">';

					html = html + "</li>";

				}
				position == 'top' ? $("#musiclist").prepend(html) : $("#musiclist").append(html);
				layer.msg("已添加到歌单");
				layer.close(index);
			});
		}else{
				layer.msg(data.msg,{icon:5,shade:0.3});
		}
	});
	};
	</script>
</body>
</html>