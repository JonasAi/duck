<?php
/**
 * web 接口基础类
 */
namespace Api;

use Slim\Http\Request;
use Slim\Http\Response;
use Lib\Lang;

/**
 * 基础类
 * Class Base
 * @package Api
 */
class Base
{
    protected $container = null;
    private $db = null;
    private $logger = null;

    protected $request = null;
    protected $response = null;
    protected $action = '';
    /** @var array Get && params 字段 */
    protected $_args = [];
    /** @var array Post 参数 */
    protected $_params = [];

    protected $_outputData = [];

    /**
     * 200 正确,无其他指令
     * 201 - 999 系统保留级别,不应该自定义
     * 1000 - 9000 类自定义级别,可在继承方法中使用,并指定对应动作
     * 9001 - 9999 有公告,类自定义级别
     * 10000 系统运行但有部分维护,且须发布公告
     * 20000 系统全部停止运行,并发布公告
     */
    protected $_outputStatus = 200;
    /** @var string 错误信息,这里应该根据类内错误码自定义生成 */
    protected $_outputMsg = '';
    /** @var null TODO 这里以后要填充一个弹窗对象 */
    protected $_outputDialog = null;
    /** @var Lang|null 语言对象 */
    protected $_lang = null;

    /** @var array 内部错误字典 */
    protected static $_standard_erros = [
        // 0 : 标准成功
        200 => [
            Lang::LANG_EN => '',
            Lang::LANG_CN => ''
        ],
        1000 => [
            Lang::LANG_EN => '',
            Lang::LANG_CN => '未设置该变量'
        ],
        1001 => [
            Lang::LANG_EN => '',
            Lang::LANG_CN => '容器设置异常'
        ],
        1002 => [
            Lang::LANG_EN => 'We dont know what you want!',
            Lang::LANG_CN => '未找到对应类或方法'
        ],

    ];

    public function __construct($container)
    {
        $this->container = $container;
        $this->_lang     = new Lang(
            Lang::iso2code($container->environment->get('HTTP_CONTENT_LANGUAGE'))
        );
    }

    /**
     * 根据路由动态调用
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    final public function __invoke(Request $request, Response $response, $args)
    {
        $this->response = $response;
        $this->request  = $request;
        // params 字段可 explode('/', $args['params']); 后使用
        $this->_args   = $args;
        $this->_params = $request->getParsedBody();
        // TODO 记录请求日志

        isset($args['action']) && $this->action = $args['action'];

// TODO 读取 header 预留以后做验证 OAuth2 | JWT (来源验证)
        // $headers = $request->getHeaders();
        // foreach ($headers as $name => $values) {
        //     echo $name . ": " . implode(", ", $values);
        // }

        // TODO 权限验证也在这里做了
        // TODO 这里可以捕获个异常, 可以根据
        try {
            if ( ! is_callable([$this, $this->action])) {
                throw new \Exception("We dont know what you want!", 1002);
            }

            call_user_func([$this, $this->action], $args);
        } catch (\Exception $e) {
            // TODO 写日志
            $this->setStatus($e->getCode())->output();
        }

        // 必须保证给 Slim '始终' 返回他的 response
        return $this->response;
    }

    /**
     * 设置输出(不许重写)
     * @param $key
     * @param $val
     * @return $this
     */
    final public function setOutput($key, $val)
    {
        $name                     = strval($key);
        $this->_outputData[$name] = $val;

        return $this;
    }

    /**
     * 设置输出状态(不许重写)
     * @param $status
     * @return $this
     */
    final public function setStatus($status)
    {
        // 状态码最小为 200,TODO 此处可以优化
        (intval($status) < 200) && $status = 200;
        $this->_outputStatus = $status;
        // 设置状态的同时获取错误文案信息
        if (isset(self::$_standard_erros[$status])) {
            $curLang = $this->_lang->current_lang();
            $this->_outputMsg = self::$_standard_erros[$status][$curLang];
        } else {
            $this->_outputMsg = 'Inner Error, please contact the administrator. ';
        }
        return $this;
    }

    /**
     * 设置弹窗对象(不许重写)
     * @return $this
     */
    final public function setDialog()
    {
        // TODO 设置弹窗内容,最好有个弹窗的标准类
        return $this;
    }

    /**
     * 生成要输出的内容(输出标准化)
     * @return array
     */
    final private function genOutput()
    {
        $data = [
            'status' => $this->_outputStatus,
            'msg'    => $this->_outputMsg,
            'data'   => $this->_outputData
        ];

        if ( ! is_null($this->_outputDialog)) {
            $data['dialog'] = $this->_outputDialog;
        }

        return $data;
    }

    /**
     * 最佳错误信息定义
     * @param array $errors
     * @return $this
     */
    final public function appendErr(array $errors)
    {
        self::$_standard_erros = $errors + self::$_standard_erros;
        return $this;
    }

    /**
     * 封装标准返回
     */
    final public function output()
    {
        $this->response = $this->response
            ->withJson($this->genOutput());
        return;
        $newResponse = $this->response
            // ->withHeader('responseType', 'NOTIFY')
            ->withJson($this->genOutput());

        // 理论上这里直接 return $newResponse 就可以但是不生效...
        // 看源码卡在了 body 的位置,不知道为什么body 在 app respond 方法中无法正常工作
        // 所以这里进行了简化的处理
        // 这里是因为
        foreach ($newResponse->getHeaders() as $name => $val) {
            header($name . ': ' . $newResponse->getHeaderLine($name));
        }

        die ($newResponse->getBody());
    }

    public function __get($name)
    {
        $name = strval($name);
        if (is_null($this->container)) {
            throw new \Exception('容器设置异常',1001);
        }

        switch ($name) {
            case 'logger' :
                is_null($this->logger) && $this->logger = $this->container->get('logger');
                break;
            case 'db' :
                is_null($this->db) && $this->db = $this->container->get('db');
                break;
            default:
                throw new \Exception('未设置该变量',1000);
                break;
        }

        return $this->$name;
    }

    // TODO 这里要做一些类的基础操作
}
