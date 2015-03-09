<?php

/**
 * Class StoragePathIsNotWritable
 *
 * @category   Storage
 * @package    Storage\Adapter\Fs
 * @subpackage Storage\Adapter\Fs\Exception
 */
namespace Storage\Adapter\Fs\Exception;

class StoragePathIsNotWritable extends \Exception
{
    /**
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct("Storage path '{$path}' is not writable");
    }
}