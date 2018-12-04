<?php
namespace Lib;

define('PARSER_LIB_ROOT',__LIB__.'/../lib/sqlparser/');
require_once PARSER_LIB_ROOT.'sqlparser.lib.php';

class SqlParsse {

	public static function format($sql) {
//		var_dump(PMA_SQP_parse($sql));
		return PMA_SQP_formatHtml(PMA_SQP_parse($sql),'text');
	}
}