"use strict";

// Auswahl Speisen oder Getränke
$('#sod').click(function(){
    if($('#sod:checked').length ==1){
        $('#speisen').css('display', 'none');
        $('#drinks').css('display', 'flex');
        // Ausblenden des Filters und mittigsetzen des Schalters bei ansicht der Getränke
        // $('#menu').css('display', 'none');
        // $('#filter').css('display','none');
        // $('#auswahl').css('margin-left' , '0px')
    } else {
        $('#speisen').css('display', 'flex');
        $('#drinks').css('display', 'none');
        // Einblenden des Filters und mittigsetzen des Schalters bei ansicht der Speisen
        // $('#menu').css('display', 'flex');
        // $('#auswahl').css('margin-left' , '43px')
        
    }
});

// Ein und Ausblenden des Filters
$('#menu img').click(function(){
    if ($('#filter').css('display')=='none') {
        $('#filter').css('display','flex');
// console.log('true');
    } else{
        $('#filter').css('display','none');
// console.log('false');
    }
});

// Ein und Ausblenden der einzelnen Speisen
let aMenu=''; //altes Menu

// $('button').click(function(event){
    // let taste=event.target.id;
function einAusblenden(taste){
    let uMenu='#'+taste+'u'; //uMenu = Untermenu z.b.: s1u
    if (aMenu==''){ //wenn kein untermenu ausgeklappt ist, öffne das neue Menu
        $(uMenu).css({
            'display':'block',
            // 'height':'auto',
            'transition': '4s'
        });
        aMenu=uMenu;
    } else if(aMenu==uMenu){ //wenn das aktuelle Menu bereits ausgeklappt ist, klappe es wieder ein
        $(uMenu).css({
            'display':'none'
            // 'height':'0px'
        });
        aMenu=''; // Variable zurücksetzen
    } else // wenn bereits ein untermenu eingeblendet ist, blende es aus und das neue ein.
    {
        $(uMenu).css({      //neues Menu einblenden
            'display':'block'
            // 'height':'auto'
        });
        $(aMenu).css({      //altes Menu ausblenden
            'display':'none'
            // 'height':'0px'
        });
        aMenu=uMenu;
    }
};


// Auswahl Allergene 
    let text = "123";
    let text2= "nix";
    // diese 2 variablen werden jetzt in der Ajax.js definiert und gefüllt
    // let o_allergene={};
    // let anzahl_allergene = document.getElementById('f_allergene').childElementCount;

    // for(let i = 1; i<= anzahl_allergene;i++){
    //     o_allergene['al_'+i]=0;
    // };

    // $('.all').dblclick(function(){});
    // $('.all').click(function(event){
    function allergeneOnOff(radio){
        let ziel=radio;// let ziel = event.target.id;
        let klasse = ".c_"+ziel;
        let aktive=0;
        // text=" 1: "+ ziel;
          console.log("Klasse: "+klasse);
        
        if (o_allergene[ziel]==1){
            o_allergene[ziel]=0;
            // hier noch die notwendigen speisen einblenden die das allergen enthalten
            // $(klasse).show(500);
                
        } else {
            o_allergene[ziel]=1;
            // hier noch die notwendigen speisen löschen die das allergen enthalten
            // $(klasse).hide(500);
        };

        // die nächsten 2 ´for loops sind notwendig falls ein produkt mehrere Allergene beinhaltet.
        // alle Prodkte wieder einblenden
        let key=0;
        for( key in o_allergene ) {
            $(".c_"+key).show();
        };

        // sämtlice Produkte ausblenden die eins der ausgewählten Allergene enthalten
        for( key in o_allergene ) {
            if(o_allergene[key]==1){
                $(".c_"+key).hide();
        }
    
    };

 

    aktive = objekt_elemente_summieren(o_allergene);
    // console.log(" anzahl aktiviert"+aktive);
    // wenn ein Allergen aktiv ist soll das filter Symbol rot werden.
    if (aktive==0){
        $('#menu img').attr('src',"img/filter_1.png");
        $('#menu img').css('background-color', 'var(--fisch)');
    } else {
        $('#menu img').attr('src',"img/filter_2.png");
        $('#menu img').css('background-color', 'var(--jause)');
    }
    
    //  print_allergene();
};

// Zugang zum Verwaltungsbereich durch klick auf das Schlossymbol im footer
    $('footer span').click(function(){
        // $('#test').html('111 u ');
        window.open('adminbereich/index.php','_self');
        // window.open('https://bergerhe.jwe.obinet.at/projekt/adminbereich/index.php','_self');
    });

// allgemeine Funktionen
    function objekt_elemente_summieren (objekt){
        let key1;
        let aktiv=0;
        for( key1 in objekt ) {
            aktiv += objekt[key1];
        };
        return aktiv;
    };



// ZUM DEBUGGEN
//   alternativer For loop
//   let key;
//   for( key in o_allergene ) {
//     alert( "key is " + [ key ] + ", value is " + o_allergene[ key ] );
//   };

let hinweis=document.getElementById('f_allergene');
// let text ='Folgende Klassen existieren: ' + hinweis.classList;    
// let text ='Folgende Klassen existieren: ' + hinweis.childElementCount;
// let text1 ='Folgende Klassen existieren: ' + hinweis.textContent;
let text1 ='Folgende Klassen existieren: ' + hinweis.childElementCount;
// let text1 ='Folgende Klassen existieren: ' + hinweis.child[2];

// document.getElementById("test").innerHTML = text1;
// console.log(text1);

function print_allergene(){
    jQuery.each( o_allergene, function( key, value ) {
        // console.log( "Schlüssel", key, "Wert", value );
        text2+= "Schlüssel: " + key + " Wert: " + value + "<br>";
        document.getElementById("test").innerHTML = text2;
    });
};

// $(window).resize() bedingung Window.Width>700

// text1 = text1.toString();
// let myarray1=text1.split('\n');

// for (let i = 0; i < myarray1.length; i++) {
//     text += myarray1[i] + "<br>";
// };

// const nodeList = hinweis.childNodes;
// let text = "";
//     for (let i = 0; i < nodeList.length; i++) {
//       text += nodeList[i].nodeName + "<br>";
//     }
    //   document.getElementById("test").innerHTML = text+text1+ hinweis.childNodes[7].nodeValue;






    
    // $('#test').html('111 u ' +uMenu + ' a' +aMenu);
    // console.log('222 ' + taste);

