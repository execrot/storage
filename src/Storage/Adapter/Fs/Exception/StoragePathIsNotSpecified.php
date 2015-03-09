<?php

/**
 * Class StoragePathIsNotSpecified
 *
 * @category   Storage
 * @package    Storage\Adapter\Fs
 * @subpackage Storage\Adapter\Fs\Exception
 */
namespace Storage\Adapter\Fs\Exception;

class StoragePathIsNotSpecified extends \Exception
{
    /**
     * Overload exception message
     */
    public function __construct()
    {
        parent::__construct("Storage path is not specified");
    }
}