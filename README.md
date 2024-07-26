
# youhujun/laravel-fast-api

<p align="center">基于Laravel开发的API和vue基础功能项目，可以用于系统的快速开发(Laravel based on the development of API and vue basic functional projects, can be used for rapid development of the system )</p>

## 1描述(describe)

### 1.1前言
基于Laravel开发的API和vue基础功能项目，可以用于系统的快速开发

<br/>

Laravel based on the development of API and vue basic functional projects, can be used for rapid development of the system 

github版本[laravel-fast-api:github](https://github.com/youhujun/laravel-fast-api.git)
国内版本[laravel-fast-api:gitee](https://gitee.com/youhujun/laravel-fast-api.git)

<br/>

此项目需要结合 [youhu-element-admin:github](https://github.com/youhujun/youhu-element-admin.git) 以及 [youhu-uniapp:github](https://github.com/youhujun/youhu-uniapp.git)

<br/>

国内版本 [youhu-element-admin:gitee](https://gitee.com/youhujun/youhu-element-admin.git) 以及 [youhu-uniapp:gitee](https://gitee.com/youhujun/youhu-uniapp.git)

<br/>

此项目运行前提需要 安装 Redis,Swoole,Imagick以及Node,Node安装完成以后,需要安装laravel-echo-server和supervisor.请自行安装

### 1.2背景

#### 1.2.1分析

- 国内存在众多开源项目,因此许多小微公司基于这些开源项目去做二次开发来实现业务.在缺乏资金,人手不足的情况下,又急于实现业务逻辑.导致项目虽然上线,但是却充斥bug,最令人头疼的是,数据库设计以及代码结构设计都存在不合理性.后续维护的开发人员只能在屎山代码上继续堆积屎山代码.这不是个例,而是本人在实践中发现基本皆是如此!
- 如此做法的最终结果是,虽然业务勉强上线,然而因为bug众多,数据库设计和代码的耦合性太强,导致业务无法健康开展,后续规划也基本化为泡影,这个时候的领导层即使意识到问题,因为前期花费了大量时间和金钱.因此只能在此基础上继续维护.为何?重新开发时间周期太长,时间成本和金钱成本都不允许.同时也没有更好的解决方案了.

#### 1.2.2最佳实践
- 为了改善以上情况,经过多年沉淀积累,以laravel框架为基础研发laravel-fast-api作为最佳实践.该开源项目本身最大优势在于在开发同样业务逻辑的情况下,实现了数据库设计的解耦以及代码的解耦,在基础业务逻辑已经实现同时,理所当然的也提供了大量示例.从而为后续开发工作的拓展和维护提供了有力保障和支撑.

#### 1.2.3优缺点对比

##### 缺点

- 相比较其他开源项目,开发时需要花费的时间相对较长.数据库设计最初就做了分表处理,代码也是松耦合的方式.
- laravel框架本身比较重,对于php初学者而言,需要学习成本.
- 业务实现需要一定的运维知识,需要安装的依赖较多,需要登录大量的第三方账号去配置

##### 优点
- 基础业务逻辑已经实现,与此同时也意味着有着大量的最佳实践代码示例.既可以提升速度和效率,也省去了大量学习成本.
- 虽然相对的开发周期变长,但是后续业务代码易维护,易拓展.只要开发者遵循开发规范,后续不会存在屎山代码问题
- 完善的开发文档,相比较其他开源项目,laravel-fast-api最初就以Apipost开发工具进行,形成了完备的开发文档.
- 为了提升业务逻辑实现效率,前端vue和uniapp封装了大量组件和Template示例模版,后端laravel在路由(route),控制器(controller),模型(model),门面服务(facade和facadeService),事件(event和listen),队列(Job),数据迁移(migration),自由定义验证规则(Rule),资源响应(Resource)等等,都分别准备了修改后的stub和包含Replace的替换模版

----
以上就是简单的优缺点对比,如何提升开发效率,以及开发思路和规范阅读 [laravel-fast-api开发思路和说明](./Documents/develop.md),同时需要结合下面的内置功能梳理总结.

### 1.3内置功能梳理总结

提示:以下功能的实现是结合vue-element-admin和uniapp实现的.不可分割

- 单点登录,后台登录会在12小时后执行退出job自动退出.手机端没有该任务
- 后台菜单管理,以及权限和角色管理,并结合Gate和Policy实现了粒度级权限控制
- 用户管理,管理员管理,所有的角色用户都基于用户产生.同时有独立表和模型,与此同时,用户查看数据交由权限管理来处理,其余的用户登录,退出,其他操作例如增加,修改,删除,上传文件都有相应的事件日志记录
- 图片空间-我的相册,无论是后台还是用户的一些静态图片资源,都由这里统一控制.同时基于七牛云封装了云存储桶处理,在后台配置好相应参数即可开启.
- 表格导入导出,微信登录(包含主动授权和静默授权),app一件登录(结合uniapp),手机验证码登录(结合腾讯云短信服务),二维码,腾讯地图,微信支付等第三方业务实现,是通过门面服务下的Public作为第三方公共服务层.但是在具体业务实现中,并不是直接调用,而是再建立一个业务中间层的门面服务.在业务中间层的门面服务中去调用.这样做的目的是为了在同一功能是实现时轻松拓展切换其他第三方服务.例如:支付宝支付,阿里短信业务等.
- 众多第三方业务功能对接实现,其参数配置可以在后台的系统配置-参数配置中去灵活配置.之后可以视情况添加到自定义的数据填充中.
- socket通讯,后台管理基于node,redis的发布订阅,结合Laravel的队列和事件机制实现,并且事件提示音配置可以在后台配置.手机端(这里是指uniapp)结合swoole实现,值得一提的是,其中也需要redis作为中间层支持.并且因为该服务是以门面服务层,结合自定义命令实现,因此在整个项目启动运行的同时,根绝业务开发情况,结合redis可以轻松获取到相应的操作数据和状态.

### 1.5效果预览

提示:预览效果是放置在开发服务器上,因为开发调试需要,不保证持续稳定.如果无法在线预览,请自行安装调试程序查看效果.

[后台管理系统](https://dadmin.youhujun.com)

示例账号:

<br/>

super

示例账号密码:

<br/>

abc321

<p align="center">
  <img width="900" src="https://qiniu.youhujun.com/laravel-fast-api/images/admin_01.png">
</p>


[手机端](https://dh5.youhujun.com)

示例账号:

<br/>

super

示例账号密码:

<br/>

abc321

<p align="center">
  <img width="600" src="https://qiniu.youhujun.com/laravel-fast-api/images/phone_01.png">

</p>


## 2安装(Installing)

```shell
$ composer require youhujun/laravel-fast-api
```


## 3发布(Publish)

### 3.1发布前准备

- 3.1.1发布开发模版

```
php artisan stub:publish
```

- 3.1.2 将laravel自身位于database\migrations数据库迁移文件移除

### 3.2执行发布命令

- 3.2.1执行覆盖发布

```
php artisan vendor:publish --tag=cover --force
```
- 3.2.2执行普通发布

```
php artisan vendor:publish --tag=init 
```
- 3.2.3 建立公共资源软链接

```
php artisan storage:link
```

-3.2.4如果是二次安装需要

重新发布静态资源

```
php artisan vendor:publish --tag=static --force
```

重新发布替换模版

```
php artisan vendor:publish --tag=stub --force
```

### 3.3调整 config下的配置文件以及.env配置文件 

- config\app.php
- config\database.php
- config\auth.php
- config\logging.php
- config\broadcasting.php
- config\queue.php
- config\mail.php

因为需要调整的内容较多,不在这里详述.可以添加下方的游鹄交流群获取配置文档

## 4填充基本数据

### 4.1执行数据库迁移

在.env处配置好数据库配置

```
php artisan migrate
```
### 4.2填充基础数据

```
php artisan db:seed --class=DatabaseSeeder
```

## 5配置配置伪静态访问

- 注意跨目录访问问题
类似于如下需要注释掉
```
#fastcgi_param PHP_ADMIN_VALUE "open_basedir=$document_root/:/tmp/:/proc/";
```
- 配置伪静态

```
location /
{
 	try_files $uri $uri/ /index.php?$query_string;
}
```
注意在此事前需要完成修改调整.env环境变量以及相关配置文件.

### Linux下需要更改访问权限

```
chmod -R 0755  bootstrap/cache

chmod -R 0755 storage/
```

## 6开发,调试和运行

### 6.1生成门面代理以及门面服务(Generate a facade agent and a facade service)

```
php artisan call:facade 路径/名称
```

示例(for example):

```
php artisan call:facade Test/TestFacade
```
执行完成以后会提示门面代理和和门面服务创建成功

### 6.2调整任务调度 app\Console\Kernel.php

#### 6.2.1 前提启动调度器

该 Cron 会每分钟调用一次 Laravel 的命令行调度器。在执行 schedule:run 命令时，Laravel 会根据你的调度执行预定的程序。  
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

#### 6.2.3已经放置好了每天备份数据库的shell脚本以及执行统计数据的命令
- 每天备份数据库的脚本 cron\mysql_bak.sh 自行配置参数即可
- 每天执行的数据统计 app\Console\Commands\ExecuteTotalCommand.php 实际上可以看出实际业务逻辑是在执行App\Facade\Common\Total\TotalAllDataFacade 数据统计门面,可以根据自身情况去完善或者根据不同业务需要分别创建其他门面在其中调用.特别提示:注意不要过度滥用门面

### 6.3开发文档

游鹄采用Apipost作为接口开发调试工具,既可以在线调试,也可以方便的生成文档.也可以方便的同Postman,Apifox等工具对接.如下所示,可以添加下方的游鹄交流群获取开发文档

提示:已经配置好相应的预执行脚本和后执行脚本,同时为了方便调试也专门为了调试测试准备相关接口,可以说是laravel-fast-api的必需品.

![apipost示例](https://qiniu.youhujun.com/laravel-fast-api/images/develop_api_post.png)

### 6.4运行

- 运行前提是安装好必要的扩展以及node

开启队列
```
php artisan queue:work
```

socket通讯不是必须的,如果不需要可以不做以下操作.前端代码自行注释掉即可

- 开启后台管理socket通讯:
特别提示:因为生产环境与开发环境会有所不同,为了开发调试方便,准备了两份laravel-echo-server.example文件,一份在项目根目录下,一份在laravel-echo-server目录下,这样做的用意是为了开发调试方便,可以同时运行.
```
laravel-echo-server start
```
- 开启手机端sokcet通讯:

```
php artisan websocket:serve
```

注意:生产环境下需要supervisor和日志切割,因为需要配置内容较多,不在这里详述.可以添加下方的游鹄交流群获取配置文档

### 6.5配置处理

系统在系统设置-系统配置-参数配置处,预留了配置.其中二维码logo配置必须要配置.因为每一名用户会自动生成自己所属的二维码.因此需要
上传一下二维码logo


## 声明:

这份开源使用声明适用于使用和分发的开源软件。请仔细阅读以下条款，如果您不同意这些条款，请不要使用或分发该软件。
- 1.本软件是免费开源软件，授权给任何个人和组织使用、复制、修改、合并、发布、分发和销售。

- 2.您可以自由使用本软件用于个人和商业用途，无需支付任何费用。

- 3.您可以通过任何渠道获取和分发本软件的全部或部分代码。

- 4.您可以对本软件进行修改和衍生，但必须在代码中注明原作者和版权信息。

- 5.如果您修改了本软件或者基于本软件进行开发，您需要在您的修改或开发的产品中包含一份本软件的开源使用声明，并在适当的位置注明原作者和版权信息。

- 6.您在使用本软件时，应承担使用风险，并自行负责软件的适用性和安全性。

- 7.原作者不对本软件的任何使用方式负任何责任，包括但不限于直接或间接的损失或损害。

- 8.本软件不附带任何担保或保证，无论明示或暗示，包括但不限于适销性、特定用途适用性和非侵权性。

- 9.本软件可能包含第三方的开源组件或库，这些组件或库受其各自的许可证限制。在使用本软件时，您也需要遵守这些许可证限制。

- 10.您不得使用本软件进行非法活动、侵犯他人权益或违反相应法律法规，如发现相关违规行为，原作者有权终止您使用本软件的权利。

- 11.原作者保留随时修改本开源使用声明的权利，修改后的声明将在原作者的官方网站或代码仓库上公布

  感谢您使用本软件!如果您对软件有任何问题或建议，请与原作者联系。

## 展望(彩蛋)

- laravel-fast-api的开源不以盈利为目的,而是为了给系统面临重构或者新项目开发提供一套解决方案.

- 于此同时,也宣告者游鹄生态系统正式迈入业务开发阶段,距离游鹄生态系统上线开始进入倒计时.为此开源laravel-fast-api也是为了寻找有相同认知,并认可游鹄价值理念的开发者以及相关人员(UI设计,产品经理)一起完成这一壮举.[游鹄生态系统介绍](./Documents/youhu.md)

## 赞赏(appreciates)

![微信赞赏](https://qiniu.youhujun.com/laravel-fast-api/images/wechat_like.jpg)


## 交流(communication)

- 扫描下方二维码,可加微信好友:

Scan the qr code below, you can add WeChat friends:

![游鹄君微信二维码](https://qiniu.youhujun.com/laravel-fast-api/images/wechat_youhujun.jpg)

<br/>

- 扫描下方二维码,可加QQ游鹄交流群:587689894

![游鹄qq交流群](https://qiniu.youhujun.com/laravel-fast-api/images/youhu_group_qq.png)

<br/>

- 扫描下方二维码,可以关注游鹄微信公众号:

![游鹄微信公众号](https://qiniu.youhujun.com/laravel-fast-api/images/qrcode_for_gh_12.jpg)

## 许可(License)

[MIT](https://github.com/youhujun/laravel-fast-api/blob/master/LICENSE)

Copyright (c) 2024 游鹄君(YouHuJun)