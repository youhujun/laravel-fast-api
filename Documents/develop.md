
# laravel-fast-api 开发思路

## 整体思路

laravel-fast-api全程贯穿的理念是数据库设计松耦合,代码结构松耦合.方便业务开发人员后续轻松维护和拓展.

以下说明:需要在执行完laravel-fast-api的发布命令以后

- 路由区分业务模块定义

- 控制器只负责接受和处理参数以及权限校验

- 业务逻辑放在门面服务中处理,门面服务原则上只处理业务主表,其余关联结合事件,队列任务执行

- 除了Model不带后缀以外,其余模块均带有后缀名称

- 数据库设计阶段,要注意表的垂直拆分,因此产生的关联表,在业务逻辑中以预加载的方式查询,其他负责业务逻辑处理放置在Resource响应阶段处理


## 特别提示:

- laravel自带的表单验证失败,返回422响应,在uniapp以及Apipost中无法正常接收失败的返回响应.所以laravel-fast-api,采用自定义验证规则,封装了公共异常处理,截断response响应,直接以异常形式抛出json响应.此种做法同时缩短了在验证失败以及业务逻辑处理异常的响应处理周期.

- 授权策略的权限处理Gate和Policy和消息通知Notificaiton可以参考示例

## 模版说明

以下模版都可以在开发新业务前提下,发挥copy技能.

### 路由模版

routes\api\template.php

### 控制器模版

- 修改后的stub

```
php artisan make:controller 路径/控制器Controller
```

- 模版

app\Http\Controllers\AdminReplaceController.php

<br/>

app\Http\Controllers\PhoneReplaceController.php

### 自定义验证规则模版

- 修改后的stub

```
php artisan make:rule 路径/验证规则Rule
```

- 模版

```
app\Rules\ReplaceRule.php
```

### 门面模版

- 修改后的stub

```
php artisan call:facade 路径/门面Facade
```

- 模版 laravel-fast-api 封装了两个Trait,自行研究调试

app\Service\Facade\ReplaceAdminListService.php

<br/>

app\Service\Facade\ReplaceAdminTreeService.php

### 事件模版

- 修改后的stub

```
php artisan make:event 路径/事件Event

php artisan make:listen 路径/事件Event/事件回调Listener

```

- 模版

app\Events\RepalceEvent.php

<br/>

app\Listeners\ReplaceListener.php



### 公共异常影响码处理

查看config\custom 下的admin,phone,public目录

### 模型模版

- 修改后的stub

```
php artisan make:model 路径/模型
```

- 模版

app\Models\Replace.php

### 队列任务模版

- 修改后的stub

```
php artisan make:job 路径/队列Job
```

- 模版

```
app\Jobs\ReplaceJob.php

```

### 响应资源模版

- 修改后的stub

```
php artisan make:resouce 路径/响应资源Resource

php artisan make:resouce 路径/响应资源集合Collection

```

- 模版

```
app\Http\Resources\ReplaceResource.php

app\Http\Resources\ReplaceCollection.php
```

### 数据迁移模版

- 修改后的stub

```
php artisan make:migration create_表名_table
```

### 数据填充模版

- 修改后的stub

php artisan make:seed 路径/数据填充Seeder