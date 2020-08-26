<?php
require 'config/config.php';
session_start();
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');
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
<div class="content-wapper" style="margin-left: 0px!important;">
  
   <div class="content-wrapper" style="margin-left: 0px!important;"> 
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        
      <div class="float-right d-none d-sm-inline">
    <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
            <h1 style="text-align: center;">Blog Site</h1>
         
          
     
      </div><!-- /.container-fluid -->
    </section>
<?php
if(!empty($_GET['pageno'])){
  $pageno=$_GET['pageno'];

}else{
  $pageno=1;
}
$numOfbl=6;
$Offset=($pageno-1)*$numOfbl;

 $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
 $stmt->execute();
 $rawresult=$stmt->fetchAll();
 $total_pages=ceil(count($rawresult)/$numOfbl);
 $stmt=$pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $Offset,$numOfbl");
 $stmt->execute();
 $result=$stmt->fetchAll();
?>
    <!-- Main content -->
    <section class="content">
      <div class="contanier">
    <div class="row">
    
    <!-- /.col -->
    <?php
                    if($result){
                      $i=1;
                      foreach($result as $u){
                       
                    ?>
    <div class="col-md-4 ">
      <!-- Box Comment -->
      <div class="card card-widget">
        <div class="card-header">
          <div class="card-title" style="text-align:center !important;float:none;">
              <h4><?php echo $u['title']; ?></h4>
          </div>
          
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <a href="detail.php?id=<?php echo $u['id']; ?>"><img class="img-fluid pad" src="images/<?php echo $u['image']?>" alt="Photo" style="width:250px!important; height: 200px!important;"></a>
          

          
         
        </div>
        <!-- /.card-body -->
      
        
      </div>
      <!-- /.card -->
    </div>
    <?php $i++;
                     }
                     
                     } ?>                 
                   
    <!-- /.col -->
  </div>
  </div>
</section>
    

   
   
  </div>
  <nav aria-label="Page navigation example" style ="float: right;">
  <ul class="pagination">
  <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
    <li class="page-item <?php if($pageno <= 1){echo 'disabled';}?>">
    <a class="page-link"    href="<?php if($pageno <= 1){echo '#';}
    else{echo '?pageno='.($pageno-1);} ?>">Previous</a>    </li>
    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $pageno ?>"><?php echo $pageno ?></a></li>
    
    <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';} ?>" >
    <a class="page-link"    href="<?php if($pageno >=  $total_pages){echo '#';}else{echo '?pageno='.($pageno+1);} ?>">Next</a>    </li>

    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages?>">Last</a></li>
  </ul>
</nav>
  <!-- /.content-wrapper -->
  <footer class="main-footer" style="margin-left: 0px!important;">
    <!-- To the right -->
    
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
<script src="/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/dist/js/demo.js"></script>
</body>
</html>
