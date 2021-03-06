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
class Login extends Base
{

    private $_innerErr = [
        // getUsers
        101 => [
            'en' => '',
            'cn' => ''
        ],
        // banUser
        102 => [
            'en' => '',
            'cn' => ''
        ],
        103 => [
            'en' => '',
            'cn' => '缺少用户ID'
        ],
    ];

    public function __construct($container)
    {
        parent::__construct($container);
        // 设置内部错误到 Base
        $this->appendErr($this->_innerErr);
    }

    /**
     * 获取用户列表
     */
    public function getUsers()
    {
        !$this->offset && $this->offset = 0;
        !$this->limit && $this->limit = 20;

        $db = $this->container->get('db');
        $users = $db->table('user')
            ->limit($this->limit)
            ->offset($this->offset)
            ->get();

        $this->setOutput('userList', $users);
        $this->setStatus(200);
        $this->output();
    }

    /**
     * 获取用户详情
     */
    public function getUserInfo(){
        if (!$this->uId) {
            $this->setStatus(103)->output();
        }

        $db = $this->container->get('db');
        $uInfo = $db->table('user')->where(['u_id'=>$this->uId])->first();
        $this->setOutput('userInfo',$uInfo)->output();
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
