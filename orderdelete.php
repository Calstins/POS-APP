<?php

// session and database connection
include_once'connect_db.php';

$id=$_POST['pidd'];

// Delete T1,T2 from T1 inner join T2 on T1.key=T2.key where condition T1.key=id

$sql="delete onek_invoice, onek_invoice_details FROM onek_invoice INNER JOIN onek_invoice_details ON onek_invoice.invoice_id = onek_invoice_details.invoice_id where onek_invoice.invoice_id=$id";

$delete=$pdo->prepare($sql);
if ($delete->execute()) {

} else {
    echo'Error in  delete';
}


?>