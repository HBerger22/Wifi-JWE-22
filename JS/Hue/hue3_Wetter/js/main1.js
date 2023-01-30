
let lat=47.7972;
let lon=13.0477;

let w_daten;
let h='';

function Sleep(milliseconds) {
    return new Promise(resolve => setTimeout(resolve, milliseconds));
};
async function wait(zeit){
    await Sleep(zeit);
};
$.ajax('https://api.openweathermap.org/data/2.5/weather?lat='+lat +'13&lon='+lon+'&appid=fb4d7b9e7ec7eac624a0ec238a6ae26f&lang=de&units=metric', 
    {
    type: 'POST',  // http method
    // data: 'lat=13&lon=13&appid=fb4d7b9e7ec7eac624a0ec238a6ae26f&lang=de&units=metric',
    
    success: function (data, status, xhr) {
        // $('p').append('status: ' + status + ', data: ' + data);
        w_daten = (xhr.responseJSON);
        h=h+' in der schleife! ';
        $('#wetterdaten').html(h);
         $('p').append(typeof(w_daten)+' 111 '+w_daten+' 133 '+ xhr.responseJSON);
        $('p').append(w_daten);},
        
    error: function (jqXhr, textStatus, errorMessage) {
            $('p').append('Error: ' + errorMessage);
    }
});

// globalThis.setTimeout(() => {
//     h=h+' wo auch immer ';
//     $('#wetterdaten').html(h);

//     h=h+' ausserhalb der Schleife! ';    
//     $('#wetterdaten').html(h);
//     $('p').append('123 '+ w_daten.name + ' warum kommt das zuerst??? ');
// }, 800);

wait(2000);
h=h+' ""GANZ draussen" ';    
$('#wetterdaten').html(h);
$('p').append('123 '+ w_daten + ' "warum kommt das zuerst???" ');
    // w_daten=$.load(
    //     `https://api.openweathermap.org/data/2.5/weather?lat=13&lon=13&appid=fb4d7b9e7ec7eac624a0ec238a6ae26f&lang=de&units=metric`
    // );

    // $.get(
    //     'https://api.openweathermap.org/data/2.5/weather?lat='+lat +'13&lon='+lon+'&appid=fb4d7b9e7ec7eac624a0ec238a6ae26f&lang=de&units=metric',
    //     function(data,status,rückgabe){
    //          $('p').append(rückgabe.responseJSON.name);
    //         w_daten=rückgabe.responseJSON;
    //         $('p').append(w_daten.name);
    //         // return rückgabe.responseJSON;
            
    //     }
    // );
    

    // let h=JSON.parse(w_daten);
    // console.log(h.responseJSON);
    // console.log($('#wetterdaten').html());
     $('#wetterdaten').html(w_daten);

// console.log(w_daten.innerHTML);



