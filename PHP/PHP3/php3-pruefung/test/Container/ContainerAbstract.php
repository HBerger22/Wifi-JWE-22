<?php
namespace WIFI\Schiff\Container;

use Exception;

abstract class ContainerAbstract {

    protected float $leergewicht;
    protected float $maxNutzlast;
    private float $ladung;

    public function __construct(float $warengewicht){
        if($warengewicht > $this -> maxNutzlast){
            throw new \Exception("Das geladene Gewicht übersteigt die Nutzlast des Containers!");
        }
        $this -> ladung = $warengewicht;
    }

    public function istGewicht (): float {
        return $this -> leergewicht + $this -> ladung;
    }

    public function maxGewicht (): float {
        return $this -> leergewicht + $this -> maxNutzlast;
    }

    public function geladenesGewicht(): float {
        return $this -> ladung;
    }

}
