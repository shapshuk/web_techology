<?php
$main_template = file_get_contents("templates\\main_template.html");

$content = file_get_contents("templates\\my_printer_content.txt");

$title = "My printer";
$main_template = str_replace("{title}", $title, $main_template);
$main_template = str_replace("{content}", $content, $main_template);

print($main_template);