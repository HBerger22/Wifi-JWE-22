<?php
namespace WIFI\SK\Model\Row;


use \Exception;
use WIFI\SK\Mysql;

class Einheit extends RowAbstract{ 
    protected string $tabelle = "einheit";
    protected string $tabellenId = "einheit_id";
    protected string $beziehung = "bz_speise_kategorie";
   
    // überprüfen ob es noch eine Verknüpfung zu einer Speise gibt.
    // public function existiertVerbindung(): bool{ 
    //     $db = Mysql::getInstanz();
    //     $result = $db -> query("SELECT * FROM `bz_speise_kategorie` where einheit_id='{$this -> daten["einheit_id"] }'");
    //     if($result -> num_rows != 0) 
    //         return false; 
    //     else 
    //         return true;
    // }

    /** 
     * Überprüft ob das übergebene Objekt verschieden ist zum eigenen Objekt
     * damit kann überprüft werden ob sich in den übergebenen Daten etwas geändert hat.
     * @param Einheit $ds1 datensatz 1
     * @return bool
     */
    public function objektVerschieden(Einheit $ds1){
        if (($ds1 -> getSpalte("name") == $this->daten["name"] && $ds1 -> getSpalte("kuerzel") == $this->daten["kuerzel"] ) || 
        (($ds1 -> getSpalte("name") == $this->daten["name"] || $ds1 -> getSpalte("kuerzel") == $this->daten["kuerzel"]) && $ds1 -> getSpalte("einheit_id") != $this->daten["einheit_id"] )){
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
        $result = $db -> query(" SELECT * from $this->tabelle where `name` ='{$this -> daten["name"]}' or `kuerzel`='{$this -> daten["kuerzel"]}' ");
        if($result ->num_rows != 0 ){
            return true;
        } else {
            return false;
        }
    }

}