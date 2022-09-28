
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- sweetalert -->
<script src="bower_components/sweetalert/sweetalert.js"></script>
<!-- sweetAlert styling -->
<style> .swal-button{background-color: #95d91a;} .swal-overlay{background-color: rgba(149, 217, 26, 0.45)}.swal-text{color:black}</style>

<?php

include_once'connect_db.php';
session_start();

error_reporting(0);

if(isset($_POST['btn_login'])){

$useremail=$_POST['txt_email'];
$password=$_POST['txt_password'];


$user_input= $pdo->prepare("select * from onek_user where useremail='$useremail' AND password='$password'");

$user_input->execute();
$row=$user_input->fetch(PDO::FETCH_ASSOC);

if ($row['useremail']==$useremail AND $row['password']==$password AND $row['role']=='Admin') {
  
  $_SESSION['userid']=$row['userid'];
  $_SESSION['username']=$row['username'];
  $_SESSION['useremail']=$row['useremail'];
  $_SESSION['role']=$row['role'];
  
  echo'<script type ="text/javascript">
  
  jQuery(function validation(){

      swal({
        title: "Good Job! '.$_SESSION['username'].'",
        text: "Details Matched",
        icon: "success",
        button: "Loading...",
      });

  });
  
  </script>';
  
  header('refresh:3;dashboard.php');

} else if($row['useremail']==$useremail AND $row['password']==$password AND $row['role']=='Manager'){

   
  $_SESSION['userid']=$row['userid'];
  $_SESSION['username']=$row['username'];
  $_SESSION['useremail']=$row['useremail'];
  $_SESSION['role']=$row['role'];

  echo'<script type ="text/javascript">
  
  jQuery(function validation(){

      swal({
        title: "Good Job! '.$_SESSION['username'].'",
        text: "Details Matched",
        icon: "success",
        button: "Loading...",
      });

  });
  
  </script>';
  
  header('refresh:1;manager.php');

} else if($row['useremail']==$useremail AND $row['password']==$password AND $row['role']=='Warehouse'){
  
  $_SESSION['userid']=$row['userid'];
  $_SESSION['username']=$row['username'];
  $_SESSION['useremail']=$row['useremail'];
  $_SESSION['role']=$row['role'];

  echo'<script type ="text/javascript">
  
  jQuery(function validation(){

      swal({
        title: "Good Job! '.$_SESSION['username'].'",
        text: "Details Matched",
        icon: "success",
        button: "Loading...",
      });

  });
  
  </script>';

  header('refresh:1;warehouse.php');

} else if($row['useremail']==$useremail AND $row['password']==$password AND $row['role']=='Cashier'){
  
  $_SESSION['userid']=$row['userid'];
  $_SESSION['username']=$row['username'];
  $_SESSION['useremail']=$row['useremail'];
  $_SESSION['role']=$row['role'];

  echo'<script type ="text/javascript">
  
  jQuery(function validation(){

      swal({
        title: "Good Job! '.$_SESSION['username'].'",
        text: "Details Matched",
        icon: "success",
        button: "Loading...",
      });

  });
  
  </script>';
  
  header('refresh:1;cashier.php');
} else{
  echo'<script type ="text/javascript">
  
  jQuery(function validation(){

      swal({
        title: "Email or password is wrong!",
        text: "Details Not Matched",
        icon: "error",
        button: "Ok",
      });

  });
  
  </script>';
} 

}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>1KSHOP POS | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Font Awesome 2 -->
  <!-- <link rel="stylesheet" href="bower_components/fontawesome_/css/font-awesome.min.css"> -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- login box style -->
  <link rel="stylesheet" href="bower_components/login_style/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body  style='font-family: sans-serif;	
	background-image: url(pos.jpg);
	background-repeat: no-repeat;
	overflow: hidden;
	background-size: auto;' class="hold-transition login-page">
<div  class="login-box">
  <div class="login-logo">
  </div>
 
  <div class="login-box-body" style = "background-color:#95d91a;" >
    <p class="login-box-msg" style = "color:black;" ><b>Log</b>in</p>

    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="txt_email" required >
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="txt_password" required id="passwordinput"><br>
        <input type="checkbox" onclick="passwordVisible()">Show Password
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
         
        </div>
   
        <div class="col-xs-4" style = "background-color:#95d91a;">
          <button type="submit" class="btn-block btn-flat" name="btn_login">Login</button>
        </div>
       
      </div>
    </form>

    
    <a href="#" onclick="swal('To Get Password','Please contact Admin(Mr Paul) or Webmaster(Mr Caleb)','error')">I forgot my password</a><br> 

  </div>

 
</div>
<!-- <div class="container">
 	<div class="header">
 		<h1>login</h1>
 	</div>
 	<div class="main">
 		<form action="" method="post">
 			<span>
 				<i class="fa fa-user"></i>
 				<input type="email" placeholder="email" name="txt_email">
 			</span><br>
 			<span>
 				<i class="fa fa-lock"></i>
 				<input type="password" placeholder="password" name="txt_password">
 			</span><br>
       <div class="form-group has-feedback">
      </div><br>
      <a href="#">I forgot my password</a><br> 
 				<button name="btn_login">login</button>
 		</form>
 	</div>
 </div> -->



 <!-- jQuery 3 -->
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });

</script>

</body>
</html>
