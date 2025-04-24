<?php

namespace Alexey\MyProdject\Infrastructure;

use Alexey\MyProdject\Application\Application;
use PDO;

class Storage {

    private PDO $connection;

    public function __construct() {
        $this->connection = new PDO(
            Application::$config->get()['database']['DSN'] . ';charset=utf8',
            Application::$config->get()['database']['USER'], 
            Application::$config->get()['database']['PASSWORD'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    public function get(): PDO {
        return $this->connection;
    }
}