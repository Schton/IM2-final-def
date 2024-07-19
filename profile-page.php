<?php
    session_start();
    ob_start();

    if(!isset($_SESSION["userID"])){
        header("Location: login.php");
    } else {
        $userID = $_SESSION["userID"];
        include 'db_con.php';
    }

    $firstName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT first_name  FROM users WHERE userID = $userID"))['first_name'];
    $email = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email  FROM users WHERE userID = $userID"))['email'];

    if (isset($_POST['change-email'])) {
        $oldEmail = $_POST['oldemail'];
        $newEmail = $_POST['newemail'];
    
        // Check if the new email is already taken
        $sql_check_email = "SELECT COUNT(*) AS email_count FROM users WHERE email = ?";
        $stmt_check_email = mysqli_prepare($conn, $sql_check_email);
    
        if ($stmt_check_email) {
            mysqli_stmt_bind_param($stmt_check_email, 's', $newEmail);
            mysqli_stmt_execute($stmt_check_email);
            $result_check_email = mysqli_stmt_get_result($stmt_check_email);
            $row = mysqli_fetch_assoc($result_check_email);
    
            if ($row['email_count'] > 0) {
                // Email is already taken
                echo "<script>alert('This email is already taken. Please try again.')</script>";
            } else if($email !== $oldEmail){
                echo "<script>alert('Incorrect email. Please try again.')</script>";
            } else {
                // Update the email
                $stmt_update_email = mysqli_prepare($conn, "UPDATE users SET email = ? WHERE userID = ? AND email = ?");
                mysqli_stmt_bind_param($stmt_update_email, "sss", $newEmail, $userID, $oldEmail);
                mysqli_stmt_execute($stmt_update_email);
    
                if (!mysqli_stmt_error($stmt_update_email)) {
                    // Email changed successfully
                    $_SESSION['email'] = $newEmail; // Update session with new email
                    echo "<script>
                            alert('Email succesfully changed.');
                            window.location.href = 'profile-page.php';
                        </script>";
                    exit();
                } else {
                    // Error updating email
                    echo "<script>alert('Error updating email. Please try again.')</script>";
                }
            }
    
            mysqli_stmt_close($stmt_check_email);
        } else{
            // Error preparing statement for checking email
            echo "<script>alert('Error preparing statement. Please contact the administrator.')</script>";
        }
    }

    if (isset($_POST['change-password'])) {
        $oldPassword = $_POST['oldpassword'];
        $newPassword = $_POST['newpassword'];
    
        // Check if the entered current password matches the stored password
        $sql_check_password = "SELECT * FROM users WHERE userID = ? AND password = ?";
        $stmt_check_password = mysqli_prepare($conn, $sql_check_password);
    
        if ($stmt_check_password) {
            mysqli_stmt_bind_param($stmt_check_password, 'ss', $userID, $oldPassword);
            mysqli_stmt_execute($stmt_check_password);
            $result_check_password = mysqli_stmt_get_result($stmt_check_password);
    
            if (mysqli_num_rows($result_check_password) > 0) {
                // Current password is correct, proceed to update
                $stmt_update_password = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE userID = ?");
                mysqli_stmt_bind_param($stmt_update_password, "si", $newPassword, $userID);
                mysqli_stmt_execute($stmt_update_password);
    
                if (!mysqli_stmt_error($stmt_update_password)) {
                    // Password changed successfully
                    header("Location: profile-page.php");
                    exit();
                } else {
                    // Error updating password
                    echo "<script>alert('Error updating password. Please try again.')</script>";
                }
            } else {
                // Incorrect current password
                echo "<script>alert('Current password is incorrect. Please try again.')</script>";
            }
    
            mysqli_stmt_close($stmt_check_password);
        } else {
            // Error preparing statement for checking password
            echo "<script>alert('Error preparing statement. Please contact the administrator.')</script>";
        }
    }            
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Account Information</title>
    <!-- css -->
    <link rel="stylesheet" href="..\css\navbar.css">
    <link rel="stylesheet" href="..\css\profilepage.css">
    <link rel="stylesheet" href="..\css\footer.css">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- font styles -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="..\images\smartpress.png" type="image/x-icon">
</head>

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
/* edited */
#pass-change{
    background: red;
    color:white;
    border: 0;
    height: 20px;
    width: 120px;
}
.account-info-container{
    margin-top:10em;
    color:white;
    box-shadow: 2px 2px 20px 4px rgba(0,0,0,0.5);
}

.container {
    padding: 20px;
    display: flex;
    justify-content: center;
}

.account-title{
    color:white;
}

.fa-user{
    color:white;
    margin-right: 1em;
}
/* edited */

