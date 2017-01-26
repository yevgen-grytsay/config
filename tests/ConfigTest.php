<?php
/**
 * @author: yevgen
 * @date: 25.01.17
 */

namespace YevgenGrytsay\Config\Tests;


use YevgenGrytsay\Config\Config;


class ConfigTest extends \PHPUnit_Framework_TestCase {
    public function testObjectIsSet()
    {
        $conf = new Config(['a' => 'val']);
        $this->assertTrue(isset($conf->a));
    }

    public function testArrayIsSet()
    {
        $conf = new Config(['a' => 'val']);
        $this->assertTrue(isset($conf['a']));
    }

    public function testObjectNestedIsSet()
    {
        $conf = new Config(['a' => ['b' => 'val']]);
        $this->assertTrue(isset($conf->a->b));
    }

    public function testArrayNestedIsSet()
    {
        $conf = new Config(['a' => ['b' => 'val']]);
        $this->assertTrue(isset($conf['a']['b']));
    }

    public function testObjectSet()
    {
        $conf = new Config();
        $conf->key = 'val';
        $this->assertEquals(['key' => 'val'], $conf->toArray());
    }

    public function testMergeFromArray()
    {
        $conf = new Config(['a' => ['b' => 'c']]);
        $conf->mergeFromArray(['a' => ['d' => 'e']]);
        $expected = ['a' => [
            'b' => 'c',
            'd' => 'e'
        ]];
        $this->assertEquals($expected, $conf->toArray());
    }

    public function testMergeFromArrayReplacePlainValueByArray()
    {
        $conf = new Config(['a' => 'val']);
        $conf->mergeFromArray(['a' => ['d' => 'e']]);
        $expected = ['a' => ['d' => 'e']];
        $this->assertEquals($expected, $conf->toArray());
    }
}
