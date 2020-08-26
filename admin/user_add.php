
<?php
require '../config/config.php';
session_start();
if(empty($_SESSION['user_id'])&& empty($_SESSION['logged_in'])){
  header('Location: login.php');

}if($_SESSION['role']!=1){
  header('Location: login.php');
}
if($_POST){
    if(empty($_POST['isAdmin'])){
        $row=0;
    }else{
        $row=1;
    }
    $email=$_POST['email'];
    
    $stat=$pdo->prepare("SELECT * FROM users WHERE email=:email");
   
   $stat->bindValue(':email',$email);
  
    $stat->execute();
    
    $user=$stat->fetch(PDO::FETCH_ASSOC);
  
   
    if(!empty($user)){
        echo "<script>alert('email duplicated');</script>";
        echo"<script>document.location.href = 'user_add.php',true;</script>";}
        else{
            $pdostatement=$pdo->prepare("INSERT INTO users(name,email,password,row) VALUES(:name,:email,:password,:row)");
    $result=$pdostatement->execute([
        ":name"=>$_POST['name'],
        ":email"=>$_POST['email'],
        ":password"=>$_POST['password'],
        ":row"=>$row,
    ]);
if($result){
    echo "<script>alert('Successful Added'); </script>";
  
    echo"<script>document.location.href = 'index.php',true;</script>";
}
        
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
                <h3 class="card-title">Create New User </h3>
              </div>
            
              <!-- /.card-header -->
 <div class="card-body">
           <form action="user_add.php" enctype="multipart/form-data" method="post">
           
         <div class="form-group">
             <label for="">name</label>
      <input type="text" name="name" class="form-control" id="" >

         </div>
         

         <div class="form-group">
             <label for="email">Email</label>
             <input type="email" name="email" class="form-control"  >

         </div>
         <div class="form-group">
            <div><label for="">Password</label></div> 
             
      <input type="password" name="password" class="form-control" >

         </div>
         <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="isAdmin" value="1">
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

