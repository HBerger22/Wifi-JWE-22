<?php


// konfiguration für das Projekt

const MYSQL_HOST = "localhost";
const MYSQL_USER = "root";
const MYSQL_PASS = "";
const MYSQL_DB = "speisekarte";

// const MYSQL_HOST = "localhost";
// const MYSQL_USER = "jwe_bh";
// const MYSQL_PASS = "6td4t~O1jZ75f5@e";
// const MYSQL_DB = "obinet_jwe_bh_db1";

if(!empty($_SESSION["objekt"])){
    if($_SESSION["objekt"]=="speise"){
        $objektId="speise_id";
    } else {
        $objektId="getraenk_id";
    }
}
