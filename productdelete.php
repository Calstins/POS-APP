<?php

// session and database connection
include_once'connect_db.php';

$id=$_POST['pidd'];
$sql="delete from onek_product where pid=$id";
$delete=$pdo->prepare($sql);
if ($delete->execute()) {

} else {
    echo'Error in  delete';
}


?>