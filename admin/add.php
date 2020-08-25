
<?php
require '../config/config.php';
session_start();
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');
}
if($_POST){
  
    $file='../images/'.($_FILES['image']['name']);
    $imageType=pathinfo($file,PATHINFO_EXTENSION);
     $imageType=strtoupper($imageType);
    if($imageType!='PNG' && $imageType !='JPG' && $imageType!='JEPG'){
        echo "<script>alert('Please enter image file'); </script>";
    }
    move_uploaded_file($_FILES['image']['tmp_name'],$file);
    $pdostatement=$pdo->prepare("INSERT INTO posts(title,content,image,authur_id) VALUES(:title,:content,:image,:authur_id)  ");
    $result=$pdostatement->execute([
        ":title"=>$_POST['title'],
        ":content"=>$_POST['content'],
        ":image"=>$_FILES['image']['name'],
        ":authur_id"=>$_SESSION['user_id'],
    ]);
if($result){
    echo "<script>alert('Successful Added'); </script>";
  
    echo"<script>document.location.href = 'index.php',true;</script>";
}
}

?>
<?php include('header.php');?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Create New Blog Post</h3>
              </div>
            
              <!-- /.card-header -->
 <div class="card-body">
           <form action="add.php" enctype="multipart/form-data" method="post">
         <div class="form-group">
             <label for="">title</label>
      <input type="text" name="title" class="form-control" id="">

         </div>

         <div class="form-group">
             <label for="">Content</label>
    <textarea name="content" id="" cols="30" rows="5" class="form-control"></textarea>

         </div>
         <div class="form-group">
             <label for="">image</label>
      <input type="file" name="image" class="form-control" id="">

         </div>
         <div class="form-group">
             <input type="submit" value="Create" class="btn btn-info">
          <a href="index.php" class="btn btn-success">back</a>
         </div>
</form>
         

           </div>
              <!-- /.card-body -->
            
            </div>
            <!-- /.card -->

           
            <!-- /.card -->
          </div>
         
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <?php include('footer.html');?>