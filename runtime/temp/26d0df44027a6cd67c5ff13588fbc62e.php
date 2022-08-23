<?php /*a:1:{s:50:"D:\phpstudy_pro\project\auth\view\index\index.html";i:1603539712;}*/ ?>
<!--[if lt IE 10]><script>alert("您正在使用的浏览器版本过低，为了您的最佳体验，请先升级浏览器。");window.location.href="http://support.dmeng.net/upgrade-your-browser.html?referrer="+encodeURIComponent(window.location.href);</script><![endif]-->
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo config('web.webname'); ?> - <?php echo config('web.title'); ?></title>
    <meta name="description" content="<?php echo config('web.description'); ?>">
    <meta name="keywords" content="<?php echo config('web.keywords'); ?>">
    
    
    <link rel="stylesheet" href="static/index/css/app-20190821.css">
    <link rel="stylesheet" type="text/css" href="static/index/css/plugins.css">
    <link rel="stylesheet" type="text/css" href="static/index/css/style-0406.css">
    <link rel="stylesheet" href="static/index/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/index/css/font-awesome.min.css">
    <link rel="stylesheet" href="static/index/css/layui.css" media="all">
    <script type="text/javascript" src="static/index/js/jquery.min.js"></script>
    <script type="text/javascript" src="static/index/js/layui.js"></script>
</head>
<body>
<div class="as_tm_wrapper_all">
    <div class="as_tm_preloader"><div class="spinner_wrap"><div class="spinner"></div></div></div>
    <div class="as_tm_content">
        <div class="as_tm_rightpart">
            <div class="rightpart_inner">
                <div class="as_tm_section" id="home">
                    <div class="as_tm_hero_header_wrap">
                        <div class="as_tm_ripple_wrap" id="ripple">
                            <div class="overlay"></div>
                            <div class="inner_content">
                                <div class="name_holder">
                                    <h3><span><?php echo config('web.webname'); ?></span></h3><br>
                                </div>
                                <div class="name_holder">
                                    <h3><?php echo config('web.title'); ?></h3><br>
                                </div>
                                <div class="btns-row">
                                    <a href="/console#/user/act/reg" class="btn btn-tran">免费注册</a>
                                    <a href="/console#/user/act/login" class="btn btn-tran">立即登陆</a>
                                                                    </div>
                                <div class="text_typing">
                                    <p><span class="as_home_text_word"></span></p>
                                </div>
                            </div>
                            <div class="as_tm_arrow_wrap bounce anchor">
                                <a href="#about"><i class="xcon-angle-double-down"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="as_tm_section relative" id="about">
                    <div class="as_tm_about_wrapper_all">
                        <div class="container">
                            <div class="as_tm_title_holder">
                                <h3>关于</h3>
                                <span>日积月累 / 精益求精</span>
                            </div>
                            <div class="as_tm_about_wrap">
                            	<blockquote class="layui-elem-quote layui-quote-nm" style="margin-bottom:10px;font-size:unset">
                <p><?php echo config('web.webname'); ?>是为梨花带雨开源音乐播放器开发的后端控制面板<br>提供各种音乐接口以及管理操作,已兼容地球上所有语言程序的任何网站
