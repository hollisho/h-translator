<?php
namespace hollisho\htranslator\Formatters;

use hollisho\htranslator\Catelogues\MessageCatalogueInterface;

/**
 * @author Hollis
 * @desc 内容格式化类
 * Class MessageFormatter
 * @package hollisho\htranslator\Formatters
 */
class MessageFormatter implements FormatterInterface
{
    private $messageCatalogue;

    public function __construct(MessageCatalogueInterface $messageCatalogue = null)
    {
        $this->messageCatalogue = $messageCatalogue;
    }

    public function format(string $message, string $locale, array $parameters = []): string
    {
        if ($this->messageCatalogue instanceof MessageCatalogueInterface) {
            $value = $this->messageCatalogue->get($message);
            if (is_callable($value)) {
                return call_user_func_array($value, $parameters);
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
                    array_unshift($parameters, $value);
                    $value = call_user_func_array('sprintf', $parameters);
                } else {
                    // 关联索引解析
                    $replace = array_keys($parameters);
                    foreach ($replace as &$v) {
                        $v = "{:{$v}}";
                    }
                    $value = str_replace($replace, $parameters, $value);
                }
            }

            return $value;
        }

        return strtr($message, $parameters);
    }
}