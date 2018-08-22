<?php

namespace Lib;

use \Lib\inf\inf_lang;

class Lang implements inf_lang
{
    /** 语言定义列表的数目 */
    const LANG_COUNT = 2;
    /** 语言：英文 */
    const LANG_EN = 0;
    /** 语言：中文 */
    const LANG_CN = 1;
    /** 语言：默认 */
    const LANG_DEFAULT = self::LANG_CN;

    /** 语言名称索引 */
    private static $_name = array(
        self::LANG_EN => 'EN',
        self::LANG_CN => 'CN',
    );
    /** 方法判断列表 */
    private static $_method = array(
        self::LANG_EN => 'is_en',
        self::LANG_CN => 'is_cn',
    );

    /** @var int $_lang 当前语言选择 */
    private $_lang = self::LANG_DEFAULT;
    /** @var array $_strings 当前的语言列表 */
    private $_strings = [];

    /**
     * 构造方法
     * @param int $lang 准备使用的语言类型，若设定语言不是标准语言，则使用当前默认设置
     */
    public function __construct($lang)
    {
        if (! array_key_exists(intval($lang), self::$_name)) {
            $lang = self::LANG_DEFAULT;
        }
        $this->_lang = $lang;
        return;
    }

    /**
     * 获取当前的语言类型
     * @return int [<description>]
     */
    public function current_lang()
    {
        return $this->_lang;
    }

    /**
     * 重置内部多语言文本内容
     * @return  Lang [<description>]
     */
    public function clear_strings()
    {
        $this->_strings = [];
        return $this;
    }


    /**
     * 设置所有相关的文本资源
     * @param array $strings 多语言数组
     * @return  Lang [<description>]
     */
    public function with_strings(array $strings)
    {
        $this->_strings = $strings + $this->_strings;   // 重载数组方式，不可更改顺序
        return $this;
    }

    /**
     * 获得指定索引的相关文本内容，若不存在指定内容，则返回空字符串
     * @param int $index [<description>]
     * @return string [<description>]
     */
    public function index($index)
    {
        if ( ! isset ($this->_strings[$index])) {
            return '';
        }
        if ( ! isset ($this->_strings[$index][$this->_lang])) {
            return '';
        }
        return $this->_strings[$index][$this->_lang];
    }

    /**
     * 获取所有语言的名称列表
     * @return array
     */
    public static function name_list()
    {
        return self::$_name;
    }

    /**
     * 获取指定索引的方法判断列表
     * @param int $index
     * @return string
     */
    public static function get_method($index)
    {
        $index = intval($index);
        if ( ! array_key_exists($index, self::$_method)) {
            $index = self::LANG_DEFAULT;
        }
        return self::$_method[$index];
    }

    /**
     * 获取语言顺序号，若顺序号不支持，则给出默认的域名编号
     * @param int $lang
     * @return  int [<description>]
     */
    public static function get_lang($lang)
    {
        if ( ! array_key_exists(intval($lang), self::$_name)) {
            return self::LANG_DEFAULT;
        } else {
            return $lang;
        }
    }

    /*********************************************************
     * inf_lang
     *********************************************************/
    /** @var array $_lang_list 支持的所有语言列表和关联关系 */
    private static $_lang_list = [
        self::LANG_EN => [
            'en',
            'en_ag',
            'en_as',
            'en_au',
            'en_ca',
            'en_cn',
            'en_du',
            'en_en',
            'en_fj',
            'en_gb',
            'en_hk',
            'en_ie',
            'en_in',
            'en_kr',
            'en_mg',
            'en_my',
            'en_na',
            'en_nz',
            'en_ph',
            'en_pk',
            'en_sg',
            'en_tz',
            'en_uk',
            'en_us',
            'en_xa',
            'en_za',
            'en_zg',
            'en_zw',
        ],
        self::LANG_CN => [
            'zh',
            'zh_cn',
            'zh_hans',
            'zh_hans_cn',
            'zh_hans_hk',
            'zh_hans_mo',
            'zh_hans_sg',
            'zh_sg',
        ],
    ];

    /**
     * 是否给定的语言编号在明确支持范围内
     *
     * 当前语言支持范围内不支持的编号语言设定不是不可以使用，
     * 但是应该没有相关常量匹配支持，并且可能在未来会存在二义性问题。
     * 如果一个设定的语言编号在其他类库中使用了，
     * 那么在当前类处理中会采用 default_code 方法返回的默认语言及进行替换处理。
     *
     * @param int $code
     * @return bool
     */
    public static function is_in_support($code)
    {
        return isset(self::$_lang_list[intval($code)]);
    }

    /**
     * 将 ISO-639 语言定义转换为内部数字编码
     *
     * 对 ISO-639 支持的范围不是固定的哪个扩展协议集，
     * 而是以我们目前采集到的常用语言定义为蓝本进行的，可能横跨 1 - 4 的扩展。
     *
     * @param string $iso
     * @return int 若不存在对应关系，则给出默认
     */
    public static function iso2code($iso)
    {
        // 规范 ISO 格式为小写下划线格式
        $iso    = str_replace('-', '_', strtolower(trim($iso)));
        $result = self::LANG_DEFAULT;
        foreach (self::$_lang_list as $key => $value) {
            if (in_array($iso, $value)) {
                $result = $key;
                break;
            }
        }
        return $result;
    }

    /**
     * 将内部数字编码转换为接近的 ISO-639 编码
     *
     * 将内部的编号按照常用 ISO-639 的编码对应，进行转换。
     * 一个内部编码可能会对应 ISO-639 的多个编码，若想获取到所有的编码，
     * 请参考  int2iso_all 方法的调用。
     *
     * @param int $code
     * @return string 若不存在给出空字符串
     */
    public static function code2iso($code)
    {
        $code = intval($code);
        if ( ! self::is_in_support($code)) {
            return '';
        }
        if ( ! isset(self::$_lang_list[$code][0])) {
            return '';
        }
        return self::$_lang_list[$code][0];
    }

    /**
     * 将内部数字编码转换为所有对应的 ISO-639 编码
     *
     * 一次性提供所有跟内部编码能够对应的 ISO-639 编码列表，
     * 其中的顺序跟常用性无关。
     *
     * @param int $code
     * @return array 若不存在给出空数组
     */
    public static function code2iso_all($code)
    {
        $code = intval($code);
        if ( ! self::is_in_support($code)) {
            return [];
        }
        return self::$_lang_list[$code];
    }

    /**
     * 提供默认语言的内部编码
     *
     * 默认语言编码用于适应给出的语言不在支持范围内的情况下。
     *
     * @return int
     */
    public static function default_code()
    {
        return self::LANG_DEFAULT;
    }

    /**
     * 当前语言编码 (ISO-639)
     * @return mixed
     */
    public function __toString()
    {
        return self::$_name[self::LANG_DEFAULT];
    }
}