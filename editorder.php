<?php

include_once'connect_db.php';
session_start();



// select product
function selectProduct($pdo,$pid){
    $outputdata='';
    $select=$pdo->prepare("select * from onek_product order by pname asc");
    $select->execute();
    $result=$select->fetchAll();

    foreach($result as $row){

        $outputdata.='<option value="'.$row["pid"].'"';
        if($pid==$row['pid']){
            $outputdata.='selected';
        }
        $outputdata.='>'.$row["pname"].'</option>';
        // $outputdata.='<option value="'.$row["pid"].'">'.$row["pname"].'</option>';
    }
    return $outputdata;

};
////// fetch data from database(INVOICE DETAILS) using GET BY ID

$id=$_GET['id'];
$select= $pdo->prepare("select * from onek_invoice where invoice_id =$id");
$select->execute();

$row= $select->fetch(PDO::FETCH_ASSOC);

$customer_name=$row['customer_name'];
$order_date=date('y-m-d', strtotime($row['order_date']));
$subtotal=$row['subtotal'];
$tax=$row['tax']; 
$discount=$row['discount'];
$total=$row['total'];
$paid=$row['paid'];
$due=$row['due'];
$payment_type=$row['payment_type'];

// insert into invoice details tax, subtoatl etc  Ajax
$select= $pdo->prepare("select * from onek_invoice_details where invoice_id =$id");
$select->execute();
$row_invoice_details= $select->fetchAll(PDO::FETCH_ASSOC);


///// insert data into onek_invoice_details database for update
if (isset($_POST['btnupdateorder'])) {
    
//    step 1- Get values from text fields and from array in variables.
    $txt_customer_name=$_POST['txtcustomer'];
    $txt_order_date=date('y-m-d', strtotime($_POST['orderdate']));
    $txt_subtotal=$_POST['txtsubtotal'];
    $txt_tax=$_POST['txttax'];
    $txt_discount=$_POST['txtdiscount'];
    $txt_total=$_POST['txttotal'];
    $txt_paid=$_POST['txtpaid'];
    $txt_due=$_POST['txtdue'];
    $txt_payment_type=$_POST['radiobtn'];

    //   for ajax table 
    $arr_productid=$_POST['productid'];
    $arr_productname=$_POST['productname'];
    $arr_stock=$_POST['stock'];
    $arr_qty=$_POST['qty'];
    $arr_price=$_POST['price'];
    $arr_total=$_POST['total'];

//    step 2- Write update query for onek_product stock
    foreach($row_invoice_details as $item_invoice_details){

        $updateproduct = $pdo->prepare("update onek_product set pstock=pstock+".$item_invoice_details['qty']." where pid='".$item_invoice_details['product_id']."'");

        $updateproduct->execute();

    } 

//    step 3- Write delete query for onek_invoice_details table data where invoice_id =$id

    $delete_invoice_details=$pdo->prepare("delete from onek_invoice_details where invoice_id=$id");
    
    $delete_invoice_details->execute();

//  step 4- Write update query for onek_invoice table data   

    $update_invoice=$pdo->prepare("update onek_invoice set customer_name=:cust,order_date=:orderdate,subtotal=:stotal,tax=:tax,discount=:disc, total=:total,paid=:paid,due=:due,payment_type=:ptype where invoice_id=$id ");
        
    $update_invoice->bindParam(':cust', $txt_customer_name);
    $update_invoice->bindParam(':orderdate',$txt_order_date);
    $update_invoice->bindParam(':stotal',$txt_subtotal);
    $update_invoice->bindParam(':tax',$txt_tax);
    $update_invoice->bindParam(':disc',$txt_discount);
    $update_invoice->bindParam(':total',$txt_total);
    $update_invoice->bindParam(':paid',$txt_paid);
    $update_invoice->bindParam(':due',$txt_due);
    $update_invoice->bindParam(':ptype', $txt_payment_type);

    $update_invoice->execute();

// 2nd query for invoice_details db

    $invoice_id=$pdo->lastInsertId();     
        
    if($invoice_id!=null){
        for ($i=0; $i < count($arr_productid); $i++) { 

//  step 5- write select query for onek_product table to get out stock values

            $selectpdt=$pdo->prepare("select * from onek_product where pid='".$arr_productid[$i]."'");
            $selectpdt->execute();

            while($rowpdt=$selectpdt->fetch(PDO::FETCH_OBJ)){

                $db_stock[$i]=$rowpdt->pstock;

                // update Stock
                $rem_qty=$db_stock[$i]-$arr_qty[$i];

                    if ($rem_qty<0) {
                        return "Order is not complete!";
                    } else {

//  step 6- write update query for onek_poduct to update stock values.

                        $update=$pdo->prepare("update onek_product SET pstock ='$rem_qty' where pid='".$arr_productid[$i]."'");

                        $update->execute();
                    }
            }

//  step 7- write update query for onek_poduct to update stock values.
                    
                    
            $insert=$pdo->prepare("insert into onek_invoice_details(invoice_id,product_id,product_name,qty,price,order_date) values(:invid,:pid,:pname,:qty,:price,:orderdate)");

            $insert->bindParam(':invid', $id);
            $insert->bindParam(':pid', $arr_productid[$i]);
            $insert->bindParam(':pname',$arr_productname[$i]);
            $insert->bindParam(':qty', $arr_qty[$i]);
            $insert->bindParam(':price', $arr_price[$i]);
            $insert->bindParam(':orderdate',$txt_order_date);

            $insert->execute(); 
                    
        }
        header('location:orderlist.php');
    } 
        

//    step 4- Write update query for onek_invoice table data

}

