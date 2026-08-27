CREATE DATABASE IF NOT EXISTS vintage_store_db;
USE vintage_store_db;

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    user_email VARCHAR(100) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    points INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario de prueba inicial
INSERT IGNORE INTO users (user_name, user_email, user_password, points)
VALUES ('Admin', 'admin@admin.com', '123', 100);
