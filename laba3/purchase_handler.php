<?php

$main_template = file_get_contents("templates\\main_template.html");

$title = "Purchase processing";
$main_template = str_replace("{title}", $title, $main_template);




$number = $_POST["number"];
$regexp = '/^(\+?375|80)((\(|\-)\d{2}(\)|\-)|\d{2})\d{7}\s?$/';

preg_match($regexp, $number, $result);

if (($result != NULL) && ($_POST['email'] != NULL) && ($_POST['name'] != NULL))
{
    $pos = strpos($number, $result[2]);
    $second_part_number = substr($number, ($pos+strlen($result[2])));

 if (strlen($result[2]) == 4)
 {
     $code = substr($result[2], 1, 2);
 }
 else
 {
     $code = $result[2];
 }

 $rightNumber = $code . '-' . $second_part_number;

 $pathname = 'D:\Work\XAMPP\htdocs\laba3' . '\\' . $_POST["email"];
 mkdir($pathname);

 $filepath = $pathname . '\\' . $_POST["name"] . '.txt';
 $file = fopen($filepath, 'w');

 fwrite($file, $_POST["name"] . "\n" . $_POST["email"] . "\n" . $rightNumber . "\n" . $_POST["description"] . "\n" . $filepath);

 fclose($file);


 $order_name = $_POST['name'];
 $email = $_POST['email'];

 $description = $_POST['description'];




//    $sth = $dbh->prepare("INSERT INTO orders(name, email, phone_number, description, file)
//    VALUES($_POST['name'],$_POST['email'],$rightNumber),$_POST['description'],");
//    $sth->execute();
//    $array = $sth->fetchAll(PDO::FETCH_ASSOC);


 foreach($_FILES["userfile"]["error"] as $key => $error)
 {
     if ($error == UPLOAD_ERR_OK) {
         $tmp_name = $_FILES['userfile']['tmp_name'][$key];
         $name = basename($_FILES['userfile']['name'][$key]);
         move_uploaded_file($tmp_name, $pathname . "\\" . $name);
         try {
             $filepath = $pathname . '\\' . $name;
             $filepath = quotemeta($filepath);

             substr_replace($filepath, '\\\\', 3, 0);

//             $filepath = str_replace("\\", "\\\\", $filepath);

             $dbh = new PDO('mysql:dbname=3dprinting;host=127.0.0.1:3306', 'root', '');
             $request =   "INSERT INTO orders(name, email, phone_number, description, file) VALUES('$order_name' , '$email' , '$rightNumber' , '$description' , '$filepath')";
             $sth = $dbh->prepare($request);
             $sth->execute();
//             print($filepath);
//             print('success');
         } catch (PDOException $e) {
             die($e->getMessage());
         }

         
     }
 }


 $content = "Data is sent succesfully";
 //echo $text;
}
else
{
 $content = "Wrong data!";
 //echo $text;
}
$main_template = str_replace("{content}", $content, $main_template);

print($main_template);
