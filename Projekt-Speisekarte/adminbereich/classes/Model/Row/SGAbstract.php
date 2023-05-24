<?php
namespace WIFI\SK\Model\Row;

// include "../../Mysql.php";
use \Exception;
use WIFI\SK\Model\BzEinheit;
use WIFI\SK\Mysql;

abstract class SGAbstract extends RowAbstract{ 

    protected string $beziehungKat = "bz_speise_kategorie";
    protected string $beziehungAllergene = "bz_speise_allergene";
    
    /** 
     * Liefer alle Deteils zu einem Produkt retour (inkl. kategorie mep allergene)
     * notwendig für API 
     * oder liefert False zurück falls es keinen Datensatz dazu gibt
     * @return false | Array
     */
    public function detailsProdukt():bool | array{
        $db = Mysql::getInstanz();
        $result = $db -> query("SELECT s.name, s.beschreibung, s.aktiv, s.speise_id,k.name as kName, k.beschreibung as kBeschreibung, k.typ, bz.menge,  e.name as eName, e.kuerzel, bz.preis FROM `bz_speise_kategorie` bz, speise s , kategorie k, einheit e WHERE bz.einheit_id = e.einheit_id and s.speise_id = {$this->getSpalte($this->tabellenId)} and s.speise_id=bz.speise_id and k.kategorie_id = bz.kategorie_id;");
        if($result ->num_rows != 0 ){
            $daten=array();
            $i=0;
            while ($row = $result -> fetch_assoc()){
                if(empty($daten)){
                    $daten["pId"]=$row["speise_id"];
                    $daten["pName"]=$row["name"];
                    $daten["pBeschreibung"]=$row["beschreibung"];
                    $daten["pAktiv"]=$row["aktiv"];
                    $daten["kName"]=$row["kName"];
                    $daten["kBeschreibung"]=$row["kBeschreibung"];
                    $daten["kTyp"]=$row["typ"];
                    $daten["mep"][$i]["menge"]=$row["menge"];
                    $daten["mep"][$i]["einheit"]=$row["kuerzel"];
                    $daten["mep"][$i]["preis"]=$row["preis"];                    
                } else {
                    $daten["mep"][$i]["menge"]=$row["menge"];
                    $daten["mep"][$i]["einheit"]=$row["kuerzel"];
                    $daten["mep"][$i]["preis"]=$row["preis"];   
                }
                $i++;
            }
            $resulta = $db -> query("SELECT klasse, name FROM `bz_speise_allergene` bz, allergen a WHERE bz.allergen_id = a.allergen_id and bz.speise_id = {$this->getSpalte($this->tabellenId)}");
            if($result ->num_rows != 0 ){
                $j=0;
                while ($row = $resulta -> fetch_assoc()){
                    $daten["allergen"][$j]["klasse"]=$row["klasse"];
                    $daten["allergen"][$j]["name"]=$row["name"];
                    $j++;
                }
            }
            return $daten;
        } else {
            return false;
        }
    }


    /** 
     * Aktiviert oder deaktiviert ein Objekt in der DB inkl. aktuelles Datum für löschung inaktiver Produkte über einen längeren Zeitraum
     * @param int $aktiv Aktiv= 1, Inaktiv = 0
     * @param string $typ speise oder Getränk
     * @return bool
     */
    public function akDeakSpeise(int $aktiv, string $typ): bool {
        $db = Mysql::getInstanz();
        $sqlAktiv = $db -> escape($aktiv);
        $sqlTyp = $db -> escape($typ);
        
        if($sqlAktiv==0){ //deaktivieren
            $db -> query("UPDATE {$this -> tabelle} set aktiv = {$sqlAktiv} , `deaktiviert_am` = CURRENT_DATE where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
            return true;
        }else { //aktivieren
            // Das Produkt darf nur aktiviert werden wenn es eine MEP (Menge/Einheit/Preis) gibt! Macht sonst bei der anzeige keinen Sinn
            $bzMep = new BzEinheit($this -> daten[$this -> tabellenId],$sqlTyp);
            if($bzMep->alleAktivenMepEinerSpeise()){
                $db -> query("UPDATE {$this -> tabelle} set aktiv = {$sqlAktiv} , deaktiviert_am=NULL where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
                return true;
            } else {
                return false;
            }
        }
    }

    /** 
     * Aktiviert oder deaktiviert ein Objekt in der DB 
     * @param int $aktiv Aktiv= 1, Inaktiv = 0
     */
    public function bzLoeschen():void{
        $db = Mysql::getInstanz();
        $db -> query("DELETE FROM {$this->beziehungAllergene} where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
        $db -> query("DELETE FROM {$this->beziehungKat} where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
    }

    /** 
     * Überprüft ob das übergebene Objekt verschieden ist zum eigenen Objekt
     * damit kann überprüft werden ob sich in den übergebenen Daten etwas geändert hat.
     * @param Speise $ds1 datensatz 1
     * @return bool
     */
    public function objektVerschieden(Speise $ds1):bool {
        if ($ds1 -> getSpalte("name") == $this->daten["name"] && $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"] ){
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
        $result = $db -> query(" SELECT * from {$this->tabelle} where `name` ='{$this -> daten["name"]}' or `beschreibung`='{$this -> daten["beschreibung"]}' ");
        if($result ->num_rows != 0 ){
            return true;
        } else {
            return false;
        }
    }
}