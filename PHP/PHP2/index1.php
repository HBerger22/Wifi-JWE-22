<?php

$userpwd = "Lisa123";
echo "User Passwort: ". $userpwd. "<br>";
// ein Betreiber PWD auch salt genannt dazugeben.
$betreiberpwd ="köagdghK";
echo "Betreiber/Salt Passwort: ". $betreiberpwd. "<br>";
$pwd=$userpwd.$betreiberpwd;



echo "Neues gesamt PWD = ". $userpwd.$betreiberpwd;
echo "<br>";
echo "<br>";

$md5hashpwd = md5($pwd) ;
echo "Neues Gesamt PWD zusätzlich noch MD5 verschlüssen";
echo "<br>";
echo "MD5 Hash: ".$md5hashpwd;
echo "<br>";

// überprüfung eines MD5 Passwortes
$db_passwort ="cf5bfb2efe0612b26cb07398c979d93f"; //aus der db geholtes passwort
if($db_passwort==md5($pwd)){
    echo "PWD stimmt <br>";
}
echo "<br>";

echo "password_hash() <br>";
$pwdhash=password_hash("1", PASSWORD_DEFAULT);
echo $pwdhash; 
echo "<br>";