是基于QQ音乐、酷狗音乐、网易云音乐等歌曲ID全自动解析的Html5音乐播放器<br>欢迎加入 <a href="https://jq.qq.com/?_wv=1027&k=MeJBm3Ts" target="_blank" class="layui-btn layui-btn-xs layui-btn-normal" style="text-decoration: none;"><i class="layui-icon layui-icon-find-fill"></i> 交流群</a></p>
                                </blockquote>
                                <div class="author_wrap">
                                    <div class="leftbox">
                                        <div class="about_image_wrap parallax" data-relative-input="true">
                                            <div class="image layer" data-depth="0.1">
                                                <img src="static/index/image/player.png" alt="picture">
                                                <div class="inner" data-img-url="static/index/image/player.png"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rightbox">
                                        
                                <div class="layui-form layui-form-pane">
                                <div class="layui-form-item">
                                	<blockquote class="layui-elem-quote" style="margin: 10px 0;font-size:unset">
                                		注册后添加播放器获取简短代码插入到自己页面底部&lt;/body&gt;之前即可使用播放器</b>
                                        
                                    </blockquote>
                                </div>
                                <div class="layui-form-item">
                                    <blockquote class="layui-elem-quote layui-quote-nm" style="font-size:unset">
                                        <b style="color:#f00">（非必要）</b>如果提示jQuery问题，将此段代码插入到网站的&lt;header&gt;，或播放器代码之前
                                    </blockquote>
                                    <textarea id="script_code" class="layui-textarea" style="font-size:12px">&lt;script src="//lib.baomitu.com/jquery/3.4.1/jquery.min.js"&gt;&lt;/script&gt;</textarea>
                                </div>
                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="as_tm_section" id="services">
                    <div class="as_tm_services_wrap">
                        <div class="container">
                            <div class="as_tm_title_holder">
                                <h3>功能</h3>
                                <span>功能丰富 / 完美兼容</span>
                            </div>
                            <div class="list_wrap">
                                <ul>
                                    <li>
                                        <div class="inner">
                                            <div class="icon">
                                                <i class="fa fa-music"></i>
                                            </div>
                                            <div class="title_service">
                                                <h3>多种来源</h3>
                                            </div>
                                            <div class="text">
                                                <p>支持多个音乐平台解析，歌单调用，搜索添加，支持自定义歌曲播放</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="inner">
                                            <div class="icon">
                                                <i class="fa fa-list-ol"></i>
                                            </div>
                                            <div class="title_service">
                                                <h3>多列表专辑</h3>
                                            </div>
                                            <div class="text">
                                                <p>多个列表随心切换，想听哪个专辑听哪个，可添加无限个音乐专辑，无限首歌曲</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="inner">
                                            <div class="icon">
                                                <i class="fa fa-rocket"></i>
                                            </div>
                                            <div class="title_service">
                                                <h3>安装简易</h3>
                                            </div>
                                            <div class="text">
                                                <p>播放器自动生成短代码调用，并提供配套插件，后台任何修改实时更新，无需修改代码，无需安装插件</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        <div class="inner">
                                            <div class="icon">
                                                <i class="fa fa-magic"></i>
                                            </div>
                                            <div class="title_service">
                                                <h3>个性自定义</h3>
                                            </div>
                                            <div class="text">
                                                <p>播放器会根据专辑图片主色调，自动改变主体，歌词文字等色彩，可自由设置/开启全部个性化功能</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="inner">
                                            <div class="icon">
                                                <i class="fa fa-mobile-phone"></i>
                                            </div>
                                            <div class="title_service">
                                                <h3>设备兼容</h3>
                                            </div>
                                            <div class="text">
                                                <p>采用响应式设计，无论电脑、手机、平板均可使用，100%完美兼容您的设备</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="inner">
                                            <div class="icon">
                                                <i class="fa fa-thumbs-o-up"></i>
                                            </div>
                                            <div class="title_service">
                                                <h3>完善售后</h3>
                                            </div>
                                            <div class="text">
                                                <p>从购买，开通，使用到部署网站，均提供完整技术支持，并有售后群和专业人员解决问题，自由交流</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="as_tm_section" id="users">
                    <div class="as_tm_testimonials_wrapper_all">
                        <div class="as_tm_universal_box_wrap">
                            <div class="bg_wrap">
                                <div class="overlay_image testimonial jarallax" data-speed="0"></div>
                                <div class="overlay_color testimonial"></div>
                            </div>
                            <div class="content testimonial section-funinfo">
                                <div class="container">
                                    <div class="row">
                                    <div class="col-xs-6 col-sm-3">
                                        <div class="count-block">
                                            <div class="count-icon animate pulse" style="color: white;">
                                                <i class="fa fa-users"></i>
                                            </div>
                                            <div class="count-amount animate zoomIn" data-from="25" data-to="<?php echo htmlentities($data['users']); ?> " style="visibility: visible; animation-name: zoomIn;"><?php echo htmlentities($data['users']); ?>                                       </div>
                                            <div class="count-name">用户数量</div>
                                        </div>
                                    </div>
									<div class="col-xs-6 col-sm-3">
                                            <div class="count-block">
                                                <div class="count-icon animate pulse" style="color: white;">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </div>
                                                <div class="count-amount animate zoomIn" data-from="25" data-to="<?php echo htmlentities($data['players']); ?>" style="visibility: visible; animation-name:
                                                zoomIn;"><?php echo htmlentities($data['players']); ?>   </div>
                                            <div class="count-name">播放器数量</div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-3">
                                        <div class="count-block">
                                            <div class="count-icon animate pulse" style="color: white;">
                                                <i class="fa fa-file-text-o"></i>
                                            </div>
                                            <div class="count-amount animate zoomIn" data-from="25" data-to="<?php echo htmlentities($data['sheets']); ?> " style="visibility: visible; animation-name: zoomIn;"><?php echo htmlentities($data['sheets']); ?>                                               </div>
                                            <div class="count-name">歌单数量</div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-3">
                                        <div class="count-block">
                                            <div class="count-icon animate pulse" style="color: white;">
                                                <i class="fa fa-music"></i>
                                            </div>
                                            <div class="count-amount animate zoomIn" data-from="25" data-to="<?php echo htmlentities($data['songs']); ?>  " style="visibility: visible; animation-name: zoomIn;"><?php echo htmlentities($data['songs']); ?>                                               </div>
                                            <div class="count-name">歌曲数量</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="as_tm_section">
            	<div class="as_tm_news_wrap">
            		<div class="container">
            			<div class="as_tm_title_holder">
            				<h3>TA们</h3>
            				<span>忠实用户 / 最新活跃</span>
            			</div>
            			<div class="as_tm_list_wrap">
            				<div class="container"><ul class="item-list">
							<?php if(is_array($users) || $users instanceof \think\Collection || $users instanceof \think\Paginator): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
							<li><a title="<?php echo htmlentities($v['regtime']); ?>"><img src="https://q2.qlogo.cn/headimg_dl?bs=qq&dst_uin=<?php echo htmlentities($v['qq']); ?>&spec=100" alt="icon" class="icon"> <p><?php echo hideStr($v['username'],2,2); ?></p></a></li>
							<?php endforeach; endif; else: echo "" ;endif; ?>
							</ul></div>
            			</div>
            		</div>
            	</div>
            </div>
            <div class="as_tm_section" id="good">
                <div class="as_tm_services_wrap" style="
    margin-top: 70px;
