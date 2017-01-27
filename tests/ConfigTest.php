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
        $this->assertEquals('val', $conf->key);
    }

    public function testArraySet()
    {
        $conf = new Config();
        $conf['key'] = 'val';
        $this->assertEquals('val', $conf['key']);
    }

    public function testObjectAccess()
    {
        $conf = new Config(['key' => 'val']);
        $this->assertEquals('val', $conf->key);
    }

    public function testArrayAccess()
    {
        $conf = new Config(['key' => 'val']);
        $this->assertEquals('val', $conf['key']);
    }

    public function testNestedObjectAccess()
    {
        $conf = new Config(['a' => ['b' => 'val']]);
        $this->assertEquals('val', $conf->a->b);
    }

    public function testNestedArrayAccess()
    {
        $conf = new Config(['a' => ['b' => 'val']]);
        $this->assertEquals('val', $conf['a']['b']);
    }

    public function testSetList()
    {
        $conf = new Config();
        $conf->key = [1, 2, 3];
        $this->assertEquals([1, 2, 3], $conf->key);
    }

    public function testMergeFromArray()
    {
        $conf = new Config(['a' => ['b' => 'c', 'd' => 'e']]);
        $conf->mergeFromArray(['a' => ['b' => 'c2', 'g' => 'h']]);
        $expected = ['a' => [
            'b' => 'c2',
            'd' => 'e',
            'g' => 'h'
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

    public function testIterator()
    {
        $conf = new Config(['a' => 'val']);
        $result = [];
        foreach ($conf as $key => $value) {
            $result[$key] = $value;
        }
        $this->assertEquals(['a' => 'val'], $result);
    }
}
