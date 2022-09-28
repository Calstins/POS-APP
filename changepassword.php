<?php

include_once'connect_db.php';
session_start();


if($_SESSION['useremail']==""){
    header('location:login.php');
}

if ($_SESSION['role']=="Admin"){
  include_once'header.php';
} 
elseif ($_SESSION['role']=="Manager") {
  include_once'header_manager.php';
}
elseif ($_SESSION['role']=="Warehouse") {
  include_once'header_warehouse.php';
}
elseif ($_SESSION['role']=="Cashier") {
  include_once'header_cashier.php';
}
 


// get values form password input 
if(isset($_POST['btnupdate'])){

  $oldpassword_txt=$_POST['txtoldpass'];
  $newpassword_txt=$_POST['txtnewpass'];
  $conpassword_txt=$_POST['txtconpass'];
  
  // use query to select from database table using email
  $useremail= $_SESSION['useremail'];
  
  $select=$pdo->prepare("select * from onek_user where useremail='$useremail'" );
  
  $select->execute();
  $row=$select->fetch(PDO::FETCH_ASSOC);
  
  $useremail_db =$row['useremail'];
  $password_db=$row['password'];


// compare user input and database values
  if ($oldpassword_txt==$password_db) {
    if ($newpassword_txt==$conpassword_txt) {
       
      $update=$pdo->prepare("update onek_user set password=:pass where useremail=:email");

      $update->bindParam(':pass',$conpassword_txt);
      $update->bindParam(':email',$useremail);

      if ($update->execute()) {
        echo'<script type ="text/javascript">
  
        jQuery(function validation(){
    
            swal({
              title: "Good Job!",
              text: "Your password is updated successfully",  
              icon: "success",
              button: "Ok ",
            });
    
        });
        
        </script>';
    
      } else {
        echo'<script type ="text/javascript">
  
        jQuery(function validation(){
    
            swal({
              title: "Error!",
              text: "Your password was not updated successfully",  
              icon: "error",
              button: "Ok ",
            });
    
        });
        
        </script>';
      }
      


    } else {
      echo'<script type ="text/javascript">
  
        jQuery(function validation(){
    
            swal({
              title: "Oops!",
              text: "Your new password and confirmed password do not match",  
              icon: "warning",
              button: "Ok ",
            });
    
        });
        
        </script>';
    }
    
  } else {
    echo'<script type ="text/javascript">
  
    jQuery(function validation(){

        swal({
          title: "Oops!",
          text: "Your password is wrong fill in the rght password",
          icon: "warning",
          button: "Ok ",
        });

    });
    
    </script>';

  }
  
   
}
  
  



?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="">
              <div class="box-body">
                
              <div class="form-group">
                  <label for="exampleInputPassword1">Old Password</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtoldpass" required>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">New Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1"   placeholder="Password" name="txtnewpass" required>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputPassword1">Confirm Password</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtconpass" required>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="btnupdate">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php

include_once'footer.php';

?> 