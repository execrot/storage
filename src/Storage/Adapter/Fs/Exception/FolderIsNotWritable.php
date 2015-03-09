<?php

/**
 * Class FolderIsNotWritable
 *
 * @category   Storage
 * @package    Storage\Adapter\Fs
 * @subpackage Storage\Adapter\Fs\Exception
 */
namespace Storage\Adapter\Fs\Exception;

class FolderIsNotWritable extends \Exception
{
    /**
     * @param string $folder
     */
    public function __construct($folder)
    {
        parent::__construct("Requested folder '{$folder}' is not writable");
    }
}