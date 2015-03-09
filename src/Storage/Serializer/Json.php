<?php

/**
 * Class Json
 *
 * @category Storage
 * @package  Storage\Serializer
 */

namespace Storage\Serializer;

class Json implements InterfaceSerializer
{
    /**
     * @return string
     */
    public function getName()
    {
        return "Json";
    }

    /**
     * @param string $content
     * @return string
     */
    public function serialize($content)
    {
        return json_encode($content);
    }

    /**
     * @param string $content
     * @return string
     */
    public function unserialize($content)
    {
        return json_decode($content, true);
    }
}