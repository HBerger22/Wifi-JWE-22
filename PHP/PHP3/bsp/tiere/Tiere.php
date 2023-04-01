<?php
namespace WIFI\JWE;

use WIFI\JWE\Tier\TierAbstract;


class Tiere implements TiereInterface, \Iterator{

    private array $herde = array(); // statt array() geht auch []


    // Die Typedeklaration (Type-Hint): TierAbstract (kann auch direkt auf ein bestimmtes Objekt eingeschränkt werden)
    // Nur Objekte die vom TierAbstract erben, oder selbst "TierAbstract" sind dürfen
    // als Argument übergeben werden.
    public function add(TierAbstract $tier):void{
        $this->herde[] = $tier;
    }

    public function ausgabe(){
        $ret="";
        foreach($this->herde as $tier){
            $ret .= $tier->getName() ;
            $ret .= " macht " .$tier->gibLaut()."<br>";
        }
        
        return $ret;
    }

    // Code zum einbauen des globalen \Iterator interface
    private int $index=0;

    public function current():mixed{
        return $this->herde[$this->index];
    }

    // wenn foreach verwendet wird verwendet sie die next methode um auf das nächste objekt springen kann und mit current gibt sie es aus
    public function next():void{
        $this->index ++;
    }

    public function key():mixed{
        return $this->index;
    }

    // überprüft ob der index existiert wenn ja = true
    public function valid():bool{
        return isset($this->herde[$this->index]);
    }

    // am ende der foreach muss der Index wieder auf 0 gesetzt werden
    public function rewind():void{
        $this->index = 0;
    }





}