<?php
//  Klasse definieren, die später als objekt verwendet werden kann
class Person{

    // Eigenschaft (engl. Property) festlegen: Platzhalter für spätere Werte (Wie variablen)
    public $vorname; //public kann von aussen zugegriffen werden
    
    // Private Eigenschaften (oder Methoden) können nur innerhalb der Klasse verwendet werden.
    private $nachname; // private kann von aussen NICHT zugegriffen werden.

    // Konstruktor wird immer beim erzeugen des Objektes aufgerufen, hierhin werden die übergebenen Variablen übergeben und verarbeitet/zugewiesen.
    public function __construct($uebergebene_Variable){
        $this -> nachname = $uebergebene_Variable; 
        // mit This spreche ich die aktuelle klasse an und mit -> die darin enthaltene Variable

    }

    // Methode zum holen des Privaten Nachnamens
    // Ein sogenannter "getter"
    public function get_nachname(){
        return $this -> nachname;
    }

    // Methode zum Ändern des Privaten Nachnamens
    // Ein sogenannter "setter
    public function set_nachname($name_neu){
        $this -> nachname =$name_neu;
        // div. andere Anweisungen zB.: speichern in eine DB,
        // deshalb wird es auf private gesetzt und ich kann den Nachnamen nicht direkt ändern,
        //  sondern ich muss diese Funktion aufrufen und kann damit das Speichern nicht vergessen.
    }

    // Methode zum Ändern des Privaten Nachnamens, allerdings darf es nicht der gleiche name sein sonst kommt eine Fehlermeldung
    public function set_nachname2($name_neu2){
        if($name_neu2 == $this -> nachname){
            // nicht üblich hier ein Echo oder return aufzurufen, dafür gibt es eine andere Möglichkeit, die folgt später
            echo "Der name ist der gleiche und wird nicht geändert! <br>";
        } else {
            $this -> nachname =$name_neu2;
        }
    }

    // Öffentliche Methode (Public) die von aussen angesprochen werden kann.
    public function vorstellen(){
        return "Hallo, ich heiße " . $this -> vorname." ". $this -> nachname;
    }

}