<?php

return [
    'user' => [
        'username' => 'Hollis',
    ],
    'datetime' => function () {
        return date('Y-m-d H:i:s');
    },
    'This is %s,base on %s' => '这是%s，基于%s',
    'moment' => function () {
        $moment = new \Moment\Moment('now', 'Asia/ShangHai');
        $moment::setLocale('zh_CN');
        return $moment->format('llll', new \Moment\CustomFormats\MomentJs());
    }
];