<?php
namespace WIFI\SK\Model\Row;


use \Exception;
use WIFI\SK\Mysql;

class Allergen extends RowAbstract{ 
    protected string $tabelle = "allergen";
    protected string $tabellenId = "allergen_id";
    protected string $beziehung = "bz_speise_allergene";
   
    // überprüfen ob es noch eine Verknüpfung zu einer Speise gibt.
    // public function existiertVerbindung(): bool{ 
    //     $db = Mysql::getInstanz();
    //     $result = $db -> query("SELECT * FROM `bz_speise_kategorie` where einheit_id='{$this -> daten["einheit_id"] }'");
    //     if($result -> num_rows != 0) 
    //         return false; 
    //     else 
    //         return true;
    // }

    // überprüfen ob sich im Datensatz etwas geändert hat (es werden div. werte von 2 Kat objekten miteinander verglichen)
    public function objektVerschieden(Allergen $ds1){
        
        // "SELECT * from einheit where (`name` ='{$sql_name}' and `kuerzel`='{$sql_kuerzel}') or 
        //     ((`name` ='{$sql_name}' or `kuerzel`='{$sql_kuerzel}') and `einheit_id`!= {$sql_id} )"

        if (($ds1 -> getSpalte("name") == $this->daten["name"] && $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"] && $ds1 -> getSpalte("klasse") == $this->daten["klasse"]) || 
        (($ds1 -> getSpalte("name") == $this->daten["name"] || $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"]) && $ds1 -> getSpalte("allergen_id") != $this->daten["allergen_id"] )){
            // echo "Fehler kommt von objektVerschieben <br>";
            return true;
        } else {
            return false;
        }   
    }

    // // überprüfen ob der Datensatz schon in der DB existiert
    public function datensatzExistiertBereits(): bool{
        
        $db = Mysql::getInstanz();
        $result = $db -> query(" SELECT * from $this->tabelle where `name` ='{$this -> daten["name"]}' or `klasse`='{$this -> daten["klasse"]}' or `beschreibung`='{$this -> daten["beschreibung"]}' ");
        if($result ->num_rows != 0 ){
            // echo "Fehler kommt von datensatzExistiertBereits <br>";
            return true;
        } else {
            return false;
        }
    }

    public function existiertVerbindungZuSpeise(int $speiseId):bool {
        $db = Mysql::getInstanz();
        $result = $db -> query(" SELECT * from {$this->beziehung} where `speise_id`=$speiseId and `allergen_id`= {$this->daten["allergen_id"]}");
        if($result ->num_rows != 0 ){
            return true;
        } else {
            return false;
        }
    }

    public function verbindungSpeichern(int $speiseId, bool $aktiv):void{
        $db = Mysql::getInstanz();
        $sqlSpeiseId=$db->escape($speiseId);
        if($aktiv){ //aktiv und Verbindungseintrag existiert nicht --> Eintrag in Beziehungstabelle erstellen
            if(!$this->existiertVerbindungZuSpeise($speiseId)){
                $db->query ("INSERT INTO {$this -> beziehung} SET `speise_id`= '{$sqlSpeiseId}', `allergen_id`= '{$this->daten["allergen_id"]}';"); //{$this->tabelle}
            }
        } else { //inaktiv und verbindungseintrag existiert --> löschen des Eintrages
            if($this->existiertVerbindungZuSpeise($speiseId)){
                $db->query ("DELETE FROM {$this -> beziehung} where `speise_id`= '{$sqlSpeiseId}' and `allergen_id`= '{$this->daten["allergen_id"]}';"); //{$this->tabelle}
            }
        }
        

    }

    

}