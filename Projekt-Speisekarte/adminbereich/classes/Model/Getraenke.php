<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
use WIFI\SK\Model\Row\Speise;
// use WIFI\SK\Model\Row\Kat;

class Getraenke extends ModelAbstract{
    // private array $k_daten =array();
    protected string $tabelle = "getraenk";
    protected string $tabellenId = "getraenk_id";
    protected string $sqlOrder = " order by aktiv desc, `name` asc ";
    protected string $rowObjekt = "Getraenk";

    public function alleAktiveElemente(): array | false{
        $db_con = Mysql::getInstanz();


        $alleElemente = array();
        // echo "ModelAbstract: SELECT * from {$this->tabelle} {$this->sqlOrder} <br>";
        $result = $db_con -> query("SELECT g.getraenk_id, s.name as sName, g.beschreibung as gBeschreibung, menge, preis, k.name as kName, k.beschreibung as kBeschreibung, k.typ, e.name as eName, e.kuerzel 
            from {$this->tabelle} g, bz_speise_kategorie bz, kategorie k , einheit e where g.aktiv= 1 and g.getraenk_id=bz.speise_id and bz.aktiv =1 and k.kategorie_id=bz.kategorie_id and k.aktiv=1 and e.einheit_id=bz.einheit_id order by typ, k.name, g.name, menge;");
        if($result->num_rows == 0){
            return false;
        } else {
            while ($row = $result -> fetch_assoc()){
                $alleElemente[] = $row;
            }
            return $alleElemente;
        }
    }


}