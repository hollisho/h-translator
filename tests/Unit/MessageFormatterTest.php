<?php

namespace hollisho\htranslatorTests\Unit;

use hollisho\htranslator\Formatters\MessageFormatter;
use PHPUnit\Framework\TestCase;

class MessageFormatterTest extends TestCase
{

    /**
     * @return void
     * @desc
     */
    public function testCallback()
    {
        $time = date('Y-m-d H:i:s');
        $messageFormatter = new MessageFormatter();
        $format = $messageFormatter->format(function ($my_var) use ($time) {
            return $time . '-' .$my_var;
        }, 'zh-cn', [
            'my_var' => 'Ho'
        ]);

        $this->assertTrue($format == $time . '-Ho');
    }

    /**
     * @return void
     * @desc 占位符测试
     */
    public function testPlaceholder()
    {
        $messageFormatter = new MessageFormatter();
        $format = $messageFormatter->format('这是%s，基于%s', 'zh-cn', [
            '占位符',
            'formatter'
        ]);

        $this->assertTrue($format == '这是占位符，基于formatter');
    }

    /**
     * @return void
     * @desc 占位符测试
     */
    public function testPlaceholder02()
    {
        $messageFormatter = new MessageFormatter();
        $format = $messageFormatter->format('这是{:message}，基于{:base}', 'zh-cn', [
            'message' => '占位符',
            'base' => 'formatter'
        ]);

        $this->assertTrue($format == '这是占位符，基于formatter');
    }
}