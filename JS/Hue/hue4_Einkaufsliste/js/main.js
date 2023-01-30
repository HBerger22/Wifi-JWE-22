"use strict";

let liste = [];

console.log('text '+typeof cookie.get('EkListe'));

// Cookie wenn vorhanden einlesen
if(typeof cookie.get('EkListe') != 'undefined'){
    console.log('wieso');
    liste = cookie.get('EkListe').split(',');
    console.log(liste);
    console.log(typeof(liste));
};

// wenn im eingabefeld etwas drinnensteht und enter gedrückt wurde wird der inhalt zur Liste hinzugefügt und als cookie gespeichert.
$('#e_dazu').on('keydown',function(event){
    if(event.key =='Enter' && $('e_dazu').val() !=''){
        // console.log($('#e_dazu').val());
        liste.push($('#e_dazu').val());
        createHtml();
        setCookie();
        // console.log(liste);
        $('#e_dazu').val(''); //Inhalt vom Eingabefeld leeren
        
    }
});

// html erzeugen und ausgeben
function createHtml(){
    let html='';
    // array in eine html tag liste umwandeln
    $.each(liste,function(index, value){
        html=html+'<input type="checkbox" id="'+index+'" value="gekauft">'+value +' <br>';
    });
    // liste ausgeben
    $('#gegenstaende').html(html);
};

// attribute: (Name des Cookies, inhalt des Cookies, lebensdauer (hier 4 tage))
function setCookie(){
    cookie.set('EkListe',liste,4);
}

// wenn der Cookie vorhanden war, wird eine volle Liste ausgegeben sonst nur ''
createHtml();

// gesamte Liste löschen (cookie löschen)
$('#listeLeeren').on('click',function(){
    cookie.remove('EkListe');
    liste=[];
    createHtml();
});

let text ='hallo Welt';

