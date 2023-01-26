


let images = [
    1,
    2,
    3,
    4
];


$(images).each(function(index, element) {
    
    // Akzentzeichen für HTML mit Zeilenumbruch
    // Platzhalter '#' wird später ersetzt in der each Schleife
   
    let proto = `
        <a href="images/${element}.jpg">
            <img src="images/thumbs/${element}.jpg" alt="">
        </a>
    `;

    $('body').append(proto);
});


console.log( $(proto).find('img').attr('src') );