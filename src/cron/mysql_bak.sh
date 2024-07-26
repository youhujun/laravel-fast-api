# /bin/sh
###
 # @Descripttion: 
 # @version: v1
 # @Author: youhujun 2900976495@qq.com
 # @Date: 2024-07-21 07:29:24
 # @LastEditors: youhujun 2900976495@qq.com
 # @LastEditTime: 2024-07-21 07:30:53
 # @FilePath: d:\wwwroot\Working\PHP\Components\Laravel\youhujun\laravel-fast-api-base\cron\mysql_bak.sh
### 

time=$(date "+%Y%m%d%H%M%S")
mysqldump -u用户名 -p密码% 数据库名 >  路径/数据库名$time.sql