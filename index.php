<?php
session_start();
 
$isLogin = false;
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["userID"]) && $_SESSION["userloggedin"] === true){
    $isLogin = true;
}

require_once 'connection.php';

$username = $password = $fname = $lname = $city = $zip = "";
$username_err = $password_err = $login_err = $fname_err = $lname_err = $city_err = $zip_err = $add_err = "";
$added = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(isset($_POST['loginBtn'])) {
        // Check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter username.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate credentials
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            $sql = "SELECT `Username`, `Password` FROM `clients` WHERE `Username` = '". $username ."' AND `Password` = '". $password ."'";

            if($result = mysqli_query($conn, $sql)) {
                                
                if (mysqli_num_rows($result) > 0) {
                    session_start();
                        
                    $_SESSION["userloggedin"] = true;
                    $_SESSION["userID"] = $username;                            
                    
                    header("location: index.php");
                } else {
                    $login_err = "Invalid username or password.";
                }
            
            }
        }
    } else if(isset($_POST['registerBtn'])) {
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter username.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
        } else{
            $password = trim($_POST["password"]);
        }

        if(empty(trim($_POST["fname"]))){
            $fname_err = "Please enter firstname.";
        } else{
            $fname = trim($_POST["fname"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["lname"]))){
            $lname_err = "Please enter your last name.";
        } else{
            $lname = trim($_POST["lname"]);
        }

        if(empty(trim($_POST["city"]))){
            $city_err = "Please enter city.";
        } else{
            $city = trim($_POST["city"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["zip"]))){
            $zip_err = "Please enter your zip.";
        } else{
            $zip = trim($_POST["zip"]);
        }

        if(empty($username_err) && empty($password_err) && empty($fname_err) && empty($lname_err) && empty($city_err) && empty($zip_err)) {
            $sql = "SELECT * FROM `clients` WHERE `Username` = '". $username ."'";
            if($result = mysqli_query($conn, $sql)) {
                if(mysqli_num_rows($result) > 0) {
                    $added = false;
                    $add_err = "Username already exists.";
                } else {
                    $sql = "INSERT INTO `clients` (`Username`, `Password`, `LName`, `FName`, `City`, `Zip`) VALUES ('". $username ."', '". $password ."', '". $lname ."', '". $fname ."', '". $city ."', '". $zip ."')";
                    if($result = mysqli_query($conn, $sql)) {
                        $added = true;
                    }
                }
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>BibliOphile</title>
    <!--fav icon -->
    <link rel="icon" href="img/favicon.png" type="image/x-icon" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <!-- MDB -->
    <link rel="stylesheet" href="css/mdb.min.css" />
    <!-----BEAUTY.CSS----->
    <link rel="stylesheet" href="css/beauty.css" />

    <!-- Google Fonts Monserrat -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">

</head>

<body>
    <!-- navbar-->
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar">
        <div class="container">


            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <img src="img/finalnav.png" alt="logo" width="150px" height="60px">
            </a>

            <!-- Collapse -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            <!-- Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Left -->
                <strong><ul class="navbar-nav" >
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home
            <span class="sr-only">(current)</span>
          </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about" >About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#shop" >Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq" >Faq</a>
                    </li>
                    
                    <?php 
                        if(!$isLogin) {
                            echo '
                                <li class="nav-item">
                                    <a class="nav-link" href="#register" >Register</a>
                                </li>
                            ';
                        }
                    ?>

                </ul></strong>

                <!-- Right -->
                <ul class="navbar-nav list-inline ms-auto">
                    <!-- Icons -->

                    <?php 
                        if($isLogin) {
                            echo '
                                <li class="">
                                    <a class="nav-link" href="ucp/cart.php" rel="nofollow" >
                                        <i class="fas fa-cart-plus"></i> Cart
                                    </a>
                                </li>
    
                                <li class="nav-item">
                                    <a href="ucp" type="button" class=" btn-warning btn-sm">
                                        User CP
                                    </a>
                                </li>
                                <li><a>-</a></li>
                                <li class="nav-item">
                                    <a href="logout.php" type="button" class=" btn-danger btn-sm">
                                        Logout
                                    </a>
                                </li>
                            ';
                        } else {
                            echo '
                                <li class="nav-item">
                                    <button type="button" class=" btn-warning btn-sm" data-mdb-toggle="modal" data-mdb-target="#loginModal">
                                        LOGIN
                                    </button>
                                </li>
                            ';
                        }
                    ?>


                </ul>

            </div>

        </div>
    </nav>
    <!-- Navbar -->

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong>LOGIN</strong></h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <?php 
                                        if(!empty($login_err)){
                                            echo '<div class="alert alert-danger">' . $login_err . '</div>';
                                        }        
                                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="text" name="username" id="form2Example1" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"/>
                            <label class="form-label" for="form2Example1">Username</label>
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" name="password" id="form2Example2" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" />
                            <label class="form-label" for="form2Example2">Password</label>
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>

                        <!-- 2 column grid layout for inline styling -->
                        <div class="row mb-4">
                            <div class="col d-flex justify-content-center">
                                <!-- Checkbox -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="form2Example3" checked />
                                    <label class="form-check-label" for="form2Example3"> Remember me </label>
                                </div>
                            </div>

                            
                        </div>

                        <!-- Submit button -->
                        <button type="submit" name = "loginBtn" class="btn btn-primary btn-block mb-4">Sign in</button>

                        <!-- Register buttons -->
                        <div class="text-center">
                            <p>Not a member? <a href="#register">Register</a></p>
                            
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!---------------CAROUSEL------------->

    <!-- Carousel wrapper -->

    <div class="carousel-indicators">
        <button type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div id="carouselBasicExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">
        <!-- Indicators -->


        <!-- Inner -->
        <div class="carousel-inner">
            <!-- Single item -->
            <div class="carousel-item active">
                <div class="bg-image">
                    <img src="img/car 1.jpg" class="d-block w-100" alt="..." class="w-100" style="height: 700px; " />

                </div>
                <div class="mask" style="
                background: linear-gradient(
                  45deg,
                  rgba(155,92,40,0.7),
                  rgba(0, 0, 0, 0.7) 100%
                );
              "></div>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Best Book Shop</h5>
                    <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                </div>
            </div>


            <!-- Single item -->
            <div class="carousel-item ">
                <div class="bg-image">
                    <img src="img/car 2.jpg" class="d-block w-100" alt="..." class="w-100" style="height: 700px;" />

                </div>
                <div class="mask" style="
              background: linear-gradient(
                45deg,
                rgba(155,92,40,0.7),
                rgba(0, 0, 0, 0.7) 100%
              );
            "></div>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Secure and Fast</h5>
                    <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                </div>
            </div>

            <div class="carousel-item">
                <div class="bg-image">
                    <img src="img/car 3.jpg" class="d-block w-100" alt="..." class="w-100" style="height: 700px;" />

                </div>
                <div class="mask" style="
            background: linear-gradient(
              45deg,
              rgba(155,92,40,0.7),
              rgba(0, 0, 0, 0.7) 100%
            );
          "></div>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Trusted by thousand of book readers</h5>
                    <!-- <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p> -->
                </div>
            </div>

            <!-- Inner -->

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="prev">
<span class="carousel-control-prev-icon" aria-hidden="true"></span>
<span class="visually-hidden">Previous</span>
</button>
            <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="next">
<span class="carousel-control-next-icon" aria-hidden="true"></span>
<span class="visually-hidden">Next</span>
</button>
        </div>
        <!-- Carousel wrapper -->


        <!---------------CAROUSEL------------->

        <!-------------------------MAIN HEADING------------------------------->

        <div class="container d-flex justify-content-center align-items-center" id="about">
            <div class="row">
                <div class="column my-5">
                    <center>
                        <h1>About BibliOphile</h1>
                    </center>
                    <div class="border-top border-warning w-60 mx-auto my-3"></div>
                </div>
            </div>
        </div>

        <!-------------------------MAIN HEADING------------------------------->

        <!--------------------------ABOUT US---------------------------------->
        <!-- START THE FEATURETTES -->
        <div class="container">
            <div class="row featurette d-flex justify-content-center align-items-center">
                <div class="col-md-7">
                    <h1/h1 class="featurette-heading">
                        Best in this business.
                        <span class="text-muted">Secure, Fast and Trusted.</span>
                        </h1>
                        <p class="lead">
                            Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.
                        </p>
                </div>
                <div class="col-md-5">
                    <img class="bd-placeholder-img bd-placeholder-img-sm featurette-image img-fluid mx-auto" style="height: 500px; width: 500px;" src="img/about1.jpg" />
                    <title>Placeholder</title>
                </div>
            </div>

            <hr><br>

            <!-------------------------MAIN HEADING------------------------------->

            <div class="container d-flex justify-content-center align-items-center" id="shop">
                <div class="row">
                    <div class="column my-5">
                        <h1>BEST SELLER</h1>
                        <div class="border-top border-warning w-60 mx-auto my-3"></div>
                    </div>
                </div>
            </div>
            <!-------------------------MAIN HEADING------------------------------->


            <!---------------------CAROUSEL CARDS---------------------->

            <!-- Carousel wrapper -->
            <div id="carouselMultiItemExample" class="carousel slide carousel-dark text-center" data-mdb-ride="carousel">
                <!-- Controls -->
                <div class="d-flex justify-content-center mb-4">
                    <button class="carousel-control-prev position-relative" type="button" data-mdb-target="#carouselMultiItemExample" data-mdb-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
                    <button class="carousel-control-next position-relative" type="button" data-mdb-target="#carouselMultiItemExample" data-mdb-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
                </div>
                <!-- Inner -->
                <div class="carousel-inner py-4">

                    <?php
                        $num = 0;
                        $op = true;
                        
                        $sql = "SELECT *, (SUM(Price)/(SELECT price FROM `books` WHERE books.ISBN = transactions.ISBN)) AS QTY, (SELECT books.Name FROM books WHERE books.ISBN = transactions.ISBN) AS Name, (SELECT books.Description FROM books WHERE books.ISBN = transactions.ISBN) AS Description, (SELECT books.Img FROM books WHERE books.ISBN = transactions.ISBN) AS Img FROM `transactions` GROUP BY ISBN ORDER BY QTY DESC LIMIT 6";
                        
                        if($result = mysqli_query($conn, $sql)) {
                            
                            if (mysqli_num_rows($result) > 0) {
                                
                                while($row = mysqli_fetch_assoc($result)) {
                                    
                                    if($num == 0) {
                                        if($op) {
                                            echo '<div class="carousel-item active">';
                                            $op = false;
                                        } else {
                                            echo '<div class="carousel-item">';
                                        }
                                        echo '<div class="container">
                                            <div class="row"> ';
                                    }

                                    $descrr = "";
                                    $descrr = $row["Description"];
                                    if(strlen($descrr) > 150) {
                                        $descrr = substr($descrr, 0, 140);
                                    }

                                    echo '
                                    <div class="col-lg-4">
                                            <div class="card">
                                                <img src="admin/'. $row['Img'] .'" class="card-img-top" style="margin-left:auto;margin-right:auto;width:150px;" alt="..." />
                                                <div class="card-body">
                                                    <h5 class="card-title">'. $row['Name'] .'</h5>
                                                    <p class="card-text">
                                                        '. $descrr .'...
                                                    </p>
                                                    <a href="book.php?isbn='. $row["ISBN"] .'" class="btn btn-primary"><strong>ADD TO CART</strong></a>
                                                </div>
                                            </div>
                                        </div>
                                    ';

                                    $num++;
                                    if($num == 3) {
                                        echo '</div> </div> </div>';
                                        $num = 0;
                                    }

                                
                                }
                                if($num < 3 && $num != 0) echo '</div> </div> </div>';
                            } else {
                                echo "0 results";
                            }
                            
                        }
                    ?>

                    
                </div>
                <!-- Inner -->
            
            <!-- Carousel wrapper -->
            <!---------------------CAROUSEL CARDS---------------------->
            <hr><br>

            <!----------------------------HIGHLY RECOMMENDED ---------------------->

            <section class="recent-book-sec">

                <div class="container d-flex justify-content-center align-items-center">
                    <div class="row">
                        <div class="column my-5">
                            <h1>BRAND NEW</h1>
                            <div class="border-top border-warning w-60 mx-auto my-3"></div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <?php

                        $sql = "SELECT * FROM books ORDER BY ID DESC LIMIT 5";
                        if($result = mysqli_query($conn, $sql)) {
                            if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo 
                                    '<div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="item">
                                            <img style="text-align:center;widht:200px;" src="admin/'. $row['Img'] .'" alt="img">
                                            <h3><a href="book.php?isbn='. $row["ISBN"] .'">'. $row['Name'] .'</a></h3>
                                            <h6><span class="price">PKR '. $row['Price'] .'</span> / <a href="book.php?isbn='. $row["ISBN"] .'">Buy Now</a></h6>
                                        </div>
                                    </div>';
                                }
                            }
                        }

                        ?>
                        
                    </div>
                    <div class="btn-sec">
                        <a href="allbooks.php" class="btn gray-btn">view all books</a>
                    </div>
                </div>

            </section>
            <hr><br>
            <!----------------------------HIGHLY RECOMMENDED ---------------------->
            <!----------------------------------FAQ-------------------------------->
            <div class="breadcrumb">
                <div class="container">
                    <span class="breadcrumb-item active" id="faq">FAQ</span>
                </div>
            </div>
            <section class="static about-sec">
                <div class="container">
                    <h1>FAQ</h1>
                    <strong><h3>Why do I need to register on the site before I can place an order?</h3></strong>
                    <p>Establishing an online account with us assures you that your purchasing information is secure, confidential and accessible to you. Once you establish an account, you will only need to sign-in to place an order in the future,
                        check on the status of your current order, view past purchases or update your profile information.</p>
                    <strong><h3>How long does it take for delivery to International destinations? </h3></strong>
                    <p>When we ship orders to international destinations it can take 8-12 weeks when shipping surface postal mail, depending on final destination. Airmail can take 2-3 weeks. The charges for surface or airmail service, is based on the weight
                        of the package.

                    </p>
                </div>
            </section>
            <!--------------------------------FAQ---------------------------------->
            <br>
            <hr>
            <!-------------------------MAIN HEADING------------------------------->
            <?php
