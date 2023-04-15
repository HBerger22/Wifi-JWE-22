<?php
namespace WIFI\Fdb\Model;

// funktioniert nicht müsste noch angepasst werden um als vererbungsfähige classe zu definieren

use WIFI\Fdb\Mysql;

abstract class RowAbstract {
    protected string $tabelle;

/**
     * Gibt alle Fahrzeuge zurück
     * @return array ein Array mit mehreren Fahrzeug Objekten darin
     */
    public function alleFahrzeuge(): array {

        $db = Mysql::getInstanz();

        $fahrzeugeGesamt=array();
        $result = $db-> query("SELECT * FROM `{$this->tabelle}`"); 
        // SELECT f.*, m.hersteller FROM `fahrzeuge` f, `marken` m WHERE f.marken_id=m.id
        while ($row = $result->fetch_assoc()){
            $fahrzeugeGesamt[] = new Fahrzeug($row);

        }
        return $fahrzeugeGesamt;

    }
}