<?php
$main_template = file_get_contents("templates\\main_template.html");

$title = "Sign in";
$main_template = str_replace("{title}", $title, $main_template);

$content = file_get_contents("templates\\sign_in.html");


$main_template = str_replace("{content}", $content, $main_template);

print($main_template);