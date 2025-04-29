<?php
session_start(); // بدء الجلسة

// تدمير جميع بيانات الجلسة
session_unset();
session_destroy();

// إعادة التوجيه إلى صفحة تسجيل الدخول
header("Location: login.php");
exit();