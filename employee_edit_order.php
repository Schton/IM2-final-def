<?php
include "db_con.php";
$orderID = $_GET['orderID'];

if(isset($_POST['save'])) {
    $productType = $_POST['product'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];
    $details = $_POST['details'];
    $orderType = isset($_POST['priority']) ? 2 : 1;
    $price = $_POST['totalPrice'];
    $paymentStatus = $_POST['paymentstatus']; // Add this line to retrieve payment status from the form
    $status = $_POST['status'];

    $sql = "UPDATE orders SET productType = '$productType', quantity = '$quantity',
    size = '$size', details = '$details', orderType = '$orderType', price = '$price', 
    paymentStatus = '$paymentStatus', status = '$status' WHERE orderID = '$orderID'";

    $result = mysqli_query($conn, $sql);

    if($result) {
        header("Location: employee.php?msg=Data updated successfully");
    }
    else {
        echo "Failed: " . mysqli_error($conn);  
    }
}

if(isset($_POST['cancel'])){
    header("Location: employee.php");
}

$orderID = $_GET['orderID'];
$sql = "SELECT * FROM `orders` WHERE orderID = $orderID LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- internal css-->
<style>
body {
    background-color: #023047;
    color: white;
    font-family: "Play", sans-serif;
    margin: 0;
}

.container{
    width: 500px;
    padding: 30px;
    background: #1A1A1A;
    border-radius: 15px;
    color: #fff;
    opacity: 80%;
}

.form-group{
    float:right 50%;
}

#product{
    width: 59%;
    height: 24px;
}

#quantity{
    width: 39%;
    height: 24px;
}

#size{
    width: 100%;
    height: 24px;
}

#details{
    width: 100%;
    height: 48px;
}

#totalPrice {
    width: 51%;
}

select {
    height: 29.5px;
    width: 47%;
}

/* ====================== */
#save,#cancel{
    height:40px;
    width: 96px;
    border:0;
}
.container{
    background-color: #f7982d;
    padding: 30px;
    border-radius: 1px;
    margin-top: 30px;
    box-shadow: 2px 2px 20px 4px rgba(0,0,0,0.5);
}
.form-container input{
    border:0;
}
.logo{
    height:120px;
    width:120px;
    margin-left:29%
}
</style>
<title>EDIT ORDER INFORMATION</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="..\images\smartpress.png" alt="Smart Press Logo" class="logo">
        </div>
        <hr>
        <div class="text-center mb-4">
            <h3>Edit Order</h3>
            <p class="text-muted">Click update after changing any information</p>
        </div>
        <div class="d-flex justify-content-center">
            <div class="form-container">
                <form method="post">
                    <div class="form-group">
                        <select name="product" id="product">
                            <option value="" id="product">Select product</option>
                            <?php
                            $orderOpt = [
                                "Tarpaulin" => ["2 x 3 ft", "2 x 4 ft", "3 x 3 ft", "3 x 4 ft", "4 x 4 ft", "5 x 6 ft"],
                                "Stickers (5pcs)" => ["1.5\" x 1.5\"", "3\" x 2\"", "4\" x 3\""],
                                "Brochures" => ["8.5\" x 11\"", "5.5\" x 8.5\""],
                                //   "Posters (6pcs)" => ["18\" x 24\"", "24\" x 36\"", "27\" x 40\""],
                                //   "Business Cards (5pcs)" => ["51mm x 89mm", "54mm x 85.6mm"],
                                "Signages" => ["150\" x 150\"", "200\" x 200\"", "350\" x 350\""]
                            ];
                            foreach ($orderOpt as $product => $sizes) {
                                $selected = ($row['productType'] == $product) ? 'selected' : '';
                                echo "<option value='$product' $selected>$product</option>";
                            }
                            ?>
                            </select>
                            <input type="number" placeholder="Qty" id="quantity" name="quantity" value="<?php echo $row['quantity'] ?>">
                            <br><br>
                            <select name="size" id="size">
                                <option value="">Please select a product first</option>
                                <?php
                                if ($row['productType'] && $row['size']) {
                                    $sizes = $orderOpt[$row['productType']];
                                    foreach ($sizes as $size) {
                                        $selected = ($row['size'] == $size) ? 'selected' : '';
                                        echo "<option value='$size' $selected>$size</option>";
                                    }
                                }
                                ?>
                                </select>
                            </div>
                            <br>
                            <!-- details -->
                             <div class="form-group">
                                <div class="details">
                                    <textarea placeholder="More details" id="details" name="details"><?php echo $row['details'] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <!-- price -->
                                 <input type="number" id="totalPrice" name="totalPrice" step="any" value="<?php echo $row['price'] ?>">
                                 <!-- status -->
                                 <select name="status" id="status">
                                    <?php
                                    $selectedStatus = $row['status'];
                                    $statuses = ['Pending', 'In-progress', 'Completed', 'Canceled'];
                                    foreach ($statuses as $status) {
                                        $selected = ($selectedStatus == $status) ? 'selected' : '';
                                        echo "<option value='$status' $selected>$status</option>";
                                    }
                                    ?>
                                    </select>
                                </div>
                                <br>
                                <div class="form-group">
                                    <select name="paymentstatus" id="paymentstatus" style="width:100%;">
                                    <?php
                                    $selectedPayStatus = $row['paymentStatus'];
                                    $paymentStatOps = ['Unverified', 'Verified'];
                                    foreach ($paymentStatOps as $paymentStatus) {
                                        $selected = ($selectedPayStatus == $paymentStatus) ? 'selected' : '';
                                        echo "<option value='$paymentStatus' $selected>$paymentStatus</option>";
                                    }
                                    ?>
                                    </select>
                                </div>
                                <br>                                
                                <!-- order type -->
                                 <div class="proz">
                                    <input type="checkbox" id="priority" name="priority" value="prio" <?php echo ($row['orderType'] == 2) ? 'checked' : ''; ?>>
                                    <label for="priority">Make Priority</label>
                                    <p style="font-size: x-small;">(costs more, lesser wait for your order)</p>
                                    <br>
                                    <div class="total" style="display:flex;flex-direction:row;">
                                        <p>Total: Php </p>
                                        <p id="total"><?php echo $row['price'] ?></p>
                                    </div>
                                    <br>
                                </div>
                                <br>
                                <div>
                                    <button type="submit" class="submit-button" id="save" name="save">Update</button>
                                    <button type="submit" class="submit-button" id="cancel" name="cancel">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
