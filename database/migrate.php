<?php
/**
 * Script Migrasi Database - Untuk command line
 * Jalankan: php database/migrate.php
 */

// Cek jika dijalankan dari command line
if (php_sapi_name() !== 'cli') {
    die("This script can only be run from command line");
}

echo "Starting database migration...\n";

try {
    // Include config file - path relative to this file
    require_once __DIR__ . '/../config/database.php';
    
    $database = new Database();
    
    // Initialize database
    if ($database->initializeDatabase()) {
        echo "✓ Database initialized successfully\n";
        
        // Test connection
        $conn = $database->getConnection();
        if ($conn) {
            echo "✓ Database connection successful\n";
            
            // Check if tables exist and have data
            $stmt = $conn->query("SELECT COUNT(*) as user_count FROM data_users");
            $result = $stmt->fetch();
            
            echo "✓ Found " . $result['user_count'] . " users in database\n";
            echo "\n🎉 Migration completed successfully!\n";
            echo "You can now access the CRUD application at: http://localhost/Project1/index.php\n";
        }
    } else {
        echo "✗ Database initialization failed\n";
    }
    
} catch (Exception $e) {
    echo "✗ Migration failed: " . $e->getMessage() . "\n";
}
?>