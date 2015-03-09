<?php

/**
 * Class Base64
 *
 * @category Storage
 * @package  Storage\Serializer
 */

namespace Storage\Serializer;

class Base64 implements InterfaceSerializer
{
    /**
     * @return string
     */
    public function getName()
    {
        return "Base64";
    }

    /**
     * @param string $content
     * @return string
     */
    public function serialize($content)
    {
        return base64_encode($content);
    }

    /**
     * @param string $content
     * @return string
     */
    public function unserialize($content)
    {
        return base64_decode($content);
    }
}