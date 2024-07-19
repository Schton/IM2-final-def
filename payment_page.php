<?php
session_start();
ob_start();

if (!isset($_SESSION["userID"])) {
    header("Location: login.php");
    exit();
} else {
    $userID = $_SESSION["userID"];
    include 'db_con.php'; // Include your database connection script
    $downpay = $_SESSION['downpay'];

    if (isset($_POST['submit'])) {
        // Sanitize and escape user inputs
        $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
        $cardnumber = mysqli_real_escape_string($conn, $_POST['cardnumber']);
        $amountpaid = floatval($_POST['amountpaid']);
        $refnumber = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
        $paymentType = $_SESSION['paymentType'];

        // Insert payment details into 'payment_details' table
        $sql_payment = "INSERT INTO payment_details (userID, method, cardnumber, amountpaid, refnumber, paymentType) 
                        VALUES ('$userID', '$payment_method', '$cardnumber', '$amountpaid', '$refnumber', '$paymentType')";
        
        $_SESSION['refnumber'] = $refnumber;
        $_SESSION['amountpaid'] = $amountpaid;

        //confirm page amount page
        // $amountpaid
        //confirm page amount page


        if ($conn->query($sql_payment) === TRUE) {
            // Retrieve order details from session
            $orderDetails = $_SESSION['orderDetails'];

            // Extract order details
            $productType = mysqli_real_escape_string($conn, $orderDetails['productType']);
            $quantity = intval($orderDetails['quantity']);
            $size = mysqli_real_escape_string($conn, $orderDetails['size']);
            $productFile = mysqli_real_escape_string($conn, $orderDetails['productFile']);
            $details = mysqli_real_escape_string($conn, $orderDetails['details']);
            $orderType = intval($orderDetails['orderType']);
            $price = floatval($orderDetails['price']);
            $dateOrdered = mysqli_real_escape_string($conn, $orderDetails['dateOrdered']);

            // Insert order details into 'orders' table
            $sql_order = "INSERT INTO orders (userID, productType, quantity, size, productFile, details, orderType, price, dateOrdered) 
                          VALUES ('$userID', '$productType', '$quantity', '$size', '$productFile', '$details', '$orderType', '$price', '$dateOrdered')";

            if ($conn->query($sql_order) === TRUE) {
                $orderID = mysqli_insert_id($conn);

                // Redirect to confirmation page after successful payment and order storage
                header("Location: confirm.php");
                exit();
            } else {
                echo "Error inserting order details: " . $conn->error;
            }
        } else {
            echo "Error inserting payment details: " . $conn->error;
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment | Smartpress</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/smartpress.png" type="image/x-icon">
    <style>
        body {
            margin: 0;
            background: #023047;
            font-family: "Play", sans-serif;
            color: white;
        }
        .header {
            display: flex;
            justify-content: center;
        }
        .header img {
            width: 100px;
            height: 100px;
        }
        .payment-cont {
            display: flex;
            justify-content: center;
        }
        form {
            width: 40%;
        }
        input {
            border: 1px solid white;
            background: 0;
            margin-bottom: 2%;
            padding-left: 2%;
            font-size: 16px;
            color: white;
        }
        h4 {
            font-size: 32px;
        }
        #lname {
            margin-left: 20px;
        }
        #fname, #lname {
            width: 48%;
        }
        input #phone, #address, #card-name, #card-number {
            width: 100%;
        }
        .text-div {
            height: 3em;
        }
        input #country, #province, #city {
            margin-left: 8px;
            width: 32%;
        }
        #phone {
            width: 100%;
        }
        button {
            width: 26em;
            background: #192236;
            color: white;
            border: 0;
            height: 3em;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Play", sans-serif;
            font-size: 20px;
        }
        #country {
            width: 32%;
        }
        #payment-method option[disabled] {
            display: none;
        }
        #payment-method {
            background: #023047;
            color: white;
            font-family: "Play", sans-serif;
            border: 0;
            font-size: 20px;
        }
        #cardnumber{
            width: 16em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <a href="../php/home.php"><img src="../images/smartpress.png" alt=""></a>
            </div>
        </div>
        <hr>
        <div class="payment-cont">
            <form action="payment_page.php" method="POST">

                <h4>Payment</h4>
                <p>All transactions are secure and encrypted</p>
                <p>For onsite payments, please pay the exact downpayment amount <?php echo $downpay?>.</p>
                <p>For online payments please pay the full amount.</p>
                <select id="payment-method" name="payment_method">
                    <option value="" disabled selected>Select payment method</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Gcash">Gcash</option>
                    <option value="PayMaya">PayMaya</option>
                </select>
                <br><br>
                <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "text" maxlength = "11" name="cardnumber" class="text-div" id="cardnumber" placeholder="Card number" required>
                <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "11" name="amountpaid" class="text-div" id="amountpaid" placeholder="Amount (in PHP)" required>
                <hr>
                <button type="submit" class="submit" id="submit" name="submit">Pay now</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php } ?>