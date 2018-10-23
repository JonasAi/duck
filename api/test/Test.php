<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018/10/23
 * Time: 12:23 AM
 */
namespace Api\Test;
use Lib\SmsYZX as YZX;

class Test extends \Api\Base
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
        $this->appendErr($this->_innerErr);
    }

    /**
     * 短信发送测试
     */
    public function sendSms()
    {
        //载入ucpass类

//初始化必填
//填写在开发者控制台首页上的Account Sid
        $options['accountsid'] = 'a2f9ad92da9f2749a730c2a3bed2';
//填写在开发者控制台首页上的Auth Token
        $options['token'] = '0fe2ef6f2e736234b37fa9f2ba5c';

//初始化 $options必填
        $ucpass = new YZX($options);
        $appId = "0530cb9590824c5e9d49ba717d84";    //应用的ID，可在开发者控制台内的短信产品下查看
        $templateid = "39792";    //可在后台短信产品→选择接入的应用→短信模板-模板ID，查看该模板ID
        $param = 123444; //多个参数使用英文逗号隔开（如：param=“a,b,c”），如为参数则留空
        $mobile = '18210940279';
        $uid = "100";

        //70字内（含70字）计一条，超过70字，按67字/条计费，超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。

        echo $ucpass->SendSms($appId, $templateid, $param, $mobile, $uid);
/********************************************************
 * 返回样例：
 * {
 *       "code": "000000",
 *       "count": "1",
 *       "create_date": "2018-10-23 22:17:57",
 *       "mobile": "18210940279",
 *       "msg": "OK",
 *       "smsid": "b4108feee532f29fd308da79bd5af8",
 *       "uid": "100"
 *   }
 ********************************************************/
    }
}