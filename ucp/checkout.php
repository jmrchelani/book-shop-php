<?php

session_start();
require_once 'connection.php';
$isLogin = false;
$username = "";
if(isset($_SESSION["userID"]) && $_SESSION["userloggedin"] === true){
    $isLogin = true;
    $username = $_SESSION['userID'];
} else header('location: ..');

if(isset($_SESSION['cart'])) {

    foreach($_SESSION['cart'] as $id=>$x)
    {	
        $isbn = $x["isbn"];
        $price = ($x['qty']*$x['rate']);

        $sql = "INSERT INTO `transactions` (`Username`,`ISBN`,`Price`) VALUES ('". $username ."', '". $isbn ."', ". $price .")";
        $res = mysqli_query($conn, $sql) or die("Can't Execute Query..");

        $i++;
    }

    unset($_SESSION['cart']);

    header('location: done.php');

} else header('location: ..');


?>