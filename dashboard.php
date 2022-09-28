<?php

include_once'connect_db.php';
session_start();


if($_SESSION['useremail']==""){
    header('location:login.php');
}

$select= $pdo->prepare("select sum(total) as t, count(invoice_id) as inv from onek_invoice");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);

$total_order=$row->inv;
$net_total=$row->t;


$select=$pdo->prepare("select order_date, total from onek_invoice group by order_date LIMIT 30");
$select->execute();
$ttl=[];
$date=[];
 while($row = $select->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $ttl[]=$total;
    $date[]=$order_date;
 }
 
            

include_once'header.php';

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header">
      <h1>
        ADMIN DASHBOARD
        <small>This is the admin dashboard</small>
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
     <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $total_order; ?></h3>

              <p>Total Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>₦<?php echo number_format($net_total,2); ?></h3>
              <!-- <h3>53<sup style="font-size: 20px">%</sup></h3> -->

              <p>Total Revenew</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <?php
        
        $select= $pdo->prepare("select count(pname) as p from onek_product");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_OBJ);

        $total_product=$row->p;
        
        ?>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $total_product; ?></h3>

              <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      
        <!-- ./col -->
        
      </div>
      
    </div>
    <div class="box box-success">
          <div class="box-header with-border">
            <div class="box-title">Earning per Day</div>
          </div>
          <div class="box-body">
            <div class="chart">
            <canvas id="earningsChart" style="height: 250px;"></canvas>
            </div>
          </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-success">
          <div class="box-header with-border">
            <div class="box-title">Best Selling Product</div>
          </div>
          <div class="box-body">
          <table id="bestsellingproductlist" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Product ID</th>                          
                          <th>Product Name</th>
                          <th>Qty</th>
                          <th>Paid</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                              
                          
                                        
                          
                      <?php
                                 
                                 $select=$pdo->prepare("select product_id, product_name,price,sum(qty) as q, sum(qty*price) as total from onek_invoice_details group by product_id order by sum(qty) DESC LIMIT 10");
                                 $select->execute();
                                  while($row = $select->fetch(PDO::FETCH_OBJ)){
 
                                     echo'<tr>
                                     
                                         <td>'.$row->product_id.'</td>
                                         <td>'.$row->product_name.'</td>
                                         <td><span class="label label-info">'.$row->q.'</span></td>
                                         <td><span class="label label-primary">'.$row->price.'</span></td>
                                         <td><span class="label label-success">'.$row->total.'</span></td>
                                      
                                     </tr>';
 
                                  } 
                                  
                                 ?>
                            

                      </tbody>
                    </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
      <div class="box box-success">
          <div class="box-header with-border">
            <div class="box-title">Recent Orders</div>
          </div>
          <div class="box-body">
          <table id="orderlisttable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Invoice ID</th>                          
                          <th>Customer name</th>
                          <th>Order date</th>
                          <th>Total</th>
                          <th>Payment Time</th>
                        </tr>
                      </thead>
                      <tbody>
                              
                          
                                        
                          
                      <?php
                                 
                                 $select=$pdo->prepare("select * from onek_invoice order by invoice_id desc limit 10");
                                 $select->execute();
                                  while($row = $select->fetch(PDO::FETCH_OBJ)){
 
                                     echo'<tr>
                                     
                                         <td><a href ="editorder.php?id='.$row->invoice_id.'">'.$row->invoice_id.'</a></td>
                                         <td>'.$row->customer_name.'</td>
                                         <td>'.$row->order_date.'</td>
                                         <td><span class="label label-success">'.$row->total.'</span></td>';

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
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  // chart script
  var ctx = document.getElementById('earningsChart').getContext('2d');
      var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: 'bar',

          // The data for our dataset
          data: {
              labels:<?php echo json_encode($date);?>,
              datasets: [{
                  label: 'Total Earnings',
                  backgroundColor: 'rgb(255, 99, 132)',
                  borderColor: 'rgb(255, 99, 132)',
                  data: <?php echo json_encode($ttl);?>
              }]
          },

          // Configuration options go here
          options: {}
    });


</script>
<?php

include_once'footer.php';

?> 