<?php

include_once'connect_db.php';
session_start();

if($_SESSION['useremail']=="" OR $_SESSION['role']=="Manager" OR $_SESSION['role']=="Cashier" OR $_SESSION['role']=="Warehouse"){
  header('location:login.php');
}


include_once'header.php';

error_reporting(0);
if ($id = $_GET['id']) {
  $delete=$pdo->prepare("delete from onek_user where userid=".$id);

  if ($delete->execute()) {
    echo'<script type ="text/javascript">
    
    jQuery(function validation(){

        swal({
          title: "Great!",
          text: "Account Deleted",
          icon: "success",
          button: "Ok",
        });

    });
    
    </script>'; 
  }
} 



$delete=$pdo->prepare("delete from onek_user where userid=".$id);

if (isset($_POST['btnregister'])) {
  
  $username=$_POST['txtname'];
  $useremail=$_POST['txtemail'];
  $password=$_POST['txtpassword'];
  $userole=$_POST['txtrole'];
  $userlocation=$_POST['txtlocation'];


  $insert=$pdo->prepare("insert into onek_user(username,useremail,password,role,location_assign) values(:name,:email,:pass,:role,:location_assign)");

  $insert->bindParam(':name',$username);
  $insert->bindParam(':email',$useremail);  
  $insert->bindParam(':pass',$password);
  $insert->bindParam(':role',$userole);
  $insert->bindParam(':shop_location',$userlocation);

    if ($insert->execute()) {
      echo'<script type ="text/javascript">
  
      jQuery(function validation(){
  
          swal({
            title: "Good Job!",
            text: "Your registration was successful",  
            icon: "success",
            button: "Ok ",
          });
  
      });
      
      </script>';

    } else {
      echo'<script type ="text/javascript">
  
        jQuery(function validation(){
    
            swal({
              title: "Oops!",
              text: "Your registration was not successful",  
              icon: "error",
              button: "Ok ",
            });
    
        });
        
        </script>';
    }

} else {
  # code...
}



?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Registration
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
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">List of Registered Staff</h3>
          </div>
            <!-- /.box-header -->
            <!-- form start -->
              <form role="form" action="" method="post">
                <div class="box-body">
                  
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>STAFF</th>
                          <th>EMAIL</th>
                          <th>PASSWORD</th>
                          <th>ROLE</th>
                          <th>LOCATION ASSIGNED</th>
                          <th>DELETE</th>
                        </tr>
                      </thead>
                      <tbody>
                              <?php
                              $select=$pdo->prepare("select * from onek_user order by userid desc");
                              $select->execute();
                              while($row=$select->fetch(PDO::FETCH_OBJ)){
                                  echo'
                                  <tr>
                                      <td>'.$row->userid.'</td>
                                      <td>'.$row->username.'</td>
                                      <td>'.$row->useremail.'</td>
                                      <td>'.$row->password.'</td>
                                      <td>'.$row->role.'</td>
                                      <td>'.$row->location_assign.'</td>
                                     
                                      <td>
                                        <a href="registration.php?id='.$row->userid.'" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" title="delete"></span></a>
                                      </td>
                                  </tr>
                                  ';
                              }
                              ?>
                      </tbody>
                    </table>
                     
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                </div>
              </form>
            
        </div>
        
          <!-- /.box -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Registration form</h3>
          </div>
            <!-- /.box-header -->
            <!-- form start -->
              <form role="form" action="" method="post">
                <div class="box-body">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Staff Name</label>
                      <input type="text" class="form-control"  placeholder="Enter the staff name" name="txtname" required>
                    </div>
                    
                    <div class="form-group">
                      <label>Email address</label>
                      <input type="email" class="form-control"  placeholder="Enter email" name="txtemail" required>
                    </div>
                    
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control"  placeholder="Password" name="txtpassword" required>
                    </div>
                        
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                      <label>Select a staff role</label>
                        <select class="form-control" name="txtrole" required>
                          <option value="" disabled selected>Select Role</option>
                          <option>Admin</option>
                          <option>Manager</option>
                          <option>Warehouse</option>
                          <option>Cashier</option>
                        </select>
                    </div>

                    <div class="form-group">
                      <label>Location Assigned</label>
                        <select class="form-control" name="txtlocation" required>
                          <option value="" disabled selected>Select Location</option>
                          <?php
                                            $select = $pdo->prepare("select * from onek_location order by location_id desc");
                                            $select->execute();
                                            while ($row=$select->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                        ?>
                                            <option>
                                                <?php
                                                    echo $row['location_name'];
                                                ?>
                                            </option>
                                        <?php    
                                            }
                                        ?>
                          
                        </select>
                    </div>
                  </div>   
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                <center><button type="submit" class="btn btn-success" name="btnregister">Register</button></center>
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