<?php
    include "db_con.php";
    if (isset($_GET['userID'])) {
        $userID = intval($_GET['userID']);
    
        // Start a transaction
        mysqli_begin_transaction($conn);
    
        try {
            // Delete from orders
            $sql = "DELETE FROM orders WHERE userID = $userID";
            if (!mysqli_query($conn, $sql)) {
                throw new Exception("Error deleting from orders: " . mysqli_error($conn));
            } else
    
            // Delete from feedback
            $sql = "DELETE FROM feedback WHERE userID = $userID";
            if (!mysqli_query($conn, $sql)) {
                throw new Exception("Error deleting from feedback: " . mysqli_error($conn));
            }
    
            // Finally, delete from users
            $sql = "DELETE FROM users WHERE userID = $userID";
            if (!mysqli_query($conn, $sql)) {
                throw new Exception("Error deleting from users: " . mysqli_error($conn));
            } 
    
            // Commit the transaction
            mysqli_commit($conn);
    
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            mysqli_rollback($conn);
            echo "Failed to delete user: " . $e->getMessage();
        }
        $result = mysqli_query($conn, $sql);
            if($result) {
                echo "<script>
                        alert('User successfully removed.');
                        window.location.href = 'admin1.php';
                    </script>";
        }
    }
?>