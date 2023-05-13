<?php
//Aufruf erfolgt: "http://localhost/php2/api/" => .htaccess - Datei

//http://localhost/php2/api/v1/zutaten => gibt eine Liste aller Zutaten zurück
//http://localhost/php2/api/v1/rezepte => gibt eine Liste aller Rezepte zurück
//http://localhost/php2/api/v1/rezepte/1 => gibt das rezept mit der ID 1 inkl. Zutaten zurück


htaccess:
RewriteEngeine On einschalten 

RewriteRule ^\/?api\/? api.php 
wenn das zutrifft wird auf die api.php umgeleitet




2Parameter 1.
^ ganz am anfang 

? = 0 oder 1mal



javascript aufruf mit json_decode
chrown job datei zum löschen schreiben