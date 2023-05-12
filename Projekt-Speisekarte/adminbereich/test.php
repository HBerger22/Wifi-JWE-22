<?php
$zahl = 123.1;
echo "position 123 : ". strpos("123",",") . "<br>";
echo "länge: ". strlen("123")  . "<br>";
echo "position 123,4 : ". strpos("123,4",",") . "<br>";
echo "länge: ". strlen("123,4")  . "<br>";
echo "position 123,45 : ". strpos("123,45",",") . "<br>";
echo "länge: ". strlen("123,45")  . "<br>";


echo $zahl . "<br>";



echo $zahl . "<br>";

if(strpos($zahl,".")){
    // echo "länge: ". strlen($zahl)." pos: "
    if(strlen($zahl)-strpos($zahl,".")<3){
        $zahl=$zahl."0";
        echo " 0 dazu";
    } else {
        $zahl.="";
    }
    echo "komma da ". "<br>";
} else {
    echo " kein komma ". "<br>";
    echo $zahl.",00". "<br>";
}

// $zahl=strval($zahl);
if(stripos($zahl,".")){}
         $zahl[stripos($zahl,".")]=",";

echo $zahl ."<br>";

$eingabe="12a0";

if (preg_match("/^\d+[\.,]?\d{0,2}?$/", $eingabe)){
    echo "stimmt";
} else {
    echo "falsch";

}

echo "<br><br>";

// "\d+(\.\d{1,2})?$"
// preg_match("/(?=.*[a-zA-Z]+.*){1,}(?=.*\d+.*){1,}(?=.*[@$!%*#?&]+.*){1,}/",$name


include "classes/Model/Row/Kat.php";
include "classes/Mysql.php";
include "config.php";
use WIFI\SK\Model\Row\Kat;

$kat = new Kat(2);
echo "Name: " . $kat -> getSpalte("abeschreibung");
