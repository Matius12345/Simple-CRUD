-- Buat database
CREATE DATABASE IF NOT EXISTS crud_simple CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Gunakan database
USE crud_simple;

-- Buat tabel users
CREATE TABLE IF NOT EXISTS data_users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telepon VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Buat tabel untuk logs (opsional)
CREATE TABLE IF NOT EXISTS activity_logs (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    action VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO data_users (nama, email, telepon, alamat) VALUES
('John Doe', 'john.doe@example.com', '081234567890', 'Jl. Merdeka No. 123, Jakarta'),
('Jane Smith', 'jane.smith@example.com', '081298765432', 'Jl. Sudirman No. 456, Bandung'),
('Bob Johnson', 'bob.johnson@example.com', '081112223334', 'Jl. Thamrin No. 789, Surabaya'),
('Alice Brown', 'alice.brown@example.com', '081556667778', 'Jl. Gatot Subroto No. 321, Medan'),
('Charlie Wilson', 'charlie.wilson@example.com', '081998887776', 'Jl. Asia Afrika No. 654, Yogyakarta');

-- Buat index untuk optimasi
CREATE INDEX idx_email ON data_users(email);
CREATE INDEX idx_created_at ON data_users(created_at);