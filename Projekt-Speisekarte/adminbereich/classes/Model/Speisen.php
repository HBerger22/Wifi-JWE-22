<?php
namespace WIFI\SK\Model;

use WIFI\SK\Mysql;
use WIFI\SK\Model\Row\Speise;
// use WIFI\SK\Model\Row\Kat;

class Speisen extends SGModelAbstract{
    protected string $tabelle = "speise";
    protected string $tabellenId = "speise_id";
    protected string $sqlOrder = " order by aktiv desc, `name` asc ";
    protected string $rowObjekt = "Speise";

    protected string $sqlAlleAktivenElementeTeil1 = "SELECT s.speise_id, s.name, s.beschreibung, menge, preis, k.name as kName, k.beschreibung as kBeschreibung, k.typ, e.name as eName, e.kuerzel from ";
    protected string $sqlAlleAktivenElementeTeil2 = " s, bz_speise_kategorie bz, kategorie k , einheit e where s.aktiv= 1 and s.speise_id=bz.speise_id and bz.aktiv =1 and k.kategorie_id=bz.kategorie_id and k.aktiv=1 and e.einheit_id=bz.einheit_id order by typ, k.reihenfolge, s.name, menge;";
}