<?php
$main_template = file_get_contents("templates\\main_template.html");

$title = "Purchase";
$main_template = str_replace("{title}", $title, $main_template);

$content = file_get_contents("templates\\purchase_form.txt");


$main_template = str_replace("{content}", $content, $main_template);

print($main_template);