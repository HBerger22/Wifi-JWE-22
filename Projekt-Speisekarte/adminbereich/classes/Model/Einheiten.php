<?php
namespace WIFI\SK\Model;

// use WIFI\SK\Mysql;
// use WIFI\SK\Model\Row\Kat;

class Einheiten extends ModelAbstract{
    // private array $k_daten =array();
    protected string $tabelle = "einheit";
    protected string $tabellenId = "einheit_id";
    protected string $sqlOrder = " order by `name` asc ";
    // protected string $rowObjekt = "Einheit";


}