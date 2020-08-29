
<?php
require '../config/config.php';
session_start();
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');
}
if($_SESSION['role']!=1){
  header('Location: login.php');
}
$pdostatement=$pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$pdostatement->execute();
$result=$pdostatement->fetchAll();

if($_POST){
  if(empty($_POST['title']) ||empty($_POST['content']) ){
    if(empty($_POST['title'])){
      $title_error='Title cannot be null';
      
    }
   if(empty($_POST['content'])){
     $content_error='Content cannot be null';
   }
   
  }else{

    $id=$_POST['id'];
    $title=$_POST['title'];
    $content=$_POST['content'];
    
  if($_FILES['image']['name']!=null){
    $file='../images/'.($_FILES['image']['name']);
    $imageType=pathinfo($file,PATHINFO_EXTENSION);
     $imageType=strtoupper($imageType);
    if($imageType!='PNG' && $imageType !='JPG' && $imageType!='JEPG'){
        echo "<script>alert('Please enter image file'); </script>";
        
    }else{
        move_uploaded_file($_FILES['image']['tmp_name'],$file);
        $image=$_FILES['image']['name'];
        $pdostatement=$pdo->prepare("UPDATE  posts SET title='$title',content='$content',image='$image' WHERE id='$id'");
        $result=$pdostatement->execute();
           
    }
  }else{
    $pdostatement=$pdo->prepare("UPDATE  posts SET title='$title',content='$content' WHERE id='$id'");
    $result=$pdostatement->execute();
       
  }
   
    
   
if($result){
    echo "<script>alert('Successful Added'); </script>";
  
    echo"<script>document.location.href = 'index.php',true;</script>";
}
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
           <form action="" enctype="multipart/form-data" method="post">
           <input type="hidden" name="id" value="<?php echo$result[0]['id']?>">
         <div class="form-group">
             <label for="">title</label><p class="text-danger"><?php echo empty($title_error)? '':  $title_error; ?></p>
      <input type="text" name="title" class="form-control" id="" value="<?php echo $result[0]['title'] ?> ">

         </div>
         

         <div class="form-group">
             <label for="">Content</label><p class="text-danger"><?php echo empty($content_error)? '':  $content_error; ?></p>
    <textarea name="content" id="" cols="30" rows="5" class="form-control"><?php echo $result[0]['content']?></textarea>

         </div>
         <div class="form-group">
            <div><label for="">image</label>
              <a href="../images/<?php echo$result[0]['image']?>">
            <img src="../images/<?php echo$result[0]['image']?>" alt="" class="col-md-2 mb-3">
            </a>
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