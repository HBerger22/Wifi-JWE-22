"use strict";



// Auswahl Speisen oder Getränke
$('#sod').click(function(){
    if($('#sod:checked').length ==1){
        $('#speisen').css('display', 'none');
        $('#drinks').css('display', 'flex');
    } else {
        $('#speisen').css('display', 'flex');
        $('#drinks').css('display', 'none');
    }
});


// Ein und Ausblenden des Filters
$('#menu img').click(function(){
    if ($('#filter').css('display')=='none') {
        $('#filter').css('display','flex');
console.log('true');
    } else{
        $('#filter').css('display','none');
console.log('false');
    }
});

// Ein und Ausblenden der einzelnen Speisen
let taste;
let aMenu=''; //altes Menu
$('button').click(function(event){
    taste=event.target.id;
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
});

    
    // $('#test').html('111 u ' +uMenu + ' a' +aMenu);
    // console.log('222 ' + taste);

