<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/apes_{action}[/{params:.*}]', '\Api\Apes\login');