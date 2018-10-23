<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/test_{action}[/{params:.*}]', '\Api\Test\Test');


