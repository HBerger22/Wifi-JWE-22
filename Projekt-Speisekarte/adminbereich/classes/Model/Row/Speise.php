<?php
namespace WIFI\SK\Model\Row;

// include "../../Mysql.php";
use \Exception;
use WIFI\SK\Model\BzEinheit;
use WIFI\SK\Mysql;

class Speise extends SGAbstract{ 
    protected string $tabelle = "speise";
    protected string $tabellenId = "speise_id";
}