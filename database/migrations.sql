-- Migration Script for CRUD Simple Website
-- Version: 1.0
-- Description: Initial database setup with sample data

-- Migration: 001_create_database
CREATE DATABASE IF NOT EXISTS crud_simple CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE crud_simple;

-- Migration: 002_create_data_users_table
CREATE TABLE IF NOT EXISTS data_users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telepon VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Migration: 003_create_activity_logs_table
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    action VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES data_users(id) ON DELETE SET NULL
);

-- Migration: 004_insert_sample_data
INSERT INTO data_users (nama, email, telepon, alamat) VALUES
('John Doe', 'john.doe@example.com', '081234567890', 'Jl. Merdeka No. 123, Jakarta'),
('Jane Smith', 'jane.smith@example.com', '081298765432', 'Jl. Sudirman No. 456, Bandung'),
('Bob Johnson', 'bob.johnson@example.com', '081112223334', 'Jl. Thamrin No. 789, Surabaya'),
('Alice Brown', 'alice.brown@example.com', '081556667778', 'Jl. Gatot Subroto No. 321, Medan'),
('Charlie Wilson', 'charlie.wilson@example.com', '081998887776', 'Jl. Asia Afrika No. 654, Yogyakarta');

-- Migration: 005_create_indexes
CREATE INDEX idx_email ON data_users(email);
CREATE INDEX idx_created_at ON data_users(created_at);
CREATE INDEX idx_action ON activity_logs(action);

-- Migration: 006_add_status_column (contoh migrasi tambahan)
ALTER TABLE data_users ADD COLUMN status ENUM('active', 'inactive') DEFAULT 'active' AFTER alamat;

-- Update sample data dengan status
UPDATE data_users SET status = 'active';