<?php
/**
 * web 接口基础类
 */
namespace Api;

use Lib\Client;
use Slim\Http\Request;
use Slim\Http\Response;
use Interop\Container\ContainerInterface;

/**
 * 基础类
 * Class Base
 * @package Api
 */
class Base extends Client
{
    protected $container = null;
    protected $request = null;
    protected $response = null;
    protected $action = '';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
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

    // TODO 这里要做一些类的基础操作
}
