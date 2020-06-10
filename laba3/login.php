<?php
session_start();

if (isset($_POST["username"])) {
    $username = $_POST['username'];
} else {
    echo "error";
    exit;
}
if (isset($_POST["password"])) {
    $password = $_POST['password'];
}


$dbh = new PDO('mysql:dbname=3dprinting;host=127.0.0.1:3306', 'root', '');
$request = "SELECT * FROM users WHERE username = '$username'";

$sth = $dbh->prepare($request);
$sth->execute();
$array = $sth->fetchAll(PDO::FETCH_ASSOC);


if ((count($array) <> 0) && (password_verify($password, $array[0]["password"]))) {
    $_SESSION['name'] = $username;
    header("Location: admin_page.php");
}else {
    header('HTTP/1.0 403 Forbidden');
}