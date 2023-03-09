<?php


$nav_array = array (
    "home" => "Startseite",
    "leistungen" => "Unsere Leistungen",
    "oeffnungszeiten" => "Unsere Öffnungszeiten",
    "kontakt" => "Kontaktformular"
);

foreach ($nav_array as $key => $nav_text){
    echo "<li ";
    if ($key==$seite){
        echo "class='active' ";
    };
    echo "><a href='index.php?seite={$key}'>{$nav_text}</a></li>";

};




?>

<!--
    <li class="active"><a href="index.php?seite=home">Home</a></li>
    <li><a href="index.php?seite=leistungen">Leistungen</a></li>
    <li><a href="index.php?seite=oeffnungszeiten">Öffnungszeiten</a></li>
    <li><a href="index.php?seite=kontakt">Kontakt</a></li> 
-->