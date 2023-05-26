<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
use WIFI\SK\Model\Row\Speise;
// use WIFI\SK\Model\Row\Kat;
use function WIFI\SK\zwei_kommastellen;

abstract class SGModelAbstract extends ModelAbstract{
    // private array $k_daten =array();


    protected string $sqlAlleAktivenElementeTeil1;
    protected string $sqlAlleAktivenElementeTeil2;    // protected string $sqlAlleAktivenElemente = "SELECT s.speise_id, s.name as sName, s.beschreibung as sBeschreibung, menge, preis, k.name as kName, k.beschreibung as kBeschreibung, k.typ, e.name as eName, e.kuerzel from {$this->tabelle} s, bz_speise_kategorie bz, kategorie k , einheit e where s.aktiv= 1 and s.speise_id=bz.speise_id and bz.aktiv =1 and k.kategorie_id=bz.kategorie_id and k.aktiv=1 and e.einheit_id=bz.einheit_id order by typ, k.reihenfolge, s.name, menge;";

    /** 
     * Liefert alle Aktiven Elemente retour
     * Aktiv bedeutet, daß die SPeise/das Getränk selbst aktiv sein müssen und die Kategorie aktiv sein muss und mindestens 1 aktiver MEP vorhanden sein muss
     * @return false | array false wenn es keine Elemente gibt | Array mit den abgefragten objekten
     */
    public function alleAktivenElemente(): array | false{
        $db_con = Mysql::getInstanz();
        
        $alleElemente = array();
        $result = $db_con -> query($this->sqlAlleAktivenElementeTeil1.$this->tabelle.$this->sqlAlleAktivenElementeTeil2);
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $alleElemente[] = $row;
            }
            return $alleElemente;
        }
    }

    /** 
     * Liefert alle Aktiven Elemente mit Kategorie und MEP (Menge Einheit Preis) daten retour
     * Aktiv bedeutet, daß die Speise/das Getränk selbst aktiv sein müssen und die Kategorie aktiv sein muss und mindestens 1 aktiver MEP vorhanden sein muss
     * @return false | array false wenn es keine Elemente gibt | Array mit den abgefragten objekten
     */// alle Aktiven Elemente inkl. Kategorier und Menge EInheit Preis aufrufen
    public function alleElementeMitKatMep (){
       
        $daten=array();
            $j=0;
            $vorherigeId="-1";
            $alleAktivenElemente=$this->alleAktivenElemente();
            foreach ($alleAktivenElemente as $element){
                if($vorherigeId==$element[$this->tabellenId]){
                    // mep hinzufügen zu $daten-Array
    
                    $mep[]=array(
                        "menge" => zwei_kommastellen($element["menge"]),
                        "eName" => $element["eName"],
                        "eKuerzel" => $element["kuerzel"],
                        "preis" => zwei_kommastellen($element["preis"]) 
                    );
                } else if(!empty($mep)) {
                    // mep(s) in $daten ablegen
                    $daten[$j]["mengeEinheitPreis"]=$mep;
                    $j++;
                    unset($mep);
                }
                $daten[$j]["Name"]=$element["name"];
                $daten[$j]["Beschreibung"]=$element["beschreibung"];
                    
                // Allergene
                    $allergene = new Allergene();
                    $alleAllergene = $allergene -> alleElemente();
                
                    $bzAllergene= new BzAllergene($this->tabelle);
                    $elementAllergene=$bzAllergene->alleElemente($element[$this->tabellenId]);
    
                    $ag=array();
                    foreach ($alleAllergene as $allergen){
                    $vorhanden=false;
                        if($elementAllergene){
                            foreach ($elementAllergene as $elementAllergen){
                                if ($elementAllergen["allergen_id"] == $allergen->getSpalte("allergen_id")){
                                    $vorhanden=true;
                                }
                            }
                        }
                        if ($vorhanden){
                            $aktiv=1; //die speise hat dieses Allergen
                        } else {
                            $aktiv=0;
                        }
                        $ag[]=array(
                            "klasse" => $allergen->getSpalte("klasse"),
                            "name" => $allergen->getSpalte("name"),
                            "beschreibung" => $allergen->getSpalte("beschreibung"),
                            "pBeinhaltetA" => $aktiv
                        );
                        
                    }
                $daten[$j]["allergene"]=$ag;
    
                // Kategorie Einheit Preis Typ 
                $daten[$j]["Typ"] = $element["typ"];
                $daten[$j]["kName"] = $element["kName"];
                $daten[$j]["kBeschreibung"] = $element["kBeschreibung"];
    
                    // $mep=array();
                    if(empty($mep)){
                        $mep[]=array(
                            "menge" => zwei_kommastellen($element["menge"]),
                            "eName" => $element["eName"],
                            "eKuerzel" => $element["kuerzel"],
                            "preis" => zwei_kommastellen($element["preis"]) 
                        );
                    }
    
                    $vorherigeId=$element[$this->tabellenId];
            }
            // mep für letzten Datensatz hinzufügen
            $daten[$j]["mengeEinheitPreis"]=$mep;
            return $daten;
    }

    /** 
     * Liefert alle Produkte (Speise/Getränke) die mindestens 1 Jahr lang nicht aktiviert waren
     * @return false | array false wenn es keine Elemente gibt | Array mit den abgefragten objekten
     */
    public function getProductsInactiveMinOneYear():bool | array{
        $db_con = Mysql::getInstanz();
        
        $alleElemente = array();
        $result = $db_con -> query("SELECT * FROM {$this->tabelle} WHERE DATEDIFF( NOW(), deaktiviert_am ) > 360;");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $alleElemente[] = $row;
            }
            return $alleElemente;
        }
    }
}