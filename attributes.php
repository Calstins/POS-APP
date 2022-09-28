<?php
// session and database connection
include_once'connect_db.php';
session_start();

// user privilages
if($_SESSION['useremail']=="" OR $_SESSION['role']=="Manager" OR $_SESSION['role']=="Cashier" OR $_SESSION['role']=="Warehouse"){
  header('location:login.php');
}

include_once'header.php';


////////////CRUD CATEGORY ENDS
if(isset($_POST['btnsave'])){

    $category= $_POST['txtcategory'];
    
    if (empty($category)) {
        $error='<script type ="text/javascript">
  
        jQuery(function validation(){
    
            swal({
              title: "Oops! Empty field",
              text: "Please fill in the empty field",  
              icon: "error",
              button: "Ok ",
            });
    
        });
        
        </script>';
        echo $error;
       
        
    } 

        if (!isset($error)) {
            $insert=$pdo->prepare("insert into onek_category(category) values(:category)");
            
            $insert->bindParam(':category',$category);
            
            if($insert->execute()){
                echo '<script type ="text/javascript">
    
            jQuery(function validation(){
        
                swal({
                title: "Added!",
                text: "Category successfully added",  
                icon: "success",
                button: "Ok",
                });
        
            });
            
            </script>';
            
            }else{

                echo'<script type ="text/javascript">
  
                jQuery(function validation(){
    
                swal({
                title: "Oops!",
                text: "Category creation failed ",  
                icon: "error",
                button: "Ok ",
                });
        
            });
        
            </script>';

            }
        } 
    
} 
//btn add end
// btn update begin
if(isset($_POST['btnupdate'])){

    $id= $_POST['txtid'];
    $category= $_POST['txtcategory'];
    
    if (empty($category)) {

        $errorupdate='
        <script type ="text/javascript">
  
        jQuery(function validation(){

        swal({
        title: "Oops! Field empty",
        text: "Please fill in the empty field",  
        icon: "error",
        button: "Ok ",
        });

        });

    </script>';

    echo $errorupdate;

    }
    if (!isset($errorupdate)) {
        $update = $pdo->prepare("update onek_category set category=:category where catid=".$id);
        $update->bindParam(':category',$category);
        if($update->execute()){
            echo '<script type ="text/javascript">
    
            jQuery(function validation(){
        
                swal({
                title: "Updated!",
                text: "Category successfully updated",  
                icon: "success",
                button: "Ok",
                });
        
            });
            
            </script>';
        }else{
            echo '<script type ="text/javascript">
    
            jQuery(function validation(){
        
                swal({
                title: "Oops!",
                text: "Category update failed",  
                icon: "error",
                button: "Ok",
                });
        
            });
            
            </script>';
        }
    }
} 
// btn update code end
//btn delete code
if(isset($_POST['btndelete'])){

    $delete=$pdo->prepare("delete from onek_category where catid=".$_POST['btndelete']);
    
    if ($delete->execute()) {
        echo'<script type ="text/javascript">
        
        jQuery(function validation(){
    
            swal({
              title: "Deleted!",
              text: "Category is Deleted",
              icon: "success",
              button: "Ok",
            });
    
        });
        
        </script>';
      }else{
        echo'<script type ="text/javascript">
        
        jQuery(function validation(){
    
            swal({
              title: "Error!",
              text: "Category is not Deleted",
              icon: "error",
              button: "Ok",
            });
    
        });
        
        </script>';
      }


}else{}
////////////CRUD CATEGORY ENDS

