<?php
session_start();

include('db_con.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];
    // Ensure account-type is set and not empty
    if (isset($_POST['account-type'])) {
        $account_type = $_POST['account-type']; // Retrieve account type from POST data
        
        // Insert into the database
        $query = "INSERT INTO users (account_type, last_name, first_name, email, password, createdAt) 
                  VALUES ('$account_type', '$last_name', '$first_name', '$email', '$password', NOW())";
        
        // Execute your SQL query here (not shown for brevity)
    } else {
        // Handle case where account-type was not selected (optional)
        echo "Account type is required.";
    }

    if (!empty($email) && !empty($password) && $password === $confirmPassword) {
        $sql = "SELECT email FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) === 0) {
                $query = "INSERT INTO users(account_type,last_name,first_name,email, password, createdAt) VALUES('$account_type','$last_name','$first_name','$email', '$password', now())";
                $result = mysqli_query($conn, $query);
    
                if ($result) {
                    echo "<script>
                        alert('Authorized successfully created.');
                        window.location.href = 'login.php';
                        </script>";
                }

            } else {
                echo "<script>alert('This email is already taken. Please try another.')</script>";
            }
            mysqli_free_result($result);
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Error preparing statement. Please contact the administrator.')</script>";
        }
    } else {
        echo "<script>alert('Please fill up with your credentials and ensure passwords match.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Play' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Smart Press Sign up</title>
</head>
<style>
* {
    margin: 0;
    padding: 0;
    font-family: 'Play';
    box-sizing: border-box;
}

body {
    display: flex;
    height: 100dvh;
    align-items: center;
    background-size: cover;
    justify-content: center;
    background-color: #023047; 
    font-family: sans-serif, Courier, monospace;
}

.main-container {
    min-width: 350px;
    border-radius: 12px;
    background-color: #ffffff;
    border: 1px solid rgba(25, 59, 101, 0.08);
}

.form-title {
    border-bottom: 1px solid rgba(25, 59, 101, 0.1);
}

.form-title h2 {
    padding: 20px;
    text-align: center;
}

.form-container {
    display: flex;
    padding: 20px;
    flex-direction: column;
}

.form-control {
    color: #595959;
    display: flex;
    line-height: 2.5rem;
    margin-bottom: 20px;
    flex-direction: column; 
}

.email-input, .password-input, .confirm-password, #account-type{
    padding: 10px;
    overflow: hidden;
    font-size: 1.2rem;
    border-radius: 6px;
    border: 1px solid #D6DEEB;
}

.password-container {
    position: relative; 
}

.fa-regular { 
  top: 65%;
  right: 10px;
  cursor: pointer;
  position: absolute;
}

.password-input, .confirm-password {
    padding-right: 40px;
}

.submit-button {
    width: 100%;
    color: #ffff;
    cursor: pointer;
    padding: 12px 30px;
    border-radius: 42px;
    background-color: #ffb703;
    border: 2px solid #ffb703;
}

.login {
    display: flex;
    margin-top: 10px;
    align-items: center;
    flex-direction: column;
    justify-content: center;
}

.login a {
    cursor: pointer;
    color: #00416a;
    text-decoration: none;
}
</style>
<body>
    <div class="main-container">
        <div class="form-title">
            <h2>Sign Up</h2>
        </div>
        <form class="form-container" autocomplete="off" method="post">
            <div class="form-control email-container">
                <label for="email">Email</label>
                <input type="email" class="email-input" name="email" placeholder="Enter Email" required>
            </div>
            <div class="form-control password-container">
                <label for="password">Password</label>
                <input type="password" id="password" class="password-input" name="password" placeholder="Enter Password" required>
                <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
            </div>
            <div class="form-control password-container">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" id="confirmPassword" class="confirm-password" name="confirmpassword" placeholder="Enter Password" required>
                <i class="fa-regular fa-eye-slash" id="togglePassword2"></i>
            </div>
            <div class="form-control account-type">
                <label for="account-type">Account Type</label>
                <select id="account-type" name="account-type" required>
                    <option value="" disabled selected>Select account type</option>
                    <option value="Admin">Adminstrator</option>
                    <option value="Employee">Employee</option>
                </select>
            </div>
            <input type="submit" value="SIGN UP" class="submit-button" name="submit">
            <div class="login">
                <a href="login.php">Go back</a>
            </div>
        </form>
    </div>
    <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    togglePassword.addEventListener('click', () => {
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        togglePassword.classList.toggle('fa-eye-slash');
        togglePassword.classList.toggle('fa-eye');
    });

    const togglePassword2 = document.getElementById('togglePassword2');
    const passwordInput2 = document.getElementById('confirmPassword');

    togglePassword2.addEventListener('click', () => {
        passwordInput2.type = passwordInput2.type === 'password' ? 'text' : 'password';
        togglePassword2.classList.toggle('fa-eye-slash');
        togglePassword2.classList.toggle('fa-eye');
    });
    </script>
</body>
</html>
<!-- http://localhost/smart_press/signup.php -->