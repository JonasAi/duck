<?php

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