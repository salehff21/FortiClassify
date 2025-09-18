### FortiClassify

FortiClassify is a simple web-based system for file classification with user authentication, file upload, and an admin dashboard for management.

## 📂 Project Structure

FortiClassify/
│── about us.html # About page
│── alert.js # JavaScript alerts
│── contact us.php # Contact page
│── dashboard.php # Admin dashboard
│── db_connect.php # Database connection
│── FortiClassify.jpg # Logo or site image
│── home.html # Home page
│── login.php # User login
│── loginAdmin.php # Admin login
│── logout.php # Logout
│── register.php # User registration
│── script.js # Extra JavaScript scripts
│── UploadFile.php # File upload and classification
│── .git/ # Git version control data

markdown
Copy code

## ⚙️ Requirements

- PHP 7.4 or higher  
- Apache or Nginx web server  
- MySQL database  

## 🚀 Installation and Setup

1. Copy the project folder into your local web server directory (e.g., `htdocs` in XAMPP or `www` in WAMP).  
2. Create a MySQL database.  
3. Import the SQL schema for the project (if provided).  
4. Update database credentials inside `db_connect.php`:
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "fclassify_db";
Start the server and open in browser:

arduino
Copy code
http://localhost/FortiClassify
🔑 Features
User and admin login system

User registration

File upload and classification

Dashboard for managing users and files

Informational pages: About Us, Contact Us

📌 Notes
Ensure upload permissions are set on the server for file handling.

Secure the application before production use (sanitize inputs, validate file uploads, configure HTTPS).
Eng: Saleh Al-shaebi
