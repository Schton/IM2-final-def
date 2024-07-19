<?php
session_start();
ob_start();

if(!isset($_SESSION["userID"])){
    header("Location: login.php");
} else {
$userID = $_SESSION["userID"];
include 'db_con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['SUBMIT'])) {
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $contactInfo = mysqli_real_escape_string($conn, $_POST['contactInfo']);
    $concerns = mysqli_real_escape_string($conn, $_POST['concerns']);

    // Include userID in the insert statement
    $query = "INSERT INTO feedback (fullName, contactInfo, concerns, userID) VALUES ('$fullName', '$contactInfo', '$concerns', '$userID')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Feedback submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/Contact_Us.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/smartpress.png" type="image/x-icon">
    <title>Contact Us</title>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <nav>
            <div class="nav-logo"><a href="../php/home.php"><img src="../images/smartpress.png" alt=""></a></div>
            <div class="printing-services"><a href="../php/orderform.php">Printing Services</a></div>
            <div class="community">
                <select id="community-dropdown" onchange="location = this.value">
                    <option value="" disabled selected>Community</option>
                    <option value="../php/About_Us.php">About Us</option>
                    <option value="../php/Contact_Us.php">Contact Us</option>
                    <option value="../php/FAQs.php">FAQs</option>
                </select>
            </div>
            <div class="profile"><a href="../php/profile-page.php"><i class="fa-regular fa-user"></i></a></div>
        </nav>
    </div>

    <div class="box" style="width:40%; margin: 10em auto; background-color: #023047; border-radius: 10px; padding: 20px;">
        <h1 style="color:white">Contact Us</h1>
        <form method="POST" action="">
            <label for="fullName" style="color:white">Name:</label>
            <input type="text" id="fullName" name="fullName" placeholder="Your full name" style="width: 80%; margin: 5px; color:white; background-color: #023047; border: none; border-bottom: 1px solid white;"><br>

            <label for="contactInfo" style="color:white">Contact Info:</label>
            <input type="text" id="contactInfo" name="contactInfo" placeholder="Contact no./email" style="width: 72%; margin: 5px; color:white; background-color: #023047; border: none; border-bottom: 1px solid white;"><br><br>

            <textarea id="concerns" name="concerns" style="height: 200px; width: 100%; margin: 5px; background-color:#023047; color:white;" placeholder="Type your concerns/questions here!"></textarea><br><br>

            <button type="submit" name="SUBMIT" style="width: 100%; height: 50px; background-color: #ffb703; font-size: 25px; border: none; font-family: 'Play', sans-serif;">Submit</button>
        </form> 
    </div>

    <!-- Footer -->
    <div class="footer-container">
        <div class="socials">
            <div class="footer-logo">
                <img src="../images/smartpress.png" alt="">
            </div>
            <div class="social-media-links">
                <div class="fb"><i class="fa-brands fa-facebook fa-2x"></i></div>
                <div class="twitter"><i class="fa-brands fa-square-twitter fa-2x"></i></div>
                <div class="instagram"><i class="fa-brands fa-square-instagram fa-2x"></i></div>
            </div>
        </div>

        <div class="footer-help">
            <h4 id="footer-help-title">Help</h4>
            <a href="../php/Contact_Us.php">Contact Us</a>
            <a href="../php/FAQs.php">FAQs</a>
        </div>

        <div class="footer-about">
            <h4 id="footer-about-title">About</h4>
            <a href="../php/About_Us.php">About Us</a>
            <a href="../php/About_Us.php">Our Process</a>
        </div>
    </div>

</body>
</html>
<?php }?>