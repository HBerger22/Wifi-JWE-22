<?php
namespace WIFI\JWE\Tier;
class Hund{

    private string $name;

    public function __construct(string $hundename){
        $this->name=$hundename;
    }

    public function getName() : string {
        return $this->name;
    }

    public function gibLaut() : string {
        return "Wuff!";
    }

}