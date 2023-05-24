<?php
namespace WIFI\SK\Model\Row;


use \Exception;
use WIFI\SK\Mysql;

class Allergen extends RowAbstract{ 
    protected string $tabelle = "allergen";
    protected string $tabellenId = "allergen_id";
    protected string $beziehung = "bz_speise_allergene";
    private string $objektId; //datenbank feld getränk_id oder speise_id
   
    /** 
     * Setzen des Datenbankfeldes für die Objekt ID 
     * folgende werte sind möglich speise_id oder getraenk_id
     * @param string $objektId speise_id oder Getraenk_id
     */
    public function setTyp(string $objektId){
        $db = Mysql::getInstanz();
        $sqlObjektId=$db->escape($objektId);
        $this->objektId= $db->escape($sqlObjektId);
    }

    /** 
     * Überprüft ob das übergebene Objekt verschieden ist zum eigenen Objekt
     * damit kann überprüft werden ob sich in den übergebenen Daten etwas geändert hat.
     * @param Allergen $ds1 datensatz 1
     * @return bool
     */
    public function objektVerschieden(Allergen $ds1){
        if (($ds1 -> getSpalte("name") == $this->daten["name"] && $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"] && $ds1 -> getSpalte("klasse") == $this->daten["klasse"]) || 
        (($ds1 -> getSpalte("name") == $this->daten["name"] || $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"]) && $ds1 -> getSpalte("allergen_id") != $this->daten["allergen_id"] )){
            // echo "Fehler kommt von objektVerschieben <br>";
            return true;
        } else {
            return false;
        }   
    }

    /** 
     * Überprüft ob dieses Objekt schon als Datensatz in der DB existieren
     * @return bool
     */
    public function datensatzExistiertBereits(): bool{
        $db = Mysql::getInstanz();

        $result = $db -> query(" SELECT * from $this->tabelle where `name` ='{$this -> daten["name"]}' or `klasse`='{$this -> daten["klasse"]}'  "); //or `beschreibung`='{$this -> daten["beschreibung"]}'
        if($result ->num_rows != 0 ){
            // echo "Fehler kommt von datensatzExistiertBereits <br>";
            return true;
        } else {
            return false;
        }
    }

    /** 
     * Überprüft ob das jeweilige Objekt eine Verbindung zur Speise/n oder Getränke/n hat
     * wenn es einen eintrag in der Beziehungstabelle mit der übergebenen objekt_ID gibt
     * @param int $objektId
     * @return bool
     */
    public function existiertVerbindungZuSpeise(int $produktId):bool {
        $db = Mysql::getInstanz();
        $sqlproduktId=$db->escape($produktId);
        $result = $db -> query(" SELECT * from {$this->beziehung} where `{$this->objektId}`=$sqlproduktId and `allergen_id`= {$this->daten["allergen_id"]}");
        if($result ->num_rows != 0 ){
            return true;
        } else {
            return false;
        }
    }

    /** 
     * Speichern der Beziehung zum Produkt in der Beziehungstabelle
     * wenn es einen eintrag in der Beziehungstabelle mit der übergebenen objekt_ID gibt
     * @param int $objektId 
     * @param bool $aktiv wenn aktiv wird ein eintrag erstellt, wenn inaktiv wird der bestehende eintrag gelöscht
     * @return bool
     */
    public function verbindungSpeichern(int $produktId, bool $aktiv):void{
        $db = Mysql::getInstanz();
        $sqlproduktId=$db->escape($produktId);
        if($aktiv){ //aktiv und Verbindungseintrag existiert nicht --> Eintrag in Beziehungstabelle erstellen
            if(!$this->existiertVerbindungZuSpeise($produktId)){
                $db->query ("INSERT INTO {$this -> beziehung} SET `{$this->objektId}`= '{$sqlproduktId}', `allergen_id`= '{$this->daten["allergen_id"]}';"); //{$this->tabelle}
            }
        } else { //inaktiv und verbindungseintrag existiert --> löschen des Eintrages
            if($this->existiertVerbindungZuSpeise($produktId)){
                $db->query ("DELETE FROM {$this -> beziehung} where `{$this->objektId}`= '{$sqlproduktId}' and `allergen_id`= '{$this->daten["allergen_id"]}';"); //{$this->tabelle}
            }
        }
    }
}