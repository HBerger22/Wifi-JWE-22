<?php
namespace WIFI\Schiff;

use WIFI\Schiff\Container\Container20;
use WIFI\Schiff\Container\Container40;

class Frachtschiff implements \Iterator{
    private float $reiseGeschwindigkeit;
    private array $geladeneContainer=array();

    public function __construct(float $geschwindigkeit) {
        $this -> reiseGeschwindigkeit = $geschwindigkeit;
    }

    public function reisezeit(float $strecke): float{
        return $strecke / $this -> reiseGeschwindigkeit;
    }

    public function laden(Container20|Container40 $container): void{
        $this -> geladeneContainer[]=$container;
    }

    public function geladenesGewicht():float{
        $gewicht=0;
        foreach ($this -> geladeneContainer as $container){
            $gewicht += $container -> geladenesGewicht();
        }
        return $gewicht;
    }

    public function anzahlContainer(): int{
        if ($this->geladeneContainer[0] instanceof Container20){
            return count($this -> geladeneContainer); 
        } else {
            return count($this -> geladeneContainer)*2; 
        }

        
            
    }




    // Iterator
    private int $index=0;

    public function current():mixed{
        return $this->geladeneContainer[$this->index];
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
        return isset($this->geladeneContainer[$this->index]);
    }

    // am ende der foreach muss der Index wieder auf 0 gesetzt werden
    public function rewind():void{
        $this->index = 0;
    }

}