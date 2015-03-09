<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once "vendor/autoload.php";

\Storage\Storage::setConfig(array(
    'nesting' => 4,
    'step' => 4,
    'path' => '{path-to-storage-directory}',
    'url' => '{url-to-saved-files}'
));

$storage = new Storage\Storage();

$storage->setSerializers(array(
    new Storage\Serializer\Php(),
    new \Storage\Serializer\Base64()
));

$id = $storage->save(array(
    'param1' => 'value1',
    'param2' => 'value2'
));

var_dump($storage->get($id));

$storage->delete($id);