<?php
$main_template = file_get_contents("templates\\main_template.html");

$title = "My projects";
$main_template = str_replace("{title}", $title, $main_template);

$content = "";

try {
    $dbh = new PDO('mysql:dbname=3dprinting;host=127.0.0.1:3306', 'root', '');

    $sth = $dbh->prepare("SELECT Name, picture, description, link FROM myprojects");
    $sth->execute();
    $array = $sth->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($array); $i++) {

        $projectName = $array[$i]['Name'];
        $projectPicture = $array[$i]['picture'];
        $projectDescription = $array[$i]['description'];
        $projectLink = $array[$i]['link'];

//        print("<div class=\"img\">  <img src = \"" . $projectPicture . " \" width = \"500\"> </div>");

        $content = $content . "<div class=\"img\">  <img src = \"" . $projectPicture . " \" width = \"500\"> </div>";

//        print("<div class = \"textContent\"> <h3>" . $projectName . "</h3> <p>" . $projectDescription . "</p> <br> <a href = \"" . $projectLink . "\">Model source</a>  </div>");

        $content = $content . "<div class = \"textContent\"> <h3>" . $projectName . "</h3> <p>" . $projectDescription . "</p> <br> <a href = \"" . $projectLink . "\">Model source</a>  </div>";
    }


} catch (PDOException $e) {
    die($e->getMessage());
}


$main_template = str_replace("{content}", $content, $main_template);

print($main_template);