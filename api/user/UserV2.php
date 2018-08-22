<?php

namespace Api\User;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Illuminate\Database\Query\Builder;
use Monolog\Logger;
use Api\Base;
use Lib\Lang;

// use Slim\Views\Twig;

/**
 * This is an example class that shows how you could set up a method that
 * runs the application. Note that it doesn't cover all use-cases and is
 * tuned to the specifics of this skeleton app, so if your needs are
 * different, you'll need to change it.
 */
class UserV2 extends Base
{

    private $_innerErr = [
        // getUsers
        101 => [
            Lang::LANG_EN => '',
            Lang::LANG_CN => ''
        ],
        // banUser
        102 => [
            Lang::LANG_EN => '',
            Lang::LANG_CN => ''
        ]
    ];

    public function __construct($container)
    {
        parent::__construct($container);
        // 设置内部错误到 Base
        $this->appendErr($this->_innerErr);
    }

    public function getUsers()
    {
        var_dump($this->dsadsa);die;
        $this->setOutput('test', 'strval');
        $this->setOutput('test1', [1, 2, 3, 4,]);
        $this->setOutput('test2', []);
        $this->setStatus(200);
        $this->output();

        // return $this->output();
        //    var_dump($this->args);
        //    $table = $this->db->table('test');
        // $rows = $table->get();
        // var_dump($rows[0]);die;
    }

    public function banUser() {
        $this->setOutput('test', 'strval');
        $this->setOutput('test1', [1, 2, 3, 4,]);
        $this->setOutput('test2', []);
        $this->setStatus(200);
        $this->output();
        $this->output();
    }
}
