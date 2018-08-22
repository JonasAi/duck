<?php

// 已弃用该文件,请使用 routes 目录文件替代
die('已弃用该文件,请使用 routes 目录文件替代');
use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/hello/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

// 测试
$app->post('/test', function ($request, $response, $args) {
 		// Create new book
		echo 'books 路由';

		// Render index view
    return $this->renderer->render($response, 'books.phtml', $args);
});

$app->get('/user[/{params:.*}]', function ($request, $response, $args) {

var_dump($this);die;

$this->getName('chunhui');
var_dump(api\user\User::class);
		// $params = explode('/', $request->getAttribute('params'));
		// var_dump($params);

  //   // $params is an array of all the optional segments
		// var_dump($request);
		// // var_dump($response);
		// // var_dump($args);
		// die;
 	// 	// Create new book
		// echo 'books 路由';

		// $user = new api/user/user();

		// Render index view
    return $this->renderer->render($response, 'books.phtml', $args);
});