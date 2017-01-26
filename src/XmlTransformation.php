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
     * @param array $data
     * @return mixed
     */
    public static function arrayToXml(array $data)
    {
        $doc = new \SimpleXMLElement('<?xml version="1.0"?><root></root>');
        self::convert($data, $doc);
        return $doc->asXML();
    }

    /**
     * @param array $array
     * @param \SimpleXMLElement $el
     */
    private static function convert(array $array, \SimpleXMLElement $el)
    {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                if (count($value) === 0) {
                    continue;
                }
                list($firstKey, $_) = each($value); //TODO упрощенная проверка
                if (is_numeric($firstKey)) {
                    foreach ($value as $item) {
                        self::convert(array($key => $item), $el);
                    }
                } else {
                    $child = $el->addChild("$key");
                    self::convert($value, $child);
                }
            } else {
                $el->addChild("$key", htmlspecialchars("$value"));
            }
        }
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