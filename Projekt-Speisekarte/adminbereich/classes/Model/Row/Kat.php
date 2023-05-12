<?php
namespace WIFI\SK\Model\Row;

// include "../../Mysql.php";
use \Exception;
use WIFI\SK\Mysql;

class Kat extends RowAbstract{ 
    protected string $tabelle = "kategorie";
    protected string $tabellenId = "kategorie_id";
    protected string $beziehung = "bz_speise_kategorie";
   
    // überprüfen ob es noch eine Verknüpfung zu einer Speise gibt.
    // public function existiertVerbindung(): bool{ 
    //     $db = Mysql::getInstanz();
    //     $result = $db -> query("SELECT * FROM `bz_speise_kategorie` where kategorie_id='{$this -> daten["kategorie_id"] }'");
    //     if($result -> num_rows != 0) 
    //         return false; 
    //     else 
    //         return true;
    // }

    // überprüfen ob sich im Datensatz etwas geändert hat (es werden div. werte von 2 Kat objekten miteinander verglichen)
    public function objektVerschieden(kat $ds1){
        
        if (($ds1 -> getSpalte("name") == $this->daten["name"] && $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"] && $ds1 -> getSpalte("typ") == $this->daten["typ"]) || 
        (($ds1 -> getSpalte("name") == $this->daten["name"] || $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"]) && $ds1 -> getSpalte("kategorie_id") != $this->daten["kategorie_id"] )){
            // echo "Fehler kommt von objektVerschieben <br>";
            return true;
        } else {
            return false;
        }   
    }

    // überprüfen ob der Datensatz schon in der DB existiert
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