.account-section {
    min-width: 300px;
    line-height: 1.8rem;
    margin-top:10em;
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

.account-management {
    padding: 25px;
    min-width: 700px;
    line-height: 1.5rem;
    background-color: #192236;
}

.account-management-header p {
    margin-bottom: 5px;
}

.account-details {
    display: flex;
    padding: 30px;
    line-height: 3rem;
    flex-direction: column;
}

.account-links button {
    cursor: pointer;
}

.edit-email, .edit-contact-number, .edit-password {
  top: 50%;
  left: 50%;  
  padding: 20px;
  position: absolute;
  background-color: #ffffff;
  transform: translate(-50%, -50%);
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

.edit-email, .edit-contact-number, .edit-password {
    display: none;
    padding: 20px;
    border-radius: 5px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    background-color: #f5f5f5;
  }

.edit-email form, .edit-contact-number form, .edit-password form {
    gap: 10px;
    display: flex;
    flex-direction: column;
}

.edit-email input[type="text"], .edit-contact-number input[type="number"], .edit-password input[type="password"] {
    padding: 10px;
    font-size: 16px;
    border-radius: 3px;
    border: 1px solid #ccc;
}

.edit-email button, .edit-contact-number button, .edit-password button {
    border: none;
    color: black;
    cursor: pointer;
    padding: 10px 20px;
    border-radius: 4px;
    background-color: #ffb703;
}

.edit-email button:hover, .edit-contact-number button:hover, .edit-password button:hover {
    background-color: #fb8500;
}

.close-btn {
    color: black;
    background-color: #ccc;
}

</style>
<body>
    <!-- navbar -->
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

    <!-- main  -->
    <div class="container">
        <div class="account-section">
            <div class="account-header">
                <i class="fa-regular fa-user"></i>
                <h3 class="account-title">My Account</h3>
            </div>
            <div class="account-nav">
                <ul>
                    <li><a href="profile-page.php">Account Information</a></li>
                    <li><a href="order-history.php">Order History</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="account-info-container">
            <div class="account-management">
                <div class="account-management-header">
                    <h3 class="account-management-title">Hello, <?php echo $firstName; ?> !</h3>
                    <p class="account-management-description">Manage and Protect your account</p>
                    <hr>
                </div>
                <div class="account-details">
                    <div class="account-links">
                        <h3>Email</h3>
                        <p><?php echo $email; ?> <button class="edit-btn" data-target=".edit-email"><i class="fa-regular fa-pen-to-square"></i></button></p>
                        <h3>Password</h3>
                        <button class="edit-btn" data-target=".edit-password" id="pass-change">Change Password</button>
                    </div>
                </div>
            </div>
            <div class="edit-email" style="display: none">
                <form method="post">
                    <label for="oldmail"></label>
                    <input type="email" id="oldemail" name="oldemail" placeholder="Old Email" autocomplete="off">

                    <label for="newmail"></label>
                    <input type="email" id="newmail" name="newemail" placeholder="New Email" autocomplete="off">

                    <button type="submit" id="change-email" name="change-email">Submit</button>
                    <button type="button" class="close-btn">Cancel</button>
                </form>
            </div>
            <div class="edit-password" style="display: none">
                <form method="post">
                    <div class="password-container">
                        <label for="oldpassword"></label>
                        <input type="password" id="oldpassword" name="oldpassword" placeholder="Current Password">
                        <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
                    </div>
                    
                    <div class="password-container">
                        <label for="newpassword"></label>
                        <input type="password" id="newpassword" name="newpassword" placeholder="New Password">
                        <i class="fa-regular fa-eye-slash" id="togglePassword2"></i>
                    </div>
                    
                    <button type="submit" id="change-password" name="change-password">Change</button>
                    <button type="button" class="close-btn">Cancel</button>
                </form>
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
<script>
    const editButtons = document.querySelectorAll(".edit-btn");
const closeButtons = document.querySelectorAll(".close-btn");

const togglePassword = document.getElementById("togglePassword");
const passwordInput = document.getElementById("oldpassword");

const togglePassword2 = document.getElementById("togglePassword2");
const passwordInput2 = document.getElementById("newpassword");

editButtons.forEach((button) => {
  button.addEventListener("click", function () {
    const target = document.querySelector(this.dataset.target);
    target.style.display = "block";
  });
});

closeButtons.forEach((button) => {
  button.addEventListener("click", function () {
    const parent = this.closest(".edit-email, .edit-password");
    parent.style.display = "none";
  });
});

togglePassword.addEventListener("click", () => {
  passwordInput.type = passwordInput.type === "password" ? "text" : "password";
  togglePassword.classList.toggle("fa-eye-slash");
  togglePassword.classList.toggle("fa-eye");
});

togglePassword2.addEventListener("click", () => {
  passwordInput2.type =
    passwordInput2.type === "password" ? "text" : "password";
  togglePassword2.classList.toggle("fa-eye-slash");
  togglePassword2.classList.toggle("fa-eye");
});
</script>
</html>
