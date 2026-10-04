-- إنشاء قاعدة البيانات
CREATE DATABASE IF NOT EXISTS u741730784_registration;
USE u741730784_registration;

-- جدول المستخدمين (للتسجيل والدخول)
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- إضافة مستخدم افتراضي (username: admin, password: admin123)
INSERT INTO users (username, password) VALUES ('admin', MD5('admin123'));

-- جدول التسجيلات
CREATE TABLE IF NOT EXISTS registrations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    mobile_number VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    graduation_year INT NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

