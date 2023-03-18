"use strict";

// Ein und Ausblenden der einzelnen Speisen
let aMenu=''; //altes Menu
$('button').click(function(event){
    let taste=event.target.id;
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