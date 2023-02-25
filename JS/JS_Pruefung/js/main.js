// "use strict";

// deklarieren der Konstante MYCHANNEL
const MYCHANNEL = 5555;

// Beim Klick auf die Taste netflix wird das attribute value im inputfeld mit der id eingabe auf netflix gesetzt.
$('#netflix').click(function(){
    $('#eingabe').val('netflix');
});

// Beim Klick auf die Taste youtube wird das attribute value im inputfeld mit der id eingabe auf youtube gesetzt.
$('#youtube').click(function(){
    $('#eingabe').val('youtube');
});

// Beim Klick auf die Taste disney wird das attribute value im inputfeld mit der id eingabe auf disney gesetzt.
$('#disney').click(function(){
    $('#eingabe').val('disney');
});

let key;
let kanal=''; // setzen einer leeren String Variable für die Kanal/Sender auswahl.
$('button').click(function(event){
    let taste=event.currentTarget.innerText; //Übergabe des HTML Inhalts in die Variable taste
        key=event;
           console.log(taste);     
    if(taste.match(/\d/) != null){      //Überprüfen ob der eingegebene Inhalt eine Zahl ist.
        
        if (kanal.length<4){            //überprüfen auf max 3 Zeichen. (4.kommt erst danach dazu)
            kanal=kanal + taste;
            $('#eingabe').val(kanal);
            
            if (kanal.length==4) { // Ausgabe des Kanalnamens wenn alle 4 Zahlen eingegeben wurden.
                $('#tv').html('<h2>Kanal: '+kanal + ' MTV</h2>');
            };
        
        } else {    // mehr als 4 Zeichen beende die function
           return false;
        }

    } else if(taste=='♥'){ // wurde der ♥ Button gedrückt?
        $('#eingabe').val(MYCHANNEL);       //
        $('#tv').html('<h2>Kanal: Mein Lieblingskanal ;-)</h2>');
    }else if(taste=='\uD83D\uDEC8'){ // wurde der 🛈 = \uD83D\uDEC8 (unicode) = #128712; (html) Button gedrückt?
        $('#eingabe').val('0000');       //
        $('#tv').html('<h2>Information: <br>Sie können über die Fernbedienung einen 4-stelligen Sender auswählen. Oder sie drücken auf das ♥, um Ihren Lieblingssender zu sehen. ;-)</h2>');
    }; 
});

console.log('123 🛈 \uD83D\uDEC8  ');