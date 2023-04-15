<?php
namespace WIFI\Fdb\Model\Row;

use Exception;
use WIFI\Fdb\Mysql;

abstract class RowAbstract {
    protected string $tabelle;
    private array $daten = array();

    public function __construct(int|array $idOderDaten){
        if(is_int($idOderDaten) ){ //is_numeric
            // id wurde übergeben, Daten aus DB auslesen.
            $db = Mysql::getInstanz();
            $sql_id = $db->escape($idOderDaten);
            $result = $db->query("SELECT * from {$this->tabelle} where id = '{$sql_id}'");
            $this -> daten = $result->fetch_assoc();
        } else {
            // Fertiges Array wurde übergeben, verwenden wie gegeben.
            $this -> daten = $idOderDaten;
        }
    }

    // magic Method um direkt auf die Spaltennamen zuzugreifen
    public function __get(string $spaltenname): mixed{
        if( !array_key_exists($spaltenname,$this -> daten) ){
            throw new \Exception("Die Spalte {$spaltenname} existiert nicht");
        }
        return $this -> daten[$spaltenname];
    }

    public function entfernen(): void {
        $db = Mysql::getInstanz();
        $sql_id = $db->escape($this->id);
        $db->query("DELETE FROM {$this->tabelle} where id ='{$sql_id}'");
    }

    public function speichern(): void {
        $db = Mysql::getInstanz();

        $sqlFelder="";
        foreach($this->daten as $spaltenname => $formularwert){
            if($spaltenname == "id"){
                continue;
            }
            $sqlFormularwert = $db->escape($formularwert);
            $sqlFelder.=" {$spaltenname} = '{$sqlFormularwert}',";
        }
        // letztes Komma entfernen
        $sqlFelder = rtrim($sqlFelder," ,");


        if($this->daten["id"] == null){
            // neuen Datensatz speichern
            $db->query ("INSERT INTO {$this->tabelle} SET {$sqlFelder} ");

        } else {
            // bestehenden Datensatz ändern
            $sql_id= $db->escape($this->daten["id"]);
            $db->query ("UPDATE {$this->tabelle} SET {$sqlFelder} where id = '{$sql_id}'");
        }

        // echo "<pre>"; print_r($this->daten); echo "</pre>";
        // die($sqlFelder);
    }
}