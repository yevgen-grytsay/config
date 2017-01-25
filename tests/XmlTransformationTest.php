<?php
/**
 * @author: yevgen
 * @date: 25.01.17
 */

namespace YevgenGrytsay\Config\Tests;


use PHPUnit\Framework\TestCase;
use YevgenGrytsay\Config\XmlTransformation;


class XmlTransformationTest extends TestCase {
    public function testShouldIgnoreRoot()
    {
        $xml = '<root></root>';
        $arr = XmlTransformation::xmlToArray($xml);
        $this->assertEquals([], $arr);
    }

    public function testArray()
    {
        $xml = '<root><a>1</a><a>2</a><a>3</a></root>';
        $arr = XmlTransformation::xmlToArray($xml);
        $this->assertEquals(['a' => [1, 2, 3]], $arr);
    }

    public function testNestedValue()
    {
        $xml = '<root><a><b>value</b></a></root>';
        $arr = XmlTransformation::xmlToArray($xml);
        $this->assertEquals(['a' => ['b' => 'value']], $arr);
    }

    public function testNestedArray()
    {
        $xml = '<root><a><b>value 1</b><b>value 2</b><b>value 3</b></a></root>';
        $arr = XmlTransformation::xmlToArray($xml);
        $this->assertEquals(['a' => ['b' => ['value 1', 'value 2', 'value 3']]], $arr);
    }

    public function testMixed()
    {
        $xml = '
            <root>
                <a>value a</a>
                <a>
                    <b>value a-b-1</b>
                    <b>value a-b-2</b>
                    <b>value a-b-3</b>
                </a>
            </root>';
        $expected = [
            'a' => [
                'value a',
                [
                    'b' => ['value a-b-1', 'value a-b-2', 'value a-b-3']
                ]
            ]
        ];
        $this->assertEquals($expected, XmlTransformation::xmlToArray($xml));
    }

    public function testVeryComplexNestedMixed()
    {
        $xml = '
            <root>
                <a>
                    <b>value a-b</b>
                    <b>
                        <c>value a-b-c-1</c>
                        <c>value a-b-c-2</c>
                        <c>value a-b-c-3</c>
                    </b>
                </a>
            </root>';
        $expected = [
            'a' => [
                'b' => [
                    'value a-b',
                    [
                        'c' => ['value a-b-c-1', 'value a-b-c-2', 'value a-b-c-3']
                    ]
                ]
            ]
        ];
        $this->assertEquals($expected, XmlTransformation::xmlToArray($xml));
    }
}
