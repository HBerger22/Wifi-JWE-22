<h1>Statische Eigenschaften und Methoden</h1>
<?php

include "Statisch.php";

$neu = new Statisch();
echo Statisch::$aufrufe;
echo "<br>";

$neu2 = new Statisch();
echo Statisch::$aufrufe;
echo "<br>";

$neu3 = new Statisch();
echo Statisch::$aufrufe;
echo "<br>";


// aufruf der STATISCHEN Methode
Statisch::setze_0();
echo Statisch::$aufrufe;
echo "<br>";
