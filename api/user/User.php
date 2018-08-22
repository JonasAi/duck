<?php

namespace Api\User;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Illuminate\Database\Query\Builder;
use Monolog\Logger;

// use Slim\Views\Twig;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class User
{

    private $view;
    private $logger;
    protected $table;

    public function __construct(Logger $logger, Builder $table) {

        // $this->view   = $view;
        $this->logger = $logger;
        $this->table  = $table;
        // parent::__construct();
    }

    public function getUsers() {
    	$rows = $this->table->get();
    	$logger
    	var_dump($rows[0]);die;
    } 

    public static function getName($name) {
    	echo $name;die;
    }
}
