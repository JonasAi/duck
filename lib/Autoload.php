<?php
namespace Lib;

class Autoload
{
		private $_dir = '';
    public function __contruct($dir) {

    	$this->dir = $dir;
    	$this->loader();
    }

    // TODO 自动加载类
    public function loader() {
	    	if (is_dir($dir)) {
	    		  $file = scandir($srcDir);
						foreach($file as $k=>$v) {
								if ($this->isValidFile($v)) {
									include $v;
								}
						}
	    	} else {
	    		if (is_file($dir)) {
	    			// TODO 这里可以做一个性能测试的东西
	    			include $dir;
	    		}
	    	}
    }

    /** 文件自动加载 */
    public static function fileLoader($dir) {
    	$obj = new self($dir);
    	if (is_dir($dir)) {
	    		  $file = scandir($srcDir);
						foreach($file as $k=>$v) {
								if ($obj->isValidFile($v)) {
									include $v;
								}
						}
	    	} else {
	    		if (is_file($dir) && $obj->isValidFile($dir)) {
	    			// TODO 这里可以做一个性能测试的东西
	    			include $dir;
	    		}
	    	}
    }

    /** 只支持自动加载 php | inc 扩展名的文件 */
    private function isValidFile($file) {
    	// 非文件
    	if ($file == '.' || $file == '..') {
						return false;
			}

    	// 只支持自动加载 php 和 inc 为后缀的文件
    	if (in_array($this->getExtName($dir), ['php','inc'])) {
	    			return true;
	    }

	    return false;
    }

    /** 获取文件扩展名 */
    private function getExtName($file) {
    		if (is_dir($file)) {
    			return '';
    		}

    		list($extName) = array_pop(explode('.',$file));
    		return $extName;
    }

    // TODO 这里要做一些类的基础操作
}


