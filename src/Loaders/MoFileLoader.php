<?php

namespace hollisho\htranslator\Loaders;

use hollisho\htranslator\Exceptions\InvalidResourceException;

/**
 * Mo文件结构
 * Header:
 * 0x950412de  // 魔数
 * 0x00000000  // 版本号
 * 0x00000002  // 字符串数量（2）
 * 0x0000001c  // 原始字符串表偏移（28）
 * 0x0000002c  // 翻译字符串表偏移（44）
 *
 * .mo 文件头部信息的固定大小是 28 字节（7 个 4 字节的整数）。
 * 头部信息（28 字节）:
 * Offset	Size	Description
 * 0	4	魔数（0x950412de）
 * 4	4	版本号（0）
 * 8	4	原始字符串的数量（1）
 * 12	4	原始字符串表的偏移量（28）
 * 16	4	翻译字符串表的偏移量（36）
 * 20	4	哈希表大小（0）
 * 24	4	哈希表的偏移量（0）
 *
 * @author Hollis
 * @desc
 * Class MoFileLoader
 * @package hollisho\htranslator\Loaders
 */
class MoFileLoader extends FileLoader
{
    /**
     * 小端模式
     */
    public const MO_LITTLE_ENDIAN_MAGIC = 0x950412DE;

    /**
     * 大端模式
     */
    public const MO_BIG_ENDIAN_MAGIC = 0xDE120495;

    /**
     * .mo 文件头部信息的固定大小是 28 字节（7 个 4 字节的整数）。
     * .mo 文件至少为 28 字节
     */
    public const MO_HEADER_SIZE = 28;

    protected function loadResource(string $resource)
    {
        $stream = fopen($resource, 'r');

        $stat = fstat($stream);

        if ($stat['size'] < self::MO_HEADER_SIZE) {
            throw new InvalidResourceException('MO stream content has an invalid format.');
        }
        $magic = unpack('V1', fread($stream, 4));
        $magic = hexdec(substr(dechex(current($magic)), -8));

        if (self::MO_LITTLE_ENDIAN_MAGIC == $magic) {
            $isBigEndian = false;
        } elseif (self::MO_BIG_ENDIAN_MAGIC == $magic) {
            $isBigEndian = true;
        } else {
            throw new InvalidResourceException('MO stream content has an invalid format.');
        }

        // 版本号
        $this->readLong($stream, $isBigEndian);
        // 字符串数量
        $count = $this->readLong($stream, $isBigEndian);
        // 原始字符串表偏移
        $offsetId = $this->readLong($stream, $isBigEndian);
        // 翻译字符串表偏移
        $offsetTranslated = $this->readLong($stream, $isBigEndian);
        // 哈希表大小
        $this->readLong($stream, $isBigEndian);
        // 哈希表的偏移量
        $this->readLong($stream, $isBigEndian);

        $messages = [];

        for ($i = 0; $i < $count; ++$i) {
            $pluralId = null;
            $translated = null;

            fseek($stream, $offsetId + $i * 8);
            // 原始字符串的长度
            $length = $this->readLong($stream, $isBigEndian);
            // 原始字符串的偏移量
            $offset = $this->readLong($stream, $isBigEndian);

            if ($length < 1) {
                continue;
            }

            fseek($stream, $offset);
            $singularId = fread($stream, $length);

            if (strpos($singularId, "\000") !== false) {
                [$singularId, $pluralId] = explode("\000", $singularId);
            }

            fseek($stream, $offsetTranslated + $i * 8);
            // 翻译字符串的长度
            $length = $this->readLong($stream, $isBigEndian);
            // 翻译字符串的偏移量
            $offset = $this->readLong($stream, $isBigEndian);

            if ($length < 1) {
                continue;
            }

            fseek($stream, $offset);
            $translated = fread($stream, $length);

            if (strpos($translated, "\000") !== false) {
                $translated = explode("\000", $translated);
            }

            $ids = ['singular' => $singularId, 'plural' => $pluralId];
            $item = compact('ids', 'translated');

            if (!empty($item['ids']['singular'])) {
                $id = $item['ids']['singular'];
                if (isset($item['ids']['plural'])) {
                    $id .= '|'.$item['ids']['plural'];
                }
                $messages[$id] = stripcslashes(implode('|', (array) $item['translated']));
            }
        }

        fclose($stream);

        return array_filter($messages);
    }

    /**
     * @param $stream
     * @param bool $isBigEndian
     * @return int
     * @author Hollis
     * @desc 读取无符号长整型（32位） N 大端， V 小端
     */
    private function readLong($stream, bool $isBigEndian): int
    {
        $result = unpack($isBigEndian ? 'N1' : 'V1', fread($stream, 4));
        $result = current($result);

        return (int) substr($result, -8);
    }
}