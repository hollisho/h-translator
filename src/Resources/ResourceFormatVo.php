<?php

namespace hollisho\htranslator\Resources;

use hollisho\objectbuilder\HObject;

/**
 * Class ResourceFormatVo
 * @package hollisho\htranslator\Resources
 */
class ResourceFormatVo extends HObject
{
    const ARR = 'array';

    const JSON_FILE = 'json_file';

    const PHP_FILE = 'php_file';

    const YAML_FILE = 'yaml_file';

    const MO_FILE = 'mo_file';
}