<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;


abstract class ModelAbstract {
    protected string $tabelle;
    protected string $tabellenId;
    protected string $sqlOrder; // wie soll das objekt sortiert werden
    protected string $rowObjekt; // Welches Objekt soll neu erzeugt werde, (Kat, Einheit, ...)

    /** 
     * Gibt alle Elemente eines Objekts retour
     * @return false | array false wenn es keine Elemente gibt | Array mit den abgefragten objekten
     */
    public function alleElemente(): array | false{
        $db_con = Mysql::getInstanz();
        $alleElemente = array();

        $result = $db_con -> query("SELECT * from {$this->tabelle} {$this->sqlOrder}");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $obj = "\\WIFI\\SK\\Model\\Row\\".$this->rowObjekt; //definition welches Objekt  erstellt werden soll
                $alleElemente[] = new $obj($row["{$this->tabellenId}"]);
            }
            return $alleElemente;
        }
    }
}