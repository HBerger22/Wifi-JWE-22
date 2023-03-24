<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Grundlagen 02 - Variablen</title>
</head>
<body>
    <h1>Variablen mit PHP</h1>
    <p>Variablen werden mit einem "$" Zeichen eingeleitet</p>
    <?php
        // Ganzzahl (Integer) definieren und ausgeben.
        $meineVariable = 47;
        echo "Ich bin: ";
        echo $meineVariable;
        echo " Jahre alt.";
        echo "<br>";

        // Kommazahl (float) definieren und ausgeben.
        $kontostand = 0.81;
        echo "Kontostand: ";
        echo $kontostand;
        echo " <br>";

        // Text (string) einer Variable zuweisen und ausgeben.
        $name ="Peter";

        echo "Ich heiße ";
        echo $name;
        echo "<br>";
        echo "Ich heiße $name"; // bei doppelten Anführungsstrichen wird der Inhalt analysiert und Variablen erkannt.
        echo "<br>";
        echo 'Ich heiße $name'; // Achtung einfache Anführungsstriche ist der Inhalt nur Text!!
        echo "<br>" ;
        echo "Ich heiße " . $name;
        echo "<br>";

        echo "Ich habe". $name."´s Stift";
        echo "<br>";
        echo "Ich habe ($name)´s Stift";
        echo "<br>";
        // mit der {} kann definiert werden, dass es sich um eine Variable handelt und damit kann das s gleich direkt angehängt werden.
        echo "Ich habe {$name}´s Stift"; 
        echo "<br>";
        echo "Ich habe [$name]´s Stift";
        echo "<br>";
        
        // Boolean (Bool)
        $wahr = true;
        echo $wahr; //ausgabe als 1 verarbeitet kann es mit true false werden
        echo "<br>";
        
        $falsch = false; // es erfolgt keine ausgabe
        echo ">".$falsch."<";
        echo "<br>";

        // null: "nichts" oder "undefiniert"
        $nichts = null;
        echo ">".$nichts."<"; // es erfolgt ebenfalls keine ausgabe
        echo "<br>";
        
        // Konstanten: 
        define("datenbank","jwe.mysql.com");
        echo datenbank;
        echo "<br>";
        //neue Schreibweise
        const datenbank2 = "jwe";
        echo datenbank2;
        echo "<br>";
        



    ?>
    
</body>
</html>