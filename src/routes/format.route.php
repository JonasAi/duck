<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/fun_{action}', '\Api\Format\Format');