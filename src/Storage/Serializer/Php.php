<?php

/**
 * Class Php
 *
 * @category Storage
 * @package  Storage\Serializer
 */

namespace Storage\Serializer;

class Php implements InterfaceSerializer
{
    /**
     * @return string
     */
    public function getName()
    {
        return "Php";
    }

    /**
     * @param mixed $content
     * @return string
     */
    public function serialize($content)
    {
        return serialize($content);
    }

    /**
     * @param string $content
     * @return string
     */
    public function unserialize($content)
    {
        return unserialize($content);
    }
}