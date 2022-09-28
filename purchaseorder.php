<?php

// session and database connection
include_once'connect_db.php';

session_start();

include_once'header.php';

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Purchase Order
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Sales</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="box box-success"> 
          <form action="" method="post">
          <div class="box-header with-border">
              <h3 class="box-title"><b>From: </b> <?php  echo $_POST['date_1']?><b> --- To: </b><?php  echo $_POST['date_2']?></h3>
          </div>
            <!-- /.box-header -->
            <!-- form start -->
            
        <div class="box-body">
             <div class="row">
                 <div class="col-md-5">
                    <!-- Date -->
                    <div class="form-group">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker1" name="date_1" data-date-format="yyyy-mm-dd" placeholder="starting from...">
                        </div>
                            <!-- /.input group -->
                    </div>
                </div>
                 <div class="col-md-5">
                    <div class="form-group">
                        <div class="input-group date">
                            <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker2" name="date_2" data-date-format="yyyy-mm-dd" placeholder="ending at...">
                        </div>
                    </div>
                 </div>
                 <div class="col-md-2">
                 <div align="left">
                    <input  type="submit"  class="btn btn-success" name="btndatefilter" value="Filter by Date">
                
                </div>
                 </div>
             </div>
             <br><br>

             <?php
             
             $select=$pdo->prepare("select sum(total) as total, sum(subtotal) as stotal, count(invoice_id) as invoice from onek_invoice where order_date between :fromdate AND :todate");
                                 $select->bindParam(':fromdate',$_POST['date_1']);
                                 $select->bindParam(':todate',$_POST['date_2']);
                                 $select->execute();
                             $row = $select->fetch(PDO::FETCH_OBJ);
                             $net_total=$row->total;
                             $stotal=$row->stotal;
                             $invoice=$row->invoice;
                              
             
             ?>
             
                   <!-- Info boxes -->
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Purchase</span>
              <span class="info-box-number"><?php echo $invoice?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Amount</span>
              <span class="info-box-number">&#8358;<?php  echo number_format($stotal)?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

      </div>
      <!-- /.row --> 
               <div style="overflow-x: auto;">
                    <table id="salesreporttable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Date</th>                          
                          <th>Company Name</th>
                          <th>Status</th>
                          <th>Amount(<span>&#8358;</span>)</th>
                          <th>Total Amount(<span>&#8358;</span>)</th>
                        </tr>
                      </thead>
                      <tbody>
                                  
                          
                      <?php
                                 
                                 $select=$pdo->prepare("select * from onek_invoice where order_date between :fromdate AND :todate");
                                 $select->bindParam(':fromdate',$_POST['date_1']);
                                 $select->bindParam(':todate',$_POST['date_2']);
                                 $select->execute();
                                  while($row = $select->fetch(PDO::FETCH_OBJ)){
 
                                     echo'<tr>
                                     
                                         <td>'.$row->invoice_id.'</td>
                                         <td>'.$row->customer_name.'</td>
                                         <td>'.$row->subtotal.'</td>
                                         <td>'.$row->tax.'</td>
                                         <td>'.$row->discount.'</td>
                                         <td><span class="label label-danger">'.$row->total.'</span></td>
                                         <td>'.$row->paid.'</td>
                                         <td>'.$row->due.'</td>
                                         <td>'.$row->order_date.'</td>
                                     ';
                                     if ($row->payment_type=="cash"){
                                         echo'<td><span class="label label-info">'.$row->payment_type.'</span></td>';
                                     } elseif($row->payment_type=="card"){
                                        echo'<td><span class="label label-warning">'.$row->payment_type.'</span></td>';
                                     } else {
                                        echo'<td><span class="label label-primary">'.$row->payment_type.'</span></td>';
                                     }
                                     
 
                                  } 
                                  
                                 ?>
                               
                      </tbody>
                    </table>
                </div>    
          </div>
          </form>
        </div>
        
        

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
    $(document).ready( function () { 
        $('#salesreporttable').DataTable();
    } );
    //Date picker1
    $('#datepicker1').datepicker({
      autoclose: true
    });
</script>
<?php

include_once'footer.php';

?> 