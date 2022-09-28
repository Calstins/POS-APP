<?php

// session and database connection
include_once'connect_db.php';
session_start();


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

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ADMIN DASHBOARD
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
              <h3 class="box-title">Order List </h3>
          </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body">
                <div style="overflow-x: auto;">
                    <table id="orderlisttable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Invoice ID</th>                          
                          <th>Customer name</th>
                          <th>Order date</th>
                          <th>Total</th>
                          <th>Paid</th>
                          <th>Due</th>
                          <th>Payment Time</th>
                          <th>Print</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                      </thead>
                      <tbody>
                              
                          
                                        
                          
                      <?php
                                 
                                 $select=$pdo->prepare("select * from onek_invoice order by invoice_id desc");
                                 $select->execute();
                                  while($row = $select->fetch(PDO::FETCH_OBJ)){
 
                                     echo'<tr>
                                     
                                         <td>'.$row->invoice_id.'</td>
                                         <td>'.$row->customer_name.'</td>
                                         <td>'.$row->order_date.'</td>
                                         <td>'.$row->total.'</td>
                                         <td>'.$row->paid.'</td>
                                         <td>'.$row->due.'</td>
                                         <td>'.$row->payment_type.'</td>
                                             <td>
                                             <a href="invoice.php?id='.$row->invoice_id.'" target= "_blank" class="btn btn-success" role="button"><span class="glyphicon glyphicon-print" title="Print Invoice" data-toggle="tooltip" stlye="color:black"></span></a>
                                             </td>
                                             <td>
                                             <a href="editorder.php?id='.$row->invoice_id.'" class="btn btn-info" role="button"><span class="glyphicon glyphicon-edit" data-toggle="tooltip" stlye="color:black" title="Edit Order"></span></a>
                                             </td>
                                             <td>
                                             <button id='.$row->invoice_id.' class="btn btn-danger btndelete"><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Order"></span></button>
                                         </td>
                                     
                                     </tr>';
 
                                  } 
                                  
                                 ?>
                            

                      </tbody>
                    </table>
                
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- call this function table -->
<script>
$(document).ready( function () { 
    $('#orderlisttable').DataTable();
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
                text: "Once deleted, you will not be able to recover the order details!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url:'orderdelete.php',
                            type:'post',
                            data:{
                                pidd: id
                            },
                            success:function(data){
                                tdh.parents('tr').hide(); 
                            }
                        });
                        swal("Your order has been deleted!", {
                        icon: "success",
                        });
                    } else {
                swal("Your order is safe!");
                }
            }); 
    });
});
</script>
<?php

include_once'footer.php';

?> 