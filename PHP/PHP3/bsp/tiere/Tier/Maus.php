<?php
namespace WIFI\JWE\Tier;
// "extends TierAbstract" kopiert alle Eigenschaften und Methoden von der übergeordneten "TierAbstract"
// Klasse (die nicht private sind). Somit hat diese Klasse alle Möglichkeiten des Eltern Objekts

// Wenn eine Methode definiert wird die mit selben Namen und Übergabewerten in der Elternklasse
// bereits existiert, so wird diese überschrieben.
class Maus extends TierAbstract{

    // man könnte auch eine protected Eigenschaft der übergeordneten Klasse überschreiben
    // protected string $name ="dklfjsl";


    // Ich möchte die Methode soweit ändern, das zum Namen auch noch (Maus) dabei steht:
    // Das funktioniert leider in der nachfolgenden überschriebenen Methode leider nicht da
    // die $name in der Elternklasse (TierAbstract) als Private deklariert ist.
    // public function getName():string{
    //     return $this->name ." (Maus)";
    // }

    // abhilfe schafft entweder das ich in der Elternklasse die Variable nicht mehr als Privat sondern als Protected deklariere
    // oder indem ich mit dem Schlagwort Parent:: auf die Methode der Elternklasse zugreife und dann noch (Maus) hinzufüge

    public function getName():string{
        $mausname = parent::getName(); 
        // parant::getName()ruft von der Elternklasse (TierAbstract) die Methode "getName()" auf und wir
        // können den Rückgabewert in unserer überschriebenen Methode weiter verwenden.
        return $mausname ." (Maus)";
    }

    public function gibLaut(): string {
        return "Pieps";
    }
   

}