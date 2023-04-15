<?php
namespace WIFI\Fdb;

class Validieren {
    private array $errors = array();

    /**
     * Prüfen ob ein Wert (aus einem Formular) ausgefüllt ist.
     * @param string $wert Der Wert, der auf "ausgefüllt" geprüft werden soll
     * @param string $feldname Name des Formularfeldes für die Fehlermeldung
     * @return bool False wenn $wert leer ist ansonsten true
     */
    public function istAusgefuellt( string $wert, string $feldname): bool {
        if( empty($wert)) {
            $this -> errors[] = "Das Feld ".$feldname." war leer!";
            return false;
        } 
        return true;
    }

    public function fehlerAufgetreten(): bool{
        return !empty($this->errors);  //empty liefert bereits bool deshalb keine if anfrage nicht notwendig      
    }

    public function fehlerHinzu(string $fehlermeldung): void{
        $this -> errors[]=$fehlermeldung;
        return; 
    }

    public function fehlerListeHtml(): string{
        // return implode ("<br>", $this->errors); //ganz kurze Version für die Rückgabe
        if( !$this->fehlerAufgetreten()){ //ist kein Fehler aufgetreten gib nichts zurück
            return "";
        }

        $ret="<ul style='color:red'>"; //style elemente sollten hier nicht sein
        foreach($this->errors as $error){
            $ret.= "<li>{$error}</li>";
        }
        $ret .="</ul>";
        return $ret;
    }
}