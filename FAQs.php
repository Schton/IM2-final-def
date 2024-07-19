<?php
session_start();
ob_start();

if(!isset($_SESSION["userID"])){
    header("Location: login.php");
} else {
$userID = $_SESSION["userID"];
include 'db_con.php';
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="..\css\FAQs.css">
    <title>FAQs</title>
        <link rel="stylesheet" href="..\css\navbar.css">
        <link rel="stylesheet" href="..\css\footer.css">
        <!-- icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <!-- font styles -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
        <link rel="icon" href="..\images\smartpress.png" type="image/x-icon">
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
    <div class="container">
        <h1 id="title">FAQs</h1>
        <div class="FAQ-content">

            <div class="quick-links">
                <div class="order">
                    <a href="#order-content">Orders</a>
                </div>
                <div class="product">
                    <a href="#product-content">Products</a>
                </div>
                <div class="service">
                    <a href="#service-content">Services</a>
                </div>
                <div class="transaction">
                    <a href="#transaction-content">Transactions</a>
                </div>
                <div class="back-to-top"><a href="#"><i class="fa-solid fa-arrow-up"></i></a></div>
            </div>

            <div class="content">
                <div class="order-content" id="order-content">
                    <h3>Orders</h3>
                    <div class="order-question-one">
                        <h5>1. How will you be able to order/request our prints?</h3>
                        <p>You will be able to inquire for your orders online using our website or directly at our company building in (LOCATION).</p>
                        <hr>
                    </div>
                    <div class="order-question-two">
                        <h5>2. Once the order is finished processing, how will we be notified of its completion?</h3>
                        <p>You will notified through the number and email that you used to log into our website or have given to the cashier.</p>
                        <hr>
                    </div>
                    <div class="order-question-three">
                        <h5>3. How long does it take to complete an order?</h3>
                        <p>About 1-3 days for prints, tarpaulines, and signages. For billboards, it may take about 7 days or more.</p>
                        <hr>
                    </div>
                </div>
                <div class="product-content" id="product-content">
                    <h3>Products</h3>
                    <div class="product-question-one">
                        <h5>1. What type of products am I able to request?</h3>
                        <p>You can order your very own custom prints, tarpaulines, signages and even billboards.</p>
                        <hr>
                    </div>
                    <div class="product-question-two">
                        <h5>2. What types of paper and finishing options do you offer for my prints?</h3>
                        <p>We offer various paper weights and finishes such as matte, gloss, satin, and specialty papers. Finishing options include 
                            lamination, UV coating, embossing, and more.</p>
                        <hr>
                    </div>
                </div>
                <div class="service-content" id="service-content">
                    <h3>Services</h3>
                    <div class="service-question-one">
                        <h5>1. What if I need my order delivered?</h3>
                        <p>Unfortunately, we do not offer deliveries for your orders, you must pick it up at our company building at (LOCATION).</p>
                        <hr>
                    </div>
                    <div class="service-question-two">
                        <h5>2. Can you help with design and file preparation?</h3>
                        <p>Yes, we offer design services and can also assist with file preparation to ensure your artwork meets printing standards.</p>
                        <hr>
                    </div>
                </div>
                <div class="transaction-content" id="transaction-content">
                    <h3>Transactions</h3>
                    <div class="transaction-question-one">
                        <h5>1. When does my order start processing?</h3>
                        <p>Once you have submmitted your proof of payment through our email,<b> smartpress@gmail.com</b>, within a day or two we will start processing your order.</p>
                        <hr>
                    </div>
                    <div class="transaction-question-two">
                        <h5>2. How would I know if my order has started processing?</h3>
                        <p>You can check you order status in your <b>profile</b> <i class="fa-solid fa-arrow-right"></i> <b>order history</b> and there you can see you order history.</p>
                        <hr>
                    </div>
                    <div class="transaction-question-three">
                        <h5>3. What if I wanted to cancel my order?</h3>
                        <p>You can cancel your orders only if your order status is at <b>Pending.</b></p>
                        <hr>
                    </div>
                    <div class="transaction-question-four">
                        <h5>4. What if my order gets damaged when processing?</h3>
                        <p>An email will be sent that there will be a delay with the order.</p>
                        <hr>
                    </div>
                    <div class="transaction-question-four">
                        <h5>5. How do I receive my complete order?</h3>
                        <p>You can pickup up your order onsite (LOCATION) once you have fully paid. You can fully pay on pickup or online.</p>
                        <hr>
                    </div>
                </div>
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
<?php }?>