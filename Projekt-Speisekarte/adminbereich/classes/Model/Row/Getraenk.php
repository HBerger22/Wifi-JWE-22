<?php
namespace WIFI\SK\Model\Row;

// include "../../Mysql.php";
use \Exception;
use WIFI\SK\Model\BzEinheit;
use WIFI\SK\Mysql;

class Getraenk extends SGAbstract{ 
    protected string $tabelle = "getraenk";
    protected string $tabellenId = "getraenk_id";
}