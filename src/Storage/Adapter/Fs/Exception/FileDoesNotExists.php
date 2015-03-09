<?php

/**
 * Class FileDoesNotExists
 *
 * @category   Storage
 * @package    Storage\Adapter\Fs
 * @subpackage Storage\Adapter\Fs\Exception
 */
namespace Storage\Adapter\Fs\Exception;

class FileDoesNotExists extends \Exception
{
    /**
     * @param string $file
     */
    public function __construct($file)
    {
        parent::__construct("Requested file '{$file}' die not exists");
    }
}