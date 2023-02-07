"use strict";
// document.getElementById('headline').style.color = 'red';
// document.getElementById('headline').style.textDecoration = 'underline';
// document.getElementById('headline').style.font-size = 'red';

$('#headline').css('background-color','red');

let myVariable = 90

// Setter: mehrere css eigenschaften setzen (attribut + wert = setter)
$('#headline').css({
    'color': 'orange',
    'text-decoration':'underline',
    'font-size': myVariable +'px'
});

// Getter: Abfragen von css informationen (nur attribut ohne wert = getter), gibt die Farbe von der id headline zurück
console.log($('#headline').css('color'));

$('.alert').hide();
/*
Windows.setTimeout hat 2 Attribute,
1. die Funktion, die danach ausgeführt werden soll
2. nach welcher Zeit es ausgeführt werden soll
*/

window.setTimeout(
    function(){
        $('.alert').slideDown()
        },2000
);

// mehrere befehle hintereinander schreiben
$('.alert').
    fadeIn().
    delay(3000).
    fadeOut().
    delay(3000).
    fadeIn()
;

// alle buttons in der Klasse alert ansprechen und mit lenght abfragen wieviele es gibt. Wenn es welche gibt, dann bekommen sie die Funktion das wenn sie geklickt werden, wird die Klasse alert ausgeblendet
 console.log($('.alert button').length);

if($('.alert button').length > 0){
    $('.alert button').click(function(){
        $('.alert').fadeOut();
    })
};

/*
Attribute: 

z.B.: bei h1 id='headline'
*/

let spanTags = $('p span');

console.log(spanTags);
console.log(spanTags[0].nodeName);
console.log(spanTags.attr('class','nw')); //hier wird die Klasse kw mit nw ersetzt (console log macht hier natürlich keinen Sinn)
console.log(spanTags.attr('class'));
spanTags.addClass('xyz');
spanTags.removeClass('nw');

// ein Strong Tag in den Span tag einfügen
spanTags.wrapInner('<strong></strong>');

// ein Strong Tag um den Span tag herum einfügen
// spanTags.wrap('<strong></strong>');

spanTags.each(
    function(index, element){
        console.log(element)
        console.log('.html: '+ $(element).html()); // alles was innerhalb des Span tags steht auch tags selber
        console.log('.text: '+ $(element).text()); // alles was innerhalb des Span tags steht ohne tags selber
        $(element).append('<sup>'+(index +1)+'</sup> '); //füge den index hochgestellt dazu
        $(element).find('sup').css('color','rgb(250, 10, 0)');
    }
)



