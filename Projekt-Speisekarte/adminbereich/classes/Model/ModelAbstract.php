<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;

abstract class ModelAbstract {
    // private array $k_daten =array();
    protected string $tabelle;
    protected string $tabellenId;
    protected string $sqlOrder; // wie soll das objekt sortiert werden
    protected string $rowObjekt; // Welches Objekt soll neu erzeugt werde, (Kat, Einheit, ...)

    public function alleElemente(): array | false{
        $db_con = Mysql::getInstanz();

        // $this -> rowObjekt.='($row["{$this->tabellenId}"])';
        // echo $this -> rowObjekt;
        // if($this->aktiv){
        //     $order="aktiv desc, ";
        // } else {
        //     $order="";
        // }

        $alleElemente = array();
        // echo "ModelAbstract: SELECT * from {$this->tabelle} {$this->sqlOrder} <br>";
        $result = $db_con -> query("SELECT * from {$this->tabelle} {$this->sqlOrder}");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                

                // sicher nicht die beste Lösung, das sollte besser gehen.
                // Nachfragen am Samstag
                $obj = "\\WIFI\\SK\\Model\\Row\\".$this->rowObjekt;
                $alleElemente[] = new $obj($row["{$this->tabellenId}"]);
                

            }
            return $alleElemente;
        }
    }
}