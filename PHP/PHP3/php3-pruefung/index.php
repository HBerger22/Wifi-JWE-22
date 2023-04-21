<!DOCTYPE html>
<html>
    <head>
        <title>PHP 3 Praxisprüfung</title>
        <meta charset='utf-8' />
    </head>
    <body>
        <h2>Container testen</h2>

        <?php

        include "test\setup.php";

        use WIFI\Schiff\Container\Container20;
        use WIFI\Schiff\Container\Container40;
        use WIFI\Schiff\Frachtschiff;

        $warengewicht = 12.55;
        // Irgendeinen Container mit $warengewicht erstellen
        // und Ist-Gewicht, sowie maximales Gesamtgewicht ausgeben   

        $cont20 = new Container20($warengewicht);
        echo "<strong>20 Fuß - Container: </strong><br>";
        echo "Ist-Gewicht ist: ".$cont20 -> istGewicht() ."<br>";
        echo "Max-Gesamtgewicht ist: ".$cont20 -> maxGewicht() ."<br>";
        echo "<br>";

        $cont40 = new Container40($warengewicht);
        echo "<strong>40 Fuß - Container: </strong><br>";
        echo "Ist-Gewicht ist: ".$cont40 -> istGewicht() ."<br>";
        echo "Max-Gesamtgewicht ist: ".$cont40 -> maxGewicht() ."<br>";
        echo "<br>";


        ?>


        <h2>Frachtschiff testen</h2>
        <?php
        if (!empty($_POST)) {
            // - Frachtschiff erstellen
            // - Gegebene Anzahl an Container hinzufügen (for-Schleife)
            // - Reisezeit, Anzahl Container, geladenes Gewicht ausgeben

            
            
            $frachtschiff = new Frachtschiff($_POST["geschwindigkeit"]);
            echo "<strong>Frachtschiff 1 geladen mit 20-Fuß Containern</strong><br>";
            echo "Die Reisezeit beträgt ({$_POST["strecke"]} km / {$_POST["geschwindigkeit"]} km/h): ".$frachtschiff -> reisezeit($_POST["strecke"])." Stunden";
            echo "<br>";
            echo "<br>";
            

            for ($i = 1; $i <= $_POST["anzahl_container"]; $i++) {
                // Container dem Schiff hinzufügen
                $frachtschiff -> laden(new container20($_POST["gewicht_container"]));

            }
            
            echo "Anzahl Container: ". $frachtschiff -> anzahlContainer() . " Stk" ;
            echo "<br>";
            
            echo "Geladenes Gesamtgewicht in Tonnen: ". $frachtschiff -> geladenesGewicht();
            echo "<br>";
            echo "<br>";
           

            // echo "<pre>";
            // print_r($frachtschiff);
            // echo "</pre>";
            
            foreach($frachtschiff as $key => $container){
              echo "Geladenes Gewicht im Conainer {$key} :".$container -> geladenesGewicht() ." Tonnen<br>";
            }
            echo "<br>";
            echo "<br>";

            
            
            
            
            
            $frachtschiff2 = new Frachtschiff($_POST["geschwindigkeit"]);
            echo "<strong>Frachtschiff 2 geladen mit 40-Fuß Containern</strong><br>";
            echo "Die Reisezeit beträgt ({$_POST["strecke"]} km / {$_POST["geschwindigkeit"]} km/h): ".$frachtschiff2 -> reisezeit($_POST["strecke"])." Stunden";
            echo "<br>";
            echo "<br>";

            

            for ($i = 1; $i <= $_POST["anzahl_container"]; $i++) {
                // Container dem Schiff hinzufügen
                $frachtschiff2 -> laden(new container40($_POST["gewicht_container"]));

            }
            
            echo "Anzahl Container: ". $frachtschiff2 -> anzahlContainer() . " Stk" ;
            echo "<br>";
            
            echo "Geladenes Gesamtgewicht in Tonnen: ". $frachtschiff2 -> geladenesGewicht();
            echo "<br>";
            echo "<br>";
           

            foreach($frachtschiff2 as $key => $container){
              echo "Geladenes Gewicht im Conainer {$key} :".$container -> geladenesGewicht() ." Tonnen<br>";
            }
            echo "<br>";
            echo "<br>";
        }
        ?>


        <form action='index.php' method='post'>
            <div>
                <label for='geschwindigkeit'>Geschwindigkeit in km/h:</label>
                <input type='number' name='geschwindigkeit' id='geschwindigkeit' min='0.0' max='100.0' step='0.1' value='<?php
                  if (!empty($_POST["geschwindigkeit"])) {
                    echo $_POST["geschwindigkeit"];
                  } else {
                    echo 23;
                  } ?>' />
            </div>
            <div>
                <label for='strecke'>Strecke in km:</label>
                <input type='number' name='strecke' id='strecke' min='0' max='40000' step='1' value='<?php
                  if (!empty($_POST["strecke"])) {
                    echo $_POST["strecke"];
                  } else {
                    echo 4669;
                  } ?>' />
            </div>
            <div>
                <label for='anzahl_container'>Anzahl Container:</label>
                <input type='number' name='anzahl_container' id='anzahl_container' min='0' max='10000' step='1' value='<?php
                  if (!empty($_POST["anzahl_container"])) {
                    echo $_POST["anzahl_container"];
                  } else {
                    echo 8400;
                  } ?>' />
            </div>
            <div>
                <label for='gewicht_container'>Warengewicht je Container:</label>
                <input type='number' name='gewicht_container' id='gewicht_container' min='0.0' max='100.0' step='0.01' value='<?php
                  if (!empty($_POST["gewicht_container"])) {
                    echo $_POST["gewicht_container"];
                  } else {
                    echo 8.64;
                  } ?>' />
            </div>
            <div>
                <button type='submit'>Berechnen</button>
            </div>
        </form>
    </body>
</html>