">
                    <div class="container">
                        <div class="as_tm_title_holder">
                            <h3>优势</h3>
                            <span>只有对比 / 才有伤害</span>
                        </div>
                        <div class="list_wrap">
                            <ul>
                                <li>
                                    <div class="inner">
                                        <div class="icon">
                                            <i class="fa fa-flash"></i>
                                        </div>
                                        <div class="title_service">
                                            <h3>极速加载</h3>
                                        </div>
                                        <div class="text">
                                            <p>播放器一旦成功加载歌单，下次访问无需重载歌单，优先秒加载播放器并播放</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon">
                                            <i class="fa fa-flag"></i>
                                        </div>
                                        <div class="title_service">
                                            <h3>播放记忆</h3>
                                        </div>
                                        <div class="text">
                                            <p>无论播放到哪一首，哪一秒，或调整音量，暂停播放，下次访问播放器将会记忆重载</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon">
                                            <i class="fa fa-bar-chart"></i>
                                        </div>
                                        <div class="title_service">
                                            <h3>数据统计</h3>
                                        </div>
                                        <div class="text">
                                            <p>后台可查看每个播放器最近一周播放量，歌曲来源，访客浏览器等详细统计信息</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <div class="inner">
                                        <div class="icon">
                                            <i class="fa fa-check-square-o"></i>
                                        </div>
                                        <div class="title_service">
                                            <h3>智能纠错</h3>
                                        </div>
                                        <div class="text">
                                            <p>播放过程中一旦发现歌单某歌曲无法正常播放，所有播放器歌单将不再加载本歌曲，同时歌单管理标记本歌曲已失效</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <div class="title_service">
                                            <h3>独立主页</h3>
                                        </div>
                                        <div class="text">
                                            <p>播放器可绑定二级域名直接访问独立主页并搜索、播放、下载，也可生成源码放在自己网站，使用自己域名访问</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="inner">
                                        <div class="icon">
                                            <i class="fa fa-handshake-o"></i>
                                        </div>
                                        <div class="title_service">
                                            <h3>技术支持</h3>
                                        </div>
                                        <div class="text">
                                            <p>播放器从内核到控制台，历经多年研发，具备成熟、稳定、专业的技术支撑，分钟级别解决一切BUG</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="as_tm_section" id="news">
                <div class="as_tm_news_wrap">
                    <div class="container">
                        <div class="as_tm_title_holder news">
                            <h3>版本</h3>
                            <span>一次购买终身免费</span>
                        </div>
                        <div class="as_tm_list_wrap">
                           <div class="col-sm-6">
                                <div class="pricing-tab">
                                    <div class="package-title">免费版</div>
                                    <div class="package-price">
                                        <span>￥0</span>/元
                                    </div>
                                    <ul class="package-advantage">
                                        <li>适合：仅体验且不在意细节功能人群</li>
                                        <li>优点：注册即可永久免费使用</li>
                                        <li>缺点：功能被限制，不支持KSC歌词</li>
                                        <li>播放器仅可添加一个站点授权</li>
										<li>不可使用播放器换肤功能</li>
                                        <li>不提供任何技术支持（仅交流群）</li>
                                    </ul>
                                </div>
                            </div>
							 <div class="col-sm-6">
                                <div class="pricing-tab">
                                    <div class="package-title">付费版</div>
                                    <div class="package-price">
                                        <span>￥<?php echo config('web.vipmoney'); ?></span>/元
                                    </div>
                                    <ul class="package-advantage">
                                        <li>适合：重度使用的网站且需求最完整功能</li>
                                        <li>优点：无限添加站点,支持KSC歌词</li>
                                        <li>开放KSC歌词使用</li>
										<li>多款精品皮肤免费使用</li>
                                        <li>可无限添加播放器授权站点</li>
                                        <li>提供售后技术服务</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="as_tm_section" id="contact">
                
                <div class="as_tm_footer_contact_wrapper_all">
                    <div class="as_tm_footer_wrap">
                        <div class="container">
                            <p>&copy; 2019 - 2021 <i class="fa fa-heart heart"></i> <?php echo config('web.webname'); ?> 版权所有</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="as_tm_totop" href="#!"></a>
