<?php
/**
 * @author: yevgen
 * @date: 25.01.17
 */
namespace YevgenGrytsay\Config\Tests;

use PHPUnit\Framework\TestCase;
use YevgenGrytsay\Config\XmlTransformation;


class XmlTransformationTest extends TestCase {
    /**
     * @dataProvider dataSet
     */
    public function testXmlToArray(array $expectedData, $xml)
    {
        $this->assertEquals($expectedData, XmlTransformation::xmlToArray($xml));
    }

    /**
     * @dataProvider dataSet
     */
    public function testArrayToXml(array $data, $expectedXml)
    {
        $this->assertXmlStringEqualsXmlString($expectedXml, XmlTransformation::arrayToXml($data));
    }

    public function dataSet()
    {
        $set = [];
        $data = [
            'a' => [
                'b' => [
                    'value a-b',
                    [
                        'c' => ['value a-b-c-1', 'value a-b-c-2', 'value a-b-c-3']
                    ]
                ]
            ]
        ];
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
        $set[] = [$data, $xml];

        $xml = '
            <root>
                <a>value a</a>
                <a>
                    <b>value a-b-1</b>
                    <b>value a-b-2</b>
                    <b>value a-b-3</b>
                </a>
            </root>';
        $data = [
            'a' => [
                'value a',
                [
                    'b' => ['value a-b-1', 'value a-b-2', 'value a-b-3']
                ]
            ]
        ];
        $set[] = [$data, $xml];

        $xml = '<root><a><b>value 1</b><b>value 2</b><b>value 3</b></a></root>';
        $data = ['a' => ['b' => ['value 1', 'value 2', 'value 3']]];
        $set[] = [$data, $xml];

        $xml = '<root><a><b>value</b></a></root>';
        $data = ['a' => ['b' => 'value']];
        $set[] = [$data, $xml];

        $xml = '<root><a>1</a><a>2</a><a>3</a></root>';
        $data = ['a' => [1, 2, 3]];
        $set[] = [$data, $xml];

        $set[] = [[], '<root></root>'];

        return $set;
    }
}
