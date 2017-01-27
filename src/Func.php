<?php
/**
 * @author: yevgen
 * @date: 26.01.17
 */
namespace YevgenGrytsay\Config;


class Func {
    /**
     * @return \Closure
     */
    public static function createIsNumeric()
    {
        return function($value) {
            return is_numeric($value);
        };
    }
    /**
     * @param callable $predicate
     * @param array $list
     * @return bool
     */
    public static function any(callable $predicate, array $list)
    {
        foreach ($list as $item) {
            if ($predicate($item)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param callable $predicate
     * @param array $list
     * @return bool
     */
    public static function none(callable $predicate, array $list)
    {
        foreach ($list as $item) {
            if ($predicate($item)) {
                return false;
            }
        }
        return true;
    }
}