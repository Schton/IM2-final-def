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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartpress | Employee Page</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/admin.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
      integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" 
      crossorigin="anonymous" referrerpolicy="no-referrer" />

      <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
        <link rel="icon" href="..\images\smartpress.png" type="image/x-icon">
            <style>
                body {
                    font-family: 'Play', sans-serif;
                }
                .table-container-orders,.table-container-paymeth{
                    height: 20em;
                    overflow-y: hidden;
                    overflow-y: scroll;
                    overflow-y: auto;
                }
                #sidebar{
                    position: fixed;
                    height: 100%;
                }
                .main{
                    margin-left:4%;
                }
                .filter-order-buttons button{background: #023047;border:0;}
            </style>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">Smart Press</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#orders" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="signup.php" class="sidebar-link" onclick="return confirm('If you want to create an account, you need to logout first. Proceed?');">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Add User</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="sidebar-link" onclick="return confirm('Are you sure you want to logout?');">
                        <i class="lni lni-exit"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-4 py-3">
                <form action="#" class="d-none d-sm-inline-block">

                </form>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="..\images\smartpress.png" class="avatar img-fluid" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded">

                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3 class="fw-bold fs-2 mb-3" id="orders">Orders</h3>
                        <div class="row">
                            <div class="col-12 col-md-4 ">
                                <div class="card border-0">
                                    <div class="card-body py-4">
                                        <h5 class="mb-2 fw-bold">
                                            Pending orders
                                        </h5>
                                        <p class="mb-2 fw-bold">
                                        <?php
                                            $sql = "SELECT COUNT(*) as pending_count FROM orders WHERE status = 'Pending'";
                                            $result = mysqli_query($conn, $sql);

                                            if ($result) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo $row['pending_count'];
                                                }
                                            } else {
                                                echo "Error: " . mysqli_error($conn);
                                            }
                                        ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 ">
                                <div class="card  border-0">
                                    <div class="card-body py-4">
                                        <h5 class="mb-2 fw-bold">
                                            In-progress orders
                                        </h5>
                                        <p class="mb-2 fw-bold">
                                        <?php
                                            $sql = "SELECT COUNT(*) as progress_count FROM orders WHERE status = 'In-progress'";
                                            $result = mysqli_query($conn, $sql);

                                            if ($result) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo $row['progress_count'];
                                                }
                                            } else {
                                                echo "Error: " . mysqli_error($conn);
                                            }
                                        ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 ">
                                <div class="card  border-0">
                                    <div class="card-body py-4">
                                        <h5 class="mb-2 fw-bold">
                                            Completed orders
                                        </h5>
                                        <p class="mb-2 fw-bold">
                                        <?php
                                            $sql = "SELECT COUNT(*) as completed_count FROM orders WHERE status = 'Completed'";
                                            $result = mysqli_query($conn, $sql);

                                            if ($result) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo $row['completed_count'];
                                                }
                                            } else {
                                                echo "Error: " . mysqli_error($conn);
                                            }
                                        ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4 ">
                                <div class="card  border-0">
                                    <div class="card-body py-4">
                                        <h5 class="mb-2 fw-bold">
                                            Cancelled orders
                                        </h5>
                                        <p class="mb-2 fw-bold">
                                        <?php
                                            $sql = "SELECT COUNT(*) as cancel_count FROM orders WHERE status = 'Canceled'";
                                            $result = mysqli_query($conn, $sql);

                                            if ($result) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo $row['cancel_count'];
                                                }
                                            } else {
                                                echo "Error: " . mysqli_error($conn);
                                            }
                                        ?>
                                        </p>
                                    </div>
                                </div>
                            </div>


                        <!-- ayaw hilabti kai maguba -->
                            <div class="row">
                                <div class="col-12 filter-order-buttons" style="display:flex;align-items:center;float:left;">
                                    <div class="dropdown" style="margin-right: 2%;">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownOrderButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            All Orders
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownOrderButton">
                                            <li><a class="dropdown-item" onclick="filterOrders('Pending', this)">Pending</a></li>
                                            <li><a class="dropdown-item" onclick="filterOrders('In-progress', this)">In-progress</a></li>
                                            <li><a class="dropdown-item" onclick="filterOrders('Completed', this)">Completed</a></li>
                                            <li><a class="dropdown-item" onclick="filterOrders('Canceled', this)">Canceled</a></li>
                                            <li><a class="dropdown-item" onclick="filterOrders('', this)">All Orders</a></li>
                                        </ul>
                                    </div>
                                    <div class="search-container-email">
                                        <input type="text" style="width: 100%;" id="emailSearch" placeholder="Search by email..." oninput="filterOrdersSearch()" class="form-control" required>
                                    </div>
                                </div>
                                    <br><br>
                                    <div class="table-container-orders">
                                        <table class="table table-hover text-center">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">Order ID</th>
                                                    <th scope="col">Email address</th>
                                                    <th scope="col">Product type</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Product file</th>
                                                    <th scope="col">Details</th>
                                                    <th scope="col">Order type</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Payment status</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="orderTableBody">
                                                <?php
                                                include "db_con.php";
                                                    $sql = "SELECT * FROM orders JOIN users ON orders.userID = users.userID 
                                                            ORDER BY CASE WHEN orderType = 'priority' THEN 0 ELSE 1 END, orderType";

                                                        $sql_type = "SELECT * FROM payment_details,orders";
                                                        $paymentTypeResult = mysqli_query($conn, $sql_type);

                                                    if ($row = mysqli_fetch_assoc($paymentTypeResult)) {
                                                        $paymentType = $row['paymentType']; 
                                                        $orderID = $row['orderID'];

                                                        $sql2 = "UPDATE orders o JOIN payment_details p ON o.userID = p.userID AND o.orderID = p.refnumber
                                                        SET o.paymentStatus = CASE WHEN p.paymentType = 'online' AND p.amountpaid >= o.price THEN 'Verified'
                                                        WHEN p.paymentType = 'onsite' AND p.amountpaid >= 0.30 * o.price THEN 'Verified'
                                                        ELSE o.paymentStatus END WHERE o.orderID = $orderID;";

                                                    $result = mysqli_query($conn, $sql);
                                                    $result_update = mysqli_query($conn, $sql2);
                                                    while ($row = mysqli_fetch_assoc($result) ) {
                                                        ?>
                                                <tr>
                                                    <td><?php echo $row['orderID'] ?></td>
                                                    <td><?php echo $row['email'] ?></td>
                                                    <td><?php echo $row['productType'] ?></td>
                                                    <td><?php echo $row['quantity'] ?></td>
                                                    <td><?php echo $row['size'] ?></td>
                                                    <td><?php echo $row['productFile'] ?></td>
                                                    <td><?php echo $row['details'] ?></td>  
                                                    <td><?php echo $row['orderType'] ?></td>   
                                                    <td><?php echo $row['price'] ?></td>  
                                                    <td>
                                                        <?php
                                                        if($result_update){
                                                            echo $row['paymentStatus'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['status'] ?></td>                              
                                                        <td>
                                                            <a href="employee_edit_order.php?orderID=<?php echo $row['orderID'] ?>" class="link-dark">
                                                            <i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                                                            <a href="#" onclick="confirmDelete(<?php echo $row['orderID'] ?>)" class="link-dark">
                                                            <i class="fa-solid fa-trash fs-5" style="margin-right:18px"></i></a>
                                                        </td>
                                                </tr>
                                                <?php }} ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                    </div>
                </div>
            </main>
            <!-- ayaw hilabti kai maguba -->
            <main class="content px-3 py-4">
    <div class="container-fluid">
        <div class="mb-3">
            <h3 class="fw-bold fs-2 mb-3" id="paymeth">Payment details</h3>
            <div class="col-12 mb-3">
                <div class="search-container-email">
                    <input type="text" style="width: 100%;" id="paymethSearch" placeholder="Search by reference number..." oninput="findPaymeth()" class="form-control" required>
                </div>
            </div>
            <div class="table-container-paymeth">
                <table class="table table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Payment ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Reference number</th>
                            <th scope="col">Payment method</th>
                            <th scope="col">Card number</th>
                            <th scope="col">Amount paid</th>
                            <th scope="col">Payment type</th>
                        </tr>
                    </thead>
                    <tbody id="paymethTableBody">
                        <?php
                        include "db_con.php";
                        $sql = "SELECT paymentid, userID, refnumber, method, cardnumber, amountpaid, paymentType FROM payment_details";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['paymentid'] ?></td>
                            <td><?php echo $row['userID'] ?></td>
                            <td><?php echo $row['refnumber'] ?></td>
                            <td><?php echo $row['method'] ?></td>
                            <td><?php echo $row['cardnumber'] ?></td>
                            <td><?php echo $row['amountpaid'] ?></td>
                            <td><?php echo $row['paymentType'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this order?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a id="deleteOrderLink" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutConfirmationModal" tabindex="-1" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutConfirmationModalLabel">Logout Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a id="logoutUserLink" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</div>


    <!-- <script src="../js/admin.js"></script> -->

    <script>
    function confirmDelete(orderID) {
        // Set the href attribute of the delete link dynamically based on the orderID
        document.getElementById('deleteOrderLink').href = 'delete_order_employee.php?orderID=' + orderID;
        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        myModal.show();       
    }
    function logoutDelete(userID) {
    // Set the href attribute of the logoutUserLink dynamically based on the userID
    document.getElementById('logoutUserLink').href = 'logout.php?userID=' + userID;

    // Show the modal
    var myModal = new bootstrap.Modal(document.getElementById('logoutConfirmationModal'));
    myModal.show();
}
    const hamBurger = document.querySelector(".toggle-btn");

    hamBurger.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("expand");
    });

    // order filter
    function filterOrders(status, element) {
            var rows = document.querySelectorAll('.table-container-orders tbody tr');
            var button = document.getElementById('dropdownOrderButton');
            
            // Update button label
            if (status === '') {
                button.innerText = 'All Orders';
            } else {
                button.innerText = element.innerText;
            }
            
            // Filter rows
            rows.forEach(row => {
                var rowStatus = row.querySelector('td:nth-child(11)').innerText.trim(); // Adjust this if your status column position is different
                if (status === '' || rowStatus === status) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // search email
        function filterOrdersSearch() {
            const input = document.getElementById('emailSearch');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('orderTableBody');
            const rows = table.getElementsByTagName('tr');

            // Loop through all table rows, and hide those that do not match the search query
            for (let i = 0; i < rows.length; i++) {
                const emailColumn = rows[i].getElementsByTagName('td')[1]; // Assuming email is in the second column
                if (emailColumn) {
                    const txtValue = emailColumn.textContent || emailColumn.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }

        // payment details
        function findPaymeth() {
        const input = document.getElementById('paymethSearch');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('paymethTableBody');
        const rows = table.getElementsByTagName('tr');

        // Loop through all table rows, and hide those that do not match the search query
        for (let i = 0; i < rows.length; i++) {
            const refnumberColumn = rows[i].getElementsByTagName('td')[1]; // Assuming reference number is in the third column
            if (refnumberColumn) {
                const txtValue = refnumberColumn.textContent || refnumberColumn.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }
    
</script>

</body>

</html>
<?php } ?>