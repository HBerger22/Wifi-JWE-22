<?php
namespace WIFI\Fdb\Model;

use WIFI\Fdb\Model\Row\Fahrzeug;
use WIFI\Fdb\Mysql;



class Fahrzeuge {

    /**
     * Gibt alle Fahrzeuge zurück
     * @return array ein Array mit mehreren Fahrzeug Objekten darin
     */
    public function alleFahrzeuge(): array {

        $db = Mysql::getInstanz();

        $fahrzeugeGesamt=array();
        $result = $db-> query("SELECT * FROM `fahrzeuge`"); 
        // SELECT f.*, m.hersteller FROM `fahrzeuge` f, `marken` m WHERE f.marken_id=m.id
        while ($row = $result->fetch_assoc()){
            $fahrzeugeGesamt[] = new Fahrzeug($row);

        }
        return $fahrzeugeGesamt;

    }


}

// echo "<pre>";
// print_r($row);
// exit;