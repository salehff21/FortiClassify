<?php
include 'db_connect.php'; // الاتصال بقاعدة البيانات
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message_text = mysqli_real_escape_string($conn, $_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message_text)) {
        $query = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message_text')";
        if (mysqli_query($conn, $query)) {
            $message = "Your message has been sent successfully!";
        } else {
            $message = "Error: Could not send message.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* تنسيق الصفحة بالكامل */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
          
        }

        /* تنسيق الهيدر */
        header {
            background-color: #2d3e50;
            color: white;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* تنسيق الفوتر */
        footer {
            background-color: #2d3e50;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 0.9em;
            margin-top: auto;
        }

        /* وضع الفورم في منتصف الصفحة */
        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            padding: 20px;
        }

        /* صندوق الفورم */
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        /* تنسيق الحقول والأزرار */
        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, textarea {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #2d3e50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 90%;
            transition: 0.3s;
        }

        button:hover {
            background-color: #1c2c3f;
            transform: scale(1.05);
        }

        /* رسالة نجاح الإرسال */
        .message-box {
            text-align: center;
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 15px;
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

    <div class="content">
        <div class="form-container">
            <h1>Contact Us</h1>
            <p>You can reach us via email or phone:</p>
            <p><strong>Email:</strong> FortiClassify@gmail.com</p>
            <p><strong>Phone:</strong> +966 123 456 789</p>

            <h3>Send Us a Message</h3>

            <?php if ($message): ?>
                <div class="message-box"><?= $message ?></div>
            <?php endif; ?>

            <form action="contact us.php" method="post">
                <div>
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div>
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div>
                    <label for="message">Your Message:</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>

                <button type="submit">Send</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 FortiClassify. All rights reserved.</p>
    </footer>

</body>
</html>
