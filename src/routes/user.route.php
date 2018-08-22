<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/userv2_{action}[/{params:.*}]', '\Api\User\UserV2');

$app->post('/user_{action}[/{params:.*}]', function ($request, $response, $args) {
// TODO 读取 header 预留以后做验证 OAuth2 | JWT
		// $headers = $request->getHeaders();
		// foreach ($headers as $name => $values) {
		//     echo $name . ": " . implode(", ", $values);
		// }	



var_dump($args);die;


$user = $this->user;
$user->getUsers();
// $data = $request->getParsedBody();
// var_dump($data);die;
	// $a = $this->Api\User\User::class;
	// var_dump($a);
	die;
	$params = explode('/', $request->getAttribute('params'));
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


