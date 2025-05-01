<?php
 
include 'db_connect.php'; // Database connection
session_start(); // تأكد من بدء الجلسة
// تحقق من أن المستخدم مسجل الدخول
if (!isset($_SESSION['user_id'])) {
    $message = "You must be logged in to upload files.";
    echo "<script type='text/javascript'>
            window.location.href = 'login.php';
          </script>";
    exit();
}
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to upload files.");
}

// Handle file upload on form submission
 
$message = ""; // تعريف متغير الرسالة بشكل عام
$messageType = ""; // لتحديد لون الرسالة

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $classification = $_POST['classification'];
    $userId = $_SESSION['user_id'];

    // مسار حفظ الملفات
    $uploadDir = "uploads/";
    $filePath = $uploadDir . basename($fileName);

    if (move_uploaded_file($fileTmpName, $filePath)) {
        $stmt = $conn->prepare("INSERT INTO files (file_name, file_path, classification, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $fileName, $filePath, $classification, $userId);

        if ($stmt->execute()) {
            $message = "✅ File uploaded successfully!";
            $messageType = "success";
        } else {
            $message = "❌ An error occurred while saving data!";
            $messageType = "error";
        }
        $stmt->close();
    } else {
        $message = "❌ File upload failed!";
        $messageType = "error";
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Centering the form and its contents */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            display: block;
            margin-bottom: 8px;
            text-align: left;
        }

        input[type="file"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            font-size: 14px;
        }

        footer {
            text-align: center;
            width: 100%;
            position: absolute;
            bottom: 20px;
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

    <div class="form-container">
        <h1>Upload File</h1>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>

        <form id="uploadForm" action="UploadFile.php" method="POST" enctype="multipart/form-data">
            <label for="file">Choose file to upload:</label>
            <input type="file" id="file" name="file" required>
            
            <label for="classification">Choose classification:</label>
            <select id="classification" name="classification" required>
                <option value="Top Secret">Top Secret</option>
                <option value="Secret">Secret</option>
                <option value="Restricted">Restricted</option>
                <option value="Public">Public</option>
            </select>

            <input type="submit" value="Upload File">
        </form>

        <p id="error-message" class="error-message"></p>
    </div>

    <footer>
        <p>&copy; 2025 FortiClassify. All rights reserved.</p>
    </footer>

    <!-- JavaScript code for validation before upload -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const uploadForm = document.getElementById("uploadForm");
            uploadForm.addEventListener("submit", function (event) {
                const fileInput = document.getElementById("file");
                if (!fileInput.value) {
                    event.preventDefault();
                    document.getElementById("error-message").textContent = "Please select a file to upload.";
                } else {
                    document.getElementById("error-message").textContent = "";
                }
            });
        });
    </script>

</body>
</html>
