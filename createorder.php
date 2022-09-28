<?php

include_once'connect_db.php';
session_start();


// select product
function selectProduct($pdo){
    $outputdata='';
    $select=$pdo->prepare("select * from onek_product order by pname asc");
    $select->execute();
    $result=$select->fetchAll();

    foreach($result as $row){
        $outputdata.='<option value="'.$row["pid"].'">'.$row["pname"].'</option>';
    }
    return $outputdata;

};

// insert data into onek_invoice_details database
if (isset($_POST['btnsaveorder'])) {
    
    $customer_name=$_POST['txtcustomer'];
    $order_date=date('y-m-d', strtotime($_POST['orderdate']));
    $subtotal=$_POST['txtsubtotal'];
    $tax=$_POST['txttax'];
    $discount=$_POST['txtdiscount'];
    $total=$_POST['txttotal'];
    $paid=$_POST['txtpaid'];
    $due=$_POST['txtdue'];
    $payment_type=$_POST['radiobtn'];
    
    // insert new variable data array(arr_) into onek_invoice
    $arr_productid=$_POST['productid'];
    $arr_productname=$_POST['productname'];
    $arr_stock=$_POST['stock'];
    $arr_qty=$_POST['qty'];
    $arr_price=$_POST['price'];
    $arr_total=$_POST['total'];

    // 1st query for invoice db
    
    $insert=$pdo->prepare("insert into onek_invoice(customer_name,order_date,subtotal,tax,discount,total,paid,due,payment_type) values(:cust,:orderdate,:stotal,:tax,:disc,:total,:paid,:due,:ptype)");

    $insert->bindParam(':cust', $customer_name);
    $insert->bindParam(':orderdate',$order_date);
    $insert->bindParam(':stotal',$subtotal);
    $insert->bindParam(':tax',$tax);
    $insert->bindParam(':disc',$discount);
    $insert->bindParam(':total',$total);
    $insert->bindParam(':paid',$paid);
    $insert->bindParam(':due',$due);
    $insert->bindParam(':ptype',$payment_type);

    $insert->execute();

    // 2nd query for invoice_details db

    $invoice_id=$pdo->lastInsertId();

    if($invoice_id!=null){
        for ($i=0; $i < count($arr_productid); $i++) { 

            // update Stock
            $rem_qty= $arr_stock[$i]-$arr_qty[$i];

            if ($rem_qty<0) {
                return "Order is not complete!";
            } else {
                $update=$pdo->prepare("update onek_product SET pstock ='$rem_qty' where pid='".$arr_productid[$i]."'");

                $update->execute();
            }
            
            
            $insert=$pdo->prepare("insert into onek_invoice_details(invoice_id,product_id,product_name,qty,price,order_date) values(:invid,:pid,:pname,:qty,:price,:orderdate)");

            $insert->bindParam(':invid', $invoice_id);
            $insert->bindParam(':pid', $arr_productid[$i]);
            $insert->bindParam(':pname',$arr_productname[$i]);
            $insert->bindParam(':qty', $arr_qty[$i]);
            $insert->bindParam(':price', $arr_price[$i]);
            $insert->bindParam(':orderdate',$order_date);

            $insert->execute();
           
        }

        header('location:orderlist.php');
    }

} 


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
        Create Order
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
            <form action="" method="post">
                <div class="box-header with-border">
                    <h3 class="box-title">Order </h3>
                </div>
                    <!-- /.box-header -->
                    <!-- form start --> 
                    
                <!-- for customer and date -->
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer Name</label>
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
                <!-- for table -->
                <div class="box-body">
                    <div class="col-md-12">
                    <div style="overflow-x: auto;">
                    <table id="onekTable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>                          
                          <th>Search Product</th>
                          <th>Stock</th>
                          <th>Price</th>
                          <th>Enter Quantity</th>
                           <th>Total</th>
                          <th>
                            <center>
                                <button type="button" class="btn btn-success btnadd btn-sm" name="add"><span class="glyphicon glyphicon-plus" title="Add Row" data-toggle="tooltip"></span></button>
                            </center>
                          </th>
                        </tr>
                      </thead>
                    </table>
                    </div>
                    </div>
                </div>
                <!-- for tax discount etc-->
                <div class="box-body"></div>
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label>SubTotal</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <b>&#8358</b>
                            </div>
                            <input type="number" class="form-control" name="txtsubtotal" required id="txtsubtotal" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>VAT(7.5%)</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <b>&#8358</b>
                            </div>
                        <input type="number" class="form-control" name="txttax" id="txttax" readonly>
                        </div>    
                    </div>
                    <div class="form-group">
                        <label>Discount</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <b>&#8358</b>
                            </div>
                        <input type="number" class="form-control"  placeholder="Enter..." name="txtdiscount" id="txtdiscount">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                            <label>Total</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <b>&#8358</b>
                                </div>
                            <input type="number" class="form-control"  name="txttotal" id="txttotal" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Paid</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <b>&#8358</b>
                                </div>
                            <input type="number" class="form-control"  placeholder="Enter..." name="txtpaid" required id="txtpaid">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Due</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <b>&#8358</b>
                                </div>
                            <input type="number" class="form-control" name="txtdue" id="txtdue" readonly>
                        </div>
                        <br>
                        <label for="">Payment Method</label>    
                        <div class="form-group">
                        <label>
                        <input type="radio" name="radiobtn" class="minimal-red" value="cash" checked><b>   CASH</b>&nbsp
                        </label>
                        <label>
                        <input type="radio" name="radiobtn" class="minimal-red" value="card"><b> CARD </b> &nbsp
                        </label>
                        <label>
                        <input type="radio" name="radiobtn" class="minimal-red" value="check"><b> CHEQUE</b>
                        </label>
                    </div>
                </div>
                    
              </div> 
                <hr>
                <div align="center">
                    <input class="btn btn-success" type="submit" name="btnsaveorder" value="Save Order">
                
                </div>
                <hr>
                
            </form>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

     //Red color scheme for iCheck
     $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })

     
    $(document).ready(function(){
    
        $(document).on('click','.btnadd',function(){
            var html='';
            html+='<tr>';
            html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
            html+='<td><select class="form-control productid"  name="productid[]" style="width:250px"><option value="">Select Product</option><?php echo selectProduct($pdo); ?></select></td>';
            html+='<td><input type="number" class="form-control stock" name="stock[]" readonly></td>';
            html+='<td><input type="number" class="form-control price" name="price[]" readonly></td>';
            html+='<td><input type="number" min="1" class="form-control qty" name="qty[] "</td>';
            html+='<td><input type="text" class="form-control total" name="total[]" readonly></td>';
            html+='<td><center><button type="button" class="btn btn-danger btnremove btn-sm" name="remove"><span class="glyphicon glyphicon-remove" title="Remove Row" data-toggle="tooltip" style="color:white"></span></button></center></td>';
        
            $('#onekTable').append(html);

      
        //Initialize Select2 Elements
        $('.productid').select2()

        // fetch out data to fill row
        $(".productid").on('change',function(e){
            var productid = this.value;
            var tr=$(this).parent().parent();
            $.ajax({
                 url:"getproduct.php",
                 method:"get",
                 data:{id:productid},
                 success:function(data){
               
                    tr.find(".pname").val(data["pname"]);
                    tr.find(".stock").val(data["pstock"]);
                    tr.find(".price").val(data["saleprice"]);
                    tr.find(".qty").val(1);
                    tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());

                    calculation(0,0);
                    
                 }
            })
        });

        }); 
        // btn remove
        $(document).on('click','.btnremove',function(){
            $(this).closest('tr').remove();
            calculation(0,0);
            $("#txtpaid").val(0);
        });

        // product automatic calculation
        $("#onekTable").delegate(".qty","keyup change",function(){

            var quantity = $(this);
            var tr =$(this).parent().parent();

            if ((quantity.val()-0)>(tr.find(".stock").val()-0)) {
                swal("WARNING!","SORRY! This much of quantity is not available","warning");
                quantity.val(1);
                tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
                
            } else {
                tr.find(".total").val(tr.find(".qty").val() * tr.find(".price").val());
                calculation(0,0);
            }

        });
    
        // Calculate Functions
        function calculation(dis,paid){
            var subTotal = 0;
            var tax = 0;
            var discount = dis;
            var netTotal = 0;
            var paidAmount = paid; 
            var due = 0;

            
            $(".total").each(function(){
                subTotal=subTotal + ($(this).val()*1);
            })

            tax=0.075*subTotal;
            netTotal=tax+subTotal;
            netTotal=netTotal-discount;
            due= netTotal-paidAmount;
            
            $("#txtsubtotal").val(subTotal.toFixed(2));
            $("#txttax").val(tax.toFixed(2));
            $("#txttotal").val(netTotal.toFixed(2));
            $("#txtdiscount").val(discount);
            $("#txtdue").val(due.toFixed(2));
            
            
             

        }
        $("#txtdiscount").keyup(function(){
            var discount = $(this).val();
            calculation(discount,0);
        })
        $("#txtpaid").keyup(function(){
            var paid = $(this).val();
            var discount= $("#txtdiscount").val();
            calculation(discount,paid);
        })

        


    });
</script>
<script>
$(document).ready( function () {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<?php

include_once'footer.php';

?>