if(!$isLogin) {
    echo '
            <div class="container d-flex justify-content-center align-items-center" id="register">
                <div class="row">
                    <div class="column my-5">
                        <h1>REGISTER</h1>
                        <div class="border-top border-warning w-60 mx-auto my-3"></div>
                    </div>
                </div>
            </div>';
}
?>
            <!-------------------------MAIN HEADING------------------------------->
            <?php 
                            if(!empty($add_err)){
                                echo '<div class="alert alert-danger">' . $add_err . '</div>';
                            } else if($added) {
                                echo '<div class="alert alert-success">"Registered successfully."</div>';
                            }
                        ?>
            <!--------------------------------FORM----------------------------------------->
            <?php
            if(!$isLogin) {
                echo '
            <form class="row g-3 needs-validation" action="'. htmlspecialchars($_SERVER["PHP_SELF"]) .'" method="post" novalidate>
                <div class="col-md-4">
                    <div class="form-outline">
                        <input type="text" name="fname" class="form-control" id="validationCustom01" required />
                        <label for="validationCustom01" class="form-label">First name</label>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-outline">
                        <input type="text" name="lname" class="form-control" id="validationCustom02" required />
                        <label for="validationCustom02" class="form-label">Last name</label>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group form-outline">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required />
                        <label for="validationCustomUsername" class="form-label">Username</label>
                        <div class="invalid-feedback">Please choose a username.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-outline">
                        <input type="password" name="password" class="form-control" id="validationCustom06" required />
                        <label for="validationCustom06" class="form-label">Password</label>
                        <div class="valid-feedback">Looks good!</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-outline">
                        <input type="text" name="city" class="form-control" id="validationCustom03" required />
                        <label for="validationCustom03" class="form-label">City</label>
                        <div class="invalid-feedback">Please provide a valid city.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-outline">
                        <input type="text" name="zip" class="form-control" id="validationCustom05" required />
                        <label for="validationCustom05" class="form-label">Zip</label>
                        <div class="invalid-feedback">Please provide a valid zip.</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required />
                        <label class="form-check-label" for="invalidCheck">
                    Agree to terms and conditions
                  </label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                    </div>
                </div>
                <div class="col-12">
                    <button name="registerBtn" class="btn btn-primary" type="submit">Register</button>
                </div>
            </form>
            ';
}
?>
            <!--------------------------------FORM----------------------------------------->
            <br>
            <hr>

            <!---------------------------------FOOTER--------------------------------->

            <footer class="bg-dark text-center text-white">
                <!-- Grid container -->
                <div class="container-fluid py-5 px-5">
                    <!-- Section: Social media -->
                    <section class="mb-4">
                        <!-- Facebook -->
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i
                  ></a>

                        <!-- Twitter -->
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i
                  ></a>

                        <!-- Google -->
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i
                  ></a>

                        <!-- Instagram -->
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i
                  ></a>

                        <!-- Linkedin -->
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i
                  ></a>

                        <!-- Github -->
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i
                  ></a>
                    </section>
                    <!-- Section: Social media -->
                </div>
                <!-- Grid container -->

                <!-- Copyright -->
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                    © 2020 Copyright:
                    <a class="text-white" href="#">BibliOphile.com</a>
                </div>
                <!-- Copyright -->
            </footer>

            <!---------------------------------FOOTER--------------------------------->

            <!-- MDB -->
            <script type="text/javascript" src="js/mdb.min.js"></script>
            <!-- Custom scripts -->
            <script type="text/javascript"></script>
            <script type="text/javascript" src="js/main.js"></script>

</body>

</html>