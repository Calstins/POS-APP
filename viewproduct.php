<?php
// session and database connection
include_once'connect_db.php';
session_start();

// user privilages
if($_SESSION['useremail']=="" OR $_SESSION['role']=="Manager" OR $_SESSION['role']=="Cashier" OR $_SESSION['role']=="Warehouse"){
  header('location:login.php');
}

 
include_once'header.php';

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Product
        <small></small>
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
              <h3 class="box-title"><a href="productlist.php" class="btn btn-success" role="button">Back to Product List</a></h3>
          </div>
          <div class="box-body">
            <?php
              
            $id=$_GET['id'];
            $select=$pdo->prepare("select * from onek_product where pid=$id");
            $select->execute();
            while($row=$select->fetch(PDO::FETCH_OBJ)){
                 echo'
                 
                 <div class= "col-md-6">
                    <ul class="list-group">
                    <center><p class="list-group-item list-group-item-success"><b>Product Details</b></p></center>
                        
                        <li class="list-group-item">Product Name <span class = "label label-primary pull-right">'.$row->pname.'</span></li>
                        <li class="list-group-item">Category <span class = "label label-info pull-right">'.$row->pcategory.'</span></li>
                        <li class="list-group-item">Colour Variation <span class = "label label-info pull-right">'.$row->pvariation.'</span></li>
                        <li class="list-group-item">Size <span class = "label label-info pull-right">'.$row->psize.'</span></li>
                        <li class="list-group-item">Brand <span class = "label label-info pull-right">'.$row->pbrand.'</span></li>
                        <li class="list-group-item">Purchase Price <span class = "label label-warning pull-right">'.$row->purchaseprice.'</span></li>
                        <li class="list-group-item">Sale Price <span class = "label label-warning pull-right">'.$row->saleprice.'</span></li>
                        <li class="list-group-item">Product Profit <span class = "label label-success pull-right">'.($row->saleprice-$row->purchaseprice).'</span></li>
                        <li class="list-group-item">Stock <span class = "label label-danger pull-right">'.$row->pstock.'</span></li>
                        <li class="list-group-item"><b>Description:</b>- <span class = ""><large> '.$row->pdescription.'</large></span></li>
                    </ul>
                 </div>

                 <div class="col-md-6">
                    <ul class="list-group">
                    <center><p class="list-group-item list-group-item-success"><b>Product Image</b></p></center>
                        <img src="productimages/'.$row->pimage.'" class="img-responsive mt-5"/>
                    </ul>
                 </div>
                 
                 ';
            }
              
            ?>
          </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php

include_once'footer.php';

?> 