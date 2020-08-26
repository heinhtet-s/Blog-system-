
<?php
require '../config/config.php';
session_start();
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');

}
if(!empty($_GET['id'])){

$pdostatement=$pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$pdostatement->execute();
$res=$pdostatement->fetch(PDO::FETCH_ASSOC);}

if($_POST){
    if(empty($_POST['isAdmin'])){
        $row=0;
    }else{
        $row=1;
    }
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    
    $pdostatement=$pdo->prepare("UPDATE  users SET name='$name',email='$email',password='$password',row='$row' WHERE id='$id'");
    $result=$pdostatement->execute();
       
    
if($result){
    echo "<script>alert('Successful Edit'); </script>";
  
    echo"<script>document.location.href = 'user_index.php',true;</script>";
}
        
        }
    


?>
<?php include('header.php');?>

<div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit User </h3>
              </div>
            
              <!-- /.card-header -->
 <div class="card-body">
           <form action="user_edit.php" enctype="multipart/form-data" method="post">
           <input type="hidden" name="id" value="<?php echo $res['id'] ?>">
         <div class="form-group">
             <label for="">name</label>
      <input type="text" name="name" class="form-control" id="" value="<?php echo $res['name']?>">

         </div>
         

         <div class="form-group">
             <label for="email">Email</label>
             <input type="email" name="email" class="form-control" value="<?php echo $res['email']?>"> 

         </div>
         <div class="form-group">
            <div><label for="">Password</label></div> 
             
      <input type="password" name="password" class="form-control" value="<?php echo $res['password']?>">

         </div>
         <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="isAdmin" value="1" <?php  if($res['row']==1){echo "checked";} ?> >
    <label class="form-check-label" for="exampleCheck1" >is Admin</label>
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



















<?php include('footer.html');?>

