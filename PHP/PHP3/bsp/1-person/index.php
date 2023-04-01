<h1 style="color:red; text-align:center">Ich bin wieder mal der Titel</h1>
<?php

include "person.php";

// Ein Objekt erzeugen aus der Klasse "Person"
// Instanzieren / eine Instanz erstellen
$ich = new Person("Berger");

$ich -> vorname = "Helmut"; //auf die Variable vom Objekt (hier vorname) darf kein $ davor sein!!!
echo "Vorname: ". $ich -> vorname ."<br>";  // dadurch das sie als Public deklariert ist kann man von aussen darauf zugreifen


// echo $ich -> nachname; // geht nicht da private, geht nur mehr über die folgende Methode/funtion
echo "Nachname: ". $ich -> get_nachname() ."<br>";

// der nachname kann nur mehr über eine Methode geändert werden, vorteil in der Methode kann/wird noch weiterer Code ausgeführt um einen Reibungslosen ablauf zu gewährleisten.
$ich -> set_nachname("Huber");
echo "Nachname: ". $ich -> get_nachname() ."<br>";

// Version 2 es darf nicht der gleiche Name übergeben werden.
$ich -> set_nachname2("Huber");
echo "Nachname: ". $ich -> get_nachname() ."<br>";

$ich -> set_nachname2("Mayer");
echo "Nachname: ". $ich -> get_nachname() ."<br>";

// Öffentliche Methode (Public) die von aussen angesprochen werden kann.
echo $ich -> vorstellen();

// weiteres Objekt erstellen:
$du = new Person("Lindner");
$du -> vorname = "Sabrina";
echo "Du heißt ". $du->vorname. " ". $du->get_nachname();

