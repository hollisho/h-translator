<?php

namespace hollisho\htranslator\Locale;


use hollisho\objectbuilder\HObject;

/**
 * @author Hollis
 * @desc 本地化配置文件
 * Class LocaleConfig
 * @package hollisho\htranslator\Objects
 */
class LocaleConfigVo extends HObject
{
    protected $timezone = 'Asia/Shanghai';

    /**
     * @desc 默认语言
     * @var string
     */
    protected $default_locale = 'zh_CN';

    /**
     * @desc 当前语言
     * @var string
     */
    protected $locale;

    /**
     * @desc 支持的语言包
     * @var array
     */
    protected $enable_locale = [];

    /**
     * @desc 自动侦测
     * @var bool
     */
    protected $auto_detect = true;

    /**
     * @desc 自动侦测变量名
     * @var string
     */
    protected $auto_detect_var = 'locale';

}