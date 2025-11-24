<?php
/**
 * Script Setup Database Otomatis
 * Jalankan file ini sekali untuk setup database
 * Akses melalui: http://localhost/Project1/setup.php
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Setup Database</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        .success { color: green; padding: 10px; background: #f0fff0; border: 1px solid green; }
        .error { color: red; padding: 10px; background: #fff0f0; border: 1px solid red; }
        .info { color: blue; padding: 10px; background: #f0f8ff; border: 1px solid blue; }
    </style>
</head>
<body>
    <h1>Setup Database CRUD Application</h1>
";

try {
    // Include config file
    require_once 'config/database.php';
    
    echo "<div class='info'>Starting database migration...</div>";
    
    $database = new Database();
    
    // Initialize database
    if ($database->initializeDatabase()) {
        echo "<div class='success'>✓ Database initialized successfully</div>";
        
        // Test connection
        $conn = $database->getConnection();
        if ($conn) {
            echo "<div class='success'>✓ Database connection successful</div>";
            
            // Check if tables exist and have data
            $stmt = $conn->query("SELECT COUNT(*) as user_count FROM data_users");
            $result = $stmt->fetch();
            
            echo "<div class='success'>✓ Found " . $result['user_count'] . " users in database</div>";
            echo "<div class='success'>🎉 Migration completed successfully!</div>";
            echo "<p>You can now access the CRUD application: <a href='index.php'>Go to Application</a></p>";
        }
    } else {
        echo "<div class='error'>✗ Database initialization failed</div>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>✗ Migration failed: " . $e->getMessage() . "</div>";
}

echo "</body></html>";
?>