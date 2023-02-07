"use strict";

let liste=[];
let einheit=['pkg','kg','g','stk','Netz'];

// <opttion value="kg">kg</option> 
// $("<option/>").val("Wert 2").text("Text 2").appendTo("#jquery-select")

// Select Feld mit den möglichen Einheiten befüllen.
$(einheit).each(function(index,element){
    // $("<option/>")
    $('<option value="'+element+'">'+element+'</option>').appendTo($('#einheit'));
    console.log('<option value="'+element+'">'+element+'</option>\n');
});

$('#einheit').val('');

// liste[0]=[3, 'kg', 'Kartoffeln'];
// liste[1]=[1.5, 'kg', 'Karotten'];
// liste[2]=[7, 'kg', 'Zitronen'];
// liste[3]=[2.5, 'Netz', 'Zwiebel'];
// liste[4]=[5, 'Stk', 'Joghurt'];
// liste[5]=[4.5, 'Stk', 'Sauerrahm'];

let html='Alle Einträge: <br>';
let platzhalter;
let arrayLaenge=0;

// Elemente der Liste in eine Variable html inkl. checkbox ausgeben
function liste_ausgeben(){
    $(liste).each(function(mindex, melement){
        html= html+'<input type="checkbox" name="' + mindex +'" id="cb' + mindex +'"> ';
        
        $(melement).each(function(sindex,selement){
            if(typeof selement == 'number'){
                platzhalter=selement.toFixed(1);
            } else {
                platzhalter=selement;
            }
            html=html+ ( platzhalter +' ')  ;

        // console.log(liste[mindex][sindex].toFixed(1));
        });
        html=html+'<br>';
    });
    // Listeninhalt in das Div Gegenstände ausgeben
    $('#gegenstaende').html(html);
    // Variablen zurücksetzen
    html='';
    $('#e_dazu').val('');
    $('#menge').val('');
    $('einheit').val('');
    // kurser auf menge setzen
};

liste_ausgeben();

// neues Element einlesen und hinzufügen wenn im letzten Feld 'Enter' gedrückt wird
$('#e_dazu').keyup(function(event){
    if(event.key=='Enter'){
        liste.push([parseFloat($('#menge').val()),$('#einheit').val(),$('#e_dazu').val()]);
        liste_ausgeben();
        arrayLaenge=liste.length;
        $('#info').html(arrayLaenge);
    };
});

// Liste komplett leeren
$('#listeLeeren').click(function(event){
    liste=[];
    liste_ausgeben();
});

let test=''; //Testvariable zur Ausgabe im HTML Tag zum Debuggen

// einzelne Elemente entfernen wenn der Butten entfernen gedrückt wird
$('#e_entfernen').click(function(){
    // for(let i=liste.length; i--;i<0) //warum das funktioniert  hat obwohl in der For Schleife die Falsche Reihenfolge der Attribute kommt, keine Ahnung
    for(let i=liste.length-1; i>=0 ;i--) //Schleife von hinten durchlaufen lassen, dann verschiebt sich nichts von den Indexen her als wenn man es von vorne nach hinten macht.
    // $(liste).each(function(index,element) //deshalb ist diese Variante nicht so sinnvoll
    {
        let vari=$('#cb'+i);
        if(vari.prop("checked")){
            if(i==0){       // wenn es das erste Element gelöscht werden soll
                liste.shift();
            }else if(i == liste.length-1){ //letztes Element löschen.
                liste.pop();
            } else { //Elemente dazwischen löschen
                for(let j=i ; j<liste.length ; j++){
                    test=test+' for 3.if schleife '+i +' ' +j +'<br>';
                    if(j==liste.length-1){
                        liste.pop();
                    } else{
                        liste[j]=liste[j+1];
                    }
                };
            };
        } else{
            // gibt hier nichts zu tun denk ich, könnte man weglassen
        }
        $('#info').html(test); // Text zum Debuggen im HTML ausgeben.
    };
    liste_ausgeben(); 
    test='';
});








