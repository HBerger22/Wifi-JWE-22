<?php
namespace WIFI\SK\Model\Row;

// include "../../Mysql.php";
use \Exception;
use WIFI\SK\Model\BzEinheit;
use WIFI\SK\Mysql;

class Speise extends SGAbstract{ 
    protected string $tabelle = "speise";
    protected string $tabellenId = "speise_id";
    
   
    // public function akDeakSpeise(int $aktiv, string $typ): bool {
    //     $db = Mysql::getInstanz();
    //     $sqlAktiv = $db -> escape($aktiv);
    //     $sqlTyp = $db -> escape($typ);
        
    //     if($sqlAktiv==0){ //deaktivieren
    //         $db -> query("UPDATE {$this -> tabelle} set aktiv = {$sqlAktiv} , `deaktiviert_am` = CURRENT_DATE where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
    //         // echo "UPDATE {$this -> tabelle} set aktiv = {$sqlAktiv} , `deaktiviert_am` = CURRENT_DATE where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}";
    //         return true;
    //     }else { //aktivieren

    //         // Die Speise darf nur aktiviert werden wenn es eine MEP (Menge/Einheit/Preis) gibt! Macht sonst bei der anzeige keinen Sinn
    //         $bzMep = new BzEinheit($this -> daten[$this -> tabellenId],$sqlTyp);
    //         if($bzMep->alleAktivenMepEinerSpeise()){
    //             $db -> query("UPDATE {$this -> tabelle} set aktiv = {$sqlAktiv} , deaktiviert_am=NULL where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
    //             return true;
    //         } else {
    //             return false;
    //     }
    //     }
        
    // }

    // public function bzLoeschen():void{
    //     $db = Mysql::getInstanz();
    //     $db -> query("DELETE FROM {$this->beziehungAllergene} where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");
    //     $db -> query("DELETE FROM {$this->beziehungKat} where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}");

    // }

    // // überprüfen ob sich im Datensatz etwas geändert hat (es werden div. werte von 2 Kat objekten miteinander verglichen)
    // public function objektVerschieden(speise $ds1):bool {
        
    //     if ($ds1 -> getSpalte("name") == $this->daten["name"] && $ds1 -> getSpalte("beschreibung") == $this->daten["beschreibung"] ){
    //         // echo "Fehler kommt von objektVerschieben <br>";
    //         return true;
    //     } else {
    //         return false;
    //     }   
    // }

    // // überprüfen ob der Datensatz schon in der DB existiert
    // public function datensatzExistiertBereits(): bool{
        
    //     $db = Mysql::getInstanz();
    //     $result = $db -> query(" SELECT * from {$this->tabelle} where `name` ='{$this -> daten["name"]}' or `beschreibung`='{$this -> daten["beschreibung"]}' ");
    //     if($result ->num_rows != 0 ){
    //         // echo "Fehler kommt von datensatzExistiertBereits <br>";
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

}