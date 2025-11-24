<?php
class UserModel {
    private $conn;
    private $table_name = "data_users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create new user
    public function create($nama, $email, $telepon, $alamat, $status = 'active') {
        $query = "INSERT INTO " . $this->table_name . " 
                 (nama, email, telepon, alamat, status) 
                 VALUES (:nama, :email, :telepon, :alamat, :status)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nama", $nama);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telepon", $telepon);
        $stmt->bindParam(":alamat", $alamat);
        $stmt->bindParam(":status", $status);
        
        return $stmt->execute();
    }

    // Read all users
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read one user by ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user
    public function update($id, $nama, $email, $telepon, $alamat, $status = 'active') {
        $query = "UPDATE " . $this->table_name . " 
                 SET nama=:nama, email=:email, telepon=:telepon, 
                     alamat=:alamat, status=:status 
                 WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":nama", $nama);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telepon", $telepon);
        $stmt->bindParam(":alamat", $alamat);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    // Delete user
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        return $stmt->execute();
    }

    // Check if email already exists
    public function emailExists($email, $exclude_id = null) {
        $query = "SELECT id FROM " . $this->table_name . " 
                 WHERE email = :email";
        
        if ($exclude_id) {
            $query .= " AND id != :exclude_id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        
        if ($exclude_id) {
            $stmt->bindParam(":exclude_id", $exclude_id);
        }
        
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Get user statistics
    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total_users,
                    SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) as active_users,
                    SUM(CASE WHEN status = 'inactive' THEN 1 ELSE 0 END) as inactive_users
                  FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>