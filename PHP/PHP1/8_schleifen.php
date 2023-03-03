<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Grundlagen 08 - Schleifen</title>
</head>
<body>
    <h1>Schleifen </h1>
    <?php
        // While Schleife: 1-10 ausgeben.
        echo "<em><strong>While Schleife: 1-10 soll ausgegeben werden:</strong></em>"; 
        echo "<br>";
        set_time_limit(2); // Prozess endet nach 2 sekunden
        $zahl=1;
        while ($zahl <=10){
            if($zahl<10){
                $t_zahl="0".$zahl;
            } else {
                $t_zahl=$zahl;

            }
            echo $t_zahl;
            $zahl++;
            echo "<br>";
        };
        echo "<br>";

        // Foreach Schleife: Array der Reihe nach ausgeben.
        echo "<em><strong>Foreach Schleife für Arrays:</strong></em>"; 
        echo "<br>";
        echo "<em>Ohne Index:</em><br>";
        $staedte=array("Bregenz","Innsbruck","Salzburg","Klagenfurt","Linz","Graz","St. Pölten","Wien","Eisenstadt");
        foreach($staedte as $stadt){
            echo $stadt ."<br>";
        };
        echo "<br>";

        echo "<em>Mit Index:</em><br>";
        foreach($staedte as $index =>$stadt){
            echo "Index: " . $index . ": ". $stadt . "<br>";
        };
        echo "<br>";

        echo "<em>Mit Index und sortiert (asort(\$staedte)):</em><br>";
        asort($staedte);
        foreach($staedte as $index =>$stadt){
            echo "Index: " . $index . ": ". $stadt . "<br>";
        };
        echo "<br>";

        echo "<em>Mit Index und Index und Wert sortiert (sort(\$staedte)):</em><br>";
        sort($staedte);
        foreach($staedte as $index =>$stadt){
            echo "Index: " . $index . ": ". $stadt . "<br>";
        };





    ?>
    
</body>
</html>