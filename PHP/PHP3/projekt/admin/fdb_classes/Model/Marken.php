<?php
namespace WIFI\Fdb\Model;

use WIFI\Fdb\Model\Row\Marke;
use WIFI\Fdb\Mysql;



class Marken {

    /**
     * Gibt alle Fahrzeuge zurück
     * @return array ein Array mit mehreren Marken Objekten darin
     */
    public function alleMarken(): array {

        $db = Mysql::getInstanz();

        $MarkenGesamt=array();
        $result = $db-> query("SELECT * FROM `marken`"); 

        while ($row = $result->fetch_assoc()){
            $MarkenGesamt[] = new Marke($row);
        }
        return $MarkenGesamt;
    }
}

// echo "<pre>";
// print_r($row);
// exit;