<?php

/**
 * Class UnableToCopyFile
 *
 * @category   Storage
 * @package    Storage\Adapter\Fs
 * @subpackage Storage\Adapter\Fs\Exception
 */
namespace Storage\Adapter\Fs\Exception;

class UnableToCopyFile extends \Exception
{
    /**
     * @param string $reason
     */
    public function __construct($reason)
    {
        parent::__construct("Unable to copy file: {$reason}");
    }
}