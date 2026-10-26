CREATE DATABASE IF NOT EXISTS cosulta CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cosulta;
CREATE TABLE IF NOT EXISTS users (
 id INT AUTO_INCREMENT PRIMARY KEY, full_name VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL, phone VARCHAR(25) NULL,
 role ENUM('customer','provider','admin') NOT NULL DEFAULT 'customer', status ENUM('active','inactive','suspended') NOT NULL DEFAULT 'active', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS provider_profiles (
 id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL UNIQUE, title VARCHAR(150) NOT NULL,
 specialization VARCHAR(150) NOT NULL, description TEXT NULL, consultation_price DECIMAL(10,2) NOT NULL DEFAULT 0,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS availability (
 id INT AUTO_INCREMENT PRIMARY KEY, provider_id INT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL,
 status ENUM('available','unavailable') NOT NULL DEFAULT 'available',
 FOREIGN KEY(provider_id) REFERENCES provider_profiles(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS appointments (
 id INT AUTO_INCREMENT PRIMARY KEY, customer_id INT NOT NULL, provider_id INT NOT NULL, availability_id INT NULL,
 start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, consultation_price DECIMAL(10,2) NOT NULL,
 status ENUM('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'confirmed', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(customer_id) REFERENCES users(id), FOREIGN KEY(provider_id) REFERENCES provider_profiles(id),
 FOREIGN KEY(availability_id) REFERENCES availability(id) ON DELETE SET NULL
);
CREATE TABLE IF NOT EXISTS payments (
 id INT AUTO_INCREMENT PRIMARY KEY, appointment_id INT NOT NULL, amount DECIMAL(10,2) NOT NULL,
 payment_method VARCHAR(50) DEFAULT 'demo', payment_status ENUM('pending','successful','failed','refunded') DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(appointment_id) REFERENCES appointments(id) ON DELETE CASCADE
);
-- الحسابات التجريبية: كلمة المرور لجميع الحسابات Demo123!
INSERT IGNORE INTO users (id,full_name,email,password_hash,role) VALUES
(1,'مدير النظام','admin@cosulta.test','$2y$10$8v4nq2yLzJf4v7j6V4mJ3e0Q5bH1uZQvQ7w6Yy1x5K1zY0b9KxT3a','admin');
-- أنشئي حسابات العملاء ومقدمي الخدمة من صفحة التسجيل. يمكن تغيير الدور في قاعدة البيانات للتجربة.
