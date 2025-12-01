 CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,  
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE users 
ADD COLUMN reset_code VARCHAR(10) NULL,
ADD COLUMN reset_expires DATETIME NULL,
ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0;

UPDATE users
SET is_admin = 1
WHERE email = 'cfish@tocfoodmarket.com';
