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
    
    /** 
     * Constructor stellt eine Verbindung zur DB her
     * @return bool
     */
    private function __construct() {
        $this->verbinden();
    }

    /** 
     * Verbindung zur DB aufbauen mithilfe der in der Config definierten Parameter
     */
    private function verbinden() {
        // Verbinden mit der Datenbank mithilfe der Klasse Mysqli (von PHP)
        $this->db = new \Mysqli(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
        // Zeichensatz mitteilen
        $this->db->set_charset("utf8");
    }

    /** 
     * DB gefährliche Zeichen aus der Übergebenen Variable auskommentieren
     *  @param string $text zu bearbeitender text/Wert
     *  @return string
     */
    public function escape(string $text): string{
        return $this->db->real_escape_string($text);
    }

    /** 
     * Datenbank abfrage. Liefert das Ergebnis oder false zurück
     * @return mysqli_result| bool
     */
    public function query(string $sql_statemant): \mysqli_result|bool {
        return $this->db->query($sql_statemant);
    }

    /** 
     * Liefert bei fehlermeldung eines Verbindungsfehlers retour
     * @return connect_error
     */
    public function verbindungsfehler(): string | null{
        return $this->db->connect_error;
    }

    /** 
     * liefert die id des zuletzt in die DB eingetragenen Datensatzes 
     * @return int
     */
    public function lastId():int{
        return mysqli_insert_id($this->db);
    }
}


