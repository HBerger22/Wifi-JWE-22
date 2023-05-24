<?php
namespace WIFI\SK;


class Validieren {
    private array $fehler = array();

    /** 
     * Überprüft ob ein Feld ausgefüllt wurde
     * @param $formularwert
     * @param $feldName des Formulares
     * @return bool und setzt eine Fehlermeldung in das eigene Array $fehler[]
     */
    public function istAusgefuellt(string $formularwert, string $feldName): bool{
        if(!empty($formularwert)){
            return true;
        } else 
        {
            $this -> fehler[]="Das Feld {$feldName} ist nicht ausgefüllt!";
            return false;
        }
    }

    /** 
     * fügt eine Fehlermeldung zum Objekt dazu
     */
    public function fehlerDazu (string $fehlermeldung): void{
        $this->fehler[]=$fehlermeldung;
    }

    /** 
     * Überprüft ob Fehler aufgetreten sind
     * @return bool wahr wenn Fehler aufgetreten sind
     */
    public function fehlerAufgetreten(): bool {
        return !empty($this->fehler);  
    }

    /** 
     * Liefert die Fehler als array retour
     * @return array
     */
    public function fehlermeldungsArray(): array{
        return $this -> fehler;
    }
    
    /** 
     * liefert die Fehler als HTML formatierten String zurück
     * @return string
     */
    public function fehlerAusgabeHtml (): string {
        if(!$this->fehlerAufgetreten()){
            return "";
        }

        $ret="<ul id='fehler'>";
        foreach($this -> fehler as $meldung){
            $ret .= "<li>{$meldung}</li>";
        }
        $ret.="</ul>";
        return $ret;
    }
}

