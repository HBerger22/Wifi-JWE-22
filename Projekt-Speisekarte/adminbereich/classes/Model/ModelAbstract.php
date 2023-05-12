<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
use WIFI\SK\Model\Row\Kat;
use WIFI\SK\Model\Row\Einheit;
use WIFI\SK\Model\Row\Allergen;
use WIFI\SK\Model\Row\Getraenk;
use WIFI\SK\Model\Row\Speise;

abstract class ModelAbstract {
    // private array $k_daten =array();
    protected string $tabelle;
    protected string $tabellenId;
    protected string $sqlOrder; // wie soll das objekt sortiert werden
    // protected object $rowObjekt; // Welches Objekt soll neu erzeugt werde, (Kat, Einheit, ...)

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
                if ($this-> tabelle=="kategorie"){
                    $alleElemente[] = new Kat ($row["{$this->tabellenId}"]);
                } else if ($this-> tabelle=="einheit") {
                    $alleElemente[] = new Einheit ($row["{$this->tabellenId}"]);
                } else if ($this-> tabelle=="allergen") {
                    // echo "test";
                    $alleElemente[] = new Allergen ($row["{$this->tabellenId}"]);
                } else if ($this-> tabelle=="speise") {
                    // echo "test";
                    $alleElemente[] = new Speise ($row["{$this->tabellenId}"]);
                } else if ($this-> tabelle=="getraenk") {
                    // echo "test";
                    $alleElemente[] = new Getraenk ($row["{$this->tabellenId}"]);
                }

            }
            return $alleElemente;
        }
    }
}