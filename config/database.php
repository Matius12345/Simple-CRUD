<?php
class Database {
    // Coba koneksi yang berbeda-beda
    private $host = "localhost";
    private $username = "root";
    private $password = ""; // Coba kosongkan dulu
    private $database = "crud_simple";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        // Coba beberapa kemungkinan koneksi
        $connectionAttempts = [
            ["mysql:host=" . $this->host . ";dbname=" . $this->database . ";charset=utf8mb4", $this->username, $this->password],
            ["mysql:host=127.0.0.1;dbname=" . $this->database . ";charset=utf8mb4", $this->username, $this->password],
            ["mysql:host=localhost;dbname=" . $this->database . ";charset=utf8mb4", "root", "root"], // Coba password 'root'
            ["mysql:host=localhost;dbname=" . $this->database . ";charset=utf8mb4", "root", "password"], // Coba password 'password'
        ];
        
        foreach ($connectionAttempts as $attempt) {
            try {
                $this->conn = new PDO($attempt[0], $attempt[1], $attempt[2]);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                echo "<div class='success'>✓ Connected to database successfully</div>";
                return $this->conn;
            } catch(PDOException $exception) {
                continue; // Coba koneksi berikutnya
            }
        }
        
        echo "<div class='error'>✗ All connection attempts failed</div>";
        return null;
    }

    public function initializeDatabase() {
        try {
            // Coba koneksi tanpa database dulu
            $temp_conn = null;
            $connectionAttempts = [
                ["mysql:host=localhost", "root", ""],
                ["mysql:host=127.0.0.1", "root", ""],
                ["mysql:host=localhost", "root", "root"],
                ["mysql:host=localhost", "root", "password"],
            ];
            
            foreach ($connectionAttempts as $attempt) {
                try {
                    $temp_conn = new PDO($attempt[0], $attempt[1], $attempt[2]);
                    $temp_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    break;
                } catch(PDOException $e) {
                    continue;
                }
            }
            
            if (!$temp_conn) {
                throw new Exception("Cannot connect to MySQL server");
            }
            
            // Buat database jika belum ada
            $sql = "CREATE DATABASE IF NOT EXISTS " . $this->database . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $temp_conn->exec($sql);
            
            // Gunakan database
            $temp_conn->exec("USE " . $this->database);
            
            // Buat tabel data_users
            $sql = "CREATE TABLE IF NOT EXISTS data_users (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                nama VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                telepon VARCHAR(20) NOT NULL,
                alamat TEXT NOT NULL,
                status ENUM('active', 'inactive') DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB";
            $temp_conn->exec($sql);
            
            // Insert sample data jika tabel kosong
            $stmt = $temp_conn->query("SELECT COUNT(*) as count FROM data_users");
            $result = $stmt->fetch();
            
            if ($result['count'] == 0) {
                $sample_data = [
                    ['John Doe', 'john.doe@example.com', '081234567890', 'Jl. Merdeka No. 123, Jakarta'],
                    ['Jane Smith', 'jane.smith@example.com', '081298765432', 'Jl. Sudirman No. 456, Bandung'],
                    ['Bob Johnson', 'bob.johnson@example.com', '081112223334', 'Jl. Thamrin No. 789, Surabaya']
                ];
                
                $insert_stmt = $temp_conn->prepare(
                    "INSERT IGNORE INTO data_users (nama, email, telepon, alamat) VALUES (?, ?, ?, ?)"
                );
                
                foreach ($sample_data as $data) {
                    $insert_stmt->execute($data);
                }
            }
            
            $temp_conn = null;
            return true;
            
        } catch(PDOException $exception) {
            echo "<div class='error'>Database Error: " . $exception->getMessage() . "</div>";
            return false;
        } catch(Exception $exception) {
            echo "<div class='error'>Error: " . $exception->getMessage() . "</div>";
            return false;
        }
    }
}
?>