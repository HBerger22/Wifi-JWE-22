<?php
namespace WIFI\SK\Model\Row;

// include "../../Mysql.php";
use Exception;
use mysqli;
use WIFI\SK\Mysql;

abstract class RowAbstract {
    protected array $daten = array();
    protected string $tabelle;
    protected string $tabellenId;
    protected string $beziehung;

    /** 
     * Constructor erzeugt ein objekt aus einem array oder lädt ein neues Objekt aus der übergebenen ID aus der DB
     * @param int | array $idOderArray
     * @throws Exception
     */
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
            foreach($idOderArray as $key => $daten){ 
                if($key == $this -> tabellenId){
                    continue;
                }
                $idOderArray[$key] = $db -> escape($daten);//alle arrayeingaben escapen
            }
            $this -> daten = $idOderArray;
        }
    }

    /** 
     * Holt den Inhalt einer spalte aus der DB abfrage
     * @param string $spaltenname
     * @return mixed
     * @throws Exception
     */
    public function getSpalte (string $spaltenname):mixed{
        if(!array_key_exists($spaltenname, $this->daten)){
            throw new \Exception("Der Spaltenname '{$spaltenname}' existiert nicht");
        } 
        return $this->daten[$spaltenname];
    }   
    
    /** 
     * Löscht den Datensatz aus der DB
     * @param string $spaltenname
     */
    public function datensatzLoeschen (): void{
        $db = Mysql::getInstanz();
        $db -> query("DELETE FROM {$this -> tabelle} where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
    }

    /** 
     * Aktiviert oder deaktiviert ein Objekt in der DB 
     * @param int $aktiv Aktiv= 1, Inaktiv = 0
     */
    public function akDeak(int $aktiv):void  {
        $db = Mysql::getInstanz();
        $sqlAktiv = $db -> escape($aktiv);
        $db -> query("UPDATE {$this -> tabelle} set aktiv = {$sqlAktiv} where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
    }

    /** 
     * Überprüft ob es eine Beziehung zu einem Produkt gibt
     * @return bool
     */
    public function existiertVerbindung(): bool{ 
        $db = Mysql::getInstanz();
        $result = $db -> query("SELECT * FROM `{$this -> beziehung}` where {$this -> tabellenId}='{$this -> daten["{$this -> tabellenId}"] }'");
        if($result -> num_rows != 0) 
            return false; 
        else 
            return true;
    }

    /** 
     * Neuen oder geänderten Datensatz in der DB speichern
     * @return int id des aktualisierten oder neuen Datensatzes
     * @throws Exception
     */
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
}