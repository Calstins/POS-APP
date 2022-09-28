<?php

// session and database connection
include_once'connect_db.php';
session_start();

// user privilages
if($_SESSION['useremail']=="" OR $_SESSION['role']=="Manager" OR $_SESSION['role']=="Cashier" OR $_SESSION['role']=="Warehouse"){
  header('location:login.php');
}

 
include_once'header.php';

if(isset($_POST['btnaddproduct'])){
    $productname= $_POST['txtprodname'];
    $category= $_POST['txtcategory'];
    $variation= $_POST['txtvariation'];
    $size= $_POST['txtsize'];
    $brand= $_POST['txtbrand'];
    $purchaseprice= $_POST['txtprice'];
    $salesprice= $_POST['txtsales'];
    $stock= $_POST['txtstock'];
    $description= $_POST['txtdescription'];
     
   
        $f_name=$_FILES['myfile']['name'];
        $f_tmp=$_FILES['myfile']['tmp_name'];
        $f_size=$_FILES['myfile']['size'];
        $f_extension = explode('.',$f_name);
        $f_extension= strtolower(end($f_extension));
        $f_newfile=uniqid().'.'.$f_extension;
        $store="productimages/".$f_newfile;
     
        if ($f_extension=='png'|| $f_extension=='jpg'|| $f_extension=='jpeg'|| $f_extension=='gif') { 
            if($f_size>=300000){
                $error='
                <script type ="text/javascript">
                
                jQuery(function validation(){
            
                    swal({
                    title: "Error!",
                    text: "Please upload a file less than 300KB",
                    icon: "warning",
                    button: "Ok",
                    });
            
                });
                </script>';
             
                echo $error;

            }else{
                if(move_uploaded_file($f_tmp,$store)){

                    // $right_file='
                    // <script type ="text/javascript">
                    
                    // jQuery(function validation(){
                
                    //     swal({
                    //     title: "Success!",
                    //     text: "File uploaded",
                    //     icon: "success",
                    //     button: "Ok",
                    //     });
                
                    // });
                    // </script>';
                 
                    // echo $right_file;
                    $productimage= $f_newfile;

                }
            }  
        } else {
            $error='
            <script type ="text/javascript">
            
            jQuery(function validation(){
        
                swal({
                title: "Error!",
                text: "Please upload only a JPG, JPEG,PNG or GIF file format",
                icon: "error",
                button: "Ok",
                });
        
            });
            </script>';
         
            echo $error;

        }
    
    // insert data
    if(!isset($error)){
        $insert=$pdo->prepare("insert into onek_product(pname,pcategory,pvariation,psize,pbrand,purchaseprice,saleprice,pstock,pdescription,pimage) values(:pname,:pcategory,:pvariation,:psize,:pbrand,:purchaseprice,:saleprice,:pstock,:pdescription,:pimage)");
        
        $insert->bindParam(':pname',$productname);
        $insert->bindParam(':pcategory',$category);
        $insert->bindParam(':pvariation',$variation);
        $insert->bindParam(':psize',$size);
        $insert->bindParam(':pbrand',$brand);
        $insert->bindParam(':purchaseprice',$purchaseprice);
        $insert->bindParam(':saleprice',$salesprice);
        $insert->bindParam(':pstock',$stock);
        $insert->bindParam(':pdescription',$description);
        $insert->bindParam(':pimage', $productimage);
        
        if($insert->execute()){
            echo'
            <script type ="text/javascript">
                    
                jQuery(function validation(){
                
                        swal({
                        title: "Success!",
                        text: "Product Added",
                        icon: "success",
                        button: "Ok",
                        });
                
                });
            </script>';

        }else{
            echo'
            <script type ="text/javascript">
                    
                jQuery(function validation(){
                
                        swal({
                        title: "Oops!",
                        text: "Product Addition failed",
                        icon: "success",
                        button: "Ok",
                        }); 
                
                });
            </script>';

        }
    
        
    }
}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Product
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
            <!-- /.box-header -->
            <!-- form start -->
            
            <form action="" method="post" name="formproduct" enctype="multipart/form-data">

                    <div class="box-body">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control"  placeholder="Enter..." name="txtprodname" required>
                            </div>
                    
                            <div class="form-group">
                                <label>Category</label>
                                    <select class="form-control" name="txtcategory" required>
                                    <option value="" disabled selected>Select Category</option>
                                        <?php
                                            $select = $pdo->prepare("select * from onek_category order by catid desc");
                                            $select->execute();
                                            while ($row=$select->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                        ?>
                                            <option>
                                                <?php
                                                    echo $row['category'];
                                                ?>
                                            </option>
                                        <?php    
                                            }
                                        ?>
                                    </select>
                            </div>

                            <div class="form-group">
                                <label>Variation</label>
                                    <select class="form-control" name="txtvariation" required>
                                    <option value="" disabled selected>Select Variation</option>
                                        <?php
                                            $select = $pdo->prepare("select * from onek_variation order by varid desc");
                                            $select->execute();
                                            while ($row=$select->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                        ?>
                                            <option>
                                                <?php
                                                    echo $row['variation'];
                                                ?>
                                            </option>
                                        <?php    
                                            }
                                        ?>
                                    </select>
                            </div>

                            <div class="form-group">
                                <label>Size</label>
                                    <select class="form-control" name="txtsize" required>
                                    <option value="" disabled selected>Select Size</option>
                                        <?php
                                            $select = $pdo->prepare("select * from onek_size order by size_id desc");
                                            $select->execute();
                                            while ($row=$select->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                        ?>
                                            <option>
                                                <?php
                                                    echo $row['size'];
                                                ?>
                                            </option>
                                        <?php    
                                            }
                                        ?>
                                    </select>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Brand</label>
                                    <select class="form-control" name="txtbrand" required>
                                    <option value="" disabled selected>Select Brand</option>
                                        <?php
                                            $select = $pdo->prepare("select * from onek_brand order by brand_id desc");
                                            $select->execute();
                                            while ($row=$select->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                        ?>
                                            <option>
                                                <?php
                                                    echo $row['brand'];
                                                ?>
                                            </option>
                                        <?php    
                                            }
                                        ?>
                                    </select>
                            </div>

                            <div class="form-group">
                                <label>Purchase Price</label>
                                <input type="number" min="1" step="1" class="form-control"  placeholder="Enter..." name="txtprice" >
                            </div>

                            <div class="form-group">
                                <label>Sales Price</label>
                                <input type="number" min="1" step="1" class="form-control"  placeholder="Enter..." name="txtsales" required>
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" min="1" step="1" class="form-control"  placeholder="Enter..." name="txtstock" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="txtdescription" id="" cols="30" rows="4" class="form-control" placeholder="Enter..."></textarea>
                            </div>

                            <div class="form-group">
                                <label>Product Image</label>
                                <input type="file" class="input-group"  placeholder="Enter..." name="myfile" >
                                <p><small>Upload only a JPG, JPEG, PNG or GIF file format with file size not more than 300KB </small></p>
                            </div>
                        </div>

                    </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-success" name="btnaddproduct">Add Product</button>
                <div>
            </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php

include_once'footer.php';

?> 