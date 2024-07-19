<?php
session_start();

include('db_con.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);

        if($row) {
            $_SESSION['userID'] = $row['userID'];
            if ($row["account_type"] === "Admin") {
                header('Location: admin1.php');
                exit();
            } else if($row["account_type"] === "Employee") {
                header('Location: employee.php');
                exit();
            } else {
                $_SESSION['userID']; 
                header('Location: profile-page.php');
                exit();
            }
        } else {
            echo "<script>alert('Invalid email or password.')</script>";
        }
    } else {
        echo "<script>alert('Please enter your email and password.')</script>";
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
    <title>Smart Press Login</title>
</head>
<style>
* {
    margin: 0;
    padding: 0;
    font-family: "Play";
    box-sizing: border-box;
}

body {
    display: flex;
    height: 100vh;
    align-items: center;
    background-size: cover;
    justify-content: center;
    background-color: #023047;
}

.main-container {
    min-width: 350px;
    border-radius: 12px;
    background-color: #ffffff;
    border: 1px solid rgba(25, 59, 101, 0.08);
    padding: 20px;
    text-align: center;
}

.logo {
    width: 100px;
    height: auto;
    margin-bottom: 20px;
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

.email-input, .password-input {
    padding: 10px;
    overflow: hidden;
    font-size: 1.2rem;
    border-radius: 6px;
    border: 1px solid #D6DEEB;
}

.password-container {
    position: relative; 
}

.password-input {
    padding-right: 40px;
}

.fa-regular { 
  top: 65%;
  right: 10px;
  cursor: pointer;
  position: absolute;
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

.sign-up , .guest {
    display: flex;
    margin-top: 10px;
    align-items: center;
    flex-direction: column;
    justify-content: center;
}

.sign-up a, .guest a {
    cursor: pointer;
    color: #00416a;
    text-decoration: none;
}

.sign-up p, .guest p {
    color: #595959;
}

.sign-up p:nth-child(2) {
    margin-top: 10px;
}
</style>
<body>
    <div class="main-container">
        <img src="..\images\smartpress.png" alt="Smart Press Logo" class="logo">
        <div class="form-title">
            <h2>Login Account</h2>
        </div>
        <form class="form-container" autocomplete="off" method="post">
            <div class="form-control email-container">
                <label for="email">Email</label>
                <input type="email" id="email" class="email-input" name="email" placeholder="Enter Email" required>
            </div>
            <div class="form-control password-container">
                <label for="password">Password</label>
                <input type="password" id="password" class="password-input" name="password" placeholder="Enter Password" required>
                <i class="fa-regular fa-eye-slash" id="togglePassword"></i>
            </div>
            <input type="submit" value="LOGIN" class="submit-button" name="loginButton">
            <div class="sign-up">
                <p>No account yet? <a href="signup.php">Sign up</a></p>
            </div>
            <!-- <div class="guest">
                <p>Continue as a <a href="#">Guest</a></p>
            </div> -->
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
    </script>
</body>
</html>
<!-- http://localhost/smart_press/login.php -->
