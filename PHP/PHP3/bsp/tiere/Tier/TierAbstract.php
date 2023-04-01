<?php
// eigener namensraum für das Projekt, bzw. diese Klasse.
// wird verwendet um gleich benannte Klassen in verschiedenen Projekten zu erlauben
namespace WIFI\JWE\Tier; //namespace Firmenname\Projekt\Verzeichnis


//abstract bedeutet es handelt sich nur um eine Basisklasse aus der kein Objekt erzezugt werden kann!!
abstract class TierAbstract{ 

    // Sichtbarkeits-Modifikatoren:
    // public:      kann von innen und außen (index.php) gelesen und geändert werden.
    // protected:   kann nur von innen und den Kindklassen gelesen und geändert werden
    // private:     kann nur in der Klasse gelesen und geändert werden in der sie erzeugt wurde.
    private string $name;

    // readonly (seit PHP 8.1): Eigenschaft kann nur 1x im constructor gesetzt werden, danach ist sie wie eine Konstante
    // private readonly string $geb_datum;


    // private string $vorname; siehe auskommentierten constructor, kann direkt dort definiert werden

    // seit kurzem kann ich die "Contructor Promotion" (seit php8.0) verwenden, 
    // d.h. ich definiere keine eigenschaften mehr oben sondern direkt im constructor
    // 
    // public function __construct(private string $vorname){
    //     $this->name=$tiername;
    // }    
    
    // namespaces = Namensräume


    
    public function __construct(string $tiername ){// ,string $datum
        $this->name=$tiername;
        // $this->geb_datum=$datum;
    }

    public function getName() : string {
        return $this->name;
    }

    abstract public function gibLaut() : string; 
    // abstracte methoden haben keinen Body {} bereich und müssen in jeder Kindklasse ausprogrammiert werden.

    // mit "final" darf keine Kindklasse diese Methode überschreiben
    public final function laufen(){
        
    }


}