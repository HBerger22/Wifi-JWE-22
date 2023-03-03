<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Grundlagen 04 - Schleifen - If-Else</title>
</head>
<body>
    <h1>If-Else Schleifen</h1>
    <?php
    /* Aufgabe:
        Der Benutzer der Seite soll je nach Uhrzeit entsprechend begrüßt werden.
        von 0 - 5 Uhr "Schlaf gut!"
        von 6 - 9 Uhr "Guten Morgen!"
        um 12 oder 18 Uhr "Mahlzeit!"
        von 19 - 23 Uhr "Gute Nacht!"
        zu jeder anderen Zeit "Hallo!"
    */

        //$stunde = 12; // Werte von 0 - 23
        for ($stunde=0; $stunde < 24 ;++$stunde ){
            if ($stunde >= 0 && $stunde <= 5){ 
                echo "Schlaf  gut!";
            }else if ($stunde >= 6 && $stunde<= 9){
                echo "Guten Morgen!";
            }else if ($stunde == 12 || $stunde== 18){
                echo "Mahlzeit";
            }else if ($stunde >= 19 && $stunde<= 23){
                echo "Gute Nacht!";
            }else {
                echo "Hallo erstmal!";
            }
            echo "<br>";
        };

        // Hier mit der aktuellen Uhrzeit mit zuhilfename der PHP Funktion date();
        $stunde = date("G");
        if (date("G") >= 0 && $stunde <= 5){ 
            echo "Schlaf  gut!";
        }else if ($stunde >= 6 && $stunde<= 9){
            echo "Guten Morgen!";
        }else if ($stunde == 12 || $stunde== 18){
            echo "Mahlzeit";
        }else if ($stunde >= 19 && $stunde<= 23){
            echo "Gute Nacht!";
        }else {
            echo "Hallo erstmal!";
        }
        echo "<br>";

    ?>



</body>
</html>