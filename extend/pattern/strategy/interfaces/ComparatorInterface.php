<?php

namespace ext\pattern\strategy\interfaces;

/**
 * ComparatorInterface类
 */
interface ComparatorInterface
{
    /**
     * @param mixed $a
     * @param mixed $b
     *
     * @return bool
     */
    public function compare($a, $b);
}