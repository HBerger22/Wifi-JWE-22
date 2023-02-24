<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Grundlagen 03 - Variablen Arrays</title>
</head>
<body>
    <h1>Arrays</h1>    
    <?php
        // Numerisches Array mit index 0, 1, 2, ...
        $daten = array("Hallo",123,"Welt",3.1); // Ausgabe "Welt und Hallo"
        echo $daten[2] ." und ". $daten[0];
        echo "<br>"; //oder
        echo "$daten[2] und $daten[0]";
        echo "<br>";

        //Wert anhängen
        echo"<pre>"; //print_r Inhalt aus einem Array darstellen (nur zum debuggen)
        print_r($daten);
        echo "</pre>";

        $daten[]= "Mario";

        echo"<pre>";
        print_r($daten);
        echo "</pre>";

        $x = 3;
        echo $daten[$x]; //index 3 ausgeben
        echo "<br>";

        echo $daten[$x+1]; //index 3+1 = 4 ausgeben
        echo "<br>";

        // Assoziatives Array mit namen als Index
        $personen =array(
            "name" => "Markus",
            "alter" => 63,
            "ort" => "Salzburg"
        );

        // Ausgabe Markus (63) aus Salzburg
        echo $personen['name'] . " (" . $personen['alter'] . ")  aus {$personen['ort']}"; 
        // entweder mit . verbinden, oder es müssen durch die einfachen Hochkoma die Variable in {} gesetzt werden
        echo "<br>";

        // Wert ändern
        $personen["name"] = "Hubert";
        echo $personen['name'];

        // Wert hinzufügen
        $personen["guthaben"] = 123.65;
        $personen[] = 123.65; //hier würde der wert 123,65 mit index "0" hinzugefügt (saudeppad)
        echo "<br><br> Mehrdimensionales Array<br>";

        // mehrdimensionales Array (verschachteltes Array)
        $mehrdimensional =array(
            array(
                "name" => "Markus",
                "alter" => 63,
                "ort" => "Salzburg"
            ),
            array(
                "name" => "Fritz",
                "alter" => 28,
            ),
            array(
                "name" => "Manuel",
                "alter" => 48,
                "ort" => "Bischofshoven"
            ),
            $personen // es kann auch eine komplette variable in ein Array gesetzt werden. wenn jetzt die Variable $Personen geändert wird der Wert im Array $mehrdimensional NICHT geändert!!!
        );

        echo $mehrdimensional[3]["name"];   //Hubert
        $personen["name"] = "Sarah";
        echo "<br>";
        echo $mehrdimensional[3]["name"];   //Hubert
        echo $personen["name"];             //Sarah

        echo"<pre>";
        print_r($mehrdimensional);
        echo"</pre>";
        echo $mehrdimensional[0]["ort"];
    ?>



</body>
</html>