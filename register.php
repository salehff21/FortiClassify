<?php
include 'db_connect.php'; // استدعاء ملف الاتصال بقاعدة البيانات

// التعامل مع إرسال البيانات من النموذج
$message = ""; // متغير لرسالة النجاح أو الخطأ
$messageClass = ""; // متغير لتحديد الكلاس المناسب للرسالة (نجاح أو فشل)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // التحقق مما إذا كان المستخدم يريد التسجيل كمدير
    $isAdmin = isset($_POST['isAdmin']) ? 1 : 0; // إذا تم تحديد الـ checkbox تكون القيمة 1، وإلا تكون 0

    if (empty($name) || empty($email) || empty($password)) {
        $message = "الرجاء ملء جميع الحقول.";
        $messageClass = "error";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, IsAdmin) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $email, $hashed_password, $isAdmin);

        if ($stmt->execute()) {
            $message = "تم التسجيل بنجاح!";
            $messageClass = "success";
            echo "<script>
                    setTimeout(function(){
                        window.location.href = 'login.php';
                    }, 2000);
                  </script>";
        } else {
            $message = "حدث خطأ أثناء التسجيل: " . $stmt->error;
            $messageClass = "error";
        }

        $stmt->close();
        $conn->close();
    }
}?>

<!DOCTYPE html>
<html lang="en">
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background-color: #4CAF50;
            color: white;
        }
        .error {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>

    <header>        
        <img src="FortiClassify.jpg" alt="logo" class="logo">
        <nav>            
            <ul>
                <li><a href="home.html">Home</a></li>            
            </ul>
        </nav>
    </header>

    <h1>Register</h1>

    <!-- عرض الرسالة إن وجدت -->
    <?php if ($message): ?>
        <div class="message <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <fieldset>
        <legend>User Information</legend>        
        <form id="signupForm" method="post" action=""> <!-- تعديل هنا -->
            <label for="name">Name:</label><br>            
            <input type="text" id="name" name="name" required><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label><br>            
            <input type="password" id="password" name="password" required oninput="checkPasswordStrength()"><br>
                        
            <div id="password-strength"></div>
            <p id="strength-text"></p>   
            <label for="isAdmin">Register as Admin:</label>
            <input type="checkbox" id="isAdmin" name="isAdmin" value="1"><br>
            <button type="submit">Register</button>
        </form>    
    </fieldset>

    <p>Already have an account? <a href="login.php">Log In</a></p>

    <footer>
        <p>&copy; 2025 FortiClassify. All rights reserved.</p>    
    </footer>

    <script src="script.js"></script>
</body>
</html>
