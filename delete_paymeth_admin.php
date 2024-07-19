<?php
    include "db_con.php";
    $paymentid = $_GET['paymentid'];
    $sql = "DELETE FROM payment_details WHERE paymentid = $paymentid";
    $result = mysqli_query($conn, $sql);
    if($result) {
        echo "<script>
                alert('Payment detail successfully removed.');
                window.location.href = 'admin1.php';
              </script>";
    }
    else {
        echo "Failed: " . mysqli_error($conn);
    }
?>