<?php
    include "db_con.php";
    $orderID = $_GET['orderID'];
    $sql = "DELETE FROM orders WHERE orderID = $orderID";
    $result = mysqli_query($conn, $sql);
    if($result) {
        echo "<script>
                alert('Order successfully removed.');
                window.location.href = 'admin1.php';
              </script>";
    }
    else {
        echo "Failed: " . mysqli_error($conn);
    }
?>