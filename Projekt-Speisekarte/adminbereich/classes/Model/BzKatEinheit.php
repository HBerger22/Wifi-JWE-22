<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
// use WIFI\SK\Model\Row\Kat;

class BzKatEinheit{
    // private array $k_daten =array();
    protected string $tabelleBzSGKat = "bz_speise_kategorie";
    private string $tabelle;
    private string $tabellenId;
    // protected string $sqlOrder = " "; // wie soll sortiert werden
    // // protected object $rowObjekt = ;

    public function __construct (string $objekt){ //objekt ist entweder speise oder getränk
        if($objekt=="Speise"){
            $this->tabelle="speise";
            $this->tabellenId="speise_id";
        } else {
            $this->tabelle="getraenk";
            $this->tabellenId="getraenk_id";
        }
    }

    public function zugehörigeKat(int $index): array | false{
        $db_con = Mysql::getInstanz();
        $sqlIndex=$db_con->escape($index);
        $kat = array();
        //  echo "ModelAbstract: SELECT * from {$this->tabelle} {$this->sqlOrder} <br>";
        $result = $db_con -> query("SELECT {$this->tabellenId}, k.aktiv , typ, k.kategorie_id  as kid, k.name as kname, k.beschreibung, k.typ from {$this->tabelleBzSGKat} bz, kategorie k where `{$this->tabellenId}`='{$sqlIndex}' and k.kategorie_id=bz.kategorie_id;");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $kat[]=$row;

            }
            return $kat;
        }
    }

    public function zugehörigeEinhMengePreis(int $index): array | false{
        $db_con = Mysql::getInstanz();
        $sqlIndex=$db_con->escape($index);
        $kat = array();
        //  echo "ModelAbstract: SELECT * from {$this->tabelle} {$this->sqlOrder} <br>";
        $result = $db_con -> query("SELECT {$this->tabellenId}, menge, preis, aktiv,  e.einheit_id as eid, e.name as ename, e.kuerzel from {$this->tabelleBzSGKat} bz, einheit e where `speise_id`='{$sqlIndex}' and e.einheit_id=bz.einheit_id;");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $kat[]=$row;

            }
            return $kat;
        }
    }

    public function katVerschieden(int $objektId, int $katId):bool {
        $db_con = Mysql::getInstanz();
        $sqlObjektId=$db_con->escape($objektId);
        $sqlKatId=$db_con->escape($katId);

        $result = $db_con -> query("SELECT * from {$this->tabelleBzSGKat} where `{$this->tabellenId}`='{$sqlObjektId}' and `kategorie_id`='{$sqlKatId}';");
        if ($result->num_rows==0){
            return true;
        } else {
            return false;
        }   
    }

    public function speichernKat(int $objekt_id, int $kat_id):void{
        $db = Mysql::getInstanz();

        $sqlObjekt = $db->escape($objekt_id);
        $sqlKat = $db->escape($kat_id);

        $result = $db->query("SELECT * from {$this->tabelleBzSGKat} where `{$this->tabellenId}`='{$sqlObjekt}' ");
        if ($result->num_rows!=0){
            $db->query("UPDATE {$this->tabelleBzSGKat} set `kategorie_id`=$sqlKat where `{$this->tabellenId}`='{$sqlObjekt}' ");
        } else {
            $db->query("INSERT into {$this->tabelleBzSGKat} set `{$this->tabellenId}`='{$sqlObjekt}', `kategorie_id`='{$sqlKat}'   ");
        }
        

    }

    
    // public function speichern():void{
    
    //     if($this->daten["{$this -> tabellenId}"] == null){
    //         // neuen Datensatz speichern
    //         $db->query ("INSERT INTO {$this -> tabelle} SET {$sqlFelder} "); //{$this->tabelle}

    //     } else {
    //         // bestehenden Datensatz ändern
    //         $sql_id= $db->escape($this->daten["{$this -> tabellenId}"]);
    //         $db->query ("UPDATE {$this -> tabelle} SET {$sqlFelder} where {$this -> tabellenId} = '{$sql_id}'"); //{$this->tabelle}
    //     }
    // }



}