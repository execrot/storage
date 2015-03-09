<?php

namespace Storage;

use Storage\Adapter\Fs;
use Storage\Adapter\InterfaceAdapter;
use Storage\Serializer\InterfaceSerializer;

/**
 * @package Storage
 *
 * @method string getName  ()
 * @method string saveFile (string $filePath,   string $ext = null)
 * @method string getUrl   (string $identifier, string $ext = null)
 * @method string delete   (string $identifier, string $ext = null)
 */
class Storage
{
    /**
     * @var array
     */
    protected static $_config = array();

    /**
     * @param string $option
     *
     * @return array
     */
    public static function getConfig($option = null)
    {
        if (!empty(self::$_config[$option])) {
            return self::$_config[$option];
        }
        return self::$_config;
    }

    /**
     * @param array $config
     */
    public static function setConfig(array $config = array())
    {
        self::$_config = $config;
    }

    /**
     * @var array
     */
    protected $_serializers = array();

    /**
     * @var InterfaceAdapter
     */
    protected $_adapter = null;

    /**
     * @return InterfaceSerializer[]
     */
    public function getSerializers()
    {
        return $this->_serializers;
    }

    /**
     * @param InterfaceSerializer[] $serializers
     * @throws \Exception
     */
    public function setSerializers(array $serializers)
    {
        $this->_serializers = array();

        foreach ($serializers as $serializer) {

            if (!$serializer instanceof InterfaceSerializer) {

                throw new \Exception("Unsupported serializer " . get_class($serializer));
            }

            $this->_serializers[] = $serializer;
        }
    }

    /**
     * @return InterfaceAdapter
     */
    public function getAdapter()
    {
        if (!$this->_adapter) {
            $this->_adapter = new Fs();
            $this->_adapter->setConfig(self::getConfig());
        }

        return $this->_adapter;
    }

    /**
     * @param mixed  $content
     * @param string $ext
     * @param string $identifier
     *
     * @return null|string
     * @throws \Exception
     */
    public function save($content, $ext = null, $identifier = null)
    {
        foreach ($this->getSerializers() as $serializer) {
            $content = $serializer->serialize($content);
        }

        return $this->getAdapter()->save($content, $ext, $identifier);
    }

    /**
     * @param string $identifier
     * @param string $ext
     *
     * @return mixed
     */
    public function get($identifier, $ext = null)
    {
        $content = $this->getAdapter()->get($identifier, $ext);

        $serializers = $this->getSerializers();

        for ($i=count($serializers)-1; $i>-1; $i--) {
            $content = $serializers[$i]->unserialize($content);
        }

        return $content;
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $args)
    {
        if (!method_exists($this->getAdapter(), $name)) {
            throw new \Exception("Adapter {$this->getAdapter()->getName()} does not support {$name} method");
        }

        return call_user_func_array(array($this->getAdapter(), $name), $args);
    }
}