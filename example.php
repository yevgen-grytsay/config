<?php
/**
 * @author: yevgen
 * @date: 25.01.17
 */
require_once __DIR__ . '/vendor/autoload.php';

$config = new \YevgenGrytsay\Config\Config();
$config['a'] = ['b' => ['c' => 'a-b-c']];

$config['a']['b']['d'] = 'a-b-d';
$config['primes'] = [2, 3, 5, 7];
$config['list'] = ['carrot'];

/**
 * Iterable
 */
foreach ($config as $key => $value) {
    var_dump($key, $value);
}

/**
 * XML
 */
$xml = '
<root>
    <a><b><c>a-b-c-2</c></b></a>
    <list>apple</list>
    <list>orange</list>
</root>
';
$config->mergeFromXml($xml);

/**
 * JSON
 */
$config->mergeFromJson('{"a":{"b":{"e":"a-b-e"}},"keys":["Alt","Ctrl","Del"]}');

echo 'Array:', PHP_EOL;
var_dump($config->toArray());

echo 'XML:', PHP_EOL;
var_dump($config->toXml());

echo 'JSON:', PHP_EOL;
var_dump($config->toJson());

echo 'Accessing values:', PHP_EOL;
var_dump($config['a']['b']['d']);
var_dump($config->a->b->d);
var_dump($config->list);