<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
// use WIFI\SK\Model\Row\Kat;

class BzEinheit{
    private int $productId;
    protected string $tabelleBz = "bz_speise_kategorie";
    protected string $tabelleEh = "einheit";
    protected string $tabellenId = "bz_sk_id";
    private int $kat_id;
    private string $pTabelle;
    private string $pTabelleId; // tabellen spalte "speise_id" oder "getraenk_id"
    // protected string $sqlOrder = " "; // wie soll sortiert werden
    // // protected object $rowObjekt = ;


    /** 
     * Constuctor erzeugt ein BZEInheit Objekt (BeZiehungAllergene zu Speisen und Getränke)
     * definiert die notwendige tabelle und Tabellen ID (Speise oder Getänke) und holt die KategorieID zur jeweiligen SPeise/Getränk
     * @param int $id ID der speise oder Getränk
     * @param string $typ Speise oder Getränk
     */
    public function __construct (int $id, string $typ){
        $db_con = Mysql::getInstanz();
        $this->productId=$db_con->escape($id);
        if($typ=="speise"){
            $this->pTabelleId="speise_id";
            $this->pTabelle="speise";
        } else {
            $this->pTabelleId="getraenk_id";
            $this->pTabelle="getraenk";
        }
        
        // Kat ID holen
        $result= $db_con -> query("SELECT kategorie_id from {$this->tabelleBz} where `{$this->pTabelleId}`={$this->productId}  ");
        if($result->num_rows != 0){
            $row=$result->fetch_assoc();
            $this->kat_id=$row["kategorie_id"];
        }
    }

    /** 
     * Liefert die Kat id retour
     * @return int die Kat ID
     */
    public function getKatId():int{
        return $this->kat_id;
    }

    /** 
     * Liefert Name, Beschreibung und Status Aktiv retour
     * @return false | array False bei Fehler | array mit obigen Feldern
     */
    public function getSpeise():bool | array{
        $db_con = Mysql::getInstanz();
        
        $result = $db_con -> query("SELECT name, beschreibung, p.aktiv from {$this->pTabelle} p where p.{$this->pTabelleId} = {$this->productId} ");
        if($result->num_rows == 0){
            return false;
        } else {
            return $result -> fetch_assoc();
        }
    }

    /** 
     * Liefert alle Meps (Menge/n Einheit/en Preis/e) einer Speise retour
     * @return false | array False wenn keine Meps existieren | array mit obigen Feldern
     */
    public function alleMepEinerSpeise(): array | false{
        $db_con = Mysql::getInstanz();
        $alleElemente = array();
        $result = $db_con -> query("SELECT bz.bz_sk_id, bz.aktiv, bz.einheit_id as eid, bz.menge, bz.preis, e.name as ename from {$this->tabelleBz} bz, {$this->tabelleEh} e where `{$this->pTabelleId}`={$this->productId} and e.einheit_id=bz.einheit_id");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $alleElemente[] = $row;
            }
            return $alleElemente;
        }
    }

   

    public function alleAktivenMepEinerSpeise(): array | false{
        $db_con = Mysql::getInstanz();
        $alleElemente = array();
        $result = $db_con -> query("SELECT bz.bz_sk_id, bz.aktiv, bz.einheit_id as eid, bz.menge, bz.preis, e.name as ename from {$this->tabelleBz} bz, {$this->tabelleEh} e where `{$this->pTabelleId}`={$this->productId} and e.einheit_id=bz.einheit_id and bz.aktiv=1");
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

        $result = $db_con -> query("SELECT bz.bz_sk_id from {$this->tabelleBz} bz where `{$this->pTabelleId}`={$this->productId} and isnull(einheit_id)");
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

        $result = $db_con -> query("SELECT bz.bz_sk_id, bz.aktiv, bz.einheit_id as eid, bz.menge, bz.preis, e.name as ename from {$this->tabelleBz} bz, {$this->tabelleEh} e where `{$this->pTabelleId}`={$this->productId} and `bz_sk_id`='{$sqlBzId}'and e.einheit_id=bz.einheit_id");
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
        // echo "SELECT * from bz_speise_kategorie where `speise_id`='{$this->productId}' and `kategorie_id`='{$sqlKatId}' and `einheit_id`='{$sqlEId}' and `menge`='{$sqlMenge}' and `preis`='{$sqlPreis}' and `aktiv`='{$sqlAktiv}'";
        $result = $db_con -> query("SELECT * from bz_speise_kategorie where `{$this->pTabelleId}`='{$this->productId}' and `kategorie_id`='{$sqlKatId}' and `einheit_id`='{$sqlEId}' and `menge`='{$sqlMenge}' and `preis`='{$sqlPreis}' ;");
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
        $sqlFelder .= " {$this->pTabelleId}='{$this->productId}' "; 
              
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