var orderOpt = {
    "Tarpaulin": ["2 x 3 ft", "2 x 4 ft", "3 x 3 ft", 
    "3 x 4 ft", "4 x 4 ft", "5 x 6 ft"],
  
    "Stickers (5pcs)": ["1.5\" x 1.5\"", "3\" x 2\"", "4\" x 3\""],

    "Brochures": ["8.5\" x 11\"", "5.5\" x 8.5\""],
  
    "Signages": ["150\" x 150\"", "200\" x 200\"", "350\" x 350\""]
}

window.onload = function() {
    var productSel = document.getElementById("product");
    var sizeSel = document.getElementById("size");
    var currentProduct = "<?php echo $row['productType']; ?>";
    var currentSize = "<?php echo $row['size']; ?>";

    // Set the initial size options based on the current product
    if (currentProduct) {
        var sizes = orderOpt[currentProduct];
        for (var i = 0; i < sizes.length; i++) {
            var option = new Option(sizes[i], sizes[i]);
            if (sizes[i] == currentSize) {
                option.selected = true;
            }
            sizeSel.options[sizeSel.options.length] = option;
        }
    }

    productSel.onchange = function() {
        sizeSel.length = 1; // Clear existing size options
        var selectedProduct = this.value;
    
        if (selectedProduct) { // Check if a product is selected
            var sizes = orderOpt[selectedProduct];
            for (var i = 0; i < sizes.length; i++) {
                sizeSel.options[sizeSel.options.length] = new Option(sizes[i], sizes[i]);
            }
        }
    };
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

    var isPriority = document.getElementById("priority").checked;
    if (isPriority) {
        total += total * 0.20; // Add 20% if priority is selected
    }
    document.getElementById("total").innerHTML = total.toFixed(2);
    document.getElementById("totalPrice").value = total.toFixed(2);
}

document.getElementById("quantity").addEventListener("input", calculateAmount);
document.getElementById("product").addEventListener("change", calculateAmount);
document.getElementById("size").addEventListener("change", calculateAmount);
document.getElementById("priority").addEventListener("change", calculateAmount);
</script>

</body>
</html>