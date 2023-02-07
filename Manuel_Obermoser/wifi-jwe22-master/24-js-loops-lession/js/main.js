let products = [
    {
        uid: 1,
        title: 'Käsesahnetorte',
        price: 8.00,
    },
    {
        uid: 2,
        title: 'Gulaschsuppe',
        price: 11.00,
    },
    {
        uid: 3,
        title: 'Kaffee mit Sahne',
        price: 4.50,
    }
];

// leeres html
let html = ''; 

// zeilweise befüllen
products.forEach( entry => {
    
    html = html + '\n' + `

    <div class="product">
        <h1>${entry.title}</h1>
        <div class="price">€ ${(entry.price).toFixed(2)}</div>
    </div>

    `;

});
// ausgabe im HTML Dokument, Inhalt der Variable in das "innerHTML" des DIVs products schreiben
document.getElementById('products').innerHTML = html;

$(products).each((index, entry) => {
    
    html = html + '\n' + `

    <div class="product">
        <h1>${entry.title}</h1>
        <div class="price">€ ${(entry.price).toFixed(2)}</div>
    </div>

    `;

});

$('#products').html(html);







for(let i=0; i < 5; i++) {
   
    if(typeof products[i] != 'undefined') {
        console.log(products[i].title);
    } else {
        console.warn('Diesen Eintrag gibt es nicht');
    }

}













