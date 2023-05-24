<?php
namespace WIFI\SK\Model\Row;

// include "../../Mysql.php";
use \Exception;
use WIFI\SK\Mysql;

class Kat extends RowAbstract{ 
    protected string $tabelle = "kategorie";
    protected string $tabellenId = "kategorie_id";
    protected string $beziehung = "bz_speise_kategorie";
   
    /** 
     * Liefert alle zugehörigen Produkte einer Kategorie als Array zurück oder False wenn keine Produkte vorhanden sind
     * @return false | array
     */
    public function zugehoerigeProdukte():bool | array{
        $db = Mysql::getInstanz();
        $result = $db -> query("SELECT s.name, s.beschreibung, s.aktiv, k.kategorie_id,k.name as kName, k.beschreibung as kBeschreibung, k.typ FROM `bz_speise_kategorie` bz, speise s , {$this->tabelle} k 
            WHERE bz.kategorie_id = {$this->getSpalte($this->tabellenId)} and s.speise_id=bz.speise_id and k.kategorie_id = bz.kategorie_id group by s.speise_id;");
        if($result->num_rows == 0){
            return false;
        } else {
            $alleElemente = array();
            $i=0;
            while ($row = $result -> fetch_assoc()){
            
                $alleElemente[$i]["k_id"] = $row["kategorie_id"]; 
                $alleElemente[$i]["kName"] = $row["kName"]; 
                $alleElemente[$i]["kBeschreibung"] = $row["kBeschreibung"]; 
                $alleElemente[$i]["typ"] = $row["typ"]; 
                $alleElemente[$i]["pName"] = $row["name"]; 
                $alleElemente[$i]["pBeschreibung"] = $row["beschreibung"]; 
                $alleElemente[$i]["pAktiv"] = $row["aktiv"]; 
                
                $i++;
            }
            return $alleElemente;
        }
    }
    
    /** 
     * Überprüft ob die übergebene ID bereits existiert
     * @param int Kategorie ID
     * @return bool
     */
    public function idExistiert(int $id):bool{
        $db = Mysql::getInstanz();
        $sqlId =$db -> escape($id);
        $result = $db -> query(" SELECT * from kategorie where {$this->tabellenId}= {$sqlId}");
        if($result ->num_rows != 0 ){
            return true;
        } else {
            return false;
        }
    }


    /** 
     * Überprüft ob das übergebene Objekt verschieden ist zum eigenen Objekt
     * damit kann überprüft werden ob sich in den übergebenen Daten etwas geändert hat.
     * @param Kat $ds1 datensatz 1
     * @return bool
     */
    public function objektVerschieden(Kat $ds1){
        if (($ds1 -> getSpalte("name") == $this->daten["name"] && $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"] && $ds1 -> getSpalte("typ") == $this->daten["typ"]) || 
        (($ds1 -> getSpalte("name") == $this->daten["name"] || $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"]) && $ds1 -> getSpalte("kategorie_id") != $this->daten["kategorie_id"] )){
            // echo "Fehler kommt von objektVerschieben <br>";
            return true;
        } else {
            return false;
        }   
    }

    /** 
     * Überprüft ob dieses Objekt schon als Datensatz in der DB existiert
     * @return bool
     */
    public function datensatzExistiertBereits(): bool{
        $db = Mysql::getInstanz();
        $result = $db -> query(" SELECT * from kategorie where `name` ='{$this -> daten["name"]}' or `beschreibung`='{$this -> daten["beschreibung"]}' ");
        if($result ->num_rows != 0 ){
            // echo "Fehler kommt von datensatzExistiertBereits <br>";
            return true;
        } else {
            return false;
        }
    }

}