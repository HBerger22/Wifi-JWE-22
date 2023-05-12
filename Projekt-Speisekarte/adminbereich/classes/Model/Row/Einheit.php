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

    // überprüfen ob sich im Datensatz etwas geändert hat (es werden div. werte von 2 Kat objekten miteinander verglichen)
    public function objektVerschieden(Einheit $ds1){
        
        // "SELECT * from einheit where (`name` ='{$sql_name}' and `kuerzel`='{$sql_kuerzel}') or 
        //     ((`name` ='{$sql_name}' or `kuerzel`='{$sql_kuerzel}') and `einheit_id`!= {$sql_id} )"

        if (($ds1 -> getSpalte("name") == $this->daten["name"] && $ds1 -> getSpalte("kuerzel") == $this->daten["kuerzel"] ) || 
        (($ds1 -> getSpalte("name") == $this->daten["name"] || $ds1 -> getSpalte("kuerzel") == $this->daten["kuerzel"]) && $ds1 -> getSpalte("einheit_id") != $this->daten["einheit_id"] )){
            // echo "Fehler kommt von objektVerschieben <br>";
            return true;
        } else {
            return false;
        }   
    }

    // // überprüfen ob der Datensatz schon in der DB existiert
    public function datensatzExistiertBereits(): bool{
        
        $db = Mysql::getInstanz();
        $result = $db -> query(" SELECT * from $this->tabelle where `name` ='{$this -> daten["name"]}' or `kuerzel`='{$this -> daten["kuerzel"]}' ");
        if($result ->num_rows != 0 ){
            // echo "Fehler kommt von datensatzExistiertBereits <br>";
            return true;
        } else {
            return false;
        }
    }

}