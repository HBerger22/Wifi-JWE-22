<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
use WIFI\SK\Model\Row\Speise;
// use WIFI\SK\Model\Row\Kat;

class Getraenke extends SGModelAbstract{
    // private array $k_daten =array();
    protected string $tabelle = "getraenk";
    protected string $tabellenId = "getraenk_id";
    protected string $sqlOrder = " order by aktiv desc, `name` asc ";
    protected string $rowObjekt = "Getraenk";
    protected string $sqlAlleAktivenElementeTeil1 = "SELECT g.getraenk_id, g.name, g.beschreibung, menge, preis, k.name as kName, k.beschreibung as kBeschreibung, k.typ, e.name as eName, e.kuerzel from " ;
    protected string $sqlAlleAktivenElementeTeil2 = " g, bz_speise_kategorie bz, kategorie k , einheit e where g.aktiv= 1 and g.getraenk_id=bz.getraenk_id and bz.aktiv =1 and k.kategorie_id=bz.kategorie_id and k.aktiv=1 and e.einheit_id=bz.einheit_id order by typ, k.name, g.name, preis;" ;
}