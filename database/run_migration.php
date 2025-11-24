<?php
// Simple migration runner that uses the Database class in config/database.php
// Usage (CLI): php run_migration.php
// This will attempt to create the database and tables using the project's Database class.

require_once __DIR__ . '/../config/database.php';

$db = new Database();
echo "Starting migration...\n";
$ok = $db->initializeDatabase();
if ($ok) {
    echo "Migration completed successfully.\n";
} else {
    echo "Migration failed. Check your MySQL credentials and server.\n";
}

?>
