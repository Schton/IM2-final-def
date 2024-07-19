<?php
session_start();
ob_start();

if(!isset($_SESSION["userID"])){
    header("Location: login.php");
} else {
$userID = $_SESSION["userID"];
include 'db_con.php';

$refnumber = $_SESSION['refnumber'];
// if (isset($_SESSION['amountpaid'])) {
//     $amountpaid = $_SESSION['amountpaid'];

// } else {

//     $amountpaid = null; 
// }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="..\css\confirm.css"> -->
    <link rel="icon" type="image/x-icon" href="smartpress.png">
    <title>Order Confirmation | Smartpress</title>
        <link rel="stylesheet" href="..\css\navbar.css">
        <link rel="stylesheet" href="..\css\footer.css">
        <!-- icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <!-- font styles -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
        <link rel="icon" href="..\images\smartpress.png" type="image/x-icon">

        <style>
            body{
                    background-color: #023047;
                    color: white;
                    font-family: "Play", sans-serif;
                    margin: 0;
            }
            .container{
                align-items: center;
                text-align: center;
                display: flex;
                justify-content: center;
            }
            .form-container{
                width: 40%;
                background-color: #f7982d;
                padding: 30px;
                border-radius: 1px;
                margin-top: 10em;
                box-shadow: 2px 2px 20px 4px rgba(0,0,0,0.5);
            }
            .form-container img {
                width: 120px;
                height: 120px;
            }
            #confirm-button{
                width:25%;
                height: 6%;
                text-decoration: none;
                color: red;
                background: #023047;
                border: 0;
            }
            #confirm-button a{
                text-decoration: none;
                color: white;
                font-family: "Play", sans-serif;
                font-size: 16px;
            }
        </style>
</head>
<body>
    <!-- navigation bar -->
    <div class="navbar">
        <nav>
            <div class="nav-logo"><a href="..\php\home.php"><img src="..\images\smartpress.png" alt=""></a></div>
            <div class="printing-services"><a href="..\php\orderform.php">Printing Services</a></div>
            <div class="community">
                <select id="community-dropdown" onchange="location = this.value">
                    <option value="" disabled selected>Community</option>
                    <option value="..\php\About_Us.php">About Us</option>
                    <option value="..\php\Contact_Us.php">Contact Us</option>
                    <option value="..\php\FAQs.php">FAQs</option> <!-- kini nlang-->
                </select>
            </div>
            <div class="profile"><a href="..\php\profile-page.php"><i class="fa-regular fa-user"></i></a></div>        
        </nav>
    </div>
    <br><br><br>
<!-- awsgsd -->
    <div class="container">
        <div class="form-container">
            <?php
                $sql = "SELECT email FROM users WHERE userID='$userID'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    if($row = mysqli_fetch_assoc($result)) {
            ?>
            <img src="..\images\smartpress.png" alt="">
            <h2>Your Smartpress receipt</h2>
            <hr>
            <p>Reference number: <?php echo $refnumber ?></p>
            <p>Email: <?php echo $row['email']; ?></p>
            <hr>
            <p>Thank you for your order!</p>
            <button id="confirm-button"><a href="..\php\order-history.php">See Order History</a></button>
        <?php }} ?>
        </div>
    </div>
<!-- sdfbhsefbsefgbds -->
</div>
</body>
</html>
<?php }?>