////////////CRUD VARIATION BEGINS
if(isset($_POST['btnsavevariation'])){

  $variation= $_POST['txtvariation'];
  
  if (empty($variation)) {
      $error='<script type ="text/javascript">

      jQuery(function validation(){
  
          swal({
            title: "Oops! Empty field",
            text: "Please fill in the empty field",  
            icon: "error",
            button: "Ok ",
          });
  
      });
      
      </script>';
      echo $error;
     
      
  } 

      if (!isset($error)) {
          $insert=$pdo->prepare("insert into onek_variation(variation) values(:variation)");
          
          $insert->bindParam(':variation',$variation);
          
          if($insert->execute()){
              echo '<script type ="text/javascript">
  
          jQuery(function validation(){
      
              swal({
              title: "Added!",
              text: "Variation successfully added",  
              icon: "success",
              button: "Ok",
              });
      
          });
          
          </script>';
          
          }else{

              echo'<script type ="text/javascript">

              jQuery(function validation(){
  
              swal({
              title: "Oops!",
              text: "Variation creation failed ",  
              icon: "error",
              button: "Ok ",
              });
      
          });
      
          </script>';

          }
      } 
  
} 
//btn add colour variation end
// btn colour variation update begin
if(isset($_POST['btnupdatevariation'])){

  $id= $_POST['txtvid'];
  $variation= $_POST['txtvariation'];
  
  if (empty($variation)) {

      $errorupdate='
      <script type ="text/javascript">

      jQuery(function validation(){

      swal({
      title: "Oops! Field empty",
      text: "Please fill in the empty field",  
      icon: "error",
      button: "Ok ",
      });

      });

  </script>';

  echo $errorupdate;

  }
  if (!isset($errorupdate)) {
      $update = $pdo->prepare("update onek_variation set variation=:variation where varid=".$id);
      $update->bindParam(':variation',$variation);
      if($update->execute()){
          echo '<script type ="text/javascript">
  
          jQuery(function validation(){
      
              swal({
              title: "Updated!",
              text: "Variation successfully updated",  
              icon: "success",
              button: "Ok",
              });
      
          });
          
          </script>';
      }else{
          echo '<script type ="text/javascript">
  
          jQuery(function validation(){
      
              swal({
              title: "Oops!",
              text: "Variation update failed",  
              icon: "error",
              button: "Ok",
              });
      
          });
          
          </script>';
      }
  }
} 
// btn update colour variation code end
//btn colour variation delete code
if(isset($_POST['btndeletevariation'])){

  $delete=$pdo->prepare("delete from onek_variation where varid=".$_POST['btndeletevariation']);
  
  if ($delete->execute()) {
      echo'<script type ="text/javascript">
      
      jQuery(function validation(){
  
          swal({
            title: "Colour Variation is Deleted",
            icon: "success",
            button: "Ok",
          });
  
      });
      
      </script>';
    }else{
      echo'<script type ="text/javascript">
      
      jQuery(function validation(){
  
          swal({
            title: "Error!",
            text: "Colour Variation is not Deleted",
            icon: "error",
            button: "Ok",
          });
  
      });
      
      </script>';
    }


}else{}
////////////CRUD COLOUR VARIATION ENDS


////////////CRUD BRAND BEGINS
if(isset($_POST['btnsavebrand'])){

  $brand= $_POST['txtbrand'];
  
  if (empty($brand)) {
      $error='<script type ="text/javascript">

      jQuery(function validation(){
  
          swal({
            title: "Oops! Empty field",
            text: "Please fill in the empty field",  
            icon: "error",
            button: "Ok ",
          });
  
      });
      
      </script>';
      echo $error;
     
      
  } 

      if (!isset($error)) {
          $insert=$pdo->prepare("insert into onek_brand(brand) values(:brand)");
          
          $insert->bindParam(':brand',$brand);
          
          if($insert->execute()){
              echo '<script type ="text/javascript">
  
          jQuery(function validation(){
      
              swal({
              title: "Added!",
              text: "brand successfully added",  
              icon: "success",
              button: "Ok",
              });
      
          });
          
          </script>';
          
          }else{

              echo'<script type ="text/javascript">

              jQuery(function validation(){
  
              swal({
              title: "Oops!",
              text: "Brand creation failed ",  
              icon: "error",
              button: "Ok ",
              });
      
          });
      
          </script>';

          }
      } 
  
} 
//btn add Brand end
// btn Brand update begin
if(isset($_POST['btnupdatebrand'])){

  $id= $_POST['txtbrand_id'];
  $brand= $_POST['txtbrand'];
  
  if (empty($brand)) {

      $errorupdate='
      <script type ="text/javascript">

      jQuery(function validation(){

      swal({
      title: "Oops! Field empty",
      text: "Please fill in the empty field",  
      icon: "error",
      button: "Ok ",
      });

      });

  </script>';

  echo $errorupdate;

  }
  if (!isset($errorupdate)) {
      $update = $pdo->prepare("update onek_brand set brand=:brand where brand_id=".$id);
      $update->bindParam(':brand',$brand);
      if($update->execute()){
          echo '<script type ="text/javascript">
  
          jQuery(function validation(){
      
              swal({
              title: "Updated!",
              text: "Brand successfully updated",  
              icon: "success",
              button: "Ok",
              });
      
          });
          
          </script>';
      }else{
          echo '<script type ="text/javascript">
  
          jQuery(function validation(){
      
              swal({
              title: "Oops!",
              text: "Brand update failed",  
              icon: "error",
              button: "Ok",
              });
      
          });
          
          </script>';
      }
  }
} 
// btn update Brand code end
//btn Brand delete code
if(isset($_POST['btndeletebrand'])){

  $delete=$pdo->prepare("delete from onek_brand where brand_id=".$_POST['btndeletebrand']);
  
  if ($delete->execute()) {
      echo'<script type ="text/javascript">
      
      jQuery(function validation(){
  
          swal({
            title: "Brand is Deleted",
            icon: "success",
            button: "Ok",
          });
  
      });
      
      </script>';
    }else{
      echo'<script type ="text/javascript">
      
      jQuery(function validation(){
  
          swal({
            title: "Error!",
            text: "Brand is not Deleted",
            icon: "error",
            button: "Ok",
          });
  
      });
      
      </script>';
    }


}else{}
////////////CRUD Brand ENDS


