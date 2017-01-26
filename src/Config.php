<?php
namespace YevgenGrytsay\Config;

/**
 * @author: yevgen
 * @date: 25.01.17
 */
class Config implements \ArrayAccess {
    private $data = [];

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function __set($name, $value)
    {
        if (is_array($value)) {
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

    public function toArray()
    {
        $result = [];
        foreach ($this->data as $key => $value) {
            $result[$key] = $value instanceof Config ? $value->toArray() : $value;
        }
        return $result;
    }
}