</div>
</div>
<style type="text/css">
    /* 防止闪烁 */
    [v-cloak] {
        display: none;
    }
    .containers{
        margin: 30px;
    }
    .item-list a{
        display: block;
        margin: 0 auto;
        color: #000;
        text-decoration: none;
        font-size: 14px;
        padding: 15px;
        text-shadow: 0 0 1px #666;
        font-weight: 300;
        border-radius: 4px;
    }
    .item-list a p{
    	margin-top: 10px;
    }
    .item-list a:hover {
        background-color: rgba(0, 0, 0, .1);
    }
    .item-list li {
        margin: 20px;
        float: left;
        list-style-type: none;
        text-align: center;
    }
    .item-list li img {
        display: block;
        width: 100px;
        height: 100px;
        box-shadow: 0 0 0 4px rgba(0,0,0,.1);
        border-radius: 50%;
    }
    @media screen and (max-width:560px){
        .item-list li{margin:10px}
    }
    #tooltip{position:absolute;z-index:99999999;display:none;padding:4px 8px;border:1px solid rgba(255,255,255,.25);border-radius:3px;background-color:#000;color:#fff;text-align:center;font-size:12px}
#tooltip:before{position:absolute;top:-6px;left:15px;width:0;height:0;border:6px dashed #000;border-top:0;color:#fff;content:' ';line-height:0;border-bottom-style:solid;border-left-color:transparent;border-right-color:transparent}
</style>
<script>if(document.all&&document.addEventListener&&window.atob){alert("您正在使用的浏览器版本过低，为了您的最佳体验，请先升级浏览器。");window.location.href="http://support.dmeng.net/upgrade-your-browser.html?referrer="+encodeURIComponent(window.location.href)}</script>
<script src="static/index/js/vue.js"></script>
<script src="static/index/js/plugins-20191012.js"></script>
<script>function as_tm_home_text(){"use strict";var animateSpan=jQuery('.as_home_text_word');animateSpan.typed({strings:["基于QQ音乐、网易云音乐、酷狗音乐等平台歌曲ID全自动解析的Html5浮窗音乐播放器","歌单调用、歌手调用、歌单导入、搜索添加、自定义、多个音乐平台支持、无限歌单","域名授权、个性主页、动态变色、滚动歌词、动态提示、任意自定义、兼容任何网站","致力于提供稳定高效的免费音乐播放器服务，支持各种语言的任意类型网站"],loop:true,startDelay:1e3,backDelay:5e3})}</script>
<script src="static/index/js/image-loaded.js"></script>
<script src="static/index/js/jquery.countto.js"></script>
<script src="static/index/js/app-20190821.js"></script>
</body>
</html>
