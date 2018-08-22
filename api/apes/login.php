<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018/8/21
 * Time: 6:42 PM
 */
namespace Api\Apes;

use Api\Base;
use Lib\Lang;

class login {
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

//    public function __construct($container)
//    {
//        parent::__construct($container);
//        // 设置内部错误到 Base
//        $this->appendErr($this->_innerErr);
//    }
//    private function appendErr() {}


    private function register() {}

    private function login_sms() {}

    /**
     * 三方账号登录
     */
    private function login_third() {}

    /**
     * 邮箱地址登录
     */
    private function login_email() {}
}