<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
// use WIFI\SK\Model\Row\Kat;

class BzAllergene{
    // private array $k_daten =array();
    // protected string $tabelle = "bz_speise_allergene";
    // protected string $tabellenId = "speise_id";
    // protected string $sqlOrder = " "; // wie soll sortiert werden
    // // protected object $rowObjekt = ;
    protected string $tabelleBzSGAllergene = "bz_speise_allergene";
    private string $tabelle;
    private string $tabellenId;

    public function __construct(string $objekt)
    {
        if($objekt=="Speise"){
            $this->tabelle="speise";
            $this->tabellenId="speise_id";
        } else {
            $this->tabelle="getraenk";
            $this->tabellenId="getraenk_id";
        }
    }

    public function alleElemente(int $index): array | false{
        $db_con = Mysql::getInstanz();

        $alleElemente = array();
        
        // echo "ModelAbstract: SELECT * from {$this->tabelleBzSGAllergene} where `{$this->tabellenId}`='{$index}' <br>";
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