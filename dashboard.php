<?php
include 'db_connect.php';
session_start(); // تأكد من بدء الجلسة
// تحقق من أن المستخدم مسجل الدخول
if (!isset($_SESSION['user_id'])) {
    $message = "You must be logged in to upload files.";
    echo "<script type='text/javascript'>
            window.location.href = 'loginAdmin.php';
          </script>";
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - File Management</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    
</head>
<body>

    <header>
        <img src="FortiClassify.jpg" alt="logo" class="logo">
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="UploadFile.php">Upload File</a></li>
                <li><a href="About Us.html">About Us</a></li>
                <li><a href="contact us.php">Contact Us</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>File Management</h1>

        <label for="classification">Filter by Classification:</label>
        <select id="classification" name="classification" onchange="filterFiles()">
            <option value="all">All</option>
            <option value="Top Secret">Top Secret</option>
            <option value="Secret">Secret</option>
            <option value="Restricted">Restricted</option>
            <option value="Public">Public</option>
        </select>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>File Name</th>
                    <th>User Name</th>
                    <th>Classification</th>
                    <th>Upload Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT f.id, f.file_name, u.name, f.classification, f.upload_date, f.file_path 
                          FROM files f 
                          JOIN users u ON f.user_id = u.id";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='file-row' data-classification='" . $row['classification'] . "'>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['file_name'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['classification'] . "</td>";
                    echo "<td>" . $row['upload_date'] . "</td>";
                    echo "<td><a href='" . $row['file_path'] . "' target='_blank' class='view-btn'>View</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2025 FortiClassify. All rights reserved.</p>
    </footer>

    <script>
        function filterFiles() {
            var selectedClassification = document.getElementById("classification").value;
            var rows = document.querySelectorAll(".file-row");
            rows.forEach(row => {
                if (selectedClassification === "all" || row.dataset.classification === selectedClassification) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>

</body>
</html>
 <style>.view-btn {
    background-color: #28a745; /* أخضر زاهي */
    color: white;
    border: none;
    padding: 10px 18px;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: background 0.3s ease-in-out;
}

.view-btn:hover {
    background-color: #218838; /* لون أغمق عند التمرير */
}
</style>