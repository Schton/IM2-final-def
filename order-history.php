<?php
session_start();
ob_start();

if(!isset($_SESSION["userID"])){
    header("Location: login.php");
} else {
    $userID = $_SESSION["userID"];
    include 'db_con.php';
    
    // Retrieve user's first name
    $firstName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT first_name  FROM users WHERE userID = $userID"))['first_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Order History</title>
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            height: 100dvh;
            background-color: #023047;
            font-family: "Play", sans-serif;
        }
        .container {
            padding: 20px;
            display: flex;
            margin-top: 10em;
            justify-content: center;
        }
        .account-section {
            min-width: 300px;
            line-height: 1.8rem;
        }
        .account-nav ul {
            list-style: none;
        }
        .account-nav a {
            cursor: pointer;
            color: #858688;
            text-decoration: none;
        }
        .account-nav a:hover {
            color: #FB8500;
        }
        .account-header {
            display: flex;
            align-items: center;
            flex-direction: row;
        }
        .profile-pic {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }
        .order-history {
            padding: 25px;
            min-width: 1000px;
            line-height: 1.5rem;
            background-color: #ffffff;
            box-shadow: 2px 2px 20px 4px rgba(0,0,0,0.5);
        }
        .order-history-header p {
            margin-bottom: 5px;
        }
        .order-details {
            height: 500px;
            display: flex;
            padding: 10px;
            margin-top: 20px;
            overflow-y: auto;
            line-height: 3rem;
            align-items: center;
            flex-direction: column;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            min-width: 30px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
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
                    <option value="..\php\FAQs.php">FAQs</option>
                </select>
            </div>
            <div class="profile"><a href="..\php\profile-page.php"><i class="fa-regular fa-user"></i></a></div>        
        </nav>
    </div>
    <div class="container">
        <div class="account-section">
            <div class="account-header">
                <i class="fa-regular fa-user" style="margin-right: 1em;color:white;"></i>
                <h3 class="account-title" style="color:white;">My Account</h3>
            </div>
            <div class="account-nav">
                <ul>
                    <li><a href="profile-page.php">Account Information</a></li>
                    <li><a href="order-history.php">Order History</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="order-history">
            <div class="order-history-header">
                <h3 class="order-history-title">Hello, <?php echo $firstName; ?> !</h3>
                <p class="order-history-description">View all your orders, past and present</p>
                <hr>
            </div>
            <div class="order-details">
                <table>
                    <tbody>
                        <tr>
                            <th>Order ID</th>
                            <th>Date Ordered</th>
                            <th>Product Type</th>
                            <th>Quantity</th>
                            <th>Product Size</th>
                            <th>Order Type</th>
                            <th>Balance</th>
                            <th>Status</th>
                        </tr>
                        <?php
                        $sql = "SELECT orderID, dateOrdered, productType, quantity, size, orderType, price, status 
                                FROM orders WHERE orders.userID = '$userID'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["orderID"]); ?></td>
                            <td><?php echo htmlspecialchars($row["dateOrdered"]); ?></td>
                            <td><?php echo htmlspecialchars($row["productType"]); ?></td>
                            <td><?php echo htmlspecialchars($row["quantity"]); ?></td>
                            <td><?php echo htmlspecialchars($row["size"]); ?></td>
                            <td><?php echo htmlspecialchars($row["orderType"] == 'regular' ? 'regular' : ($row["orderType"] == 'priority' ? 'priority' : $row["orderType"])); ?></td>
                            <td><?php echo htmlspecialchars($row["price"]); ?></td>
                            <td><?php echo htmlspecialchars($row["status"]); ?></td>
                        </tr>
                        <?php
                            } 
                        } else {
                            echo "<tr><td colspan='8'>No results found</td></tr>";
                        }
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- footer -->
    <div class="footer-container">
        <div class="socials">
            <div class="footer-logo">
                <img src="..\images\smartpress.png" alt="">
            </div>
            <div class="social-media-links">
                <div class="fb">
                    <i class="fa-brands fa-facebook fa-2x"></i>
                </div>
                <div class="twitter">
                    <i class="fa-brands fa-square-twitter fa-2x"></i>
                </div>
                <div class="instagram">
                    <i class="fa-brands fa-square-instagram fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="footer-help">
            <h4 id="footer-help-title">Help</h4>
            <a href="..\php\Contact_Us.php">Contact Us</a>
            <a href="..\php\FAQs.php">FAQs</a>
        </div>
        <div class="footer-about">
            <h4 id="footer-about-title">About</h4>
            <a href="..\php\About_Us.php">About Us</a>
            <a href="..\php\About_Us.php">Our Process</a>
        </div>
    </div>
</body>
</html>
<?php
}
?>
