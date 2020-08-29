<?php
session_start();
require 'config/config.php';
if ($_POST) {
  if(empty($_POST['name']) ||empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password']) <4 ){
    if(empty($_POST['name'])){
      $name_error='name cannot be null';
      
    }
   if(empty($_POST['email'])){
     $email_error='email cannot be null';
   }
   if(empty($_POST['password'])){
     $password_error='Password cannot be null';
   }

    if(strlen($_POST['password'])<4) {
   $password_error='Password should be 4 characters at least';
  } }
  else{
    $email=$_POST['email'];
    $name=$_POST['name'];
    $password=$_POST['password'];

    $stat=$pdo->prepare("SELECT * FROM users WHERE email=:email");
   
   $stat->bindValue(':email',$email);
  
    $stat->execute();
    
    $user=$stat->fetch(PDO::FETCH_ASSOC);
  
   
    if(!empty($user)){
        echo "<script>alert('email duplicated');</script>";
        echo"<script>document.location.href = 'register.php',true;</script>";
    }else{
        $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
        $pdostatement=$pdo->prepare("INSERT INTO users(name,email,password,row) VALUES(:name,:email,:password,:row)  ");
        $result=$pdostatement->execute([
            ":name"=>$_POST['name'],
            ":email"=>$_POST['email'],
            ":password"=>$password,
            ":row"=>0,
        ]);
      
     if($result ){
        echo "<script>alert('Successful Added.You can now login'); </script>";
      
        echo"<script>document.location.href = 'login.php',true;</script>";
    }
  }
    }
}
  


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Register New accounts</p>

      <form action="register.php" method="post">
      <p class="text-danger"><?php echo empty($name_error)? '':  $name_error; ?></p>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-user"></span>
            </div>
          </div>
        </div>
        <p class="text-danger"><?php echo empty($email_error)? '':  $email_error; ?></p>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-envelope"></span>
            </div>
          </div>
        </div>
        <p class="text-danger"><?php echo empty($password_error)? '':  $password_error; ?></p>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fa fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="container">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <a href="login.php" class="btn btn-success btn-block">Login</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      <!-- /.social-auth-links -->

      <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    </div> -->
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
