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
class User extends Base
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
        ],
        103 => [
            Lang::LANG_EN => '',
            Lang::LANG_CN => '缺少用户ID'
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
        $this->setStatus(200);
        $this->setOutput('userInfo',$uInfo)->output();
    }

    /**
     * 获取用户列表
     */
    public function getUserList(){
        !isset($this->limit) && $this->limit = 0;
        !isset($this->page) && $this->page = 20; // 默认分页 20

        $db = $this->getDb();
        $condition = [
            'limit' => $this->limit,
            'offset' => $this->page,
        ];
        $list = $db->table('user')->where($condition)->get();
        $this->setOutput('userList',$list);
        $this->setStatus(200);
        $this->output();
    }

    public function addUser() {
        // 默认设置错误
        $this->setStatus(1000);

        $db = $this->getDb();
        // 关联数组赋值
        $info = [];
        $id = $db->table('user')->insertGetId($info);
        if ($id) {
            $this->setStatus(200);
        }
        $this->output();
    }
    public function addAdmin() {
        // 默认设置错误
        $this->setStatus(1000);

        $db = $this->getDb();
        // 关联数组赋值
        $info = [];
        $id = $db->table('admin_user')->insertGetId($info);
        if ($id) {
            $this->setStatus(200);
        }
        $this->output();
    }
    public function updateUser() {
        // 默认设置错误
        $this->setStatus(1000);

        $db = $this->getDb();
        $where = [];
        // 关联数组赋值
        $info = [];
        $lineNum = $db->table('user')->where($where)->update($info);

        $this->setStatus(200);
        $this->output();
    }
    public function updateAdmin() {
        // 默认设置错误
        $this->setStatus(1000);

        $db = $this->getDb();
        $where = [];
        // 关联数组赋值
        $info = [];
        $lineNum = $db->table('admin_user')->where($where)->update($info);
        
        $this->setStatus(200);
        $this->output();
    }

    public function delUser() {
        // 默认设置错误
        $this->setStatus(1000);
        $db = $this->getDb();
        $where = [];

        if (isset($this->isForce) && $this->isForce ==1) {
            // 直接删除
            $lineNum = $db->table('user')->where($where)->delete();
        } else {
            // 软删除
            // 关联数组赋值
            $info = [];
            $lineNum = $db->table('user')->where($where)->update($info);
        }
        
        $this->setStatus(200);
        $this->output();
    }

    public function delAdmin() {
        // 默认设置错误
        $this->setStatus(1000);
        $db = $this->getDb();
        $where = [];

        if (isset($this->isForce) && $this->isForce ==1) {
            // 直接删除
            $db->table('user')->where($where)->delete();
        } else {
            // 软删除
            // 关联数组赋值
            $info = [];
            $db->table('user')->where($where)->update($info);
        }
        
        $this->setStatus(200);
        $this->output();
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
