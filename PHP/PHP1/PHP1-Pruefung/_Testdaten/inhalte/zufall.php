<?php


function zufallspasswort($laenge=8){
    $zeichen = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!?@(){}\/=~$%*-+,_';
    $passwort = "";
    for($i=1; $i<=$laenge;$i++){
        $ind = rand(0,mb_strlen($zeichen)-1);
        $passwort .= $zeichen[$ind];
    }
    return $passwort;
}

?>