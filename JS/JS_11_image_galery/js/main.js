let prototyp ='<a href="images/1.jpg"><img src="images/thumbs/1.jpg" alt="Bild 1"></a>"';

let proto =` 
    <a href="images/#.jpg">
        <img src="images/thumbs/#.jpg" alt="Bild #">
    </a>
`; //schräger einfacher Anführungsstrich geht über mehrere Zeilen (shift + neben ?)

console.log(proto);

$(proto).find('img').attr('src');
console.log($(proto).find('img').attr('src'));

let images = [
    1,
    2,
    3,
    4
]

$(images).each(function(index, element){
    const html=$(proto);
    html.find('img').attr('src'), replace('#',element);
    $('body').append(html);
});

