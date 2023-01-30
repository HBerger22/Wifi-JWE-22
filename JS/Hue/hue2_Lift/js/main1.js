"use strict";

function stockwerk(element){
    let y=0;
    if(element=='4'){
        console.log('errwr');
        for (let i=0; i<=500; i++){
            //  $('#wuerfel').css('top',i + 'px');
            setInterval(() => {
                bewegen(i);
                console.log(i);
            }, 200);
        }
        console.log('errwr2');
    }else if(element=='3'){
        $('#wuerfel').css('top','100px');
    }else if(element=='2'){
        $('#wuerfel').css('top','200px');
    }else if(element=='1'){
        $('#wuerfel').css('top','300px');
    }else if(element=='eg'){
        $('#wuerfel').css('top','400px');
    }else if(element=='min1'){
        bewegen(500);
    }
}

function bewegen(pixel){
    $('#wuerfel').css('top',pixel + 'px');
}