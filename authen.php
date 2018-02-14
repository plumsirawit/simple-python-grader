<?php
include_once "configurations.php";
session_start();
if(isset($_SESSION['uid'])){
    header("Location: main.php");
    exit();
}
echo MYSQL_USER;
$conn = new mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWORD,MYSQL_DB) or die("CONNECTION ERROR!");
if(strlen($_POST['user']) > 64 || strlen($_POST['password']) > 64){
    $_SESSION['mhd'] = "Error!";
    $_SESSION['msg'] = "Username or password too long. (Maximum 64 characters)";
    header("Location: index.php");
    exit();
}
if(isset($_POST['regis']) && $_POST['regis'] == 1){
    $stmt = $conn->prepare("SELECT * FROM user_info WHERE user = ? AND pass = ?");
    $stmt->bind_param("ss",$_POST['user'],password_hash($_POST['pass'],PASSWORD_DEFAULT));
    if($stmt->fetch_rows()){
        $stmt->free_result();
        $_SESSION['mhd'] = "Error!";
        $_SESSION['msg'] = "Username already taken!";
        $conn->close();
        header("Location: index.php");
        exit();
    }else{
        $stmt->free_result();
        $stmt = $conn->prepare("INSERT INTO user_info (user,pass) VALUES (?,?)");
        $stmt->bind_param("ss",$_POST['user'],password_hash($_POST['pass'],PASSWORD_DEFAULT));
        $_SESSION['mhd'] = "Success!";
        $_SESSION['msg'] = "Registration Successful!";
        $conn->close();
        header("Location: index.php");
        exit();
    }
}else{
    $stmt = $conn->prepare("SELECT * FROM user_info WHERE user = ? AND pass = ?");
    $stmt->bind_param("ss",$_POST['user'],password_hash($_POST['pass'],PASSWORD_DEFAULT));
    if($row = $stmt->fetch_assoc()){
        $_SESSION['uid'] = $row['id'];
        $stmt->free_result();
        $conn->close();
        unset($_SESSION['mhd']);
        unset($_SESSION['msg']);
        header("Location: main.php");
        exit();
    }else{
        $stmt->free_result();
        $conn->close();
        $_SESSION['mhd'] = "Error!";
        $_SESSION['msg'] = "Wrong username or password.";
        header("Location: index.php");
        exit();
    }
}
?>