////////////CRUD SIZE BEGINS
if(isset($_POST['btnsavesize'])){

  $size= $_POST['txtsize'];
  
  if (empty($size)) {
      $error='<script type ="text/javascript">

      jQuery(function validation(){
  
          swal({
            title: "Oops! Empty field",
            text: "Please fill in the empty field",  
            icon: "error",
            button: "Ok ",
          });
  
      });
      
      </script>';
      echo $error;
     
      
  } 

      if (!isset($error)) {
          $insert=$pdo->prepare("insert into onek_size(size) values(:size)");
          
          $insert->bindParam(':size',$size);
          
          if($insert->execute()){
              echo '<script type ="text/javascript">
  
          jQuery(function validation(){
      
              swal({
              title: "Added!",
              text: "size successfully added",  
              icon: "success",
              button: "Ok",
              });
      
          });
          
          </script>';
          
          }else{

              echo'<script type ="text/javascript">

              jQuery(function validation(){
  
              swal({
              title: "Oops!",
              text: "size creation failed ",  
              icon: "error",
              button: "Ok ",
              });
      
          });
      
          </script>';

          }
      } 
  
} 
//btn add size end
// btn size update begin
if(isset($_POST['btnupdatesize'])){

  $id= $_POST['txtsize_id'];
  $size= $_POST['txtsize'];
  
  if (empty($size)) {

      $errorupdate='
      <script type ="text/javascript">

      jQuery(function validation(){

      swal({
      title: "Oops! Field empty",
      text: "Please fill in the empty field",  
      icon: "error",
      button: "Ok ",
      });

      });

  </script>';

  echo $errorupdate;

  }
  if (!isset($errorupdate)) {
      $update = $pdo->prepare("update onek_size set size=:size where size_id=".$id);
      $update->bindParam(':size',$size);
      if($update->execute()){
          echo '<script type ="text/javascript">
  
          jQuery(function validation(){
      
              swal({
              title: "Updated!",
              text: "The Size Attribute was successfully updated",  
              icon: "success",
              button: "Ok",
              });
      
          });
          
          </script>';
      }else{
          echo '<script type ="text/javascript">
  
          jQuery(function validation(){
      
              swal({
              title: "Oops!",
              text: "The Size Attribute update failed",  
              icon: "error",
              button: "Ok",
              });
      
          });
          
          </script>';
      }
  }
} 
// btn update size code end
//btn size delete code
if(isset($_POST['btndeletesize'])){

  $delete=$pdo->prepare("delete from onek_size where size_id=".$_POST['btndeletesize']);
  
  if ($delete->execute()) {
      echo'<script type ="text/javascript">
      
      jQuery(function validation(){
  
          swal({
            title: "The Size Atribute is Deleted",
            icon: "success",
            button: "Ok",
          });
  
      });
      
      </script>';
    }else{
      echo'<script type ="text/javascript">
      
      jQuery(function validation(){
  
          swal({
            title: "Error!",
            text: "The Size Attribute was not Deleted",
            icon: "error",
            button: "Ok",
          });
  
      });
      
      </script>';
    }


}else{}
////////////CRUD SIZE ENDS



