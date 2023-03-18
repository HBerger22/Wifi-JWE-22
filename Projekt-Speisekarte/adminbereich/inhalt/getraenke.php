<?php 
$laengeSessionSeite=strlen($_SESSION["seite"]);
echo "laenge: ". $laengeSessionSeite. "<br>";
$untermenu=substr($_SESSION["seite"],2,$laengeSessionSeite-1);
echo "laenge: ". $untermenu. "<br>";



?>