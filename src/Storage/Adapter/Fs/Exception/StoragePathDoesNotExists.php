<?php

/**
 * Class StoragePathDoesNotExists
 *
 * @category   Storage
 * @package    Storage\Adapter\Fs
 * @subpackage Storage\Adapter\Fs\Exception
 */
namespace Storage\Adapter\Fs\Exception;

class StoragePathDoesNotExists extends \Exception
{
    /**
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct("Storage path '{$path}' does not exists");
    }
}