let products =[
    {
        uid: 1,
        title: "Wiener Schnitzel mit Pommes",
        price: 12.00
    },
    {
        uid: 2,
        title: "Putenstreifensalat mit steirischen Kernöl",
        price: 10.90
    },
    {
        uid: 3,
        title: "Tiramisu",
        price: 6.50
    },
    {
        uid: 4,
        title: "Apfelstrudel mit Vanillesauce",
        price: 5.90
    }
];

// console.log(products);


let html='';

// ausgabe in Jquery
// products[index]. = element.
$(products).each(function (index,element){
// $.each(products,function(i){
    // console.log(product.uid+product.title);
    html=html + '\n'+ `
        <div class="product">
            <h1>${products[index].title}</h1>
            <div class="price">€ ${element.price.toFixed(2)}</div>
        </div>`;
});


// ausgabe in Javascript 
// (products.forEach(function(entry) { ist das gleiche wie die 1. Zeile)
products.forEach(entry => { // 'entry =>' kurzschreibweise für 'function(entry)'
    console.log(entry.title);
    html=html + '\n'+ `
    <div class="product">
        <h1>${entry.title}</h1>
        <div class="price"> € ${entry.price.toFixed(2)}</div>
    </div>`;
});

console.log(html);

$('#products').html(html);

// "normaler" for Loop
for(let j=10 ; j<=20 ; j++){
    
    setInterval(() => {
        console.log("For Loop iteration: "+j);
    }, 15);
};



