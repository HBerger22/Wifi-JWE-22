"use strict";
/*
const password = swordfish;
Bedingung PWD Wahr/Falsch

let versuche = 0;
Abfrage 3*falsch sperre 5 min

*/

const password = 'swordfish';
let versuche = 0;

// Zeitpunkt zu dem die Seite geladen wurde! Statischer Wert verändert sich nicht mehr
const timeOffPageLoad = new Date().getTime(); 

// eine function die immer den aktuellen Zeitstempel zurückgibt.
let currentTime= function(){return new Date().getTime()};

let letzterVersuch; // timestamp
let wartezeit = 30; // in sekunden
let neuerVersuchsZeitpunkt = timeOffPageLoad;


function checkPWD (eingabe){
    if (eingabe==password){
        return true;
    } else {
        return false;
    }
}

function getEingabeAndCheckPwd(){
    
    if(versuche <=3){
    
        // Feld PWD auslesen
        let feldwert = document.getElementById('pwd').value;
        if(checkPWD(feldwert)==true){
            console.log('PWD richtig');
            window.location.href="https://a1.net";
        } else {
            console.log('PWD falsch');
            // window.location.href="https://google.com";
            versuche ++;

            if(versuche == 3){

            }
        }
    } else {
        // sperren
        /*window.setTimeout(
            funktion(){
                versuche=0;
            }, 30000
        );*/
        
    }
}