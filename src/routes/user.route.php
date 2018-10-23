<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/user_{action}[/{params:.*}]', '\Api\User\User');
