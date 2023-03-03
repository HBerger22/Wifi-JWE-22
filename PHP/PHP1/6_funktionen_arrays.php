<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Grundlagen 06 - Arrays</title>
</head>
<body>
    <h1>Funktionen für Arrays</h1>
    <?php
        // Elemente im Array zählen
        echo "<strong>Anzahl der Elemente im Array: </strong><br>";
        $namen =["Max","Anna","Christian","Moritz","Maria","Max","Franz"];
        echo "count(array): ".count($namen);
        echo "<br>";echo "<br>";

        // zufälliger Arrayindex
        echo "<strong>Zufälligen Indes eines Arrays ausgeben: </strong><br>";
        $zufall=array_rand($namen);
        echo "array_rand(array): ". $zufall ."<br>";
        echo "Passender Name dazu: ". $namen[$zufall]; //$namen[array_rand($namen)]
        echo "<br>";echo "<br>";

        // Doppelte Wert aus einem Array entfernen (indexe bleiben erhalten --> es entstehen lücken)
        echo "<strong>Doppelte Werte löschen: </strong><br>";
        echo "array_unique(array): <br> <em>Achtung indexe bleiben gleich !!! </em>";
        echo"<pre>";
        print_r($namen);
        echo "</pre>";

        $eindeutig=  array_unique($namen);
        echo"<pre>";
        print_r($eindeutig);
        echo "</pre>";
        echo "<br>";echo "<br>";

        // Prüfen ob in einem Array ein bestimmter Wert existiert
        echo "<strong>Prüfen ob ein spezieller Wert bereits im Array vorkommt: </strong><br>";
        $gname="Christian";
        echo "in_array(was,array): >" . in_array($gname,$namen) . "< <br> <em>Achtung es kommt ein Bool retour, also '1' oder 'nichts' als ausgabe !!! </em><br>";
        
        if (in_array($gname,$namen) == true){
            echo "$gname existiert im Array";
        } else {
            echo "$gname existiert noch nicht im Array";
        };
        echo "<br>";echo "<br>";

        // ein array alphabetisch aufsteigend sortieren, achtung indexe bleiben gleich.
        echo "<strong>Ein Array Alphabetisch aufsteigend sortieren </strong><br>";
        echo "asort(array): <br> <em>Achtung indexe bleiben gleich !!! </em>";
        asort($eindeutig);
        echo"<pre>";
        print_r($eindeutig);
        echo "</pre>";

        // Elemente anhängen
        echo "<strong>Elemente hinzufügen  </strong><br>";
        echo "array[]='Wert': oder <br> ";
        echo "array_push(array, 'Wert1', 'Wert2', ...): <br> ";
        $eindeutig[] = "Sebastian";
        array_push($eindeutig,"Sybille", "Heidi");
        echo"<pre>";
        print_r($eindeutig);
        echo "</pre>";

        // ein array alphabetisch aufsteigend sortieren, achtung indexe werden neu vergeben
        echo "<strong>Ein Array Alphabetisch aufsteigend sortieren </strong><br>";
        echo "sort(array): <br> <em>Achtung indexe werden neu vergeben !!! </em>";
        sort($eindeutig);
        echo"<pre>";
        print_r($eindeutig);
        echo "</pre>";

    ?>
    
</body>
</html>
