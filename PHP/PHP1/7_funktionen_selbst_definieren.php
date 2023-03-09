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
        
        echo "<em><strong>Celsius in Fahrenheit umrechnen:</strong></em>"; 
        echo "<br>";
        echo "12°C = ".celsius_in_fahrenheit(12)."°F";
        echo "<br>";
        echo "15°C = ".celsius_in_fahrenheit(15)."°F";
        echo "<br>";
        echo "0°C = ".celsius_in_fahrenheit(0)."°F";
        echo "<br>";
        echo "-10°C = ".celsius_in_fahrenheit(-10)."°F";
        echo "<br>";
        echo "32°C = ".celsius_in_fahrenheit(32)."°F";
        echo "<br>";

        function celsius_in_fahrenheit($grad,$optionaler_parameter=null){//der optionale Parameter ist hier sinnlos nur zum zeigen
             $fahrenheit =  $grad * 1.8 + 32;
             return $fahrenheit;
        };
        echo "<br>";

        // Funktion zum Datum formattieren von 2022-04-17 nach 17.04.2022
        echo "<em><strong>Funktion um ein Datum anders zu formatieren: Z.B.: von 2022-04-17 nach 17.04.22</strong></em><br>";
        $heute ="2032-04-19";
        echo "Aktuelles Datumsformat: ".$heute ."<br>";
        
        function format_datum($datum){
            if(mb_strlen($datum)!= 10){//überprüfen ob es nur 10 Zeichen sind sonst ist es kein Datum!
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
        };
        echo "<br>";
        echo "<em><strong>Variante 1: mit substrings </strong></em><br>";
        echo format_datum($heute);
        echo "<br>";echo "<br>";

        // oder mit "string to time" und "date()"
        echo "<em><strong>Variante 2: mit der fertigen Funktion Date() und strtotime() </strong></em><br>";
        echo date("d.m.y",strtotime($heute));
        echo "<br>";echo "<br>";

        // oder mit der explode Methode
        echo "<em><strong>Variante 3: mit der Funktion explode </strong></em><br>";
        function de_datum($datum){
            $d_array = explode("-",$datum);
            $datum_neu=$d_array[2].".".$d_array[1].".".substr($d_array[0],2);
            return $datum_neu;
        };
        echo de_datum($heute);
        echo "<br>";
        echo is_int((int)substr($heute,2,1)); //mist sollte false und nicht true sein ... (int) taugt hier nix
        echo "<br>"; echo "<br>";
        
        // einen Text bei 10 Zeichen abschneiden und ... anhängen, unter 10 Zeichen soll nix geschehen.
        echo "<em><strong>Eine Funktion die einen Text kürzt und ... anhängt ab einer gewissen Länge (10 Zeichen): </strong></em><br>";
        $text1 = "Ein text mit mehr als 10 Zeichen";
        $text2 = "\"Ein Text\"";
        
        function text_kuerzen($text,$laenge=10){
            if(mb_strlen($text) <= $laenge){
                return $text;
            }else {
                return substr($text,0,$laenge)." ...";
            }
        };
        echo text_kuerzen("Hallo heute ist ein schöner Tag!",15); echo "<br>";
        echo text_kuerzen($text2); echo "<br>";


        




    ?>

    
</body>
</html>