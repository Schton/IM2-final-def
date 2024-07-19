<?php
session_start();
ob_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION["userID"])) {
    header("Location: login.php");
    exit();
} else {
    $userID = $_SESSION["userID"];
include 'db_con.php'; // Assuming this file contains your database connection

// Handle form submission
if (isset($_POST['submit-button'])) {

    
    $productType = mysqli_real_escape_string($conn, $_POST['product']);
    $quantity = intval($_POST['quantity']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $orderType = isset($_POST['priority']) ? 2 : 1;
    $price = floatval($_POST['totalPrice']);
    $paymentType = $_POST['paymentType'];
    $dateOrdered = date('Y-m-d');

    // working on
    $downpay = $price * 0.3;
    $_SESSION['downpay'] = $downpay;

    // working on

    // session var amountpaid for order history
    // $amountpaid = $_POST['total'];
    // $_SESSION['total'] = $amountpaid;
    // session var amountpaid for order history


    $_SESSION['paymentType'] = $paymentType;

    // Handle file upload
    $productFile = '';
    if (isset($_FILES['fileID']) && $_FILES['fileID']['error'] == 0) {
        $fileTmpPath = $_FILES['fileID']['tmp_name'];
        $fileName = $_FILES['fileID']['name'];
        $fileSize = $_FILES['fileID']['size'];
        $fileType = $_FILES['fileID']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Check file extension
        $allowedfileExtensions = ['pdf', 'png', 'jpg'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Directory in which the uploaded file will be moved
            $uploadFileDir = './uploaded_files/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $productFile = $newFileName;
            } else {
                die("File upload failed.");
            }
        } else {
            die("Invalid file type. Allowed types are: pdf, png, jpg.");
        }
    }

    if ($paymentType === 'online') {
        // Store order details in session for online payment
        $_SESSION['orderDetails'] = [
            'userID' => $userID,
            'productType' => $productType,
            'quantity' => $quantity,
            'size' => $size,
            'productFile' => $productFile,
            'details' => $details,
            'orderType' => $orderType,
            'price' => $price,
            'dateOrdered' => $dateOrdered
        ];
        header("Location: payment_page.php");
        exit();
    } else {
        // Save order to database for onsite payment
        // $sql = "INSERT INTO orders (userID, productType, quantity, size, productFile, details, orderType, price, dateOrdered) 
        // VALUES ('$userID','$productType', '$quantity', '$size', '$productFile', '$details', '$orderType', '$price', '$dateOrdered')";
        $_SESSION['orderDetails'] = [
            'userID' => $userID,
            'productType' => $productType,
            'quantity' => $quantity,
            'size' => $size,
            'productFile' => $productFile,
            'details' => $details,
            'orderType' => $orderType,
            'price' => $price,
            'dateOrdered' => $dateOrdered
        ];
        // $_SESSION['orderID'];
        header("Location: payment_page.php");
        exit();
        if (mysqli_query($conn, $sql)) {
            $orderID = mysqli_insert_id($conn);

        //     if (mysqli_query($conn, $sql)) {
        //         $_SESSION['downpayment'] = $downpayment;
        //         $_SESSION['price'] = $price;
        //         $_SESSION['dateOrdered'] = $dateOrdered;

        //         exit();
        //     } else {
        //         die(mysqli_error($conn));
        //     }
        } else {
            die(mysqli_error($conn));
        }
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/orderform.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/smartpress.png" type="image/x-icon">
    <title>Order Form | Smartpress</title>
</head>
<body>
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
<div class="container">
    <div class="form-container">
        <form id="orderForm" action="orderform.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <!-- product type -->
                <select name="product" id="product" required>
                    <option value="" selected="selected">Select product</option>
                    <!-- Populate options dynamically if needed -->
                </select>

                <!-- quantity -->
                <input type="number" placeholder="Qty" id="quantity" name="quantity" required>

                <!-- size -->
                <select name="size" id="size" required>
                    <option value="" selected="selected">Please select a product first</option>
                    <!-- Populate options dynamically based on product selection -->
                </select>
            </div>
            <div class="form-group">
                <div class="card">
                    <div class="drop_box">
                        <header>
                            <h4>Upload File</h4>
                        </header>
                        <p>Files Supported: PDF, PNG, JPG</p>
                        <input type="file" hidden accept=".pdf,.png,.jpg" id="fileID" name="fileID" required>
                        <button type="button" class="btn" id="uploadButton">Choose File</button>
                    </div>
                </div>
                <div class="details">
                    <textarea placeholder="More details" id="details" name="details" required></textarea>
                </div>
            </div>
            <!-- Payment type dropdown -->
            <div class="form-group">
                <select name="paymentType" id="paymentType" required>
                    <option value="" selected="selected">Select Payment Type</option>
                    <option value="onsite">Onsite</option>
                    <option value="online">Online</option>
                </select>
            </div>
                        <!-- priority and such -->
                        <div class="proz">
                <input type="checkbox" id="priority" name="priority" value="prio">
                <label for="priority"><strong>Make Priority</strong></label>
                <p style="font-size: x-small; text-align:left;">(Additional cost: 50% of total product price. Reduces wait time for your order.)</p>
                <div class="priority-cost" style="display:flex;flex-direction:row;">
                    <p><strong>Priority Cost : </strong>Php</p>
                    <p id="priorityCost">0.00</p>
                </div>
                <br>
                <div class="total" style="display:flex;flex-direction:row;">
                    <p>Total: Php</p>
                    <p id="total">0.00</p>
                </div>
                <br>
                <input type="hidden" id="totalPrice" name="totalPrice" value="0.00">
            </div>
            <br>
            <div>
                <button type="submit" class="submit-button" id="submit-button" name="submit-button">Check out</button>
            </div>
        </form>
    </div>
</div>
<!-- <div class="footer-container">
    <div class="socials">
        <div class="footer-logo">
            <img src="../images/smartpress.png" alt="">
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
        <a href="../php/Contact_Us.php">Contact Us</a>
        <a href="../php/FAQs.php">FAQs</a>
    </div>
    <div class="footer-about">
        <h4 id="footer-about-title">About</h4>
        <a href="../php/About_Us.php">About Us</a>
        <a href="../php/About_Us.php">Our Process</a>
    </div>
</div> -->
<script>
    document.getElementById('uploadButton').addEventListener('click', function() {
        document.getElementById('fileID').click();
    });

    document.getElementById('fileID').addEventListener('change', function() {
        var fileName = this.files[0].name;
        var uploadButtonText = document.getElementById('uploadButton');
        uploadButtonText.textContent = fileName;
    });

    document.querySelector('.submit-button').addEventListener('click', function(event) {
        var productType = document.getElementById('product').value;
        var quantity = document.getElementById('quantity').value;
        var size = document.getElementById('size').value;
        var details = document.getElementById('details').value;
        var paymentType = document.getElementById('paymentType').value;

        if (productType === "" || quantity === "" || size === "" || details === "" || paymentType === "") {
            alert('Please fill out all required fields.');
            event.preventDefault(); // Prevent form submission
        } else {
            // If all fields are filled, continue with form submission
            document.getElementById('orderForm').submit();
        }
    });

    var orderOpt = {
        "Tarpaulin": ["2 x 3 ft", "2 x 4 ft", "3 x 3 ft", 
        "3 x 4 ft", "4 x 4 ft", "5 x 6 ft"],

        "Stickers (5pcs)": ["1.5\" x 1.5\"", "3\" x 2\"", "4\" x 3\""],

        "Brochures": ["8.5\" x 11\"", "5.5\" x 8.5\""],

        // "Posters (6pcs)": ["18\" x 24\"", "24\" x 36\"", "27\" x 40\""],

        // "Business Cards (5pcs)": ["51mm x 89mm", "54mm x 85.6mm"],

        "Signages": ["150\" x 150\"", "200\" x 200\"", "350\" x 350\""]
    };

    window.onload = function() {
        var productSel = document.getElementById("product");
        var sizeSel = document.getElementById("size");

        for (var x in orderOpt) {
            productSel.options[productSel.options.length] = new Option(x, x);
        }

        productSel.onchange = function() {
            sizeSel.length = 1;
            var z = orderOpt[this.value];
            for (var i = 0; i < z.length; i++) {
                sizeSel.options[sizeSel.options.length] = new Option(z[i], z[i]);
            }
        }
    };

    var basePrices = {
        "Tarpaulin": {
            "2 x 3 ft": 100.00,
            "2 x 4 ft": 120.00,
            "3 x 3 ft": 140.00,
            "3 x 4 ft": 160.00,
            "4 x 4 ft": 180.00,
            "5 x 6 ft": 200.00
        },
        "Stickers (5pcs)": {
            "1.5\" x 1.5\"": 10.00,
            "3\" x 2\"": 12.00,
            "4\" x 3\"": 14.00
        },
        "Brochures": {
            "8.5\" x 11\"": 15.00,
            "5.5\" x 8.5\"": 18.00
        },
        // "Posters (6pcs)": {
        //     "18\" x 24\"": 50.00,
        //     "24\" x 36\"": 60.00,
        //     "27\" x 40\"": 70.00
        // },
        // "Business Cards (5pcs)": {
        //     "51mm x 89mm": 5.00,
        //     "54mm x 85.6mm": 6.00
        // },
        "Signages": {
            "150\" x 150\"": 200.00,
            "200\" x 200\"": 250.00,
            "350\" x 350\"": 300.00
        }
    };

    function calculateAmount() {
        var quantity = parseFloat(document.getElementById("quantity").value) || 0;
        var productType = document.getElementById("product").value;
        var sizeprice = document.getElementById("size").value;

        var basePrice = basePrices[productType] ? basePrices[productType][sizeprice] || 0 : 0;
        var total = basePrice * quantity;

        var priorityCost = total * 0.50; // 50% of the total as priority cost
        var isPriority = document.getElementById("priority").checked;

        var finalTotal = total;
        if (isPriority) {
            finalTotal += priorityCost; // Add priority cost if priority is selected
        }

        document.getElementById("total").innerHTML = finalTotal.toFixed(2);
        document.getElementById("totalPrice").value = finalTotal.toFixed(2);
        document.getElementById("priorityCost").innerHTML = priorityCost.toFixed(2);
    }

    document.getElementById("quantity").addEventListener("input", calculateAmount);
    document.getElementById("product").addEventListener("change", calculateAmount);
    document.getElementById("size").addEventListener("change", calculateAmount);
    document.getElementById("priority").addEventListener("change", calculateAmount);

    // here error message
    

    
</script>
</body>
</html>
<?php
}
?>