<?php
// ตั้งค่าตัวแปรเชื่อมต่อ Database โดยดึงจาก Environment ของ Railway (ถ้ามี)
$host = getenv('MYSQLHOST') ?: 'localhost';
$dbn  = getenv('MYSQLDATABASE') ?: 'php-app';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';
$port = getenv('MYSQLPORT') ?: '3306';

// ลองเชื่อมต่อฐานข้อมูลแบบระวังข้อผิดพลาด (ไม่ให้เว็บพังถ้าต่อไม่ได้)
$conn = @new mysqli($host, $user, $pass, $dbn, $port);

$db_connected = true;
if ($conn->connect_error) {
    $db_connected = false;
}

if(isset($_POST['submit'])) {
    if ($db_connected) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];

        $sql = "INSERT INTO users (name, email, mobile) VALUES ('$name', '$email', '$mobile')";
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color: green;'>New record has been added successfully!</p>";
        } else {
            echo "Error: " . $sql . ":-" . mysqli_error($conn);
        }
    } else {
        echo "<p style='color: red;'>Database not connected. Cannot insert data.</p>";
    }
}

// ดึงข้อมูลมาแสดงผล (ถ้าต่อ Database ได้)
$users = [];
if ($db_connected) {
    // เช็คเผื่อว่ายังไม่ได้สร้างตาราง users
    $sql = 'SELECT * FROM users';
    if ($result = @$conn->query($sql)) {
        while ($data = $result->fetch_object()) {
            $users[] = $data;
        }
    }
}

// ส่วนแสดงผลข้อมูลด้านล่าง
echo "<h4>Registered Users:</h4>";
if (!empty($users)) {
    foreach ($users as $user_item) {
        echo $user_item->name . " | " . $user_item->email . " | " . $user_item->mobile;
        echo "<br>";
    }
} else {
    echo "No records found (or Database not connected yet).";
}

if ($db_connected) {
    $conn->close();
}
?>
