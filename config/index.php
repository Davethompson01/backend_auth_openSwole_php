<?php
require __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/db.php";
use config\database\db_connect;

// Load env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Start server
new db_connect();
