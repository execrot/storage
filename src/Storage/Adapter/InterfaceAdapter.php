<?php

/**
 * Interface InterfaceAdapter
 *
 * @category Storage
 * @package  Storage\Adapter
 */

namespace Storage\Adapter;

interface InterfaceAdapter
{
    /**
     * @param array $config
     * @return void
     */
    public function setConfig(array $config = array());

    /**
     * @param string $option
     * @return array|string
     */
    public function getConfig($option = null);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $content
     * @param string $ext
     * @param string $identifier
     *
     * @return null|string
     * @throws \Exception
     */
    public function save($content, $ext = null, $identifier = null);

    /**
     * @param string $filePath
     * @param string $ext
     * @param string $identifier
     *
     * @return mixed
     * @throws \Exception
     */
    public function saveFile($filePath, $ext = null, $identifier = null);

    /**
     * @param string $identifier
     * @param string $ext
     *
     * @return string
     */
    public function get($identifier, $ext = null);

    /**
     * @param string $identifier
     * @param string $ext
     *
     * @return mixed
     */
    public function getUrl($identifier, $ext = null);

    /**
     * @param string $identifier
     * @param string $ext
     *
     * @return bool
     */
    public function delete($identifier, $ext = null);
}