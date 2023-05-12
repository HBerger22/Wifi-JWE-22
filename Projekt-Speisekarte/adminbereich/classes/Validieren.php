<?php
namespace WIFI\SK;


class Validieren {
    private array $fehler = array();

    public function istAusgefuellt(string $formularwert, string $feldName): bool{
        if(!empty($formularwert)){
            return true;
        } else 
        {
            $this -> fehler[]="Das Feld {$feldName} ist nicht ausgefüllt!";
            return false;
        }
    }

    public function fehlerDazu (string $fehlermeldung): void{
        $this->fehler[]=$fehlermeldung;
    }

    public function fehlerAufgetreten(): bool {
        return !empty($this->fehler);  
    }

    public function fehlermeldungsArray(): array{
        return $this -> fehler;
    }
    
    public function fehlerAusgabeHtml (): string {
        if(!$this->fehlerAufgetreten()){
            return "";
        }

        $ret="<ul>";
        foreach($this -> fehler as $meldung){
            $ret .= "<li>{$meldung}</li>";
        }
        $ret.="</ul>";
        return $ret;
    }
}

