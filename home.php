<?php
session_start();
ob_start();

if(!isset($_SESSION["userID"])){
    header("Location: login.php");
} else {
$userID = $_SESSION["userID"];
include 'db_con.php';
?>

<html>
    <head>
        <link rel="stylesheet" href="..\css\home_style.css">
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
        <div class="container">

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
            
            <!-- Page introduction -->
            <div class="order-now-container">
                <h1>The Best Printing Services in the Universe</h1>
                <button><a href="..\php\orderform.php">Order Now</a></button>
            </div>

            <!-- Sales -->
             <div class="sales-container">
                <div class="sale-image">
                    <img src="..\images\1563888414355.png" alt="">
                 </div>
    
                 <div class="sale-detail">
                    <h3>STANDEES ON SALE FOR UP TO 20%</h3>
                    <p>Upcoming sale!</p>
                    <button>Order Now</button>
                 </div>
             </div>

            <!-- Why us -->
             <div class="why-us-container">
                <h3 id="title">THE SMARTPRESS DIFFERENCE</h3>

                <div class="why-us-content">

                    <div class="quality-control">
                        <i class="fa-solid fa-list-check fa-5x"></i>
                        <h3>Quality Control</h3>
                        <p>Each product undergoes meticulous inspection to ensure it
                             meets our high standards for durability and visual clarity.
                              With our dedication to quality, you can trust that your
                               advertising materials will always look professional and perform flawlessly.</p>
                    </div>

                    <div class="innovation">
                        <i class="fa-regular fa-lightbulb fa-5x"></i>
                        <h3>Innovation</h3>
                        <p>we pride ourselves on staying ahead of the curve by employing the
                             latest and most advanced printing techniques. We are committed to
                              providing cutting-edge solutions that meet and exceed your advertising needs</p>
                    </div>

                    <div class="warranty">
                        <i class="fa-solid fa-shield-halved fa-5x"></i>
                        <h3>6 Month Warrranty</h3>
                        <p>Our products are for showcasing, not worrying.
                             Because of that , we offer a 6 month full labor warranty,
                              so you can focus on the thing that matters most.</p>
                    </div>

                    <div class="high-level">
                        <i class="fa-solid fa-bolt fa-5x"></i>
                        <h3>High Level Performance</h3>
                        <p>We mean it when we say we have the best printing services in the universe.
                             Quality tools & artistry allows us to give you the ultimate results.</p>
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
        </div>
    </body>
</html>

<?php } ?>