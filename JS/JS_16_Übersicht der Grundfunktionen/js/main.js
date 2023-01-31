let counter = 19;

$('#i_temp').val(counter);

function plus(){
    counter++; //Counter +1
    // counter = counter + 5; // counter +5
    
};

function minus(){
    counter--; //counter -1
    // counter = counter -5;
};

function reset(){
    counter = 19;
};

function checkTemp(){
    if(counter<19){
        $('h1').css({'color':'lightskyblue'});

        // return -1; 
    } else if (counter<24){
        $('h1').css({'color':'green'});
        // return 0;
    }else {
        $('h1').css({'color':'red'});
        // $('h1').attr('class','hot'); // Attribut hier eine Klasse dem Element h1 hinzufügen
        // return 1;
    }
};

function ausgabe(){
    $('h1').html('Temperatur: '+ counter.toFixed(1));
    $('#i_temp').val(counter.toFixed(1));
}

$('#btnPlus').click(function(){
    plus();
    checkTemp();
    ausgabe();
});

$('#btnMinus').click(function(){
    minus();
    checkTemp();
    ausgabe();
});

$('#btnReset').click(function(){
    reset();
    checkTemp();
    ausgabe();
});

$('#i_temp').keyup('enter',function(){
    counter=parseInt($('#i_temp').val()); //*1 damit der String in eine Zahl umgewandelt wird!!!
    checkTemp();
    ausgabe();
});

checkTemp();
ausgabe();

// $('h1').html('Temperatur'); //Den Text im H1 Element überschreiben
//$('h1').text(counter.toFixed(1)); //Den Text im H1 Element überschreiben

for (let i=0; i<=30; i+=5){
    $('#controls2').append(`<button id='${i}'> ${i} </button>`);
};

let presets=['idle','warm','warmer','cold','fridge'];

let html='';

$(presets).each(function(index,element){
    html=html+ `<button id='${index}'> ${element} </button>`;
});

// presets.foreach(function(element,index,komplettesArray){ .... })

// Controls3
// $('#controls3').html(html);
function editTemperatur(){
    // lesen
    let editInput = $('#tempEdit').val();
console.log(editInput+ typeof editInput);
    // counter ändern
    if(typeof editInput == 'number'){
        counter=editInput
    }else{counter=0};

    // Anzeige Aktualisieren
    checkTemp();
    ausgabe();
};

$('#edit.button').click(function(){
    console.log('hallo');
    editTemperatur();
});