<?php 
session_start();
include 'db_connect.php'; // الاتصال بقاعدة البيانات

$message = ""; // متغير لحفظ الرسائل
$redirect = false; // متغير لتحديد ما إذا كان سيتم التوجيه

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // التحقق من الحقول الفارغة
    if (empty($email) || empty($password)) {
        $message = "Please enter your email and password.";
    } else {

        // البحث عن المستخدم في قاعدة البيانات
        $stmt = $conn->prepare("SELECT id, name, password, `IsAdmin` FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // التحقق من كلمة المرور
            if (password_verify($password, $row['password'])) {
                // التحقق من إذا كان المستخدم أدمن
                if ($row['IsAdmin'] == 1) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_is_admin'] = $row['IsAdmin'];  // تخزين إذا كان المستخدم أدمن
                    $message = "Login successful! Redirecting to admin dashboard...";
                    $redirect = true; // تفعيل إعادة التوجيه
                } else {
                    $message = "You do not have admin privileges.";
                }
            } else {
                $message = "Incorrect password.";
            }
        } else {
            $message = "Email not registered.";
        }

        // إغلاق الاتصال
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | FortiClassify</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* تنسيق الرسالة */
        .popup-message {
            display: none;
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
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

    <div>
        <h1>Admin Login to FortiClassify</h1>

        <!-- Popup Message -->
        <?php if (!empty($message)): ?>
            <div id="popupMessage" class="popup-message <?= $redirect ? '' : 'error-message' ?>">
                <?= $message; ?>
            </div>
            <script>
                document.getElementById('popupMessage').style.display = 'block';
                setTimeout(function() {
                    var popup = document.getElementById('popupMessage');
                    if (popup) {
                        popup.style.display = 'none';
                    }
                }, 1500);

                <?php if ($redirect): ?>
                    // إذا كانت إعادة التوجيه باستخدام JavaScript
                    setTimeout(function() {
                        console.log("Redirecting to dashboard.php...");
                        window.location.href = "dashboard.php"; // إعادة التوجيه إلى لوحة التحكم الخاصة بالإدمن
                    }, 1000);
                <?php endif; ?>
            </script>
        <?php endif; ?>

        <form method="post" action="loginAdmin.php">
            <fieldset>
                <legend>Login Information</legend>
                <p>Please log in to continue as an admin</p>

                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit">Login</button>

                <p>Don't have an account? <a href="register.php">Regester</a></p>
            </fieldset>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 FortiClassify. All rights reserved.</p>
    </footer>
</body>
</html>
