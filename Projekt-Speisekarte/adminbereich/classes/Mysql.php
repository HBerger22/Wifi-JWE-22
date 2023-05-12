<?php
namespace WIFI\SK;

use \Mysqli;

class Mysql {

    //  Singleton Implementierung
    // vermeidet mehrfache erstellung des selben objekts, hier erwünscht um nicht mehrere DB Verbindungen
    // zu öffnen. Aufruf von aussen ist nicht mehr $... = new Mysql sondern $... = Mysql::getInstanz (:: Zugriff auf statische objekte)
    private static ?Mysql $instanz = null; // ? heißt die Variable kann auch null sein ==   private static Mysql | null $instanz= null;

    // auf statische funktionen/variablen wird mit self:: zugegriffen!!!
    public static function getInstanz(): Mysql{
        if(!self::$instanz){ //ist die Variable leer? (statt Mysql::$instanz kann auch self::$instanz) self bei Static; this bei allen anderen
            self::$instanz = new self(); //könnte auch ...=new Mysql()
        }
        return self::$instanz;
    }
    //  Singleton Implementierung ENDE

    private \Mysqli $db;
    
    private function __construct() {
        $this->verbinden();
        
    }

    private function verbinden() {
        // Verbinden mit der Datenbank mithilfe der Klasse Mysqli (von PHP)
        $this->db = new \Mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
        // Zeichensatz mitteilen
        $this->db->set_charset("utf8");
    }

    public function escape(string $text): string{
        return $this->db->real_escape_string($text);
    }

    public function query(string $sql_statemant): \mysqli_result|bool {
        return $this->db->query($sql_statemant);
    }

    public function verbindungsfehler(): string | null{
        return $this->db->connect_error;
    }

    public function lastId():int{
        return mysqli_insert_id($this->db);
    }
}


