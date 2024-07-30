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
     * 
     * @desc 支持的语言包
     * @var array
     */
    protected $enable_locale = [];

    /**
     * 
     * @desc 是否支持语言分组
     * @var bool
     */
    protected $allow_group = false;


    /**
     * @desc 语言路径
     * @var string
     */
    protected $locale_path = '';
}