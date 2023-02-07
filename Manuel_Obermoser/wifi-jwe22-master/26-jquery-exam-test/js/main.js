let counter = 19.0;

function plus() {
    counter = counter + 0.5;
    showCurrentValue();
}

function minus() {
    counter = counter - 0.5;
    showCurrentValue();
}

function reset() {
    counter = 19.0;
    showCurrentValue();
}

// beim Laden der Seite Anzeige auf Standard-Wert setzen
reset();

// Plain JavaScript Variante
// document.getElementById('btnPlus').addEventListener('click', function() {
//     plus();
//     document.getElementById('counterInput').value = counter;
// });

function showCurrentValue() {
    // die value eines Formularfeldes setzen
    $('#counterInput').val(counter.toFixed(1));
    
    // in einem HTML-Tag ausgeben
    $('h1').text(counter.toFixed(1));

    // in der Console ausgeben
    console.log(counter.toFixed(1));

    // Temperatur prüfen
    checkTemp();
}

//jQuery Variante
$('#btnPlus').click(function(){
    plus();
});

$('#btnMinus').click(function(){
    minus();
});

$('#btnReset').click(function(){
    reset();
});



function checkTemp() {

    if(counter >= 18 && counter <= 24) {
        // OK
        console.log('OK');
        
        // Lösung über eine Klasse
        //$('#counterInput').attr('class','temp-ok');
        
        $('#counterInput').css('color','#007700');

    } else if (counter < 18 ) {
        // KALT
        console.log('kalt');
        
        $('#counterInput').css('color','lightblue');

        // Lösung über eine Klasse
        //$('#counterInput').attr('class','temp-cold');

    } else if (counter > 24 ) {
        // HEISS
        console.log('heiß');
        
        // Direkt als Inline-CSS in den gewünschten HTML-Tag schreiben
        $('#counterInput').css('color','var(--warning)');

        // reine JS-Lösung
        //document.getElementById('counterInput').style.color = 'red';
        
        // Lösung über eine Klasse
        //$('#counterInput').attr('class','temp-hot');
    }
}

// Loop für eine Reihe an Buttons
let dynamischesHTML = '';
for(let i = 18; i <= 25; i++) {
    dynamischesHTML = dynamischesHTML + `<button>${i}</button>`;
}
$('#controls2').html(dynamischesHTML);


// über ein Array "iterieren" (einzelne Speicherplätze abarbeiten)
let presets = ['idle', 'warm', 'warmer', 'cold', 'fridge'];

let dynHTML = '';
//jQuery Lösung .each()
$(presets).each(function(index, element){
    dynHTML = dynHTML + `<button data-index="${index}">${element}</button>`
});

// einfaches JS .forEach()
presets.forEach(function(element, index, presetsArr) {
    dynHTML = dynHTML + `<button data-index="${index}">${element}</button>`
});

$('#controls3').html(dynHTML);


// eingabe auslesen und in das TemperaturInput übertragen
function editTemp() {
    // value lesen und in en anderes element speichern
    $('#counterInput').val( $('#tempEdit').val() );
}
// button führ function aus
$('#edit button').click(function(){
    editTemp();
});