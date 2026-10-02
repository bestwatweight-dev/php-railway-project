<?php
// ตรวจสอบว่ารันอยู่บน Railway หรือ Local 
// บน Railway เราจะแยก Service ผ่าน Environment Variables หรือชื่อ Host ที่เชื่อมต่อ
$host = getenv('MYSQLHOST') ?: 'db';
$dbn  = getenv('MYSQLDATABASE') ?: 'php-app';
$user = getenv('MYSQLUSER') ?: 'USER';
$pass = getenv('MYSQLPASSWORD') ?: 'PASS';
$port = getenv('MYSQLPORT') ?: '3306';

$conn = new mysqli($host, $user, $pass, $dbn, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // แสดงผลแจ้งสถานะการเชื่อมต่อพร้อมบอก Host ที่กำลังใช้งานจริง
    echo "Connected to MySQL server successfully! (Host: $host, Port: $port)<br>";
}

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $sql = "INSERT INTO users (name, email, mobile) VALUES ('$name', '$email', '$mobile')";
    if (mysqli_query($conn, $sql)) {
        echo "<p style='color: green;'>New record has been added successfully!</p>";
    } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
    }
}

// ดึงข้อมูลมาแสดงผล
$sql = 'SELECT * FROM users';
$users = [];
if ($result = $conn->query($sql)) {
    while ($data = $result->fetch_object()) {
        $users[] = $data;
    }
}

echo "<h4>Registered Users:</h4>";
if (!empty($users)) {
    foreach ($users as $user_item) {
        echo $user_item->name . " | " . $user_item->email . " | " . $user_item->mobile;
        echo "<br>";
    }
} else {
    echo "No records found.";
}

$conn->close();
?>