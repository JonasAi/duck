<?php
/**
 * 系统各种接口.
 * @package \lib\inf
 * User: jonas
 * Date: 2018/8/21
 * Time: 12:02 PM
 */
namespace Lib\inf;

/**
 * 语言集合定义接口
 *
 * 满足这个接口的语言集合类，能够为其他类提供相关语言选择范围，
 * 语言编码转换功能。实现接口的类库会维护一个内部的语言编号集合，用于其他类方便定义自己的语言内容。
 * 这个类是系统中针对 i18n 处理的一部分，用于定义可以使用的语言范围。
 * 完成系统内部语言编码和 ISO-639 标准之间的转换操作，内部语言编码对 ISO-639 是一个一对多的关系。
 *
 * @package \lib\inf
 * @author Jonas <chunhuiai0127@outlook.com>
 */
interface inf_lang {
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
    public static function is_in_support ($code);

    /**
     * 将 ISO-639 语言定义转换为内部数字编码
     *
     * 对 ISO-639 支持的范围不是固定的哪个扩展协议集，
     * 而是以我们目前采集到的常用语言定义为蓝本进行的，可能横跨 1 - 4 的扩展。
     *
     * @param string $iso
     * @return int
     */
    public static function iso2code ($iso);

    /**
     * 将内部数字编码转换为接近的 ISO-639 编码
     *
     * 将内部的编号按照常用 ISO-639 的编码对应，进行转换。
     * 一个内部编码可能会对应 ISO-639 的多个编码，若想获取到所有的编码，
     * 请参考  int2iso_all 方法的调用。
     *
     * @param int $code
     * @return string
     */
    public static function code2iso ($code);

    /**
     * 将内部数字编码转换为所有对应的 ISO-639 编码
     *
     * 一次性提供所有跟内部编码能够对应的 ISO-639 编码列表，
     * 其中的顺序跟常用性无关。
     *
     * @param int $code
     * @return array
     */
    public static function code2iso_all ($code);

    /**
     * 提供默认语言的内部编码
     *
     * 默认语言编码用于适应给出的语言不在支持范围内的情况下。
     *
     * @return int
     */
    public static function default_code ();
}
?>
