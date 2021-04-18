<?php

session_start();
require_once 'connection.php';
$isLogin = false;
if(isset($_SESSION["userID"]) && $_SESSION["userloggedin"] === true){
    $isLogin = true;
} else {
    header('location: ..');
}

$username = $_SESSION['userID'];


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>History - User Panel</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>User Panel</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item"><a class="nav-link active" href=".."><i class="fas fa-tachometer-alt"></i><span>Home</span></a></li>
                <li class="nav-item"><a class="nav-link active" href="index.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="table.php"><i class="fas fa-table"></i><span>Transactions</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-table"></i><span>Cart</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-key"></i><span>Logout</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"></button></div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Transaction History</h3>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">History</p>
                        </div>
                        <div class="card-body">
                            
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>ISBN</th>
                                            <th>Book Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $sql = "SELECT `ID`, `Username`, `ISBN`, `Price`, (SELECT books.Name FROM books WHERE books.ISBN = transactions.ISBN) AS BNAME FROM transactions WHERE Username = '". $username ."'";
                                        if($result = mysqli_query($conn, $sql)) {
                                            if(mysqli_num_rows($result)) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    echo '
                                                    <tr>
                                                        <td>'. $row["ID"] .'</td>
                                                        <td>'. $row["ISBN"] .'</td>
                                                        <td>'. $row["BNAME"] .'</td>
                                                        <td>'. $row["Price"] .'</td>
                                                    </tr>
                                                    ';
                                                }
                                            }
                                        }
                                    ?>
                                    
                                        
                                    </tbody>
                                    
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © User Panel 2021</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>