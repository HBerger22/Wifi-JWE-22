<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Grundlagen 07 - eigene Funktionen</title>
</head>
<body>
    <h1>Eigene Funktionen</h1>
    <?php

        // funktion zum Umrechnen von Celsius in Fahrenheit
        // Fahrenheit = Celsius*1.8 +32;
        
        echo celsius_in_fahrenheit(12);
        echo "<br>";
        echo celsius_in_fahrenheit(15);
        echo "<br>";
        echo celsius_in_fahrenheit(0);
        echo "<br>";
        echo celsius_in_fahrenheit(-10);
        echo "<br>";
        echo celsius_in_fahrenheit(32);
        echo "<br>";

        function celsius_in_fahrenheit($grad,$optionaler_parameter=null){
             $fahrenheit =  $grad * 1.8 + 32;
             return $fahrenheit;
        };

        // Funktion zum Datum formattieren von 2022-04-17 nach 17.04.2022
        $heute ="2032-04-19";
        
        function format_datum($datum){
            if(mb_strlen($datum)!= 10){
                return "Kein datumsformat";
            } else 
            {
                $jahr = (int)substr($datum,2,2);
                $monat = substr($datum,5,2);
                $tag = substr($datum,8,2);
                // if (!is_int((int)$jahr)){
                //     return "keine Zahl";
                // } else {
                    return "$tag.$monat.$jahr ";
                // }
            }
        }

        echo format_datum($heute);

        echo is_int((int)substr($heute,2,1)); //mist sollte false und nicht true sein ... (int) taugt hier nix





    ?>

    
</body>
</html>