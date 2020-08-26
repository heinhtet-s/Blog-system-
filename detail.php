<?php
require 'config/config.php';
session_start();
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');
}
$pdostatement=$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$pdostatement->execute();
$result=$pdostatement->fetchAll();
$blogId=$_GET['id'];
$pdostatement1=$pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
$pdostatement1->execute();
$cmres=$pdostatement1->fetchAll();

$Au=[];

if($cmres){
  foreach($cmres as $key=>$value){
 
    $authur=$cmres[$key]['authur_id'];
    $pdostatement=$pdo->prepare("SELECT * FROM users WHERE id=$authur");
    $pdostatement->execute();
    $Au[]=$pdostatement->fetchAll();
  }
 
}

if($_POST){
  $comment=$_POST['comment'];
  $pdostatement=$pdo->prepare("INSERT INTO comments(content,authur_id,post_id) VALUES(:content,:authur_id,:post_id)  ");
        $result=$pdostatement->execute([
            ":content"=>$comment,
            ":authur_id"=>$_SESSION['user_id'],
            ":post_id"=>$blogId,
        ]);
         
  
        if($result ){
         header('Location: detail.php?id='.$blogId);
      }
      }
    
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
 
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
 
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style='margin-left: 0px!important;'>
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
   <section class="content">
   <div class="row">
    <div class="col-md-12">
      <!-- Box Comment -->
      <div class="card card-widget">
       
        <div class="card-header" style="text-align:center !important;float:none;">
              <h1><?php echo $result[0]['title'];?> </h1>
          </div>
          <!-- /.user-block -->
        
          <!-- /.card-tools -->
        
        <!-- /.card-header -->
        <div class="card-body img-fluid">
          <img  class="img-fluid" src="images/<?php echo $result[0]['image']?>" alt="Photo"  >
          <br>
          <hr>
          <p><?php echo $result[0]['content'];?></p>
           <br>
           <hr>
           <h2>Comment</h2>
           <a href="index.php" class="btn btn-default">Go Back</a>
    </hr>
        <!-- /.card-body -->
        <div class="card-footer card-comments">
        
          <div class="card-comment">
            <!-- User image -->
           
          <?php if(!empty($cmres)){ ?>

          
            <div class="comment-text" style='margin-left: 0px!important;'>
              
              <?php foreach($cmres as $key=>$value){ ?>
              <span class="username">
<?php echo $Au[$key][0]['name'] ?>
<span class="text-muted float-right"><?php echo $cmres[0]['created_at'] ?></span>
</span><!-- /.username -->
<?php echo $cmres[$key]['content']; ?>
              <?php } ?>
            </div>
          <?php } ?>
            <!-- /.comment-text -->
          </div>
          <!-- /.card-comment -->
        </div>
        <!-- /.card-footer -->
        <br>
        <div >
        <div class="card-footer">
                <form action="" method="post">
                  <div class="input-group">
                    <input type="text" name="comment" placeholder="Type Message ..." class="form-control" >
                    <span class="input-group-append">
                      <button type="submit" class="btn btn-primary">Send</button>
                    </span>
                  </div>
                </form>
              </div>        
                     
                  
                

        <!-- /.card-footer -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
   
    <!-- /.col -->
  </div>
  <br>
</section>
   </section>
    <!-- /.content -->

    
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left: 0px!important;">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
    <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 heinhtet .</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
