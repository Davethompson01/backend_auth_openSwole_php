<?php
namespace dbOPs;

use OpenSwoole\Coroutine\MySQL as DB;
use controllers\utilis\controller_utilis;

class db_operations {
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function test() {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE
        )";

        $result = $this->db->query($sql);

        if ($result === false) {
            return controller_utilis::returnData(false, "Error creating table: " . $this->db->error);
        }

        return controller_utilis::returnData(true, "Table users created successfully.");
    }
}
