<?php
namespace WIFI\Fdb;

use mysqli;

class Mysql {

    //  Singleton Implementierung
    // vermeidet mehrfache erstellung des selben objekts, hier erwünscht um nicht mehrere DB Verbindungen
    // zu öffnen. Aufruf von aussen ist nicht mehr $... = new Mysql sondern $... = Mysql::getInstanz
    private static ?Mysql $instanz = null; // ? heißt die Variable kann auch null sein == private static Mysql | null $instanz= null;

    // auf statische funktionen/variablen wird mit self:: zugegriffen!!!
    public static function getInstanz(): Mysql{
        if(!self::$instanz){ //ist die Variable leer? (statt Mysql::$instanz kann auch self::$instanz) self bei Static; this bei allen anderen
            self::$instanz = new self(); //könnte auch ...=new Mysql()
        }
        return self::$instanz;
    }
    //  Singleton Implementierung ENDE


    // Eigenschaften:
    private \mysqli $db;

    // funktionen:
    // private damit kann von aussen keine neue Instanz aufgerufen werden.
    private function __construct(){
        $this->verbinden();
    }

    private function verbinden(): void{
        // Mysqli Objekt erstellen und Verbindung aufbauen
        $this->db = new \mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB); // der \bedeutet das er nicht in unserem Namespace nachschaut sondern das es sich hier um ein PHP Objekt handelt (im PHP verzeichnis)
        // Zeichensatz mitteilen
        $this->db->set_charset("utf8");
    }

    public function escape(string $text):string{
        return $this->db->real_escape_string($text);
    }

    public function query(string $sqlBefehl): \mysqli_result|bool {
        return $this->db->query($sqlBefehl);
    }
}