README.md
-------------------------
文件说明: `本目录用于前端访问接口目录`
## 版本说明
    1. 该目录下每个文件夹代表一个版本,进化曲线为
        `apes(猿猴)` -> `human(人类)` -> `hero(英雄)`
### login
    1. 用于接口auth 服务
    2. 里边应该有一个基础类,然后通过继承实现不同的类
    3. 为正常使用需要在 autoload 中增加注册
        conposer.json文件中修改该部分,增加对应目录,完成后
        ```php
            "autoload-dev": {
                "psr-4": {
                    "Tests\\": "tests/",
                    "Api\\":"api/",
                    "Lib\\":"lib/"
                }
            },
            "autoload":{
                "psr-4":{
                    "Api\\":"api/",
                    "Lib\\":"lib/"
                }
            },
        ```
        完成后更新 composer 中的 autoload [--optimize] 优化自动加载效率,可选
        `composer dump-autoload [--optimize]`
