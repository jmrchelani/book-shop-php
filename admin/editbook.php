<?php
// Initialize the session
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");

}
 
// Include config file
require_once "connection.php";

$name = $isbn = $author = $price = $descr = $isbnn = "";





 
// Define variables and initialize with empty values
$name_err = $isbn_err = $author_err = $price_err = $descr_err = $add_err = "";
$added = false;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST["deleteBtn"])) {
        $isbn = trim($_POST["isbn"]);
        if(!empty($isbn)) {
            $sql = "DELETE FROM `books` WHERE `ISBN` = '". $isbn ."'";
            if($result = mysqli_query($conn, $sql)) {
                header("location: table.php");
            } else header("location: table.php");
        } else header("location: table.php");
    } else if(isset($_POST["editBtn"])) {
            // Check if username is empty
        if(empty(trim($_POST["name"]))){
            $name_err = "Please enter name.";
        } else{
            $name = trim($_POST["name"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["isbn"]))){
            $isbn_err = "Please enter ISBN.";
        } else{
            $isbn = trim($_POST["isbn"]);
        }

        if(empty(trim($_POST["author"]))){
            $author_err = "Please enter author.";
        } else{
            $author = trim($_POST["author"]);
        }

        if(empty(trim($_POST["price"]))){
            $price_err = "Please enter price.";
        } else{
            $price = trim($_POST["price"]);
        }

        if(empty(trim($_POST["descr"]))){
            $descr_err = "Please enter description.";
        } else{
            $descr = trim($_POST["descr"]);
        }

        // $target_dir = "uploads/";
        // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        // $uploadOk = 1;
        // $upload_err = "";
        // $upload_succ = 0;
        // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


        // if(!empty($_FILES["fileToUpload"]["tmp_name"])) {
        //     if(getimagesize($_FILES["fileToUpload"]["tmp_name"]) !== false) {
        //         $uploadOk = 1;
        //     } else {
        //         $uploadOk = 0;
        //         $upload_err = "There was an error uploading this image.";
        //     }
        // }

        // // Check if file already exists
        // //if (file_exists($target_file)) {
        // //    $uploadOk = 0;
        // //    $upload_err = "There was an error uploading this image.";
        // //}

        // // Check file size
        // if ($_FILES["fileToUpload"]["size"] > 500000) {
        //     $uploadOk = 0;
        //     $upload_err = "There was an error uploading this image.";
        // }

        // // Allow certain file formats
        // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        //     $uploadOk = 0;
        //     $upload_err = "There was an error uploading this image.";
        // }

        // // Check if $uploadOk is set to 0 by an error
        // $image = $target_file;
        
        
        // Validate credentials
        if(empty($name_err) && empty($isbn_err) && empty($author_err) && empty($price_err) && empty($descr_err)){
            // Prepare a select statement
            $sql = "SELECT * FROM `books` WHERE `ISBN` = '". $isbn ."'";

            if($result = mysqli_query($conn, $sql)) {
                                
                if (mysqli_num_rows($result) < 1) {
                    $add_err = "ISBN doesnt exists.";
                } else {
                    $sql = "UPDATE `books` SET `ISBN`='". $isbn ."', `Author`='". $author ."', `Name`='". $name ."', `Description`='". $descr ."', `Price`=". $price ." WHERE `ISBN` = '". $isbn ."'";
                    if($result = mysqli_query($conn, $sql)) {
                        $added = true;

                        header("location: table.php");
                    //     if ($uploadOk == 0) {
                    //         $upload_err = "There was an error uploading this image.";
                    //     } else {
                    //         if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    //             $upload_succ = 1;
                    //         } else {
                    //             $upload_err = "There was an error uploading this image.";
                    //         }
                    //     }
                    }
                }
            
            }
        }
    }
 

} else {
    if(isset($_GET["isbn"])) {
        $isbnn = $_GET['isbn'];
        $sql = "SELECT * FROM `books` WHERE `ISBN` = '". $isbnn ."'";
    
        if($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $isbn = $row['ISBN'];
                    $name = $row['Name'];
                    $author = $row['Author'];
                    $price = $row['Price'];
                    $descr = $row['Description'];
                }
            } else header("location: table.php");
        }
    }
    else header("location: table.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Edit Book - BibliOphile</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>BibliOphile</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item"><a class="nav-link active" href="index.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="addadmin.php"><i class="fas fa-user"></i><span>Add Admin</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="addbook.php"><i class="fas fa-table"></i><span>Add Book</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="table.php"><i class="fas fa-table"></i><span>Edit Book</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-user"></i><span>Edit Profile</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="far fa-user-circle"></i><span>Logout</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid">
                        <ul class="navbar-nav flex-nowrap ml-auto">
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-toggle="dropdown" href="#"><span class="d-none d-lg-inline mr-2 text-gray-600 small">Valerie Luna</span><img class="border rounded-circle img-profile" src="assets/img/avatars/avatar1.jpeg"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-1">Edit Book</h3>
                </div>
                <section class="contact-clean">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    
                        <h2 class="text-center">Book Details</h2>
                        <?php 
                            if(!empty($add_err)){
                                echo '<div class="alert alert-danger">' . $add_err . '</div>';
                            } else if($added) {
                                echo '<div class="alert alert-success">"Edited book successfully."</div>';
                            }
                        ?>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" placeholder="Name">
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="isbn" class="form-control <?php echo (!empty($isbn_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $isbn; ?>" placeholder = "ISBN">
                            <span class="invalid-feedback"><?php echo $isbn_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="author" class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $author; ?>" placeholder = "Author">
                            <span class="invalid-feedback"><?php echo $author_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>" placeholder = "Price">
                            <span class="invalid-feedback"><?php echo $price_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="descr" class="form-control <?php echo (!empty($descr_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $descr; ?>" placeholder = "Description">
                            <span class="invalid-feedback"><?php echo $descr_err; ?></span>
                        </div>
                            <!-- <p class="mb-auto"><strong>Cover Image</strong></p>
                            <input type="file" name="fileToUpload" />
                            <span class="invalid-feedback"></span> -->
                        
                        <div class="form-group"><button class="btn btn-primary btn-lg btn-block" type="submit" name="editBtn">EDIT&nbsp;</button> </div>
                        <div class="form-group"><button type="submit" class="btn btn-outline-danger btn-lg btn-block" style="color:#DC3545;" name="deleteBtn">DELETE</button></div>
                    </form>
                </section>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © BibliOphile 2021</span></div>
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