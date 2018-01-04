# codePalace

> 这里收集了一些 web 开发中常用的代码块。目前还有很多在我之前的云笔记里，往后再慢慢移过来吧Orz

## worldPlace （全球各个国家和地方名字） ： 

	- a_place.sql ： 生成的sql文件

	- index.php ： 将xml文件转成sql文件的php脚本

	- LocList.xml ： 全球各个国家和地方名字的xml文件

## industry (2017最新行业类别) ： 

	- a_industry.sql ： 生成的sql文件

	- index.php ： 转换sql格式的php脚本，可以随意自己定制

	- industry.sql ： 原格式sql

## messageQueue (消息队列) ： 

	- in.php ： 入队脚本

	- out.php ： 出队脚本

*相对于php来说操作系统级别的事件还是用shell好，所以这里只要把这两个脚本用crontab做个定时任务就好了*

## encryption （加密相关）

	- asymmetric.php ： 使用openssl实现非对称加密

	- oneway.php ： 单向散列加密

	- priv.key ： 非对称加密生成的私钥

	- pub.key ： 非对称加密生成的公钥

	- symmetric.php ： 对称加密

## fileUpload （文件表单上传）

	- static ： fileUpload插件用到的静态资源

	- vendor ： composer的包，主要是七牛云存储的

	- advanced.html ： 插件版本文件上传的静态页面

	- advanced.php ： 插件版本文件上传的后台处理脚本

	- composer.json ： composer的配置，可以不用管

	- simple.html ： 简单版文件上传的静态页面

	- simple.php : 简单版文件上传的后台处理脚本

*一共分为简单版和插件版文件上传方式，简单版就simple.html和simple.php就够了，插件版都不能少*

## algorithm （常用算法）

	- search.php ： 查找，主要是二分法查找

	- sort.php ： 排序，冒泡排序，选择排序，插入排序，快速排序
