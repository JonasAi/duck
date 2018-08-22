<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();
// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app      = new \Slim\App($settings);

/** 只支持自动加载 php | inc 扩展名的文件 */
function isValidFile($file)
{
    // 非文件
    if ($file == '.' || $file == '..' || is_dir($file)) {
        return false;
    }

    // 只支持自动加载 php 和 inc 为后缀的文件
    if (in_array(getExtName($file), ['php', 'inc'])) {
        return true;
    }

    return false;
}

/** 获取文件扩展名 */
function getExtName($file)
{
    $extName = '';
    if (is_dir($file)) {
        return $extName;
    }
    $arr     = explode('.', $file);
    $extName = array_pop($arr);
    return $extName;
}

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
// require __DIR__ . '/../src/routes.php';

// 自动加载 routes 目录
$routesDir = __DIR__ . '/../src/routes/';
if (is_dir($routesDir)) {
    $files = scandir($routesDir);
    foreach ($files as $k => $v) {
        if ( ! isValidFile($v)) {
            continue;
        }
        require $routesDir . $v;
    }
}
// Run app
$app->run();