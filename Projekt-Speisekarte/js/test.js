"use strict";
let daten;

$.get(
    '../Projekt-Speisekarte/api/V1/Allergene',
    function(data,status,rückgabe){
        daten=rückgabe.responseJSON;
        document.getElementById("test").innerHTML = daten[0];
    }
);

// $.get( "../Projekt-Speisekarte/api/", function( data ) {
//     console.log( typeof data ); // string
//     console.log( data ); // HTML content of the jQuery.ajax page
//   });