<?php
namespace YevgenGrytsay\Config;

/**
 * @author: yevgen
 * @date: 25.01.17
 */
class XmlTransformation {
    /**
     * @param string $xml
     * @return array
     */
    public static function xmlToArray($xml)
    {
        return self::sxiToArray(new \SimpleXmlIterator($xml));
    }

    /**
     * @param \SimpleXMLIterator $sxi
     * @return array
     */
    private static function sxiToArray(\SimpleXMLIterator $sxi)
    {
        $result = [];
        foreach ($sxi as $key => $value) {
            $item = $sxi->hasChildren() ? self::sxiToArray($value) : (string)$value;
            if (array_key_exists($key, $result)) {
                if (is_array($result[$key])) {
                    $result[$key][] = $item;
                } else {
                    $arr = [$result[$key], $item];
                    $result[$key] = $arr;
                }
            } else {
                $result[$key] = $item;
            }
        }
        return $result;
    }
}