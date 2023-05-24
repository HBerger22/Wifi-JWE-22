<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
// use WIFI\SK\Model\Row\Kat;

class BzAllergene{
    protected string $tabelleBzSGAllergene = "bz_speise_allergene"; 
    private string $tabelle;
    private string $tabellenId;

    /** 
     * Constuctor erzeugt ein BZAllergene Objekt (BeZiehungAllergene zu Speisen und Getränke)
     * definiert die notwendige tabelle und Tabellen ID (Speise oder Getänke)
     * @param string $objekt Wert speise oder Getränk definiert  
     */
    public function __construct(string $objekt)
    {
        if($objekt=="speise"){
            $this->tabelle="speise";
            $this->tabellenId="speise_id";
        } else {
            $this->tabelle="getraenk";
            $this->tabellenId="getraenk_id";
        }
    }

    /** 
     * Liefert alle Allergene einer Speise zurück
     * @param int $index Index der SPeise/getränks
     * @return false | array false wenn keine Allergene vorhanden sind | array mit den allergenen
     */
    public function alleElemente(int $index): array | false{
        $db_con = Mysql::getInstanz();
        $alleElemente = array();
        $result = $db_con -> query("SELECT * from {$this->tabelleBzSGAllergene} where `{$this->tabellenId}`='{$index}'");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $alleElemente[]=$row;
            }
            return $alleElemente;
        }
    }

}