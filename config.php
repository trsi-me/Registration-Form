<?php
// إعدادات الاتصال بقاعدة البيانات
$host = 'localhost';
$dbname = 'registration';
$username = 'root';
$password = '';

// الاتصال بقاعدة البيانات
$conn = new mysqli($host, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// تعيين الترميز
$conn->set_charset("utf8");

// بدء الجلسة
session_start();
?>

