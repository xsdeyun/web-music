DROP TABLE IF EXISTS `ocink_configs`;
CREATE TABLE IF NOT EXISTS `ocink_configs` (
  `k` varchar(255) NOT NULL DEFAULT '',
  `v` text,
  PRIMARY KEY (`k`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `ocink_configs` (`k`, `v`) VALUES
('webname', '梨花带雨音乐播放器'),
('title', '免费稳定的HTML悬浮播放器'),
('keywords', '梨花带雨音乐播放器,HTML5悬浮音乐播放器,网页音乐播放器,JQ音乐播放器'),
('description', '梨花带雨音乐播放器,HTML5悬浮音乐播放器,网页音乐播放器,JQ音乐播放器'),
('regpie', '1'),
('piemoney', '1'),
('vipmoney', '1');

DROP TABLE IF EXISTS `ocink_chat`;
CREATE TABLE IF NOT EXISTS `ocink_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `qq` varchar(225) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `time` varchar(225) NOT NULL,
  `sendtime` datetime NOT NULL,
  `sendip` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ocink_player`;
CREATE TABLE `ocink_player` (
  `id` varchar(100) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL COMMENT '播放器名称',
  `user_id` varchar(32) DEFAULT NULL COMMENT '关联用户id',
  `auto_player` int(1) DEFAULT '0' COMMENT '是否自动播放',
  `phone_load` int(1) DEFAULT '0' COMMENT '手机端加载播放器',
  `random_player` int(1) DEFAULT '0' COMMENT '是否随机播放',
  `default_volume` int(3) DEFAULT '75' COMMENT '默认音量',
  `show_lrc` int(1) DEFAULT '1' COMMENT '是否显示歌词',
  `greeting` varchar(30) DEFAULT NULL COMMENT '欢迎语',
  `show_greeting` int(1) DEFAULT '1' COMMENT '是否显示欢迎语',
  `default_album` int(3) DEFAULT '1' COMMENT '默认专辑',
  `background` int(1) DEFAULT '1' COMMENT '模糊背景是否开启',
  `show_notes` int(1) DEFAULT '1' COMMENT '显示音符：0不显示1显示',
  `time` int(11) DEFAULT '1' COMMENT '几秒后弹出播放器',
  `switchopen` int(11) DEFAULT '1' COMMENT '是否弹出播放器',
  `showmsg` int(11) DEFAULT '0' COMMENT '桌面通知开关',
  `voice_msg` varchar(255) DEFAULT '你的域名没有通过授权,无法播放音乐' COMMENT '防盗提示语音文字',
  `plays` varchar(32) DEFAULT NULL COMMENT '总播放次数',
  `endtime` datetime NOT NULL COMMENT '最后播放时间',
  `theme` int(11) DEFAULT '1' COMMENT '播放器皮肤',
  `create_time` datetime DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ocink_plays`;
CREATE TABLE `ocink_plays` (
  `id` varchar(100) DEFAULT NULL,
  `player_id` varchar(32) DEFAULT NULL COMMENT '播放器id',
  `user_id` varchar(32) DEFAULT NULL COMMENT '关联用户id',
  `side` varchar(32) DEFAULT NULL COMMENT '播放客户端',
  `create_time` datetime DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ocink_links`;
CREATE TABLE `ocink_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '网站标题',
  `url` text COMMENT '网站链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ocink_order`;
CREATE TABLE IF NOT EXISTS `ocink_order` (
  `trade_no` varchar(64) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `orderid` varchar(64) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trade_no`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `ocink_pays`;
CREATE TABLE IF NOT EXISTS `ocink_pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `qq` char(20) DEFAULT NULL,
  `orderid` char(64) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `name` char(64) DEFAULT NULL,
  `money` decimal(6,2) NOT NULL DEFAULT '0.00',
  `type` varchar(10) DEFAULT NULL,
  `shop` varchar(225) DEFAULT NULL,
  `shopid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `ocink_player_auth`;
CREATE TABLE `ocink_player_auth` (
  `player_id` varchar(32) DEFAULT NULL COMMENT '播放器id',
  `domain` varchar(32) DEFAULT NULL COMMENT '授权域名',
  `remark` varchar(32) DEFAULT NULL COMMENT '网站备注'
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ocink_player_song_sheet`;
CREATE TABLE `ocink_player_song_sheet` (
  `player_id` varchar(32) DEFAULT NULL COMMENT '播放器id',
  `song_sheet_id` varchar(32) DEFAULT NULL COMMENT '歌单id',
  `taxis` int(3) DEFAULT NULL COMMENT '排序'
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ocink_song`;
CREATE TABLE `ocink_song` (
  `id` varchar(100) DEFAULT NULL,
  `song_id` varchar(32) DEFAULT NULL COMMENT '歌曲id',
  `song_sheet_id` varchar(32) DEFAULT NULL COMMENT '所属歌单',
  `name` varchar(100) DEFAULT NULL COMMENT '歌曲名称',
  `type` varchar(10) DEFAULT NULL COMMENT '歌曲类型',
  `album_name` varchar(100) DEFAULT NULL COMMENT '专辑名称',
  `artist_name` varchar(100) DEFAULT NULL COMMENT '歌手名称',
  `album_cover` varchar(100) DEFAULT NULL COMMENT '专辑图片',
  `location` varchar(150) DEFAULT NULL COMMENT '歌曲地址',
  `lyric` varchar(100) DEFAULT NULL COMMENT '歌词地址',
  `taxis` int(3) DEFAULT NULL COMMENT '排序'
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ocink_song_sheet`;
CREATE TABLE `ocink_song_sheet` (
  `id` varchar(100) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `sheet_id` varchar(20) DEFAULT NULL,
  `user_id` varchar(32) DEFAULT NULL COMMENT '歌单所属用户',
  `status` int(1) DEFAULT '0' COMMENT '状态 1:开放 0:私密',
  `name` varchar(30) DEFAULT NULL COMMENT '歌单名称',
  `author` varchar(30) DEFAULT NULL COMMENT '歌单作者',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间'
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ocink_users`;
CREATE TABLE IF NOT EXISTS `ocink_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(225) DEFAULT NULL COMMENT '用户名',
  `password` varchar(225) DEFAULT NULL COMMENT '登陆密码',
  `qq` varchar(225) DEFAULT NULL COMMENT 'QQ号码',
  `mail` varchar(225) DEFAULT NULL COMMENT '邮箱',
  `power` int(11) DEFAULT NULL COMMENT '用户权限',
  `pie` int(11) DEFAULT '0' COMMENT '播放器额度',
  `skey` text COMMENT '登录验证密钥',
  `sid` text COMMENT '登录令牌',
  `token` text COMMENT 'QQ登录验证密钥',
  `dlip` varchar(20) DEFAULT NULL COMMENT '登录ip',
  `city` varchar(255) DEFAULT NULL COMMENT '城市',
  `time` varchar(255) DEFAULT NULL COMMENT '登录时间戳',
  `regtime` datetime DEFAULT NULL COMMENT '注册时间',
  `regip` varchar(32) DEFAULT NULL COMMENT '注册IP',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `ocink_users` (`uid`, `username`, `password`, `qq`, `power`, `pie`, `skey`, `sid`, `token`, `dlip`, `city`, `time`, `regtime`, `regip`) VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2491000000', '0', '0', NULL, NULL, NULL, NULL, NULL, NULL, '2021-03-01 00:00:00', '127.0.0.1')