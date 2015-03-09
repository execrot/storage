<?php

/**
 * Class Fs
 *
 * @category Storage
 * @package  Storage\Adapter
 */

namespace Storage\Adapter;

use Storage\Adapter\Fs\Exception\FileDoesNotExists;
use Storage\Adapter\Fs\Exception\FileIsNotReadable;
use Storage\Adapter\Fs\Exception\FileIsNotWritable;
use Storage\Adapter\Fs\Exception\FolderIsNotWritable;
use Storage\Adapter\Fs\Exception\StoragePathDoesNotExists;
use Storage\Adapter\Fs\Exception\StoragePathIsNotSpecified;
use Storage\Adapter\Fs\Exception\StoragePathIsNotWritable;
use Storage\Adapter\Fs\Exception\UnableToCopyFile;
use Storage\Adapter\Fs\Exception\UnableToSaveFile;

class Fs implements InterfaceAdapter
{
    /**
     * @var array
     */
    protected $_config = array();

    /**
     * @param array $config
     * @throws \Exception
     */
    public function setConfig(array $config = array())
    {
        if (empty($config['path'])) {
            throw new StoragePathIsNotSpecified();
        }

        if (!file_exists($config['path'])) {
            throw new StoragePathDoesNotExists($config['path']);
        }

        if (!is_writable($config['path'])) {
            throw new StoragePathIsNotWritable($config['path']);
        }

        $this->_config = $config;
    }

    /**
     * @param string $option
     * @return array|string
     */
    public function getConfig($option = null)
    {
        if (!empty($this->_config[$option])) {
            return $this->_config[$option];
        }
        return $this->_config;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "File System";
    }

    /**
     * @param string $content
     * @param string $ext
     * @param string $identifier
     *
     * @return null|string
     * @throws \Exception
     */
    public function save($content, $ext = null, $identifier = null)
    {
        if (!$identifier) {
            $identifier = md5(microtime());
        }

        try {
            $filePath = $this->_getAbsoluteFilePath($identifier, $ext, true);
            file_put_contents($filePath, $content);
            chmod($filePath, 0777);
        }
        catch (\Exception $e) {
            throw new UnableToSaveFile($e->getMessage());
        }

        return $identifier;
    }

    /**
     * @param string $filePath
     * @param string $ext
     * @param string $identifier
     *
     * @return mixed
     * @throws \Exception
     */
    public function saveFile($filePath, $ext = null, $identifier = null)
    {
        if (!file_exists($filePath)) {
            throw new FileDoesNotExists($filePath);
        }

        if (!is_readable($filePath)) {
            throw new FileIsNotReadable($filePath);
        }

        if (!$identifier) {
            $identifier = md5(microtime());
        }

        try {
            $newFilePath = $this->_getAbsoluteFilePath($identifier, $ext, true);
            copy($filePath, $newFilePath);
            chmod($newFilePath, 0777);
        }
        catch(\Exception $e) {
            throw new UnableToCopyFile($e->getMessage());
        }

        return $identifier;
    }

    /**
     * @param string $identifier
     * @param string $ext
     *
     * @return null|string
     * @throws \Exception
     */
    public function get($identifier, $ext = null)
    {
        $filePath = $this->_getAbsoluteFilePath($identifier, $ext);

        if (file_exists($filePath)) {

            if (!is_readable($filePath)) {
                throw new FileIsNotReadable($filePath);
            }

            return file_get_contents($filePath);
        }
        return null;
    }

    /**
     * @param string $identifier
     * @param string $ext
     *
     * @return bool
     * @throws \Exception
     */
    public function delete($identifier, $ext = null)
    {
        $filePath = $this->_getAbsoluteFilePath($identifier, $ext);
        $res = false;

        if (file_exists($filePath)) {
            if (!is_writable($filePath)) {
                throw new FileIsNotWritable($filePath);
            }
            $res = (bool)unlink($filePath);
        }

        try {

            $folderRelativePath = $this->_getRelativeFolderPath($identifier);

            $path = implode('/', array(
                $this->getConfig('path'),
                $folderRelativePath
            ));

            $count = count(explode('/', $folderRelativePath));

            for ($i = $count - 1; $i > -1; $i--) {
                rmdir($path);
                $path = dirname($path);
            }
        }
        catch (\Exception $e) {}

        return $res;
    }

    /**
     * @param string $identifier
     * @param string $ext
     *
     * @return string
     */
    public function getUrl($identifier, $ext = null)
    {
        return implode('/', array(
            $this->getConfig('url'),
            $this->_getRelativeFilePath($identifier, $ext)
        ));
    }

    /**
     * @param string $identifier
     * @param bool   $create
     *
     * @return null|string
     * @throws \Exception
     */
    private function _getRelativeFolderPath($identifier, $create = false)
    {
        $nesting = $this->getConfig('nesting');
        $step = $this->getConfig('step');

        $folder = null;

        for ($i=0; $i<$nesting; $i++) {

            $folder = implode('/', array_filter(array(
                $folder,
                substr($identifier, $i*$step, $step)
            )));

            if ($create) {
                $path = implode('/', array(
                    $this->getConfig('path'),
                    $folder
                ));

                if (!file_exists($path)) {
                    if (!is_writable(dirname($path))) {
                        throw new FolderIsNotWritable(dirname($path));
                    }

                    mkdir($path);
                    chmod($path, 0777);
                }
            }
        }

        return $folder;
    }

    /**
     * @param string $identifier
     * @param string $ext
     * @param bool   $create
     *
     * @return string
     */
    private function _getRelativeFilePath($identifier, $ext = null, $create = false)
    {
        return implode('/', array(
            $this->_getRelativeFolderPath($identifier, $create),
            implode('.', array_filter(array($identifier, $ext)))
        ));
    }

    /**
     * @param string $identifier
     * @param string $ext
     * @param bool   $create
     *
     * @return string
     */
    private function _getAbsoluteFilePath($identifier, $ext = null, $create = false)
    {
        return implode('/', array(
            $this->getConfig('path'),
            $this->_getRelativeFilePath($identifier, $ext, $create)
        ));
    }
}