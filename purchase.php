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
        New Purchase
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
              <h3 class="box-title">Make Purchase</h3>
          </div>
            <!-- /.box-header -->
            <!-- form start -->
            
          <div class="box-body">
          <div class="col-md-6">
                        <div class="form-group">
                            <label>Company Name</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control"  placeholder="Enter customer name" name="txtcustomer" id="txtcustomer" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Date -->
                        <div class="form-group">
                            <label>Date:</label>

                            <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("y-m-d")?>" data-date-format="yyyy-mm-dd" readonly>
                            </div>
                            <!-- /.input group -->
                        </div> 
              <!-- /.form group -->
                    </div>
          </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php

include_once'footer.php';

?> 