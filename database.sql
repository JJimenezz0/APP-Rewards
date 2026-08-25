CREATE DATABASE IF NOT EXISTS vintage_store_db;
USE vintage_store_db;

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_email VARCHAR(100) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario de prueba: email -> admin@vintagestore.com | password -> password123
INSERT INTO users (user_email, user_password) VALUES 
('admin@admin.com', '123');