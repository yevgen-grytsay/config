<?php
/**
 * @author: yevgen
 * @date: 25.01.17
 */
namespace YevgenGrytsay\Config;


class Config implements \ArrayAccess, \IteratorAggregate {
    private $data = [];

    /**
     * Config constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function __set($name, $value)
    {
        if ($this->isRecord($value)) {
            $this->data[$name] = new Config($value);
        } else {
            $this->data[$name] = $value;
        }
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->data);
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __unset($name)
    {
        unset($this->data[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        foreach ($this->data as $key => $value) {
            $result[$key] = $value instanceof Config ? $value->toArray() : $value;
        }
        return $result;
    }

    /**
     * @return mixed
     */
    public function toXml()
    {
        return XmlTransformation::arrayToXml($this->toArray());
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @param array $data
     */
    public function mergeFromArray(array $data)
    {
        foreach ($data as $key => $value) {
            $this->merge($key, $value);
        }
    }

    /**
     * @param string $xml
     */
    public function mergeFromXml($xml)
    {
        $this->mergeFromArray(XmlTransformation::xmlToArray($xml));
    }

    /**
     * @param string $json
     */
    public function mergeFromJson($json)
    {
        $this->mergeFromArray(json_decode($json, true));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    private function merge($key, $value)
    {
        if (isset($this->{$key}) && $this->{$key} instanceof Config) {
            $this->{$key}->mergeFromArray($value);
        } else {
            $this->{$key} = $this->isRecord($value) ? new Config($value) : $value;
        }
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function isRecord($value)
    {
        return is_array($value) && Func::none(Func::createIsNumeric(), array_keys($value));
    }
}