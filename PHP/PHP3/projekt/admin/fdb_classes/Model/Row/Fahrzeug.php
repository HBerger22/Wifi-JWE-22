<?php
namespace WIFI\Fdb\Model\Row;



class Fahrzeug extends RowAbstract{
    protected string $tabelle = "fahrzeuge";

    public function marke(): Marke{
        return new Marke($this -> marken_id);
    }

}