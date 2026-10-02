<?php
mysqli_report(MYSQLI_REPORT_OFF);

$host = getenv('MYSQLHOST')     ?: 'localhost';
$dbn  = getenv('MYSQLDATABASE') ?: 'railway';
$user = getenv('MYSQLUSER')     ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';
$port = (int)(getenv('MYSQLPORT') ?: 3306);

$conn = @new mysqli($host, $user, $pass, $dbn, $port);
$db_connected = !$conn->connect_error;

if (!$db_connected) {
    error_log('MySQL connect error: ' . $conn->connect_error . ' | host=' . $host . ' port=' . $port . ' db=' . $dbn);
} else {
    $conn->set_charset('utf8mb4');
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL,
        mobile VARCHAR(30) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) CHARACTER SET utf8mb4");
}

function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

if (isset($_POST['submit'])) {
    if (!$db_connected) {
        echo "<p style='color: red;'>Database not connected. Cannot insert data.</p>";
    } else {
        $name   = trim($_POST['name']   ?? '');
        $email  = trim($_POST['email']  ?? '');
        $mobile = trim($_POST['mobile'] ?? '');

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $mobile === '') {
            echo "<p style='color: red;'>กรุณากรอกข้อมูลให้ครบและอีเมลให้ถูกต้อง</p>";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, mobile) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $email, $mobile);
            if ($stmt->execute()) {
                echo "<p style='color: green;'>New record has been added successfully!</p>";
            } else {
                error_log('Insert failed: ' . $stmt->error);
                echo "<p style='color: red;'>บันทึกไม่สำเร็จ ลองใหม่อีกครั้ง</p>";
            }
            $stmt->close();
        }
    }
}

$users = [];
if ($db_connected) {
    if ($result = $conn->query('SELECT name, email, mobile FROM users ORDER BY id DESC')) {
        while ($row = $result->fetch_object()) {
            $users[] = $row;
        }
    }
}

echo "<h4>Registered Users:</h4>";
if (!empty($users)) {
    foreach ($users as $u) {
        echo e($u->name) . " | " . e($u->email) . " | " . e($u->mobile) . "<br>";
    }
} else {
    echo "No records found (or Database not connected yet).";
}

if ($db_connected) {
    $conn->close();
}
