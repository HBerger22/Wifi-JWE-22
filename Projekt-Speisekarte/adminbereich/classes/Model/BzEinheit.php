<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
// use WIFI\SK\Model\Row\Kat;

class BzEinheit{
    private int $speiseId;
    protected string $tabelleBz = "bz_speise_kategorie";
    protected string $tabelleEh = "einheit";
    protected string $tabellenId = "bz_sk_id";
    private int $kat_id;
    private string $typId; // tabellen spalte "speise_id" oder "getraenk_id"
    // protected string $sqlOrder = " "; // wie soll sortiert werden
    // // protected object $rowObjekt = ;

    public function __construct (int $id, string $typ){
        $db_con = Mysql::getInstanz();
        $this->speiseId=$db_con->escape($id);
        if($typ=="Speise"){
            $this->typId="speise_id";
        } else {
            $this->typId="getraenk_id";
        }
        
        
        
        // Kat ID holen
        $result= $db_con -> query("SELECT kategorie_id from {$this->tabelleBz} where `{$this->typId}`={$this->speiseId}  ");
        if($result->num_rows != 0){
            $row=$result->fetch_assoc();
            $this->kat_id=$row["kategorie_id"];
            // echo "kat_id".$this->kat_id;
        }
    }

    public function getKatId():int{
        return $this->kat_id;
    }

    public function alleMepEinerSpeise(): array | false{
        $db_con = Mysql::getInstanz();

        $alleElemente = array();
        $result = $db_con -> query("SELECT bz.bz_sk_id, bz.aktiv, bz.einheit_id as eid, bz.menge, bz.preis, e.name as ename from {$this->tabelleBz} bz, {$this->tabelleEh} e where `{$this->typId}`={$this->speiseId} and e.einheit_id=bz.einheit_id");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $alleElemente[] = $row;
            }
            return $alleElemente;
        }
    }

    public function getBzIdOhneMep():int | bool {
        $db_con = Mysql::getInstanz();

        $result = $db_con -> query("SELECT bz.bz_sk_id from {$this->tabelleBz} bz where `{$this->typId}`={$this->speiseId} and isnull(einheit_id)");
        // echo "getBzIdOhneMep()";
        if($result->num_rows != 0){
            $row=$result->fetch_assoc();
            // echo "$row ". $row["bz_sk_id"];
            return $row["bz_sk_id"];
        } else {
            // echo "false";
            return false;
        }
    }

    public function getEinzelnenMep(int $bz_id): array | bool{
        $db_con = Mysql::getInstanz();
        $sqlBzId=$db_con->escape($bz_id);

        $result = $db_con -> query("SELECT bz.bz_sk_id, bz.aktiv, bz.einheit_id as eid, bz.menge, bz.preis, e.name as ename from {$this->tabelleBz} bz, {$this->tabelleEh} e where `{$this->typId}`={$this->speiseId} and `bz_sk_id`='{$sqlBzId}'and e.einheit_id=bz.einheit_id");
        if($result->num_rows == 0){
            return false;
        } else {
            return $result -> fetch_assoc(); 
        }
    }

    public function akDeak(int $bz_sk_id, int $aktiv):void {
        $db = Mysql::getInstanz();
        $sqlBzSkId= $db -> escape($bz_sk_id);
        $sqlAktiv = $db -> escape($aktiv);
        $db -> query("UPDATE {$this -> tabelleBz} set aktiv = {$sqlAktiv} where {$this -> tabellenId}={$sqlBzSkId}");
    }

    public function mepVerschieden(array $datensatz):bool {
        $db_con = Mysql::getInstanz();
        $sqlKatId=$db_con->escape($datensatz["kategorie_id"]);
        $sqlMenge=$db_con->escape($datensatz["menge"]);
        $sqlEId=$db_con->escape($datensatz["einheit_id"]);
        $sqlPreis=$db_con->escape($datensatz["preis"]);
        // echo "SELECT * from bz_speise_kategorie where `speise_id`='{$this->speiseId}' and `kategorie_id`='{$sqlKatId}' and `einheit_id`='{$sqlEId}' and `menge`='{$sqlMenge}' and `preis`='{$sqlPreis}' and `aktiv`='{$sqlAktiv}'";
        $result = $db_con -> query("SELECT * from bz_speise_kategorie where `{$this->typId}`='{$this->speiseId}' and `kategorie_id`='{$sqlKatId}' and `einheit_id`='{$sqlEId}' and `menge`='{$sqlMenge}' and `preis`='{$sqlPreis}' ;");
        if ($result->num_rows==0){
            //    echo "bz_einheit true <br>";
            return true;
        } else {
            // echo "bzeinheit false <br>";
            return false;
        }   
    }

    public function speichern(array $datensatz):void{
        $db_con = Mysql::getInstanz();
        if($datensatz["bz_sk_id"]!=null){
            $sqlBzId=$db_con->escape($datensatz["bz_sk_id"]);
        }
        $sqlFelder="";
        foreach($datensatz as $key => $wert) {
            if($key == "{$this -> tabellenId}"){
                continue;
            }
        
            $sqlFormularwert = $db_con->escape($wert);
            $sqlFelder.=" {$key} = '{$sqlFormularwert}',";         
        }
        // letztes Komma entfernen
        $sqlFelder .= " {$this->typId}='{$this->speiseId}' "; 
              
        if ($datensatz[$this->tabellenId]!= null){
            $db_con->query("UPDATE {$this->tabelleBz} set $sqlFelder where `bz_sk_id`='{$sqlBzId}' ");
            // echo "UPDATE {$this->tabelleBz} set $sqlFelder where `bz_sk_id`='{$sqlBzId}'";
        } else {
            $db_con->query("INSERT into {$this->tabelleBz} set $sqlFelder ");
            // echo "<br> INSERT into {$this->tabelleBz} set $sqlFelder ";
        }
    }

    public function datensatzLoeschen(int $bz_id): void{
        $db_con = Mysql::getInstanz();
        $sqlBzId=$db_con->escape($bz_id);
        $meps=$this -> alleMepEinerSpeise();
        if (count($meps)>1){
            // echo "DELETE FROM {$this -> tabelle} where {$this -> tabellenId}={$this -> daten["{$this -> tabellenId}"]}";
            $db_con -> query("DELETE FROM {$this -> tabelleBz} where {$this -> tabellenId}={$sqlBzId}");
        } else {
            $db_con -> query("UPDATE {$this -> tabelleBz} set `einheit_id` = NULL, `menge` = NULL, `preis` = '0' where {$this -> tabellenId}={$sqlBzId};");
        }
    }


}