<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP - Grundlagen 05 - Funktionen</title>
</head>
<body>
    <h1>Funktionen für Strings (Zahlen)</h1>
    <?php
        $text = " Ää   <strong>Das ist irgendein</strong> text der jetzt <em>formatiert</em> werden soll. ";
        echo $text;
        echo "<br>";
        // String in kleinbuchstaben umwandeln
        echo "strtolower: <br>" . strtolower($text);
        // diese funktion arbeitet nur mit 1 Byte das "Ä" ist aber ein 2 Byte zeichen deshalb gibt es die mb (MultiByte Variante)
        echo "<br>";
        echo "mb_strtolower: <br>" . mb_strtolower($text);
        echo "<br>";
        echo "strtoupper(text): <br>" . strtoupper($text);
        echo "<br>";
        echo "mb_strtoupper(text): <br>" . mb_strtoupper($text);
        echo "<br>";echo "<br>";

        // text trimmen / kürzen praktisch für Leerzeichen am Anfang/ende
        echo "trim( text,'.l ')".trim($text, ".ldo ");
        echo "<br>";echo "<br>";

        // HTML Tags aus einen String entfernen
        echo "stip_tags(text): " . strip_tags($text);
        echo "<br>";echo "<br>"; //oder mit erlaubte tags
        echo "stip_tags(text, 'strong'): ". strip_tags($text,"<strong>"); //strip_tags($text,"<strong><em>");
        echo "<br>";echo "<br>";

        // stringlänge
        $text2 = "Übung";
        echo "strlen(text) Das Wort '<strong>" . $text2 . "</strong>': hat ". strlen($text2);
        echo " Zeichen !!!??? //Achtung Umlaut Ü hat 2 byte<br>";
        echo "mb_strlen(text) " . $text2 . ": ". mb_strlen($text2)." Jetzt stimmts !!!";
        echo "<br>";echo "<br>";

        // substr: teil eines Strings extrahieren
        $text = "Ich bin 43 Jahre alt. //Extrahiere 43 raus";
        echo $text; echo "<br>";
        echo "substr(text, 8,2): " . substr($text,8,2);
        echo "<br>";echo "<br>";

        // newlines zu <br> umwandeln
        $text = "Ich bin 43 Jahre alt. \n und das ist echt
         schlimm.";
        echo $text . "<br>";
        echo "nl2br(text): <br>". nl2br($text);
        echo "<br>";echo "<br>";

        // round runden von Zahlen
        $zahl=123.45;
        echo "Zahl: ".$zahl . " auf eine Ganzzahl runden<br>";
        echo "round(zahl): ". round($zahl) . "<br>";

        $zahl=123.45;
        echo "Zahl: ".$zahl . " auf 1 Kommastelle runden<br>";
        echo "round(zahl,1): ". round($zahl,1) . "<br>";
        echo "<br>";






        
    ?>
    
</body>
</html>