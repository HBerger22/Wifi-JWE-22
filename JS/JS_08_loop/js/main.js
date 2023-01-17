"use strict";

for ( let i=0; i<10; i++) {
    console.log ('Nr. ' + (i + 1));
    

    //kürzere Schreibweise funkt aber noch nicht
    console.log (`Nr. $(i+1)`);
}

// ein Leeres Array
let artikel = [
    // 'Banane1',
    // 'Brot1',
    // 'Reiswaffel1',
    // 'Holundersirup1',
];

if (typeof cookie.get('artikelCookie') != 'undifined') {
            
    let cookieValue =cookie.get('artikelCookie');

     // der String vom eingelesenen Cookie (cookieValue) wird mit dem Trennzeichen , in ein Array aufgesplittet
    let artikelArray = cookieValue.split(',');
    console.log(artikelArray);
    artikel=artikelArray;
    createHtml();
}


// hier werden die einzelnen Elemente des Arrays in der console ausgegeben, Nachteil ich muss wissen aus wievielen Elementen das Array besteht.
for (let i=0; i<4; i++){
    console.log(artikel[i]);
}
// oder besser, hier wird das Array durchgegangen und alle Elemente ausgegeben (d.h. es ist egal wieviele Elemente im Array sind)
artikel.forEach(element => {
    console.log(element);
})

// ausgabe in index.html im Element mit der id = ek_liste
function createHtml(){
    let html=''; //leere String-Variable definieren
    artikel.forEach(element =>{
        //variable html mit li elementen und den einzelnen Elementen des Arrays befühlen
        html=html + '<li>' + element + '</li>'; 
    })
    document.getElementById('ek_liste').innerHTML=html;
}

/*document.getElementById('new_element').addEventListener('keydown', function(){
    console.log('hey'); // hier würde bei jedem Tastendruck in der konsole hey ausgegeben.
})*/

/*document.getElementById('new_element').addEventListener('keydown', function(event){
    console.log(event); // hier würde bei jedem Tastendruck die Informationen zum Event in der konsole ausgegeben.
})
document.getElementById('new_element').addEventListener('keydown', function(event){
    console.log(event.key); // hier würde bei jedem Tastendruck die Informationen zum Event element key in der konsole ausgegeben.
})*/

document.getElementById('new_element').addEventListener('keydown', function(event){
    if (event.key == 'Enter' && document.getElementById('new_element').value != '' ){
        console.log('füge das neue Element zu artikel hinzu'); 
        
        console.log(document.getElementById('new_element').value);
        
        // dem Array ein neues Element anhängen
        artikel.push(document.getElementById('new_element').value)
        
        createHtml(); //
        document.getElementById('new_element').value='';

        cookie.set('artikelCookie',artikel,2);
    }
})
