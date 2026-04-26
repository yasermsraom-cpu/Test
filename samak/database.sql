-- =========================================
-- SAMAK - Fish Marketplace Database
-- =========================================
-- Run this file in phpMyAdmin to create
-- the database and all required tables.
-- =========================================

CREATE DATABASE IF NOT EXISTS samak_db
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE samak_db;

-- ----------- Users (Customer + Fisherman) -----------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('customer','fisherman') NOT NULL DEFAULT 'customer',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ----------- Admin -----------
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ----------- Fish products -----------
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category ENUM('Premium Fish','Local Fish') NOT NULL DEFAULT 'Local Fish',
    price DECIMAL(10,2) NOT NULL,
    quantity_kg DECIMAL(10,2) NOT NULL DEFAULT 0,
    image VARCHAR(255) DEFAULT 'default.png',
    in_service TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ----------- Cart -----------
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ----------- Orders -----------
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    address VARCHAR(255),
    delivery_type ENUM('Free','Fast') DEFAULT 'Free',
    total DECIMAL(10,2) NOT NULL,
    status ENUM('Pending','Out for delivery','Delivered','Cancelled') DEFAULT 'Pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ----------- Order items -----------
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- =========================================
-- Default Admin (username: admin / password: admin123)
-- =========================================
INSERT INTO admins (username, password)
VALUES ('admin', '$2y$10$wH8sAY5vF1mU7rKQ1y5V/.5b3XKZ0qZ8b1jKQqjKQqjKQqjKQqjKO');
-- NOTE: After install, login once and reset password from PHP page if needed.
-- Easier: replace the row by running:
-- UPDATE admins SET password = '<output of password_hash>' WHERE username='admin';

-- =========================================
-- Sample fish products
-- =========================================
INSERT INTO products (name, description, category, price, quantity_kg, image) VALUES
('King Fish',  'Fresh and rich flavor',           'Premium Fish', 4.500, 8.0,  'kingfish.png'),
('Tuna',       'Meaty and tasty fish',            'Premium Fish', 3.800, 6.0,  'tuna.png'),
('Sardine',    'Small, fresh, and soft',          'Local Fish',   1.200, 12.0, 'sardine.png'),
('Hamour',     'Tender and premium fish',         'Premium Fish', 5.200, 4.0,  'hamour.png'),
('Sea Bream',  'Light and delicate taste',        'Local Fish',   3.000, 5.0,  'seabream.png'),
('Mackerel',   'Oily and flavorful fish',         'Local Fish',   2.500, 7.0,  'mackerel.png'),
('Salmon',     'Premium imported salmon',         'Premium Fish', 6.000, 3.0,  'salmon.png');
