<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;

class BzKatEinheit{
    protected string $tabelleBzSGKat = "bz_speise_kategorie";// nicht nur speise sondern Speise oder Getränkebezihungstabelle
    private string $tabelle;
    private string $tabellenId;

    /** 
     * Constuctor erzeugt ein BZKatEinheit Objekt (BeZiehungKategorie zu Speisen und Getränke)
     * definiert die notwendige tabelle und Tabellen ID (Speise oder Getänke)
     * @param string $objekt Wert speise oder Getränk definiert  
     */
    public function __construct (string $objekt){ //objekt ist entweder speise oder getränk
        if($objekt=="speise"){
            $this->tabelle="speise";
            $this->tabellenId="speise_id";
        } else {
            $this->tabelle="getraenk";
            $this->tabellenId="getraenk_id";
        }
    }

    /** 
     * Liefert die Daten der zugehörige Kategorie zur eingegebenen Speise
     * @param int $index Index der Speise/getränks
     * @return false | array false wenn keine Kategorie vorhanden ist | array mit obigen daten
     */
    public function zugehörigeKat(int $index): array | false{
        $db_con = Mysql::getInstanz();
        $sqlIndex=$db_con->escape($index);
        $kat = array();
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

    /** 
     * Liefert die Daten der zugehörigen MEPs zur eingegebenen Speise
     * @param int $index Index der Speise/getränks
     * @return false | array false wenn keine MEPs vorhanden ist | array mit obigen daten
     */
    public function zugehörigeEinhMengePreis(int $index): array | false{
        $db_con = Mysql::getInstanz();
        $sqlIndex=$db_con->escape($index);
        $kat = array();
        $result = $db_con -> query("SELECT {$this->tabellenId}, menge, preis, aktiv,  e.einheit_id as eid, e.name as ename, e.kuerzel from {$this->tabelleBzSGKat} bz, einheit e where `{$this->tabellenId}`='{$sqlIndex}' and e.einheit_id=bz.einheit_id;");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $kat[]=$row;
            }
            return $kat;
        }
    }

    /** 
     * Überprüft ob sich eine zu einer Speise neu zugewiesene Kategorie wirklich geändert hat.
     * @param int $objektId Index der Speise/getränks
     * @param int $katID KategorieID
     * @return bool true wenn verschieden
     */
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

    /** 
     * Speichert eine neue oder geänderte Kategorie
     * @param int $objektId Index der Speise/getränks
     * @param int $katID KategorieID
     */
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
}