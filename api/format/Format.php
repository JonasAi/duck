<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 2018/10/23
 * Time: 12:23 AM
 */
namespace Api\Format;
use Slim\Http\Request;
use Slim\Http\Response;
use Lib\SqlFormatter;
use Lib\SqlParsse;

class Format extends \Api\Base
{
    private $_innerErr = [
        // getUsers
        101 => [
            'en' => '',
            'cn' => '请输入要格式化的 SQL!'
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

    public function format_v2() {
        $sqlOri = $this->text;
        if (!is_null($sqlOri)) {
            $this->setStatus(101);
        } else {
            $sqlOri = "CREATE TABLE `activity_award_tmp` (`aat_id` bigint(20) NOT NULL AUTO_INCREMENT,`external_id` int(11) unsigned NOT NULL COMMENT 'PHP主键', `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',`money` bigint(20) DEFAULT '0' COMMENT '奖励金额',`rate` smallint(6) DEFAULT '0' COMMENT '奖励利率',
  `detail` varchar(512) NOT NULL DEFAULT '' COMMENT '详细信息',`type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0:特权本金;1:奖励利率',
  `date` date NOT NULL COMMENT '生效的时间',
  PRIMARY KEY (`aat_id`), KEY `date_u_id` (`date`,`u_id`)) ENGINE=InnoDB AUTO_INCREMENT=2042546240 DEFAULT CHARSET=utf8 COMMENT='用户奖励临时表';";
            $res = SqlParsse::format($sqlOri);
            $this->setOutput('resHtml', $res);



//
//            $sql = "SELECT * \n\t FROM china \n\t LIMIT 10";
//            $this->setOutput('resHtml', $sql);
        }
        $this->output();
    }
    public function format() {

        $sqlOri = $this->text;
        if (is_null($sqlOri)) {
            $this->setStatus(101);
        } else {
//            $sqlOri = 'select * from user;';
//            $sqlOri = "CREATE TABLE `activity_award_tmp` (`aat_id` bigint(20) NOT NULL AUTO_INCREMENT,`external_id` int(11) unsigned NOT NULL COMMENT 'PHP主键', `u_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',`money` bigint(20) DEFAULT '0' COMMENT '奖励金额',`rate` smallint(6) DEFAULT '0' COMMENT '奖励利率',
//  `detail` varchar(512) NOT NULL DEFAULT '' COMMENT '详细信息',`type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0:特权本金;1:奖励利率',
//  `date` date NOT NULL COMMENT '生效的时间',
//  PRIMARY KEY (`aat_id`), KEY `date_u_id` (`date`,`u_id`)) ENGINE=InnoDB AUTO_INCREMENT=2042546240 DEFAULT CHARSET=utf8 COMMENT='用户奖励临时表';";
////            $resHtml = SqlFormatter::highlight($sqlOri);
//
//            $sqlOri = "SELECT * FROM a";
            $cmd = 'python3 '.__SHELL__.'sqlFormat.py -s '."'$sqlOri'";
            $a = shell_exec($cmd);

            $this->setOutput('resHtml', $a);
//            $resHtml = SqlFormatter::format($sqlOri);
//            $resHtml = SqlFormatter::splitQuery($sqlOri);
//            $this->setOutput('resHtml', $resHtml);
        }
        $this->output();
    }
}