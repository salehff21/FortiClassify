<?php
$host = "localhost";  // اسم المضيف (غالبًا localhost)
$user = "root";       // اسم المستخدم لقاعدة البيانات
$password = "";       // كلمة المرور (اتركها فارغة إذا كنت تستخدم السيرفر المحلي XAMPP)
$dbname = "fclassify_db";  // اسم قاعدة البيانات

// إنشاء الاتصال
$conn = new mysqli($host, $user, $password, $dbname);

// التحقق من نجاح الاتصال
if ($conn->connect_error) {
    $message = "فشل الاتصال بقاعدة البيانات: " . $conn->connect_error;
} else {
    // ضبط ترميز الاتصال لضمان دعم اللغة العربية
    $conn->set_charset("utf8mb4");
    $message = "تم الاتصال بقاعدة البيانات بنجاح!";
}



?>
    