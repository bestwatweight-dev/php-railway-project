<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Record</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
<style type="text/css">
.wrapper{ width: 500px; margin: 0 auto; }
.watermark {
  position: fixed; top: 50%; left: 50%;
  transform: translate(-50%, -50%) rotate(-30deg);
  font-size: 8rem; font-weight: bold; opacity: 0.08;
  z-index: 9999; pointer-events: none; text-transform: uppercase;
}
</style>
</head>
<body>

<?php
// เช็ค Header พิเศษที่ส่งมาจาก Nginx ถ้ามีให้เป็น NGINX ถ้าไม่มีให้เป็น APACHE
if (isset($_SERVER['HTTP_X_SERVER_TYPE']) && $_SERVER['HTTP_X_SERVER_TYPE'] === 'NGINX') {
    $server_name = 'NGINX';
} else {
    $server_name = 'APACHE';
}
?>

<div class="watermark"><?php echo $server_name; ?></div>

<div class="wrapper" style="margin-top: 50px;">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="page-header">
  <h2>Contact Form <small style="float: right; font-size: 14px; color: #888;">Server: <?php echo $server_name; ?></small></h2>
</div>
<p>Please fill this form and submit to add employee record to the database.</p>
<form action="insert.php" method="post">
<div class="form-group">
<label>Name</label>
<input type="text" name="name" class="form-control" required>
</div>
<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>
<div class="form-group">
<label>Mobile</label>
<input type="text" name="mobile" class="form-control" required>
</div>
<input type="submit" class="btn btn-primary" name="submit" value="Submit">
</form>
</div>
</div>
</div>
</div>

</body>
</html>
