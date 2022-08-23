# XPlayerConsole

#### 介绍
基于thinkphp6开发的XPlayerHTML5网页播放器前台控制面板,支持多音乐平台音乐解析。
![预览图](https://images.gitee.com/uploads/images/2020/1024/154802_b031a386_2143538.png "QQ图片20201024154837.png")

#### 技术栈
后端：thinkphp 6
前端：layui
数据库：mysql

#### 依赖
composer
php 7.1+
mysql 5.5+

#### 伪静态配置
nginx

```
location / {
      index  index.htm index.html index.php;
      #访问路径的文件不存在则重写URL转交给ThinkPHP处理
      if (!-e $request_filename) {
         rewrite  ^/(.*)$  /index.php?s=$1  last;
         break;
      }
  }
```
apache
项目自带apache静态化无需配置
#### 安装
1. 导入根目录install.sql到数据库
2. 配置config/database.php数据库信息
3. 默认账户 admin 123456
4. 开放函数popen和proc_open

#### 参与开发

- Ocink 2491000000@qq.com
- 文曲兰 <https://www.wenqulan.com/>
- 梨花带雨播放器 <https://music.m0x.cn/>

#### 赞赏
![赞赏](https://images.gitee.com/uploads/images/2020/1024/154537_900e191f_2143538.jpeg "43c81787c3defea75044fb63b58bb6a.jpg")

#### 版权信息
ThinkPHP遵循MIT开源协议发布，并提供免费使用。

版权所有Copyright © 2020 by Ocink (https://gitee.com/ocink)

All rights reserved。

点击链接加入群聊【XPlayer】：https://jq.qq.com/?_wv=1027&k=cnPMbat3
