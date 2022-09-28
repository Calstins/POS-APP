<?php
// session and database connection
include_once'connect_db.php';
session_start();

// user privilages
if($_SESSION['useremail']=="" OR $_SESSION['role']=="Manager" OR $_SESSION['role']=="Cashier" OR $_SESSION['role']=="Warehouse"){
  header('location:login.php');
}

include_once'header.php';

$id= $_GET['id'];

$select=$pdo->prepare("select * from onek_product where pid=$id");
$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);
 
$id_db=$row['pid'];
$pname_db=$row['pname'];
$pcategory_db=$row['pcategory'];
$pvariation_db=$row['pvariation'];
$psize_db=$row['psize'];
$pbrand_db=$row['pbrand'];
$purchaseprice_db=$row['purchaseprice'];
$saleprice_db=$row['saleprice'];
$pstock_db=$row['pstock'];
$pdescription_db=$row['pdescription'];
$pimage_db=$row['pimage'];

if(isset($_POST['btnupdateproduct'])){
    $productname_txt= $_POST['txtprodname'];
    $category_txt= $_POST['txtcategory'];
    $variation_txt= $_POST['txtvariation'];
    $size_txt= $_POST['txtsize'];
    $brand_txt= $_POST['txtbrand'];
    $purchaseprice_txt= $_POST['txtprice'];
    $salesprice_txt= $_POST['txtsales'];
    $stock_txt= $_POST['txtstock'];
    $description_txt= $_POST['txtdescription'];
    
    $f_name=$_FILES['myfile']['name'];

    if(!empty($f_name)){


    }else{

        $update=$pdo->prepare("update onek_product set pname=:pname, pcategory=:pcategory,  pvariation=:pvariation,  psize=:psize,  pbrand=:pbrand, purchaseprice=:purchaseprice, saleprice=:saleprice, pstock=:pstock, pdescription=:pdescription, pimage=:pimage where pid= $id");

        $update->bindParam(':pname',$productname_txt);
        $update->bindParam(':pcategory',$pcategory_txt); 
        $update->bindParam(':pvariation',$pvariation_txt);
        $update->bindParam(':psize',$psize_txt);
        $update->bindParam(':pbrand',$pbrand_txt);
        $update->bindParam(':purchaseprice', $purchaseprice_txt); 
        $update->bindParam(':saleprice', $salesprice_txt); 
        $update->bindParam(':pstock', $stock_txt);  
        $update->bindParam(':pdescription', $description_txt);   
        $update->bindParam(':pimage',$pimage_db);

        if ($update->execute()) {
            $error='
            <script type ="text/javascript">
            
            jQuery(function validation(){
        
                swal({
                title: "Updated!",
                text: "Product successfully updated",
                icon: "success",
                button: "Ok",
                });
        
            });
            </script>';
         
            echo $error;
        }else{

            $error='
            <script type ="text/javascript">
            
            jQuery(function validation(){
        
                swal({
                title: "Error!",
                text: "Product updated unsuccessful",
                icon: "error",
                button: "Ok",
                });
        
            });
            </script>';
         
            echo $error;
        }

    }  

}
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product
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
            <form action="" method="post" name="formproduct" enctype="multipart/form-data">

                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" value="<?php echo $pname_db ?>"  placeholder="Enter..." name="txtprodname" required>
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
                                        <option <?php if( $row['category']==$pcategory_db){?>
                                               selected="selected" 
                                            <?php } ?>>
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
                                    <select class="form-control" name="txtvariation" required value="<?php echo $pvariation_db ?>"  >
                                    <option value="" disabled selected>Select Variation</option>
                                        <?php
                                            $select = $pdo->prepare("select * from onek_variation order by varid desc");
                                            $select->execute();
                                            while ($row=$select->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                        ?>
                                            <option 
                                                <?php if($row['variation']==$pvariation_db) {?> 
                                                selected="selected"
                                                <?php }?>>
                                                <?php echo $row['variation'];?>
                                            </option>
                                        <?php    
                                            }
                                        ?>
                                    </select>
                        </div>>

                        <div class="form-group">
                                <label>Size</label>
                                    <select class="form-control" name="txtsize" required value="<?php echo $psize_db ?>" >
                                    <option value="" disabled selected>Select Size</option>
                                        <?php
                                            $select = $pdo->prepare("select * from onek_size order by size_id desc");
                                            $select->execute();
                                            while ($row=$select->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                        ?>
                                            <option 
                                                <?php if($row['size']==$psize_db) {?> 
                                                selected="selected"
                                                <?php }?>>
                                                <?php echo $row['size'];?>
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
                                    <select class="form-control" name="txtbrand" required value="<?php echo $pbrand_db ?>" >
                                    <option value="" disabled selected>Select Brand</option>
                                        <?php
                                            $select = $pdo->prepare("select * from onek_brand order by brand_id desc");
                                            $select->execute();
                                            while ($row=$select->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row);
                                        ?>
                                            <option 
                                                <?php if($row['brand']==$pbrand_db) {?> 
                                                selected="selected"
                                                <?php }?>>
                                                <?php echo $row['brand'];?>
                                            </option>
                                        <?php    
                                            }
                                        ?>
                                    </select>
                        </div>


                        <div class="form-group">
                            <label>Purchase Price</label>
                            <input type="number" min="1" step="1" class="form-control"  value="<?php echo $purchaseprice_db ?>"  placeholder="Enter..." name="txtprice" >
                        </div>

                        <div class="form-group">
                            <label>Sales Price</label>
                            <input type="number" min="1" step="1" class="form-control"  value="<?php echo $saleprice_db ?>"  placeholder="Enter..." name="txtsales" required>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" min="1" step="1" class="form-control"  value="<?php echo $pstock_db ?>"  placeholder="Enter..." name="txtstock" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="txtdescription" id="" cols="30" rows="4" class="form-control" placeholder="Enter..."><?php echo $pdescription_db; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Product Image</label>
                            <img src="productimages/<?php echo $pimage_db;?>" class="img-responsive" width="50px" height="50px">
                            <input type="file" class="input-group"  placeholder="Enter..." name="myfile" >
                            <p><small>Upload only a JPG, JPEG, PNG or GIF file format with file size not more than 300KB </small></p>
                        </div>
                    </div>


                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-success" name="btnupdateproduct">Update Product</button>
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