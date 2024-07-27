<?php

namespace hollisho\htranslator\Objects;


use hollisho\objectbuilder\HObject;

/**
 * @author Hollis
 * @desc
 * Class LocaleConfig
 * @package hollisho\htranslator\Objects
 */
class LocaleConfig extends HObject
{
    /**
     * @desc 默认语言
     * @var string
     */
    protected $default_locale = 'zh-cn';

    /**
     * @desc 当前语言
     * @var
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