<?php

use kiwi\Database\Connection;
use kiwi\System\Filesystem;
use kiwi\Database\Model;

if (!Filesystem::find('Custom' . DIRECTORY_SEPARATOR . 'config.php')) {
    return;
}

Model::boot(Connection::make(require 'Custom' . DIRECTORY_SEPARATOR . 'config.php'));