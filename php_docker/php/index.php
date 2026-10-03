<?php
mysqli_report(MYSQLI_REPORT_OFF);

$server_name = (isset($_SERVER['HTTP_X_SERVER_TYPE']) && $_SERVER['HTTP_X_SERVER_TYPE'] === 'NGINX')
    ? 'NGINX' : 'APACHE';

$host = getenv('MYSQLHOST')     ?: 'localhost';
$dbn  = getenv('MYSQLDATABASE') ?: 'railway';
$user = getenv('MYSQLUSER')     ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';
$port = (int)(getenv('MYSQLPORT') ?: 3306);

$conn = @new mysqli($host, $user, $pass, $dbn, $port);
$db_connected = !$conn->connect_error;
$db_error = $db_connected ? '' : $conn->connect_error;

if ($db_connected) {
    $conn->set_charset('utf8mb4');
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL,
        mobile VARCHAR(30) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) CHARACTER SET utf8mb4");
} else {
    error_log('MySQL connect error: ' . $db_error);
}

function e($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

// รับข้อมูลจากฟอร์ม แล้ว redirect กลับหน้าแรก (กันบันทึกซ้ำตอน refresh)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $status = 'nodb';
    if ($db_connected) {
        $name   = trim($_POST['name']   ?? '');
        $email  = trim($_POST['email']  ?? '');
        $mobile = trim($_POST['mobile'] ?? '');

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $mobile === '') {
            $status = 'invalid';
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, email, mobile) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $email, $mobile);
            $status = $stmt->execute() ? 'ok' : 'fail';
            if ($status === 'fail') error_log('Insert failed: ' . $stmt->error);
            $stmt->close();
        }
    }
    header('Location: /?status=' . $status);
    exit;
}

$messages = [
    'ok'      => ['success', 'บันทึกข้อมูลสำเร็จ'],
    'invalid' => ['warning', 'กรุณากรอกข้อมูลให้ครบ และอีเมลให้ถูกต้อง'],
    'fail'    => ['danger',  'บันทึกไม่สำเร็จ ลองใหม่อีกครั้ง'],
    'nodb'    => ['danger',  'เชื่อมต่อฐานข้อมูลไม่ได้ บันทึกข้อมูลไม่ได้'],
];
$flash = $messages[$_GET['status'] ?? ''] ?? null;

$users = [];
if ($db_connected && ($result = $conn->query('SELECT id, name, email, mobile FROM users ORDER BY id DESC'))) {
    while ($row = $result->fetch_object()) $users[] = $row;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Create Record - <?php echo e($server_name); ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<style>
.wrapper { max-width: 700px; margin: 40px auto; padding: 0 15px; }
.watermark {
  position: fixed; top: 50%; left: 50%;
  transform: translate(-50%, -50%) rotate(-30deg);
  font-size: 8rem; font-weight: bold; opacity: 0.06;
  z-index: 9999; pointer-events: none;
}
</style>
</head>
<body>
<div class="watermark"><?php echo e($server_name); ?></div>

<div class="wrapper">
  <h2>Contact Form <small>Server: <?php echo e($server_name); ?></small></h2>

  <?php if ($db_connected): ?>
    <div class="alert alert-success">
      <strong>Database Status:</strong> เชื่อมต่อ MySQL สำเร็จ
      (Host: <?php echo e($host); ?>, Port: <?php echo e($port); ?>, DB: <?php echo e($dbn); ?>, Table: users)
    </div>
  <?php else: ?>
    <div class="alert alert-danger"><strong>Database Status:</strong> เชื่อมต่อฐานข้อมูลไม่ได้</div>
  <?php endif; ?>

  <?php if ($flash): ?>
    <div class="alert alert-<?php echo $flash[0]; ?>"><?php echo e($flash[1]); ?></div>
  <?php endif; ?>

  <div class="panel panel-default">
    <div class="panel-heading">เพิ่มข้อมูลผู้ใช้</div>
    <div class="panel-body">
      <form action="/" method="post">
        <div class="form-group"><label>ชื่อ</label>
          <input type="text" name="name" class="form-control" required></div>
        <div class="form-group"><label>Email</label>
          <input type="email" name="email" class="form-control" required></div>
        <div class="form-group"><label>เบอร์โทร</label>
          <input type="text" name="mobile" class="form-control" required></div>
        <input type="submit" class="btn btn-primary" name="submit" value="บันทึกข้อมูล">
      </form>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">ข้อมูลผู้ใช้ (<?php echo count($users); ?> รายการ)</div>
    <table class="table table-striped">
      <thead><tr><th>ID</th><th>ชื่อ</th><th>Email</th><th>เบอร์โทร</th></tr></thead>
      <tbody>
      <?php if ($users): foreach ($users as $u): ?>
        <tr><td><?php echo e($u->id); ?></td><td><?php echo e($u->name); ?></td>
            <td><?php echo e($u->email); ?></td><td><?php echo e($u->mobile); ?></td></tr>
      <?php endforeach; else: ?>
        <tr><td colspan="4" class="text-center text-muted">ยังไม่มีข้อมูล</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
