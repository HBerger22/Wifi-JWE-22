<?php

class Magic{
    
    // speichert alle Eigenschaften über __set() übergeben werden, die nicht als
    // eigenständige eigenschaften existieren/definiert worden sind.
    private array $_daten = array();


    // Magic methode 1: __set() 
    // hier gehts um Eigenschaften (Variablen)
    // frisst alles was in der Index hineingeschmissen wird.
    // wird von aussen eine Eigenschaft angesprochen/GESETZT die es hier nicht gibt wird
    // sie automatisch über die __set() in das Array $_daten mit dem 
    // Schlüssel Variablennamen $variable und wert $wert gespeichert
    public function __set($variable, $wert){
        $this -> _daten[$variable]=$wert;
    }

    // Magic Methode 2: __get()
    // hier gehts um Eigenschaften (Variablen)
    // wird von aussen eine EIGENSCHAFT VERWENDET, die es hier im Objekt nicht gibt,
    // wird automatisch die __get()-Magic-Methode verwendet
    public function __get($index){
        return $this->_daten[$index];
    }

    // Magic Methode 3: __call()
    // hier gehts um functionen
    // wird von aussen eine METHODE(function) AUFGERUFEN die es hier nicht gibt,
    // wird automatisch die __call() -Magic-Methode verwendet.

    public function __call($methode,$argumenten_array){
        echo "Es wurde die Methode {$methode} aufgerufen. <br>";
        echo "<pre>";
        print_r($argumenten_array);
        echo "</pre>";
    }

    // Magic Methode 4: __toString()
    // Wird ein komplettes Objekt als String verwendet (z.B. mit Echo) so verwendet php 
    // den Rückgabewert der __toString() -Magic-Methode
    // wird öfters zum debuggen verwendet.
    public function __toString(){
        return print_r($this->_daten,true);
        
    }


}