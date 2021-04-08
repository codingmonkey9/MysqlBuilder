## MySQL 组件使用说明

- 如果自动加载失败，在项目根目录中的composer.json文件中加入
```
"autoload": {
        "classmap": ["vendor/codingmonkey9/mysql-builder/"]
    }
```
然后执行 `composer  dump-autoload` 重新生成自动加载文件