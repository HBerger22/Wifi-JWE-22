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

let taste;
let aMenu=''; //altes Menu
$('button').click(function(event){
    taste=event.target.id;
    let uMenu='#'+taste+'u'; //uMenu = Untermenu z.b.: s1u
    if (aMenu==''){
        $(uMenu).css({
            'display':'block',
            // 'height':'auto',
            'transition': '4s'
        });
        aMenu=uMenu;
    } else if(aMenu==uMenu){
        $(uMenu).css({
            'display':'none'
            // 'height':'0px'
        });
        aMenu=''; // Variable zurücksetzen
    } else
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

    
    $('#test').html('111 u ' +uMenu + ' a' +aMenu);
    console.log('222 ' + taste);

