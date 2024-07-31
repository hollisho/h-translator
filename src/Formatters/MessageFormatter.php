<?php
namespace hollisho\htranslator\Formatters;

/**
 * @author Hollis
 * @desc 内容格式化类
 * Class MessageFormatter
 * @package hollisho\htranslator\Formatters
 */
class MessageFormatter implements FormatterInterface
{
    public function format($message, string $locale, array $parameters = []): string
    {
        if (is_callable($message)) {
            return call_user_func_array($message, $parameters);
        }

        // 变量解析
        if (!empty($parameters) && is_array($parameters)) {
            /**
             * Notes:
             * 为了检测的方便，数字索引的判断仅仅是参数数组的第一个元素的key为数字0
             * 数字索引采用的是系统的 sprintf 函数替换，用法请参考 sprintf 函数
             */
            if (key($parameters) === 0) {
                // 数字索引解析
                array_unshift($parameters, $message);
                $message = call_user_func_array('sprintf', $parameters);
            } else {
                // 关联索引解析
                $replace = array_keys($parameters);
                foreach ($replace as &$v) {
                    $v = "{:{$v}}";
                }
                $message = str_replace($replace, $parameters, $message);
            }
        }

        return $message;

    }
}