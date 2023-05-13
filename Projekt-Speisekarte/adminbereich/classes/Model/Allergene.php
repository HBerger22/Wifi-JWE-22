<?php
namespace WIFI\SK\Model;

use WIFI\SK\Model\Row\Allergen;
use WIFI\SK\Mysql;
// use WIFI\SK\Model\Row\Kat;

class Allergene extends ModelAbstract{
    // private array $k_daten =array();
    protected string $tabelle = "allergen";
    protected string $tabellenId = "allergen_id";
    protected string $sqlOrder= " order by `klasse` asc ";
    protected string $beziehung = "bz_speise_allergene";

    protected string $rowObjekt = "Allergen";

    public function alleAllergeneEinerSpeise(int $speiseId): array | false{
        $db_con = Mysql::getInstanz();

        $alleElemente = array();
        $result = $db_con -> query("SELECT * from {$this->beziehung} where `speise_id`={$speiseId}");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $alleElemente[] = new Allergen ($row["{$this->tabellenId}"]);
            }
            return $alleElemente;
        }
    }

    
}