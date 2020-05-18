<?php
$main_template = file_get_contents("templates\\main_template.html");

$title = "3D printing"; //
//$main_button = "Main";
$text_content = file_get_contents("templates\\index_text_content.txt");


$main_template = str_replace("{title}", $title, $main_template);

$main_template = str_replace("{content}", $text_content, $main_template);


print($main_template);



