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
    <link rel="stylesheet" type="text/css" href="..\css\About_Us.css">
    <link rel="stylesheet" href="..\css\navbar.css">
        <link rel="stylesheet" href="..\css\footer.css">
        <!-- icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- font styles -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
        <link rel="icon" href="..\images\smartpress.png" type="image/x-icon">
        
    <title>About Us</title>
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

    <br><br>

    <div class="about-intro">
        <div class="about-title">
            <h1 style= "margin: 0;color:#ffb703;">About Smart Press</h1>
            <p style= "margin: 0;color:white;">The Best Printing Services Available to You!</p>
         </div>
         
         <div class="quote-container">
             <div class="quote-ic">
                 <i class="fa-sharp fa-solid fa-grip-lines fa-3x" style="color:#ffb703;"></i>
             </div>
             <div class="quote-line">
                 <p style="color: #9bee68;width: 60%">Since the beginning of our printing services,we have always aimed to 
                     deliver the best quality product to our most valued customers</p>
             </div>
         </div>
    </div>

     <div style = "width: 100%">
        <br><br>
     <img src="../images/motivational_billlboard.jpg" width="1200" height="800" class="center">
        </div>

        <div class="about-us-content">
            <div class="story-container">
                <div class="story">
                    <h4>Our Story</h4>
                    <p>We started out as a small company, 
                        but thanks to the support of all our clients, we are able to expand our operations and provide more varied 
                        services to our stakeholders. </p>
                    <p>Smart Press was founded on the year 2001 and started 
                        out as a simple printing shop. As the years went on by, the company expanded its services to include tarpaulin, signage, posters, and brochures. 
                        We were then able to earn enough revenue that we relocated our offices into a much larger workspace and expanded our operations even further. Eventually, 
                        we were able to expand enough that we now include billboard services. Now, our company boasts one of the best quality prints you can find and we are even 
                        confident enough to say that we are the best in the Universe!</p>
                </div>
            </div>
            <div class="vis-n-mis">
                <div class="vision">
                    <h4>Our Vision</h4>
                    <p>We strive to create the best possible workplace for our 
                        employees so that they may be able to produce the best possible product for our clients.</p>
                </div>
                <div class="mission">
                    <h4>Our Mission</h4>
                    <p>We aim to surpass our current capabilities as a company in both 
                        the quality of the services we provide, as well as the quantity in which we can accommodate customers.</p>
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
<?php } ?>