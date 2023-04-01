<?php

class Statisch{

    // eine statische Eigenschaft gehört zur EINMAL Klasse und nicht zu den erstellten
    // Objekten. Dadurch bleibt die Eigenschaft über die gesamte Laufzeit bestehen.
    public static int $aufrufe=0; 

    public function __construct(){
        // da die Variable static ist muss sie wie die Klasse mit self:: (oder hier Statisch::) aufgerufen werden
        // sie wird damit pro aufgerufenem Objekt um 1 erhöht
        self::$aufrufe +=1; 
        
    }


    // Diese Statische Methode wird auch direkt der Klasse zugeordnet und muss daher von Aussen über den 
    // Klassennamen aufgerufen werden (hier: Statisch::setze_0) und kann nicht über $this zugegriggen werden.
    // Sie ist nicht teil der daraus entstandenen Objekte.
    public static function setze_0(){
        self::$aufrufe=0;
    }
    
    
    
    
    public function mach_etwas(){

    }
}