<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/page/{page}[/{d:.*}]', function($request, $response, $args){
    $params = explode('/', $request->getAttribute('d'));
//    var_dump($params);
    $template = $args['page'].'.phtml';
    if (!file_exists(__TEMPLATES__.$template)) {
        throw new Exception('页面文件不存在');
    }

    return $this->view->render($response, $template, $params);
});