include_once'header.php';



?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Edit Order
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
             <!-- form starts -->
            <form action="" method="post">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Order </h3>
                </div>            
                <!-- for customer and date -->
                <div class="box-body">
                    <!-- customer  -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer Name</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control" name="txtcustomer" required id="txtcustomer" value="<?php echo $customer_name; ?>" required>
                            </div>
                        </div>
                    </div>
                    <!-- Date -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date:</label>

                            <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo $order_date?>" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- for customer and date ends -->
                </div> 
                <!-- for Ajax table for product details -->
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
                                <?php
                            
                                foreach($row_invoice_details as $item_invoice_details){
                                
                                $select= $pdo->prepare("select * from onek_product where pid='{$item_invoice_details['product_id']}'");
                                $select->execute();
                                $row_product= $select->fetch(PDO::FETCH_ASSOC);
                      
                                ?>
                                <tr>
                                <?php
                                    echo '<td><input type="hidden" class="form-control pname" name="productname[]" value="'.$row_product['pname'].'" readonly></td>';
                                    echo '<td><select class="form-control productidedit"  name="productid[]" style="width:250px"><option value="">Select Product</option>'.selectProduct($pdo,$item_invoice_details['product_id']).'</select></td>';
                                    echo '<td><input type="number" class="form-control stock" name="stock[]" value="'.$row_product['pstock'].'" readonly></td>';
                                    echo '<td><input type="number" value="'.$row_product['saleprice'].'" class="form-control price" name="price[]" readonly></td>';
                                    echo '<td><input type="number" min="1" class="form-control qty" value="'.$item_invoice_details['qty'].'" name="qty[] "</td>';
                                    echo '<td><input type="text" class="form-control total" value="'.$row_product['saleprice'] * $item_invoice_details['qty'].'" name="total[]" readonly></td>';
                                    echo '<td><center><button type="button" class="btn btn-danger btnremove btn-sm" name="remove"><span class="glyphicon glyphicon-remove" title="Remove Row" data-toggle="tooltip" style="color:white"></span></button></center></td>';
                                ?> 
                                </tr>
                                <?php  } ?>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- for Ajax table for product details ends-->
                <!-- for m=invoice details tax discount etc starts-->
                <div class="box-body"></div>
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label>SubTotal</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <b>&#8358</b>
                            </div>
                            <input type="number" class="form-control" value="<?php  echo $subtotal; ?>" name="txtsubtotal" required id="txtsubtotal" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>VAT(7.5%)</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <b>&#8358</b>
                            </div>
                        <input type="number" class="form-control" name="txttax" value="<?php  echo $tax ?>" id="txttax" readonly>
                        </div>    
                    </div>
                    <div class="form-group">
                        <label>Discount</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <b>&#8358</b>
                            </div>
                        <input type="number" class="form-control"  placeholder="Enter..." name="txtdiscount" value="<?php  echo $discount ?>" id="txtdiscount">
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
                            <input type="number" class="form-control"  name="txttotal" value="<?php  echo $total ?>" id="txttotal" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Paid</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <b>&#8358</b>
                                </div>
                            <input type="number" class="form-control"  placeholder="Enter the customer's payment" name="txtpaid" value="<?php  echo $paid ?>" required id="txtpaid">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Due</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <b>&#8358</b>
                                </div>
                            <input type="number" class="form-control" name="txtdue" value="<?php  echo $due; ?>"  id="txtdue" readonly>
                        </div>
                        <br>
                        <label for="">Payment Method</label>    
                        <div class="form-group">
                        <label>
                        <input type="radio" name="radiobtn" class="minimal-red" value="cash" value="<?php  echo ($payment_type=='cash')?'checked':'' ?>"><b>   CASH</b>&nbsp
                        </label>
                        <label>
                        <input type="radio" name="radiobtn" class="minimal-red" value="card"<?php  echo ($payment_type=='card')?'checked':''?>><b> CARD </b> &nbsp
                        </label>
                        <label>
                        <input type="radio" name="radiobtn" class="minimal-red" value="cheque"<?php  echo ($payment_type=='cheque')?'checked':''?>><b> CHEQUE</b>
                        </label>
                    </div>
                </div>
                 <!-- for m=invoice details tax discount etc ends-->   
              </div> 
                <hr>
                <div align="center">
                    <input class="btn btn-success" type="submit" name="btnupdateorder" value="Update Order">
                
                </div>
                <hr>
                
            </form>
            <!-- form Ends -->
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

          
        //Initialize Select2 Elements
        $('.productidedit').select2()

        // fetch out data to fill row
        $(".productidedit").on('change',function(e){
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
                    $("#txtpaid").val("");
                 }
            })
        }); 
    
        $(document).on('click','.btnadd',function(){
            var html='';
            html+='<tr>';
            html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
            html+='<td><select class="form-control productid"  name="productid[]" style="width:250px"><option value="">Select Product</option><?php echo selectProduct($pdo,''); ?></select></td>';
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
                    $("#txtpaid").val(""); 
                 }
            })
        });

        }); 
        // btn remove
        $(document).on('click','.btnremove',function(){
            $(this).closest('tr').remove();
            calculation(0,0);
            $("#txtpaid").val("");
        });

        // product automatic calculation
        $("#onekTable").delegate(".qty","keyup change",function(){

            var quantity = $(this);
            var tr =$(this).parent().parent();
            $("#txtpaid").val("");

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