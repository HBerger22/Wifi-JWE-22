<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
use WIFI\SK\Model\Row\Speise;
// use WIFI\SK\Model\Row\Kat;

class Speisen extends ModelAbstract{
    // private array $k_daten =array();
    protected string $tabelle = "speise";
    protected string $tabellenId = "speise_id";
    protected string $sqlOrder = " order by aktiv desc, `name` asc ";
    protected string $rowObjekt = "Speise";

    public function alleAktivenElemente(): array | false{
        $db_con = Mysql::getInstanz();


        $alleElemente = array();
        // echo "ModelAbstract: SELECT * from {$this->tabelle} {$this->sqlOrder} <br>";
        $result = $db_con -> query("SELECT s.speise_id, s.name as sName, s.beschreibung as sBeschreibung, menge, preis, k.name as kName, k.beschreibung as kBeschreibung, k.typ, e.name as eName, e.kuerzel 
            from {$this->tabelle} s, bz_speise_kategorie bz, kategorie k , einheit e where s.aktiv= 1 and s.speise_id=bz.speise_id and bz.aktiv =1 and k.kategorie_id=bz.kategorie_id and k.aktiv=1 and e.einheit_id=bz.einheit_id order by typ, k.reihenfolge, s.name, menge;");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $alleElemente[] = $row;
                // $alleElemente[] = new Speise ($row["{$this->tabellenId}"]);
            }
            return $alleElemente;
        }
    }


}