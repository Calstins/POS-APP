<?php


// session and database connection
include_once'connect_db.php';
error_reporting(0); 
session_start();


include_once'header.php';


?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Graph Report
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
              <h3 class="box-title"><b>From: </b> <?php  echo $_POST['date_1']?><b> --- To: </b><?php  echo $_POST['date_2']?></h3>
          </div>
          <form action="" method="post">
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
              $select=$pdo->prepare("select order_date, sum(total) as price from onek_invoice where order_date between :fromdate AND :todate group by order_date");
              $select->bindParam(':fromdate',$_POST['date_1']);
              $select->bindParam(':todate',$_POST['date_2']);
              $select->execute();
              $total=[];
              $date=[];
               while($row = $select->fetch(PDO::FETCH_ASSOC)){
                  extract($row);
                  $total[]=$price;
                  $date[]=$order_date;
               }
                // echo json_encode($total);
             ?>
            <div class="chart">
            <canvas id="myChart" style="height: 250px;"></canvas>
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
    })

    //Date picker2
    $('#datepicker2').datepicker({
      autoclose: true
    })
    var ctx = document.getElementById('myChart').getContext('2d');
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
                  data: <?php echo json_encode($total);?>
              }]
          },

          // Configuration options go here
          options: {}
      });
  </script>
<?php

include_once'footer.php';

?>  