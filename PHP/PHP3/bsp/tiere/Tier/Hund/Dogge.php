<?php
namespace WIFI\JWE\Tier\Hund;

use WIFI\JWE\Tier\HundRichtig;
// Vererbungen können über mehrere Ebenen Gehen
class Dogge extends HundRichtig{
    public function gibLaut(): string{
        return "GRRRRRRRrrrrrrr";
    }

    // Jede klasse kann beliebig mit Methoden ( und eigenschaften) erweitert werden.
    public function beissen():string {
        return "Autsch";
    }


}