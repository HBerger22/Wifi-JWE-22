<?php
namespace WIFI\SK\Model;

// use WIFI\SK\Mysql;
// use WIFI\SK\Model\Row\Kat;

class Kategorien extends ModelAbstract{
    // private array $k_daten =array();
    protected string $tabelle = "kategorie";
    protected string $tabellenId = "kategorie_id";
    protected string $sqlOrder = " order by aktiv desc, typ asc, `name` asc ";
    // protected object $rowObjekt = ;


}