// "use strict";
// Salzburg
let lat=47.7972;
let lon=13.0477;

let w_daten;
let s_aufgang;
let s_untergang;
let h=''; // html
let bg;
let lg;
let country;

// $('#text').append(typeof lat);

// Button wurde gedrückt - Wetterabfrage starten. 
$('#btn_wetter').on('click',function(){
    //Übernahme der Formulardaten
    bg=$('#bg').val();   
    lg=$('#lg').val();

    // ersetzen des kommazeichens durch einen punkt
    if(bg.indexOf(',')!= -1){
        bg=replaceCharAt(bg,bg.indexOf(','),'.');
    }

    if(lg.indexOf(',')!= -1){
        lg=replaceCharAt(lg,lg.indexOf(','),'.');
    }

    
   
    // Bereich überprüfen (leer bzw. innerhalb der Grade)
    if(bg!='' && lg!='' && lg <=180 && lg >= -180 && bg <=90 && bg >= -90 ){
        lat=bg;
        lon=lg;
    }else {
        alert('Keine gültigen Koordinaten! Es werden die Standardkoordinaten verwendet.');
    };
    
    // wetterdaten abfragen
    $.get(
        'https://api.openweathermap.org/data/2.5/weather?lat='+lat +'&lon='+lon+'&appid=fb4d7b9e7ec7eac624a0ec238a6ae26f&lang=de&units=metric',
        // 'https://localhost/Wifi/Wifi-JWE-22/Projekt-Speisekarte/apiv2',
        function(data,status,rückgabe){
            w_daten=rückgabe.responseJSON;
            // $('p').append(w_daten.name);
            country=w_daten.sys.country;

            if(  typeof country == 'undefined'){
                country='Unbekannter Ort';
            }    
        
        // Umwandeln des Unix Zeitcodes in normale Zeit
        s_aufgang=new Date(w_daten.sys['sunrise'] *1000);
        s_untergang=new Date(w_daten.sys['sunset']*1000);

        // Daten für ausgabe belegen/formatieren
        h=h+"<h1>für <strong>" + w_daten.name + " ("+country+")</strong>:</h1> \n";
        h=h+"<p><strong>Koordinaten:</strong><br> Längengrad: "+w_daten.coord['lon']+"° <br> Breitengrad: "+w_daten.coord['lat']+"°</p>\n";
        h=h+"<p> Heute: "+  w_daten.weather[0].description.toLowerCase() + ". <br>Wolkenanteil: "+w_daten.clouds.all+"%</p>\n";
        h=h+"<p>Temperatur: "+w_daten.main.temp+"° C<br> Gefühlte Temperatur: "+w_daten.main.feels_like+"° C</p>\n";
        h=h+"<p>Luftfeuchtigkeit: "+w_daten.main.humidity+"% <br> Luftdruck: "+w_daten.main.pressure+"hPa</p>\n"; 

        h=h+"<p> Die Sonne geht am "+ s_aufgang.toLocaleDateString('de-AT') + " um "+ s_aufgang.toLocaleTimeString('de-AT') +" auf.<br>\n";
        h=h+"Die Sonne geht am "+ s_untergang.toLocaleDateString('de-AT') + " um "+ s_untergang.toLocaleTimeString('de-AT') +" unter.</p>\n";
        h=h+"<p> Windgeschwindigkeit: "+ w_daten.wind.speed+ " aus "+w_daten.wind.deg+"° das entspricht: "+ windrichtung(w_daten.wind.deg) +"</p>\n";
        
        // Ausgabe im HTML File 
        $('#wetterdaten').html(h);
        let breite=window.innerWidth/2-180; //Position Wettericon
        $('#wicon').css({
            'right': breite+'px',
            'display':'block'
        });
        
        // Ausgabe Icons
        $('#wicon').html('<img src="img/'+w_daten.weather[0].icon+'.png" alt="Wetter Icon">');

        // Zurücksetzen der Variablen
        h=''; 
        lat=47.7972;
        lon=13.0477; 
        $('#bg').val('');
        $('#lg').val('');
        }
    );
});


// wandelt eine Grad eingabe in eine Windrichtung um: 0° = N
function windrichtung(grad){
    if (grad=='' || grad<0 || grad>360 || typeof grad!= 'number'){
        return 'Unbekannt';
    }else if ((grad>=348.76 && grad<=360) || (grad>=0 && grad<=11.25)) {
        return 'N';
    }else if (grad>=11.26  && grad<=33.75) {
        return 'NNE';
    }else if (grad>=33.76  && grad<=56.25) {
        return 'NE';
    }else if (grad>=56.26  && grad<=78.75) {
        return 'ENE';
    }else if (grad>=78.76  && grad<=101.25) {
        return 'E';
    }else if (grad>=101.26  && grad<=123.75) {
        return 'ESE';
    }else if (grad>=123.76  && grad<=146.25) {
        return 'SE';
    }else if (grad>=146.26  && grad<=168.75) {
        return 'SSE';
    }else if (grad>=168.76  && grad<=191.25) {
        return 'S';
    }else if (grad>=191.26  && grad<=213.75) {
        return 'SSW';
    }else if (grad>=213.76  && grad<=236.25) {
        return 'SW';
    }else if (grad>=236.26  && grad<=258.75) {
        return 'WSW';
    }else if (grad>=258.76  && grad<=281.25) {
        return 'W';
    }else if (grad>=281.26  && grad<=303.75) {
        return 'WWN';
    }else if (grad>=303.76  && grad<=326.25) {
        return 'NW';
    }else if (grad>=326.26  && grad<=348.75) {
        return 'NWN';
    };
};
// Bild von <a href="https://de.freepik.com/vektoren-kostenlos/handgezeichnete-wettereffekte_19344422.htm#query=wettersymbol&position=12&from_view=search&track=sph">Freepik</a>


// tauscht einen einzelnen Buchstaben im "wort" an der Stelle "index" mit den "replacementzeichen" (1 oder mehrere) aus.
function replaceCharAt(wort, index, replacement){
    if (wort.length < index ){
        return (wort);
    }
    return (wort.substring(0,index) + replacement + wort.substring(index+1));
}; 

// let text ='Hello World';
// $('#text').append(replaceCharAt(text,' '),'-'));