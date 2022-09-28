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
        Product List
        <small> </small>
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
              <h3 class="box-title">Product List </h3>
          </div>
            <!-- /.box-header -->
            <!-- form start -->
            
                <div class="box-body">
                <div style="overflow-x: auto;">
                    <table id="onekTable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>                          
                          <th>Product name</th>
                          <th>Category</th>
                          <th>Colour Variation</th>
                          <th>Size</th>
                          <th>Brand</th>
                          <th>Purchase Price</th>
                          <th>Sales Price</th>
                          <th>Total Stock</th>
                          <th>Description</th>
                          <th>Image</th>
                          <th>View</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                              
                          
                                <?php
                                 
                                $select=$pdo->prepare("select * from onek_product order by pid desc");
                                $select->execute();
                                 while($row = $select->fetch(PDO::FETCH_OBJ)){

                                    echo'<tr>
                                    
                                        <td>'.$row->pid.'</td>
                                        <td>'.$row->pname.'</td>
                                        <td>'.$row->pcategory.'</td>
                                        <td>'.$row->pvariation.'</td>
                                        <td>'.$row->psize.'</td>
                                        <td>'.$row->pbrand.'</td>
                                        <td>'.$row->purchaseprice.'</td>
                                        <td>'.$row->saleprice.'</td>
                                        <td>'.$row->pstock.'</td>
                                        <td>'.$row->pdescription.'</td>
                                        <td><img src="productimages/'.$row->pimage.'" width="40px" height="40px"></td>
                                        <td>
                                            <a href="viewproduct.php?id='.$row->pid.'" class="btn btn-success" role="button"><span class="glyphicon glyphicon-eye-open" title="View Product"></span></a>
                                            </td>
                                            <td>
                                            <a href="editproduct.php?id='.$row->pid.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" data-toggle="tooltip" style="color:black" title="Edit Product"></span></a>
                                            </td>
                                            <td>
                                            <button id='.$row->pid.' class="btn btn-danger btndelete"><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button >
                                        </td>
                                    
                                    </tr>';

                                 } 
                                 
                                ?>
                            

                      </tbody>
                    </table>
                
                </div>
                </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- call this function table -->
<script>
$(document).ready( function () {
    $('#onekTable').DataTable();
} );
</script>

<script>
$(document).ready( function () {
    $('[data-toggle="tooltip"]').tooltip();
} );
</script>
<!-- delete -->
<script>
$(document).ready( function () {
    $('.btndelete').click(function(){
        var tdh = $(this);
        var id=$(this).attr("id"); 

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover the product details!",
                icon: "warning",
                butons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url:'productdelete.php',
                            type:'post',
                            data:{
                                pidd: id
                            },
                            success:function(data){
                                tdh.parents('tr').hide(); 
                            }
                        });
                        swal("Your Product has been deleted!", {
                        icon: "success",
                        });
                    } else {
                swal("Your Product is safe!");
                }
            }); 
    });
});
</script>


<?php

include_once'footer.php';

?>   