?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Product Attributes
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
        <!-- CATEGORY -->
        <div class="row">
          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header with-border">
                <div class="box-title">Category form</div>
              </div>
              <div class="box-body">
                  <form role="form" action="" method="post">

                      <?php
                      
                      if(isset($_POST['btnedit'])){
                          $select=$pdo->prepare("select * from onek_category where catid=".$_POST['btnedit']);
                          $select->execute();
                          if($select){
                              $row=$select->fetch(PDO::FETCH_OBJ);
                              echo'
                              <div class="col-md-4">
                              <div class="form-group">
                                  <label>Category</label>
                                  <input type="hidden" class="form-control"  placeholder="Enter category..." name="txtid" value="'.$row->catid.'">
                                  <input type="text" class="form-control"  placeholder="Enter category..." name="txtcategory" value="'.$row->category.'">

                              </div>
                                  <button type="submit" class="btn btn-success" name="btnupdate">Update</button>
                              </div>
                              ';
                          }
                      }else{
                          echo'
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Category</label>
                                  <input type="text" class="form-control"  placeholder="Enter the category name" name="txtcategory">

                              </div>
                                  <button type="submit" class="btn btn-success" name="btnsave">Save</button>
                                  
                          </div>
                          ';
                      }
                      
                      ?>
                    
                    <div class="col-md-8">
                    
                      <table id="onekTable" class="table table-striped">
                        <thead>
                          <tr>
                            <th hidden>#</th>  
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                                
                            
                                  <?php
                                  
                                  $select=$pdo->prepare("select * from onek_category order by catid desc");
                                  $select->execute();
                                  while($row = $select->fetch(PDO::FETCH_OBJ)){

                                      echo'<tr>
                                      
                                          <td hidden>'.$row->catid.'</td>
                                          <td>'.$row->category.'</td>
                                          <td>
                                          <button type="submit" value="'.$row->catid.'" class="btn btn-success" name="btnedit">Edit</button></td>
                                          <td>
                                          <button type="submit" class="btn btn-danger" name="btndelete" value="'.$row->catid.'">Delete</button>
                                          </td>
                                      
                                      </tr>';

                                  } 
                                  
                                  ?>
                              

                        </tbody>
                      </table>
                      
                    </div>
                  </form>   
              </div>
            </div>
          </div>
        <!-- CATEGORY ENDS-->
        <!-- VARIATION  -->
          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header with-border">
                <div class="box-title">Colour Variation Form</div>
              </div>
              <div class="box-body">
                  <form role="form" action="" method="post">

                      <?php
                      
                      if(isset($_POST['btneditvariation'])){
                          $select=$pdo->prepare("select * from onek_variation where varid=".$_POST['btneditvariation']);
                          $select->execute();
                          if($select){
                              $row=$select->fetch(PDO::FETCH_OBJ);
                              echo'
                              <div class="col-md-4">
                              <div class="form-group">
                                  <label>Colour Variation</label>
                                  <input type="hidden" class="form-control"  placeholder="Enter colour...." name="txtvid" value="'.$row->varid.'">
                                  <input type="text" class="form-control"  placeholder="Enter colour..." name="txtvariation" value="'.$row->variation.'">

                              </div>
                                  <button type="submit" class="btn btn-success" name="btnupdatevariation">Update</button>
                              </div>
                              ';
                          }
                      }else{
                          echo'
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Colour Variation</label>
                                  <input type="text" class="form-control"  placeholder="Enter colour..." name="txtvariation">

                              </div>
                                  <button type="submit" class="btn btn-success" name="btnsavevariation">Save</button>
                                  
                          </div>
                          ';
                      }
                      
                      ?>
                    
                    <div class="col-md-8">
                    
                      <table id="onekTablecolour" class="table table-striped">
                        <thead>
                          <tr>
                            <th hidden>#</th>  
                            <th>Colour</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                                
                            
                                  <?php
                                  
                                  $select=$pdo->prepare("select * from onek_variation order by varid desc");
                                  $select->execute();
                                  while($row = $select->fetch(PDO::FETCH_OBJ)){

                                      echo'<tr>
                                      
                                          <td hidden>'.$row->varid.'</td>
                                          <td>'.$row->variation.'</td>
                                          <td>
                                          <button type="submit" value="'.$row->varid.'" class="btn btn-success" name="btneditvariation">Edit</button></td>
                                          <td>
                                          <button type="submit" class="btn btn-danger" name="btndeletevariation" value="'.$row->varid.'">Delete</button>
                                          </td>
                                      
                                      </tr>';

                                  } 
                                  
                                  ?>
                              

                        </tbody>
                      </table>
                      `
                    </div>
                  </form>
                
              </div>
            </div>
          </div>
        </div>
        <!-- VARIATION ENDS -->
        <!-- BRAND  -->
        <div class="row">
          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header with-border">
                <div class="box-title">Brand form</div>
              </div>
              <div class="box-body">
                  <form role="form" action="" method="post">

                      <?php
                      
                      if(isset($_POST['btneditbrand'])){
                          $select=$pdo->prepare("select * from onek_brand where brand_id=".$_POST['btneditbrand']);
                          $select->execute();
                          if($select){
                              $row=$select->fetch(PDO::FETCH_OBJ);
                              echo'
                              <div class="col-md-4">
                              <div class="form-group">
                                  <label>Brand</label>
                                  <input type="hidden" class="form-control"  placeholder="Enter brand..." name="txtbrand_id" value="'.$row->brand_id.'">
                                  <input type="text" class="form-control"  placeholder="Enter brand..." name="txtbrand" value="'.$row->brand.'">

                              </div>
                                  <button type="submit" class="btn btn-success" name="btnupdatebrand">Update</button>
                              </div>
                              ';
                          }
                      }else{
                          echo'
                          <div class="col-md-4">
                              <div class="form-group">
                                  <label>Brand</label>
                                  <input type="text" class="form-control"  placeholder="Enter brand..." name="txtbrand">

                              </div>
                                  <button type="submit" class="btn btn-success" name="btnsavebrand">Save</button>
                                  
                          </div>
                          ';
                      }
                      
                      ?>
                    
                    <div class="col-md-8">
                    
                      <table  class="table table-striped">
                        <thead>
                          <tr>
                            <th hidden>#</th>  
                            <th>Brand</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>
                                
                            
                                  <?php
                                  
                                  $select=$pdo->prepare("select * from onek_brand order by brand_id desc");
                                  $select->execute();
                                  while($row = $select->fetch(PDO::FETCH_OBJ)){

                                      echo'<tr>
                                      
                                          <td hidden>'.$row->brand_id.'</td>
                                          <td>'.$row->brand.'</td>
                                          <td>
                                          <button type="submit" value="'.$row->brand_id.'" class="btn btn-success" name="btneditbrand">Edit</button></td>
                                          <td>
                                          <button type="submit" class="btn btn-danger" name="btndeletebrand" value="'.$row->brand_id.'">Delete</button>
                                          </td>
                                      
                                      </tr>';

                                  } 
                                  
                                  ?>
                              

                        </tbody>
                      </table>
                      
                    </div>
                  </form>
              </div>
            </div>
          </div>

          <!-- BRAND ENDS  -->
          <!-- SIZE -->
          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header with-border">
                <div class="box-title">Size form</div>
              </div>
              <div class="box-body">
                <form role="form" action="" method="post">

                  <?php

                  if(isset($_POST['btneditsize'])){
                      $select=$pdo->prepare("select * from onek_size where size_id=".$_POST['btneditsize']);
                      $select->execute();
                      if($select){
                          $row=$select->fetch(PDO::FETCH_OBJ);
                          echo'
                          <div class="col-md-4">
                          <div class="form-group">
                              <label>Size</label>
                              <input type="hidden" class="form-control"  placeholder="Enter size...." name="txtsize_id" value="'.$row->size_id.'">
                              <input type="text" class="form-control"  placeholder="Enter size..." name="txtsize" value="'.$row->size.'">

                          </div>
                              <button type="submit" class="btn btn-success" name="btnupdatesize">Update</button>
                          </div>
                          ';
                      }
                  }else{
                      echo'
                      <div class="col-md-4">
                          <div class="form-group">
                              <label>Size</label>
                              <input type="text" class="form-control"  placeholder="Enter size..." name="txtsize">

                          </div>
                              <button type="submit" class="btn btn-success" name="btnsavesize">Save</button>
                              
                      </div>
                      ';
                  }

                  ?>

                  <div class="col-md-8">

                  <table  class="table table-striped">
                    <thead>
                      <tr>
                        <th hidden>#</th>  
                        <th>Size</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                            
                        
                              <?php
                              
                              $select=$pdo->prepare("select * from onek_size order by size_id desc");
                              $select->execute();
                              while($row = $select->fetch(PDO::FETCH_OBJ)){

                                  echo'<tr>
                                  
                                      <td hidden>'.$row->size_id.'</td>
                                      <td>'.$row->size.'</td>
                                      <td>
                                      <button type="submit" value="'.$row->size_id.'" class="btn btn-success" name="btneditsize">Edit</button></td>
                                      <td>
                                      <button type="submit" class="btn btn-danger" name="btndeletesize" value="'.$row->size_id.'">Delete</button>
                                      </td>
                                  
                                  </tr>';

                              } 
                              
                              ?>
                          

                    </tbody>
                  </table>

                  </div>
                </form>
              </div>
            </div>
          </div>
      
         
      </div>
    </div>

    </section>
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- call this function table -->
<!-- <script>
$(document).ready( function () {
    $('#onekTablecolour').DataTable();
} );
</script> -->
<?php

include_once'footer.php';

?>  