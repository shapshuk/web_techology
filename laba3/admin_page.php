<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

//require 'D:/Work/XAMPP/composer/vendor/autoload.php';


//require 'PHPMailerAutoload.php';

//require_once 'PHPMailer/src/PHPMailerAutoload.php'

//require "PHPMailerAutoload.php";

session_start();

if (!(isset($_SESSION['name'])))
{
    header("Location: /sign_in.php");
    exit;
};


if (isset($_POST['id'])){
    $id = $_POST['id'];

    $dbh = new PDO('mysql:dbname=3dprinting;host=127.0.0.1:3306', 'root', '');

    $sth = $dbh->prepare("SELECT name, email FROM orders WHERE id = '$id'");
    $sth->execute();
    $array = $sth->fetchAll(PDO::FETCH_ASSOC);

    $name = $array[0]['name'];
    $email = $array[0]['email'];

    $mail = new PHPMailer();
    $mail -> IsSMTP();
    $mail -> Host = 'smtp.gmail.com';
    $mail -> SMTPAuth = true;
    $mail -> Username = 'andrewshapshuk';
    $mail -> Password = 'hadroncollider';
    $mail -> SMTPSecure = 'ssl';
    $mail -> Port = 465;

    $mail -> setFrom('andrewshapshuk@gmail.com', '3D-printing');
    $mail -> addAddress($email, $name);
    $mail -> Subject = 'Your order is done';
    $mail-> msgHTML("<html><body>
                <h1>Hello!</h1>
                <p>Your order is already finished. For more details go to 3dprinting.com.</p>
                </html></body>");
// Отправляем
    if (!($mail->send())) {
        echo 'Error: ' . $mail->ErrorInfo;
    }


    $dbh = new PDO('mysql:dbname=3dprinting;host=127.0.0.1:3306', 'root', '');

    $sth = $dbh->prepare("DELETE from orders WHERE id='$id'");
    $sth->execute();


}
//    if (isset($_POST["username"])) {
//        $username = $_POST['username'];
//    } else {
//        echo "error";
//        exit;
//    }
//    if (isset($_POST["password"])) {
//        $password = $_POST['password'];
//    }
//
//    $dbh = new PDO('mysql:dbname=3dprinting;host=127.0.0.1:3306', 'root', '');
//    $request = "SELECT * FROM users WHERE username = '$username'";
//
////$request = "SELECT * FROM users";
//
//    $sth = $dbh->prepare($request);
//    $sth->execute();
//    $array = $sth->fetchAll(PDO::FETCH_ASSOC);
//
////$result = $dbh -> query($request);
////print($username);
////print_r($array);
//
//    if (count($array) <> 0) {
//        if (password_verify($password, $array[0]["password"])) {

            $main_template = file_get_contents("templates\\main_template.html");

            $title = "Admin page";
            $main_template = str_replace("{title}", $title, $main_template);

            $content = "";
            $content = $content . "<table border=\"1\" width='\"100%\"'> ";

            try {
                $dbh = new PDO('mysql:dbname=3dprinting;host=127.0.0.1:3306', 'root', '');

                $sth = $dbh->prepare("SELECT id, name, email, phone_number, description, file FROM orders");
                $sth->execute();
                $array = $sth->fetchAll(PDO::FETCH_ASSOC);

                for ($i = 0; $i < count($array); $i++) {
                    $order_id = $array[$i]['id'];
                    $order_name = $array[$i]['name'];
                    $order_email = $array[$i]['email'];
                    $order_phone_number = $array[$i]['phone_number'];
                    $order_description = $array[$i]['description'];
                    $file_path = $array[$i]['file'];


//        print("<div class=\"img\">  <img src = \"" . $projectPicture . " \" width = \"500\"> </div>");

//                $content = $content . "<div class=\"img\">  <img src = \"" . $projectPicture . " \" width = \"500\"> </div>";

//                $content = $content . "<div class=\"contactInfo\"> " . $order_name . "<br>" . $order_email . "<br>" . $order_phone_number . "</div>";
//                $content = $content . "<div class=\"description\"> " . $order_description . "</div>";


                    $content = $content . "<tr><td> " . $order_name . "<br>" . $order_email . "<br>" . $order_phone_number . " </td>>";
                    $content = $content . "<td>" .  $order_description . "</td>";
                    $content = $content . "<td> <a href = \">" . $file_path  . " \">  File  </a> </td>";
                    $content = $content . "<td> <form enctype=\"multipart/form-data\" action=\"admin_page.php\" method=\"POST\">
                  <input type=\"hidden\" name=\"id\" value=\"" . $order_id  ."\"> <input type=\"submit\" value=\"Finish order\"> </form></td> </tr>";

//        print("<div class = \"textContent\"> <h3>" . $projectName . "</h3> <p>" . $projectDescription . "</p> <br> <a href = \"" . $projectLink . "\">Model source</a>  </div>");

//                $content = $content . "<div class = \"textContent\"> <h3>" . $projectName . "</h3> <p>" . $projectDescription . "</p> <br> <a href = \"" . $projectLink . "\">Model source</a>  </div>";
                }


            } catch (PDOException $e) {
                die($e->getMessage());
            }

            $content = $content . "</table> ";


            $main_template = str_replace("{content}", $content, $main_template);

            print($main_template);
//        } else {
//
////            print("access blocked");
//            header('HTTP/1.0 403 Forbidden');
//        }
//    } else {
////        print("access blocked");
//        header('HTTP/1.0 403 Forbidden');
//    }







//--------------------------------------

