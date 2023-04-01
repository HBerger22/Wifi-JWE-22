<?php

/**
 * Diese Blöcke sind Beispiele für "phpDoc" und können mit phpDocumentor verarbeitet werden.
 * Es sollte das Document, die einzelnen klassen, der Variablenbereich, und jede Funktion so einen Block
 */

class Kreis{
/** */
    const PI = 3.1415926535;
    private float $_radius; //private eigenschaften/methoden werden gerne mit _ begonnen

    public function __construct(float $r){
        // $this -> _radius = $r; //diese Zeile wird auch in der Methode set_radius verwendet, daher ist es besser die Methode unten aufzurufen, sollte ein Fehler sein muss ich ihn nur einmal ändern
        $this -> set_radius($r);
    }

    // destruct wird immer aufgerufen am ende des Lebenszyklus: entweder bei Unset() oder Scriptende
    public function __destruct(){
        echo "Kreis mit Radius ". $this->_radius . " wurde zerstört! <br>";
    }

    /** Documentationsblock (DocBlock):
     * Setzt einen neuen Radius für den Kreis (Überschrift)
     * Auch wenn der Kreis bereits existiert und mit einem Radius im Kontruktor
     * befüllt wurde, kann man so einen Radius setzen. (Beschreibung)
     * @param int|float $neuer_radius Der neue Radius der gesetzt werden soll. (Beschreibung der Übergabeparameter)
     * @return void  (hier kein return)
     * @throws Exception 
     */
    public function setRadius(float $neuer_radius) :void { // mit int/float wird eine dementsprechende Übergabevariable vorgeschrieben, sonst kommt eine PHP Fehlermeldung
        if($neuer_radius <=0){
            // wirft eine Exception und der Code wird abgebrochen!
            throw new Exception("Radius muss > 0 sein"); 
        } else {
            $this-> _radius =$neuer_radius;
        }

    }

    public function flaeche() : float {
        return pow($this->_radius,2) * Kreis::PI; //statt Kreis:: kann auch self:: verwendet werden
    }

    /**
     * Berechnet anhand des gegebenen Radius den Umfang des Kreises
     * @return float Der berechnete Umfang des Kreises
     */
    public function umfang():float{ //mit :float definiere ich was zurückgegeben wird. Also der Rückgabewert muss eine Float sein !!!
        return $this->durchmesser() * self::PI;
    }
    
    public function durchmesser():float{
        return $this->_radius*2;
    }


}