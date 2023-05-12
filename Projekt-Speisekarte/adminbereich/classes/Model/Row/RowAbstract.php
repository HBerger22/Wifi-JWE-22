<?php
namespace WIFI\SK\Model\Row;

// include "../../Mysql.php";
use Exception;
use mysqli;
use WIFI\SK\Mysql;

class RowAbstract {
    protected array $daten = array();
    protected string $tabelle;
    protected string $tabellenId;
    protected string $beziehung;

    public function __construct (int | array $idOderArray){
        $db = Mysql::getInstanz();
        if(is_int($idOderArray)){
            $sqlIndex =$db -> escape($idOderArray);
            // echo "SELECT * from {$this -> tabelle} where {$this -> tabellenId} = {$sqlIndex}";
            $result = $db -> query ("SELECT * from {$this -> tabelle} where {$this -> tabellenId} = {$sqlIndex}");
            if($result->num_rows == 0){
                throw new \Exception("Der Index {$sqlIndex} existiert nicht in der Datenbank");
            }
            $this -> daten = $result -> fetch_assoc();
        } else {
            // foreach($idOderArray as $key => $daten){ //alle arrayeingaben escapen
            //     if($key == "$this -> tabellenId"){
            //         continue;
            //     }
            //     $idOderArray[$key] = $db -> escape($daten);
            // }
            $this -> daten = $idOderArray;
        }
    }

    public function getSpalte (string $spaltenname):mixed{
        if(!array_key_exists($spaltenname, $this->daten)){
            throw new \Exception("Der Spaltenname '{$spaltenname}' existiert nicht");
        } 
        return $this->daten[$spaltenname];
    }   
    
    public function datensatzLoeschen (): void{
        $db = Mysql::getInstanz();
        // echo "DELETE FROM {$this -> tabelle} where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}";
        $db -> query("DELETE FROM {$this -> tabelle} where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
    }

    public function akDeak(int $aktiv):void  {
        $db = Mysql::getInstanz();
        $sqlAktiv = $db -> escape($aktiv);
        $db -> query("UPDATE {$this -> tabelle} set aktiv = {$sqlAktiv} where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
    }

    // überprüfen ob es noch eine Verknüpfung zu einer Speise gibt.
    public function existiertVerbindung(): bool{ 
        $db = Mysql::getInstanz();
        $result = $db -> query("SELECT * FROM `{$this -> beziehung}` where {$this -> tabellenId}='{$this -> daten["{$this -> tabellenId}"] }'");
        if($result -> num_rows != 0) 
            return false; 
        else 
            return true;
    }

    public function speichern():int{
        $db = Mysql::getInstanz();

        $sqlFelder="";
        foreach($this -> daten as $key => $wert) {
            if($key == "{$this -> tabellenId}"){
                continue;
            }
        
            $sqlFormularwert = $db->escape($wert);
            $sqlFelder.=" {$key} = '{$sqlFormularwert}',";         
        }
        // letztes Komma entfernen
        $sqlFelder = rtrim($sqlFelder," ,"); 
        // $db -> query("UPDATE $this -> tabelle set `name`='{$this -> daten["name"]}', `beschreibung`='{$this -> daten["beschreibung"]}', `aktiv` = '{$this -> daten["aktiv"]}' , `typ` = '{$this -> daten["typ"]}' where `kategorie_id`= {$this -> daten["kategorie_id"]}; ");

        if($this->daten["{$this -> tabellenId}"] == null){
            // neuen Datensatz speichern
            $db->query ("INSERT INTO {$this -> tabelle} SET {$sqlFelder} "); //{$this->tabelle}
            return $db->lastId();

        } else {
            // bestehenden Datensatz ändern
            $sql_id= $db->escape($this->daten["{$this -> tabellenId}"]);
            $db->query ("UPDATE {$this -> tabelle} SET {$sqlFelder} where {$this -> tabellenId} = '{$sql_id}'"); //{$this->tabelle}
            return $this-> getSpalte($this->tabellenId) ;
        }
        
    }

    // // überprüfen ob sich im Datensatz etwas geändert hat (es werden div. werte von 2 Kat objekten miteinander verglichen)
    // public function objektVerschieden(Kat|Einheit $ds1){
        
    //     if (($ds1 -> getSpalte("name") == $this->daten["name"] && $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"] && $ds1 -> getSpalte("typ") == $this->daten["typ"]) || 
    //     (($ds1 -> getSpalte("name") == $this->daten["name"] || $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"]) && $ds1 -> getSpalte("{$this -> tabellenId}") != $this->daten["{$this -> tabellenId}"] )){
    //         // echo "Fehler kommt von objektVerschieben <br>";
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // // überprüfen ob der Datensatz schon in der DB existiert
    // public function datensatzExistiertBereits(): bool{
        
    //     $db = Mysql::getInstanz();
    //     $result = $db -> query(" SELECT * from $this -> tabelle where `name` ='{$this -> daten["name"]}' or `beschreibung`='{$this -> daten["beschreibung"]}' ");
    //     if($result ->num_rows != 0 ){
    //         // echo "Fehler kommt von datensatzExistiertBereits <br>";
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    
}