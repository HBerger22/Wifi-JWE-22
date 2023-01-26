document.getElementById('headline').style.color = "red";

/**
 * CSS auf Elemente anwenden
 */

// Eine CSS Eigenschaft setzen
$('#headline').css('color', 'green');

let myVariable = 90;

// Mehrere CSS Eigeschaften gleichzeitig setzen
$('#headline').css({
    'color': 'orange',
    'text-decoration': 'underline',
    'font-size': myVariable + 'px'
});
// getter: CSS-Informationen abrufen
// console.log($('#headline').css('color'));




/**
 * Elemente effektieren
 */
// Element beim Laden sofort ausblenden.
// $('.alert').hide();

// Nach einer Zeit von 2000 Millisekunden einblenden
// window.setTimeout(
//     function(){ 
//         $('.alert').slideDown(); 
//     }
//     , 2000
// );

$('.alert').delay(2000).fadeIn();

// console.log( $('.alert button').length );

if( $('.alert button').length > 0 ) {

    // Event-Handler: click
    $('.alert button').click(
        function(){
            $('.alert').fadeOut();
        }
    );

}



/**
 * Attribute manipulieren
 */
let spanTags = $('p span');

spanTags.attr('class','new');
spanTags.addClass('xyz');
spanTags.removeClass('new');

// innerhalb eines Tags den Inhalt umschließen
spanTags.wrapInner('<strong></strong>');


spanTags.each(
    function (index, element) {
        // console.log(element);
        console.log( $(element).text() );
        $(element).append('<sup>' + (index+1) + '</sup>');
        $(element).find('sup').css('color', 'red');
    }
);


