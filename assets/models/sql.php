<?php
namespace SafeDB;

use InvalidArgumentException;
use OpenSwoole\Coroutine\MySQL as DB;
use controllers\utilis\controller_utilis;

class TableBuilder {
    private DB $db;
    private array $allowedTypes = [
        'INT', 'BIGINT', 'VARCHAR', 'TEXT', 'BOOLEAN',
        'DATE', 'DATETIME', 'TIMESTAMP', 'DECIMAL', 'FLOAT'
    ];

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function create(string $tableName, string ...$columns): string
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
            throw new InvalidArgumentException("Invalid table name: {$tableName}");
        }

        $cleanColumns = [];

        foreach ($columns as $colDef) {
            $parts = preg_split('/\s+/', trim($colDef), 2);
            if (count($parts) < 2) {
                throw new InvalidArgumentException("Invalid column definition: {$colDef}");
            }

            [$colName, $colType] = $parts;

            if (!preg_match('/^[a-zA-Z0-9_]+$/', $colName)) {
                throw new InvalidArgumentException("Invalid column name: {$colName}");
            }

            $typeOk = false;
            foreach ($this->allowedTypes as $type) {
                if (stripos($colType, $type) === 0) {
                    $typeOk = true;
                    break;
                }
            }
            if (!$typeOk) {
                throw new InvalidArgumentException("Invalid column type: {$colType}");
            }

            $cleanColumns[] = "{$colName} {$colType}";
        }

        $sql = "CREATE TABLE IF NOT EXISTS {$tableName} (" . implode(", ", $cleanColumns) . ")";

        $result = $this->db->query($sql);

        if ($result === false) {
            return controller_utilis::returnData(false, "Error creating table: " . $this->db->error);
        }

        return controller_utilis::returnData(true, "Table {$tableName} created successfully.");
    }
}
