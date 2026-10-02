<?php
$host = getenv('PGHOST')     ?: 'localhost';
$port = getenv('PGPORT')     ?: '5432';
$dbn  = getenv('PGDATABASE') ?: 'postgres';
$user = getenv('PGUSER')     ?: 'postgres';
$pass = getenv('PGPASSWORD') ?: '';

function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

$pdo = null;
$db_connected = true;
try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbn",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    // แยกตารางของเว็บออกจากของ Activepieces
    $pdo->exec("CREATE SCHEMA IF NOT EXISTS phpapp");
    $pdo->exec("SET search_path TO phpapp");
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id SERIAL PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL,
        mobile VARCHAR(30) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $ex) {
    error_log('DB error: ' . $ex->getMessage());
    $db_connected = false;
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
            try {
                $stmt = $pdo->prepare("INSERT INTO users (name, email, mobile) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $mobile]);
                echo "<p style='color: green;'>New record has been added successfully!</p>";
            } catch (PDOException $ex) {
                error_log('Insert failed: ' . $ex->getMessage());
                echo "<p style='color: red;'>บันทึกไม่สำเร็จ ลองใหม่อีกครั้ง</p>";
            }
        }
    }
}

$users = [];
if ($db_connected) {
    try {
        $users = $pdo->query("SELECT name, email, mobile FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        error_log('Select failed: ' . $ex->getMessage());
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
