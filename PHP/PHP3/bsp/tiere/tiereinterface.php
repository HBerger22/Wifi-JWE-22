<?php
namespace WIFI\JWE;

use WIFI\JWE\Tier\TierAbstract;

interface TiereInterface{

    public function add( TierAbstract $tier):void;
}

// Ein "interface" gibt einen Bauplan für eine Klasse vor. Wenn eine Klasse
// dieses Interface implementiert, MUSS die Klasse alle hier enthaltenen 
// Methoden einbauen.