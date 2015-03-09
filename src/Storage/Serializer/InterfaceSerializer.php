<?php

/**
 * Interface InterfaceSerializer
 *
 * @category Storage
 * @package  Storage\Serializer
 */

namespace Storage\Serializer;

interface InterfaceSerializer
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $content
     * @return string
     */
    public function serialize($content);

    /**
     * @param string $content
     * @return string
     */
    public function unserialize($content);
}