## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

    composer create-project slim/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can run these commands 

	cd [my-app-name]
	composer start

Run this command in the application directory to run the test suite

	composer test

That's it! Now go build something cool.


OK. 下边是适应个人使用而做的优化方面的说明，为表对 Slim 的尊重, 以下部分使用三级标题。

### 表层目录讲解
    1. `admin` 为后台预留,这个地方计划预留为后台的接口目录,前期有可能不做前后端分离,所以单独预留后台的接口目录
    2. `api` 为 WEB端/客户端 接口预留的目录,其内包含各版本接口
    3. `lib` 为个人优化的 `lib` 库,计划写一些独立自主自力更生的内容
    4. `logs` 这个目录使用待优化,目前计划是开发版本使用该目录记日志,线上版本须重新规划
    5. `public` Slim 入口目录,计划增加一个 Cli 模式运行的入口,到时有可能增加对应脚本目录
    6. `src` 目前规划这个目录为配置文件目录,计划是开发的时候不需要打开这个目录
    7. `templates` Slim 带的模板目录,计划删除,或者新建前端项目生成静态文件到这个目录(TODO 待定)
    8. `tests` Slim 生成时的目录,计划是保留,同时用于编写一些测试的东西,需要设置开发环境执行的过滤[理论上不上线该目录]
    9. `vendor` composer 目录
    
   其他文件暂不做说明
   
#### 如何新增一个接口
    新增接口目前设置两种方式 (TODO 此处还没想好)
    1. 添加路由对应文件,即一个文件多个接口
    2. 添加路由对应方法,为一些特殊接口准备
### 开发说明
    1. 所有带版本的文件 `eg. BaseV1.php` 这种文件需要在合并到 master 的时候删除,所有版本方面的内容可以使用前缀说明,后边会预留几个版本关键词
### 版本关键词说明
    1. 接口级别(大版本)
        `1.0` apes
        `2.0` human
        `3.0` hero
       要上天的,你懂吗?
       小版本请参考方法版本关键词
    2. 文件版本(仅在文件不同版本需要共存时使用)
        1. 初版 : 后缀 `_ori`
        2. 第二版 : 后缀 `_2nd`
        3. 第三版 : 后缀 `_3rd`
        Else : 如果需要更多版本共存,请去死。
        如果需要接口需要区分平台请使用`前缀三字符小写` `ios` || `and` || `其他` 区分
    4. 接口版本(小版本,仅接口更新,对应到方法)
        写 `_v1`,`_v2`,`_v3` 不能再多了!
### 代码规范
    1. 代码规范文件
       `phpstorm: ` ...
    2. 不允许使用 tab, tab === 四个空格 
    3. 其他.. 一点点来吧,还没想好
        